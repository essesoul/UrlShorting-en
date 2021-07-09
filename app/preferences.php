<?php
require_once("../config.php");
header('Content-type:text/json');
header('Access-Control-Allow-Origin:*');
session_start();
$pass = $_GET['password'];
if(md5($_SESSION['password']) !== $pass)
{
  $json = [
      'code' => '1001',
      'msg' => 'Illegal access'
    ];
  exit(json_encode($json,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
}
//Safety inspection
$method = $_GET['method'];
$content = $_GET['content'];
$status = $_GET['status'];
//Basic information acquisition
function getResult($conn,$which)
{
   return mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM `config` WHERE `type` = '$which'"))['content'];
}
switch ($method) {
  case "set":
    mysqli_query($conn,"UPDATE `config` SET `content`='$status' WHERE `type` = '$content'");
    $json = [
      'code' => '200'
    ];
    exit(json_encode($json,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
  break;
}
//Set the protocol header