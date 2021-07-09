<html>
<head>
    <title>Short domain management</title>
    <?php
    require_once("./header.php");
    $p = $_GET['p'];
    if(empty($p) || $p < "1")
    {
      $p = "1";  //If there is no page then define a default page  = 0
    }
    $page  = ($p - 1) * $px;
    //Calculate the number of data
  $mysql = "select * from `TABLES` where `TABLE_NAME`='information';";
  $result = mysqli_query($conns,$mysql);
  $arr = mysqli_fetch_assoc($result);
  $page_allx =  $arr['TABLE_ROWS'];  //All data
 if($page_allx >= $px)
 {
  if($page_allx % $px == 0){
    $page_all = $page_allx / $px; // Calculate the total number of pages  
  }else{
    $page_all = ($page_allx - ($page_allx % $px)) / $px;
  }
 }else{
   $page_all = 1;
 }
    echo "<h4>TIP:Due to the characters, the table is not fully displayed.Mobile users can swipe to the left to see more information, and computer users can scroll to the bottom of the table and drag the control bar.</h4>";
    echo "<br /><center><div class=\"mdui-table-fluid\">
                        <table class=\"mdui-table mdui-table-hoverable\">
                            <tr>
                            <th>Short domain</th>
                            <th>Content</th>
                            <th>Type</th>
                            <th>ip</th>
                            <th>Password</th>
                            <th>Time</th>
                            <th>Short domain status</th>
                            <th>IP status</th>
                            <th>Management</th>
                            </tr>";
// Beginning of table
  $comd = "SELECT * FROM `information` order by time DESC limit $page,$px";
    $sql = mysqli_query($conn,$comd);
    while ($row = mysqli_fetch_object($sql)) {
        $comd1 = "SELECT * FROM `ban` WHERE content='$row->shorturl'";
        $count1 = mysqli_query($conn,$comd1);
        $arr2 = mysqli_fetch_assoc($count1);
        $type = $arr2['type'];
        if (empty($type)) {
            $check = "normal";
        } else {
            $check = "BAN";
        }
        $comd2 = "SELECT * FROM `ban` WHERE content='$row->ip'";
        $count2 = mysqli_query($conn,$comd2);
        $arr3 = mysqli_fetch_assoc($count2);
        $type2 = $arr3['type'];
        if (empty($type2)) {
            $check2 = "normal";
        } else {
            $check2 = "BAN";
        }    //Determine whether it has been banned
        $information = mb_strlen($row->information) >= 20 ? mb_substr($row->information,0,20) : $row->information;
            echo "
      <tr>
        <td>$row->shorturl</td>
        <td>$information</td>
        <td>$row->type</td>
        <td>$row->ip</td>
        <td>$row->passwd</td>
        <td>".date("Y-m-d H:i:s",$row->time)."</td>
        <td>$check</td>
        <td>$check2</td>
        <td>
          <a href=\"./processing.php?shorturl=$row->shorturl&&type=del\" class=\"mdui-btn mdui-btn-raised mdui-ripple\">删除</a>";
if($check=="normal"){
  echo "<a href=\"./processing.php?shorturl=$row->shorturl&&type=domain\" class=\"mdui-btn mdui-btn-raised mdui-ripple\">封短域</a>";
}else{
  echo "<a href=\"./processing.php?content=$row->shorturl&&type=cancel&&from=control\" class=\"mdui-btn mdui-btn-raised mdui-ripple\">解短域</a>";
}
if($check2=="normal"){
  echo "<a href=\"./processing.php?ip=$row->ip&&type=ip\" class=\"mdui-btn mdui-btn-raised mdui-ripple\">封ip</a>";
}else{
  echo "<a href=\"./processing.php?content=$row->ip&&type=cancel&&from=control\" class=\"mdui-btn mdui-btn-raised mdui-ripple\">解IP</a>";
}              
     echo"</td></tr>";
    }
    echo "</table></div>";
    
    $page_next = $p+1;
    $page_last = $p-1;
    //Calculate the page of the previous or next page
    echo "<br />";
    if($p != 1){
      echo  "<a href=\"./control.php?p=$page_last\" class=\"mdui-btn mdui-btn-raised mdui-ripple\">上一页</a>";
    }
    echo "&emsp;"; 
    if($p != $page_all){
      echo "<a href=\"./control.php?p=$page_next\" class=\"mdui-btn mdui-btn-raised mdui-ripple\">下一页</a>"; 
    }
    //Button jump
    echo "<br />";
    ?>
</body>
<?php require_once("../footer.php");
?>