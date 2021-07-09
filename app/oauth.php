<?php
/*
  Third-party login callback address
*/
  require_once "../config.php";
  define('CLIENT_ID','8us3lhiuyiOlyT3KitpWvtIwGindm5');
  define('CLIENT_SECRET','8us3lhiuyiOlyT3KitpWvtIwGindm5');
  session_start();
  $code = $_GET['code'];
  if(empty($code))
  {
    echo "<h2>Unauthorized access</h2>";
    header("Refresh:2;URL='../admin/login.php'");
  }
  
  $arr = json_decode(file_get_contents('https://9420.ltd/v1/token.php?code='. $code . "&client_id=".CLIENT_ID."&client_secret=".CLIENT_SECRET),true);

  if($arr['code'] == '200')
  {
    $url = 'https://9420.ltd/v1/resourse.php?access_token=' . $arr['access_token'].'&client_secret='.CLIENT_SECRET;
    $return = json_decode(file_get_contents($url),true);
    $username = $return['username']; 
    $arr = explode(",",mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `config` WHERE type='xoauth'"))['content']);
    if(empty($arr[0]))
    {
      //Prevent the problem of empty data
      $arr = array();
    }
    if(array_search($username,$arr) !== false){
      //Existing users
      $_SESSION['password'] = $passwd;
      header("Refresh:0;URL='../admin'");
    } else {
      echo "<h2>Unknown user, please add the user in the background -> third party login first!</h2>";
      header("Refresh:2;URL='../admin/login.php'");
    }
  } else{
    echo "<h2>An unknown error occurred! Error code:" . $arr['code']."</h2>";
    header("Refresh:2;URL='../admin/login.php'");
  }
