<?php
if (!file_exists("install.lock")) {
    header("Refresh:0;url=\"./install.php\"");
    exit("Jumping to the installation interface...");
}
//Check if it has been installed
require_once "header.php";
require_once "config.php";
//Start judgment processing
if ($status == "undefind" || empty($status)) {
?>
  <br/><center><br/><img src="https://3gimg.qq.com/tele_safe/safeurl/img/notice.png" widht="85"  height="85" alt="错误"></center>
  <center><h2>❌The page you visited does not exist!</h2></center>
<?php
    require_once "footer.php";
    exit();
}
if ($status == "passmessage") {
    //If the database type is read as a passphrase 
?>
      <br />
      <div class="mdui-card.mdui-card-media-covered-transparent">
        <div class="mdui-card-primary">
          <div class="mdui-card-primary-subtitle"><?php echo date('Y year m month d day H hour i minute s second',$timemessage) ?></div>
            <center>
              <div class="mdui-card-primary-title" style="word-break:break-all;">
                「<?php echo htmlspecialchars($information)?>」
              </div>
            </center>
          </div>
        </div>
      </div>
    <br/>
<?php
      require_once "footer.php";
      exit();
    }
    //At this point, the end of the passphrase is displayed
    //Because in order to solve the speed problem, the jump of the url is placed directly before the display of css, that is, the beginning of header.php
    unset($_SESSION['shorturl']);  //Delete the session of shorturl's session submit and jump to the session of shorturl.php
    //unset($_SESSION['passwd']); //Delete the last short domain session
?>
<br/>
<div class="mdui-container doc-container">
    <div class="mdui-typo">
        <h2>Short URL</h2>
        <div class="mdui-textfield">
            <textarea id="content" class="mdui-textfield-input" type="text" placeholder="*Please enter a long link or passphrase"></textarea>
        </div>
        <div style="float: left; width: 49.2%;" class="mdui-textfield">
            <input id="shorturl" class="mdui-textfield-input" type="text" placeholder="Please enter a custom short chain (optional)"/>
        </div>
        <div style="float: right; width: 49.2%;" class="mdui-textfield">
            <input id="passwd" class="mdui-textfield-input" type="text" placeholder="Please enter the encryption password (optional)"/>
        </div>
        
        <button onClick="submit();" id="submit" class="mdui-btn mdui-btn-dense mdui-color-theme-accent mdui-ripple">
          <i class="mdui-icon material-icons">send</i>
        </button>
        <label class="mdui-radio">
          <input onclick='change("shorturl")' type="radio" name="type" id="type"  value="shorturl" checked />
          <i class="mdui-radio-icon"></i>Short URL
        </label>
        &emsp;&emsp;
        <label class="mdui-radio">
          <input onclick='change("passmessage")' type="radio" name="type" id="type"  value="passmessage" />
          <i class="mdui-radio-icon"></i>Passphrase
        </label>
    </div>
</div>
<script>
var $ = mdui.JQ;

function change(type)
{
  if(type == 'shorturl')
  {
    $('#content').removeAttr('rows');
    $('#content').removeAttr('cols');
  }else{
    $('#content').attr('rows','10');
    $('#content').attr('cols','10');
  }
}

function submit(){
  type = $('input[name="type"]:checked').val();
  content = $('#content').val();
  shorturl = $('#shorturl').val();
  passwd = $('#passwd').val();
  $('#submit').attr('disabled',true)
  $('#submit').text('处理中...')
  $.ajax({
    method: 'post',
    timeout: 10000,
    url: 'submit.php',
    data: {
      type: type,
      content: content,
      shorturl: shorturl,
      passwd: passwd
    },
    success: function(data)
    {
      if(data == 200)
      {
        mdui.snackbar({
         message: '✔️Shorten success!',
         position: 'right-top',
         timeout: 0
       });
       window.setTimeout("window.location='shorturl.php'",2000);
      }else{
        mdui.snackbar({
         message: '❌Shortening failed: <br/>Prompt message: ' + data,
         position: 'right-top'
       });
      }
    },
    complete: function(xhr,textStatus) 
    {
      $('#submit').html('<i class="mdui-icon material-icons">send</i>')
      $('#submit').removeAttr('disabled');
      if(textStatus == 'timeout')
      {
        mdui.snackbar({
         message: '❌Request timed out!',
         position: 'right-top'
       });
      }
    }
  });
}

</script>
<div class="mdui-container doc-container">
    <div class="mdui-typo">
         <h2>Help</h2>
         1. Enter the short domain, please add http(s)://<br />
         2. Please manually encode the Chinese domain name with Punycode before using<br />
         3. The URL supports up to 1000 characters<br />
         4. The longest support for the secret language is 3000 characters (1000 Chinese characters)<br />
         5. Manually fill in the short field and password as optional items<br />
         6. Password limit 2-20 digits (digital password combination) / short domain limit input <?php echo $pass ?> digits<br/>
         7. For the rest, please refer to the menu-help interface
    </div>
</div>
<?php require_once "footer.php"; ?>
