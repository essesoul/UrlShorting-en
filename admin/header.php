<!--
Copyright attribution: XCSOFT
Modification time: 2019/06/28
Email: contact#xcsoft.top (replace # with @)
If you have any questions, please feel free to contact!
-->
<!--
   Secondary Developed By k6o.top
   Contact us: Gary@dtnetwork.top
-->
<?php
require_once('../config.php');
//Include the config.php of the previous folder
session_start();
//Open session
$password = $_SESSION['password'];
?>
<head>
  <link rel="icon" type="image/x-icon" href="https://cdn.jsdelivr.net/gh/soxft/cdn@1.9/urlshorting/favicon.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/soxft/cdn@master/mdui/css/mdui.min.css">
  <script src="https://cdn.jsdelivr.net/gh/soxft/cdn@master/mdui/js/mdui.min.js"></script>
  <style>
    a {
      text-decoration:none
    }
    a:hover {
      text-decoration:none
    }
  </style>
</head>
  <body background="https://cdn.jsdelivr.net/gh/soxft/cdn@1.9/urlshorting/background.png">
   <?php
   if ($_SESSION['password'] !== $passwd) {
    //Determine whether to log in
    header("Refresh:0;url=\"./login.php\"");
    exit();
}
?>
    <div class="mdui-tab mdui-tab-full-width mdui-tab-centered">
        <a href="./index.php" class="mdui-ripple">Manage homepage</a>
        <a href="./ban.php" class="mdui-ripple">BAN</a>
        <a href="./control.php" class="mdui-ripple">Short domain management</a>
        <a href="./preferences.php" class="mdui-ripple">Preferences</a>
        <a href="./oauth.php" class="mdui-ripple">oauth</a>
        <a href="./logout.php" class="mdui-ripple">sign out</a>
        <a href="../index.php" class="mdui-ripple">Back</a>
    </div>
    
   