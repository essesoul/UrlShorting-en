<html>
<head>
  <title>BAN</title>
  <?php
  require_once("./header.php");
  $comd = "SELECT * FROM `ban` order by time DESC";
  $sql = mysqli_query($conn,$comd);
  $arr=mysqli_fetch_assoc($sql);
  $content=$arr['content'];
  if (empty($content))
  {
    echo("<center><h2>No more information at the moment</h2></center>");
    require_once("../footer.php");
    exit();
  }else{
    echo "Has been banned:<br /><br /><center><div class=\"mdui-table-fluid\">
                        <table class=\"mdui-table mdui-table-hoverable\">
                            <tr>
                                <th>species</th>
                                <th>IP or short domain</th>
                                <th>status</th>
                            </tr>";
  }
  $comd = "SELECT * FROM `ban` order by time DESC";
  $sql = mysqli_query($conn,$comd);
  while ($row = mysqli_fetch_object($sql)) {
      echo("
      <tr>
        <td>$row->type</td>
        <td>$row->content</td>
              <td>
              <a href=\"./processing.php?content=$row->content&&type=cancel&&from=ban\" class=\"mdui-btn mdui-btn-raised mdui-ripple\">解除</a>
              </td>

      </tr>");
  }
  echo("</table></div>");
  ?>
</body>
<?php 
require_once("../footer.php");
?>
