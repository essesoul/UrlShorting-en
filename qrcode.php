<?php
if(empty($arr['shorturl'])){
    $value = $url . $shorturl; //QR code content 
}else{
    $value = $arr['shorturl'];
}
      $name = null;
      $max = strlen($strPol)-1;
      $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        for($i=0;$i<4;$i++){
          $name.=$strPol[rand(0,$max)];
         }
$qrcodename='./qrcode/' . $name  . '.png';
include './app/phpqrcode.php';    
  
$errorCorrectionLevel = 'L';//Fault tolerance level  
$matrixPointSize = 5;//Generated image size   
//Generate QR code image  
QRcode::png($value,$qrcodename,$errorCorrectionLevel,$matrixPointSize,2);   
echo '<center><img src=' . $qrcodename . '></center>'; 
echo("<br/>");
?>