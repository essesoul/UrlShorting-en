<?php
/*
    Encrypted page
     Date:20200723
     Author: XCSOFT
     Provide session implementation
*/
  session_start(); 
  if(isset($_POST['passwd']))
  {
      if($_POST['passwd'] == $_SESSION['shorturl_passwd'])
      {
          $_SESSION['id'] = $_POST['id'];
          echo 200;
          exit();
      }else{
          echo 1001;
          exit();
      }
  }else{
 ?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/soxft/cdn@master/mdui/css/mdui.min.css">
        <script src="https://cdn.jsdelivr.net/gh/soxft/cdn@master/mdui/js/mdui.min.js"></script>
        <title>
        Encrypted page
        </title>
    </head>
    <body>
    <div style="Height:40px"></div>
    <div class="mdui-container" style="max-width: 400px;">
        <div class="mdui-card">
                <div class="mdui-card-menu">
                    <button onclick="window.location.href='/'" class="mdui-btn mdui-btn-icon mdui-text-color-grey"><i class="mdui-icon material-icons">home</i>
                    </button>
                </div>
            <div class="mdui-card-primary">
                <div class="mdui-card-primary-title">Please enter the password</div>
                <div class="mdui-card-primary-subtitle">Please Input Passwd</div>
            </div>
            <div class="mdui-card-content">
                <div class="mdui-textfield">
                    <input class="mdui-textfield-input" id="passwd" type="password" placeholder="Please enter the password"/>
                </div>
                <br>
            </div>
            <div class="mdui-card-actions">
                <center>
                    <button id="btn" onclick="submit()" class="mdui-btn mdui-ripple mdui-btn-dense">confirm</button>
                </center>
            </div>
        </div>
    </div>
    <script>
    var $ = mdui.JQ;
	function submit()
	{
	    passwd = $('#passwd').val();
	    $('#btn').attr('disabled',true);
      $('#btn').text('Processing...');
	    //Build an ajax request
	    $.ajax({
	       method: 'post',
	       url: 'app/passwd.php',
	       timeout: 100000, 
	       data: {
	           passwd: passwd,
	           id: '<?php echo $id ?>'
	       },
	       success: function(data)
	       {
	           if(data == 200)
	           {
	              mdui.snackbar({
                    message: 'Password is correct, redirecting..',
                    position: 'right-top'
                }); 
                window.setTimeout("window.location.reload();", 3000);
	           }else{
	               mdui.snackbar({
                    message: 'Wrong password!',
                    position: 'right-top'
                });
	           }
	       },
	       complete: function(xhr,status)
	       {
	           $('#btn').text('confirm');
	           $('#btn').removeAttr('disabled')
	           if(status == 'timeout')
	           {
	            mdui.snackbar({
                    message: 'Request timed out!',
                    position: 'right-top'
                });
	           }
	       }
	    });
	}
    </script>
    <?php } ?>
    </body>