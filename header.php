<!DOCTYPE html>
<!--
Copyright attribution: XCSOFT
Email: contact#xcsoft.top (replace # with @)
If you have any questions, please feel free to contact!
-->
<!--
   Secondary Developed By k6o.top
   Contact us: Gary@dtnetwork.top
-->
<?php
session_start();
require_once "config.php";
require_once "app/code.php";    
$id = $_GET['id'];
if(!preg_match("/^[a-zA-Z0-9\#]*$/",$id))
{
  exit();
  //Determine whether the id is a pure English number to prevent SQL injection
}
//Get id
if (empty($id)) {
  $status = "ok";
  //If there is no id, skip the judgment
} else {
  //Search the database if there is an id
  $arr1 = mysqli_fetch_assoc(mysqli_query($conn,"SELECT *FROM `ban` where `content`='$ip' or `content`='$id'"));
  $type = $arr1['type'];
  if (!empty($type)) {
    echo("<br /><br /><center><img src=\"https://cdn.jsdelivr.net/gh/soxft/cdn@master/urlshorting/notice.png\" widht=\"85\"  height=\"85\" alt=\"错误\"></center>");
    echo('<center><h1>This short URL has been banned by the administrator</h1></center></div>');
    exit();
  }
  $arr1 = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM `information` WHERE binary `shorturl`='$id'"));
  //binary Used to force the same case
  $type = $arr1['type'];
  $shorturlPasswd = $arr1['passwd'];
  $information = $arr1['information'];
  $timemessage = $arr1['time'];
  //Get basic data
  
  function getResult($conn,$type)
  {
    $retun = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM `config` WHERE `type` = '$type'")); 
    return $retun['content'] == "true" ? true:false; 
  }
  
  if(getResult($conn,"QQ") && strpos($_SERVER['HTTP_USER_AGENT'],'QQ/') !== false)
  {
    $ifBrowser = true;
  }else if(getResult($conn,"wechat") && strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false)
  {
    $ifBrowser = true;
  }else{
    $ifBrowser = false;
  }
  
  //Determine user options
  if (empty($type)) {
    $status = "undefind";
    //No data
  } else {
    if ($ifBrowser) {
        //Determine whether the open browser UA is WeChat or QQ
        require_once("./app/openInBrowser.php");
        exit();
    }

    if(!empty($shorturlPasswd) && $_SESSION['id'] !== $id){
        //Encryption If there is a password, and the session is not set 
        //Scenario 2, the value of session is changed to shorturl
        $_SESSION['shorturl_passwd'] = $shorturlPasswd;
        require_once "app/passwd.php";
        exit();
    }
    
    if ($type == 'shorturl') {
      //If the database type is read as a short field
      if (preg_match('/[\x{4e00}-\x{9fa5}]/u',$information) > 0) {
        $informations = parseurl($information);
        //Convert url format (endecode)
      } else {
        $informations = $information;
      }
      if(getResult($conn,"jump"))
      {  //If open
        require_once "app/jump.php";
        exit();
      } else {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: $informations");
        //Change to 301 jump
        exit();
        }
    }
  if ($type == 'passmessage') {
    $status = "passmessage";
    //passmessage
  }
}
}
//The initial judgment is over, enter the add url interface
?>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <title>
    <?php echo $title?>
  </title>
  <link rel="shortcut icon" type="image/x-icon" href="https://cdn.jsdelivr.net/gh/soxft/cdn@1.9/urlshorting/favicon.ico" media="screen" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/soxft/cdn@master/mdui/css/mdui.min.css">
  <script src="https://cdn.jsdelivr.net/gh/soxft/cdn@master/mdui/js/mdui.min.js"></script>
  <script src="//instant.page/1.2.2" type="module" integrity="sha384-2xV8M5griQmzyiY3CDqh1dn4z3llDVqZDqzjzcY+jCBCk/a5fXJmuZ/40JJAPeoU"></script>
  </head>
  <header class="mdui-appbar mdui-appbar-fixed">
  <style>
    a {
      text-decoration:none
    }
    a:hover {
      text-decoration:none
    }
  </style>
  <body background="https://cdn.jsdelivr.net/gh/soxft/cdn@1.9/urlshorting/background.png" class="mdui-drawer-body-left mdui-appbar-with-toolbar">
    <div class="mdui-toolbar mdui-color-theme">
      <span class="mdui-btn mdui-btn-icon mdui-ripple" mdui-drawer="{target: '#main-drawer'}">
        <i class="mdui-icon material-icons">menu</i>
      </span>
      <a href="" class="mdui-typo-title">Urlshorting</a>
    </header>
    <div class="mdui-drawer" id="main-drawer">
      <div class="mdui-list" mdui-collapse="{accordion: true}" style="margin-bottom: 68px;">
        <div class="mdui-list">
          <a href="/" class="mdui-list-item">
            <i class="mdui-list-item-icon mdui-icon material-icons">filter_none</i>
            &emsp;Home
          </a>
          <a href="./help.php" class="mdui-list-item">
          <i class="mdui-list-item-icon mdui-icon material-icons">help_outline</i>
          &emsp;Help
        </a>
        <a href="./admin" class="mdui-list-item">
          <i class="mdui-list-item-icon mdui-icon material-icons">person_outline</i>
          &emsp;Backstage
        </a>
        </div>
        <div class="mdui-collapse-item ">
          <div class="mdui-collapse-item-header mdui-list-item mdui-ripple">
            <i class="mdui-list-item-icon mdui-icon material-icons">&#xe80d;</i>
            &emsp;友链
            <i class="mdui-collapse-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>
          </div>
          <div class="mdui-collapse-item-body mdui-list">
           <a href="https://blog.dtnetwork.top/" class="mdui-list-item mdui-ripple ">💻The Blog Of DTnetwork</a>
          </div>
        </div>
      </div>
    </div>
  </div>
