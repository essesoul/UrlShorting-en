<?php
session_start();
if(!isset($_SESSION['shorturl']))
{
 header("Refresh:0;url=\"./index.php\"");
 exit();
}
require_once "header.php";
//require_once "app/qrcode.php";
$shorturl = $_SESSION['shorturl'];
$urlpasswd = $_SESSION['passwd'];
if(empty($urlpasswd)){
    $text = $shorturl; 
}else{
    $text = "link: " . $shorturl . " | password: " . $urlpasswd;
}
?>
<div class="mdui-container doc-container">
    <div class="mdui-typo">
        <h2>Shorten success!🎉</h2>
        <center>
          <br />
          <div id="qrcode"></div>
          <h3>Short link (click on the link to copy):<div class="URL" id="URL" data-clipboard-text="<?PHP echo $text; ?>"><?PHP echo($shorturl); ?><?php if(!empty($urlpasswd)):?><br/>password: <?php echo $_SESSION['passwd'] ?>
          <?php endif ?>
          </h3>
          </div>
        </center>
    </div>
</div>
<style>
.URL{
  cursor:pointer;
}
</style>
<script src="https://cdn.jsdelivr.net/gh/soxft/cdn@master/jquery/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/soxft/cdn@1.9/urlshorting/clipboard.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/soxft/cdn@2.7/jquery/jquery-qrcode/jquery.qrcode.min.js"></script>
<script>
    $('#qrcode').qrcode
    ({
      width: 150,
      height: 150,
      render: "table",
      correctLevel:0,
      text: '<?php echo $shorturl ?>'
    });

  new ClipboardJS(".URL");
  $(".URL").click(function() {
    mdui.snackbar({
      message: "Link copied✔️"
    });
  }) 
</script>


<?php
require_once "footer.php";
?>
