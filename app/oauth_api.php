<?php
/*
  Third-party login Ajax processing address
*/
    session_start();
    require_once "../config.php";
    header('Content-type:text/json');
    header('Access-Control-Allow-Origin:*');
    //Letter verification measures
    if ($_SESSION['password'] !== $passwd) {
      //Determine whether to log in
       $data = array('code' => 444,'msg' => 'Unauthorized access');
    }
    $method = $_POST['method'];
    switch($method){
        case 'del':
          $arr = explode(",",mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `config` WHERE type='xoauth'"))['content']);
          unset($arr[array_search($_POST['user'],$arr)]);
          $str = implode(",",$arr);
          mysqli_query($conn,"UPDATE `config` SET `content`='$str' WHERE `type` = 'xoauth' ");
          $data = array('code' => 200,'msg' => 'SUCCESS');
        break;
    }
    exit(json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
