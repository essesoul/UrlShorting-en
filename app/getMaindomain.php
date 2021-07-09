<?php
function getTopHost($url) {
  $url = strtoupper($url);
  //First convert to lowercase
  $hosts = parse_url($url);
  $host = $hosts['host'];
  //Check the level of domain name
  $data = explode('.',$host);
  $n = count($data);
  //Determine whether it is a double suffix
  $preg = '/[\w].+\.(com|net|org|gov|edu)\.cn$/';
  if (($n > 2) && preg_match($preg,$host)) {
    //Double suffix takes the last 3 digits
    $host = $data[$n-3].'.'.$data[$n-2].'.'.$data[$n-1];
  } else {
    //Non-double suffix takes the last two digits
    $host = $data[$n-2].'.'.$data[$n-1];
  }
  return $host;
}