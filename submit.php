<?php
session_start();
require_once 'app/core.php';
require_once 'config.php';
//Introduce core files
$content = $_POST['content'];
$shorturl = $_POST['shorturl'];
$passwd = $_POST['passwd'];
$type = $_POST['type'];
//If the user chooses a short domain

$arr = Urlshorting($content, $type, $passwd, $shorturl);
if ($arr[0] == 200) {
    echo "200";
    $_SESSION['shorturl'] = $arr[1];
    $_SESSION['passwd'] = $arr[2];
} elseif ($arr[0] == 1001) {
    if ($type == 'shorturl') {
        echo "Illegal URL";
    } else {
        echo "Illegal secret words";
    }
} elseif ($arr[0] == 1002) {
    echo "❌The domain name you entered or your IP has been blocked!";
} elseif($arr[0] == 3001 || $arr[0] == 3002) {
    echo "❌The password can only be 2-20 digits in English, numbers, punctuation or a combination";
}elseif($arr[0] == 2001 || $arr[0] == 2002) {
    echo "❌The custom short domain can only be" . $pass . "Digits in English, numbers or combinations";
}elseif($arr[0] == 2003) {
    echo "❌This short domain has already been used!";
}else{
    echo "error: " . $arr[0];
}

?>