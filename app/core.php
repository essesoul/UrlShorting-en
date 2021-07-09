<?php
/*
  URL shortening core service
   Powered by xcsoft
   All rights reserved, piracy must be punished
   Time2020/07/31
  Version:2.0.1
*/
require_once "config.php";
require_once "app/strpol.php";
require_once "app/ip.php";
/*
*  @author   xcsoft
*  @version  2.0.1
*/
function Urlshorting($content, $type, $passwd, $shorturlInput) {
    global $ip;
    //ip
    global $conn;
    //database
    global $strPol;
    //Short URL contains content
    global $pass;
    //Short URL length
    global $url; 
    //URL domain
    $time = time();
    
    @$arr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT *FROM `ban` where `content`='$ip'"));
    if (!empty($arr)) {
        //Retrieve whether the user ip or short domain is blocked
        return array(1002);
        exit();
    }
    if (empty($content)) {
        //Check if there is input
        return array(1001);
        exit();
    }
    //Judgment officially started

    //Judged as short domain
    if($type == 'shorturl'){
        if (!preg_match('#(http|https)://(.*\.)?.*\..*#i', $content) || mb_strlen($content) > 1000 || mb_strlen($content) < 10) {
            return array(1001);
            exit();
        }
    }
    //Judgment of URL legitimacy
    if($type == 'passmessage'){
        if (mb_strlen($content) > 3000 || mb_strlen($content) < 3) {
            return array(1001);
            exit();
        }
    }
    //Judgment of Secret Language Legitimacy
    
     if(!empty($passwd))
    {
        if(strlen($passwd) < 2 || strlen($passwd) >= 20)
        {
            return array(3001);
            exit();
            //Overlength limit
        }
        if(!preg_match("/^[\\~!@#$%^&*()-_=+|{}\[\],.?\/:;\'\"\d\w]+$/",$passwd))
        {
            return array(3002);
            exit();
            //Illegal password
        }
    }
    //return array(123456789);
     //       exit();
    //Password check
    
    if(!empty($shorturlInput))
    {
        if((double)strlen($shorturlInput) !== (double)$pass)
        {
            //Only limited digits
            return array(2001);
            exit();
            //Overlength limit
        }
        if(!preg_match("/^[_0-9a-zA-Z]+$/",$shorturlInput))
        {
            return array(2002);
            exit();
            //Illegal short domain
        }
        $arr = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `information` WHERE `shorturl` = '$shorturlInput'"));
        //AND `information` = '$content' AND `type` = '$type' AND `passwd` = '$passwd'"
        //There are duplicate and identical user entries
        if(!empty($arr['shorturl']))
        {
            //If it exists, continue to determine whether it is a complete duplicate
            if($arr['passwd'] == $passwd && $arr['information'] == $content && $arr['type'] == $type)
            {
                //Completely duplicate items, direct output
                return array(200, $url . $arr['shorturl'],$arr['passwd']);
                exit();
            }else{
                return array(2003);
                //Repeated short fields
                exit();  
            }
        }else{
            mysqli_query($conn,"insert into `information` values('$content','$shorturlInput','$type','$passwd','$time','$ip');");
            return array(200, $url . $shorturlInput,$passwd);
            exit();
            //There are duplicates
        }
        //Determine whether the database has the same type of repeatability
    }else{
        $arr1 = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `information` WHERE `information` = '$content' AND `type` = '$type' AND `passwd` = '$passwd'"));
        $shorturl = $arr1['shorturl'];
        if (!empty($shorturl)) {
            return array(200,$url . $shorturl,$passwd);
            exit;
        }
        
        while (true) {
        $shorturl = null;
        $max = strlen($strPol)-1;
        for ($i = 0; $i < $pass; $i++) {
            $shorturl .= $strPol[rand(0, $max)];
        }
        //Detect whether there are duplicates
        @$arr = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `information` WHERE shorturl='$shorturl'"));
        @$information = $arr['information'];
        if (empty($information)) {
            mysqli_query($conn,"insert into `information` values('$content','$shorturl','$type','$passwd','$time','$ip');");
            return array(200, $url . $shorturl, $passwd);
            exit;
        }
    }
    }
    //Custom short domain repeatability detection
}