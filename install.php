<title>Installer</title>
<body background="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/soxft/cdn@master/mdui/css/mdui.min.css">
  <script src="https://cdn.jsdelivr.net/gh/soxft/cdn@master/mdui/js/mdui.min.js"></script>
  <br />
  <center><h2>Installer</h2></center>
  <?php
  $lockfile = "install.lock";
  if (file_exists($lockfile)) {
    exit("<center><h3>You have already installed it, if you need to reinstall, please delete install.lock in the root directory first (if you only need to modify the content, please visit the database to modify the config table<br />If you have any questions, please Contact Gary@dtnetwork.top)</center></h3>");
  }
  if (!isset($_POST['submit'])) {
    ?>
    <form action="" method="post" enctype="multipart/form-data">
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">Database address</label>
        <input name="db_host" type="text" class="mdui-textfield-input" value="localhost" />
      </div>
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">Database username</label>
        <input name="db_username" type="text" class="mdui-textfield-input" />
      </div>
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">Name database</label>
        <input name="db_name" type="text" class="mdui-textfield-input" />
      </div>
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">Database password</label>
        <input name="db_password" type="password" class="mdui-textfield-input" />
      </div>
      <br />
      <br />
      <br />
      <hr><hr>
      <br />
      <br />
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">Website domain name</label>
        <input name="url" type="text" class="mdui-textfield-input" value="http://<?php echo$_SERVER['HTTP_HOST'] ?>/" />
      </div>
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">The number of letters or numbers required after the short URL</label>
        <input name="pass" type="text" class="mdui-textfield-input" value="4" />
      </div>
      <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">Manage password</label>
        <input name="passwd" type="text" class="mdui-textfield-input" value="admin" />
      </div>
      <br />
      <center>
        <input class="mdui-btn mdui-btn-raised mdui-ripple" type="submit" name="submit" value="安装" />
      </center>
      </form>
      <?php
    } else {
      if (empty($_POST['db_host']) || empty($_POST['db_username']) || empty($_POST['db_name']) || empty($_POST['db_password']) || empty($_POST['url']) || empty($_POST['title']) || empty($_POST['title1']) || empty($_POST['pass']) || empty($_POST['passwd'])) {
        exit("<br/><center><h1>Please check whether you have filled in all the content and try again!</h1></center>");
      } else {
        $db_host = $_POST['db_host'];
        $db_username = $_POST['db_username'];
        $db_password = $_POST['db_password'];
        $db_name = $_POST['db_name'];
        $url = $_POST['url'];
        $title = $_POST['title'];
        $title1 = $_POST['title1'];
        $pass = $_POST['pass'];
        $passwd = $_POST['passwd'];
      }
      $conn = mysqli_connect($db_host,$db_username,$db_password,$db_name);
      if ($conn) {
      $banx = "CREATE TABLE ban (
        type varchar(10) NOT NULL,
        content	varchar(999) NOT NULL,
        time varchar(999) NOT NULL
      )";
      $informationx = "CREATE TABLE information(
        information	mediumtext NOT NULL,
        shorturl char(20)	NOT NULL,
        type char(20)	NOT NULL,
        passwd mediumtext NOT NULL,
        time char(20)	NOT NULL,
        ip char(20)	NOT NULL
      )";
      $config = "CREATE TABLE config(
        type mediumtext NOT NULL,
        content mediumtext	NOT NULL
      )";
      mysqli_query($conn,$banx);
      mysqli_query($conn,$informationx);
      mysqli_query($conn,$config);
      function configAdd($conn,$type,$content)
      {
        mysqli_query($conn,"INSERT INTO `config` VALUES('$type','$content')");
      }
      configAdd($conn,'url',$url);
      configAdd($conn,'title',$title);
      configAdd($conn,'title1',$title1);
      configAdd($conn,'pass',$pass);
      configAdd($conn,'strPolchoice',"123"); //url style
      configAdd($conn,'passwd',$passwd);
      configAdd($conn,'wechat','true');
      configAdd($conn,'QQ','true');
      configAdd($conn,'jump','true');
      configAdd($conn,'urlcheck','true');
      configAdd($conn,'xoauth','');
      configAdd($conn,'px','25');
      configAdd($conn,'version','2.1.5');
      } else {
        exit("<br/><center><h1>Database connection failed! Please confirm that the database information is filled in correctly!</h1></center>");
      }
      //Write database
      $config_file = "config.php";
      $config_strings = "<?php\n";
      $config_strings .= "\$conn=mysqli_connect(\"".$db_host."\",\"".$db_username."\",\"".$db_password."\",\"".$db_name."\");\n";
      $config_strings .= "\$conns=mysqli_connect(\"".$db_host."\",\"".$db_username."\",\"".$db_password."\",\"information_schema\");\n//你的数据库信息\n";
      $config_strings .= "function content(\$info)\n";
      $config_strings .= "{\n";
      $config_strings .= "global \$conn;    //Global variable\n";
      $config_strings .= "\$comd = \"SELECT * FROM `config` where `type` = '\$info';\";\n";
      $config_strings .= "\$sql = mysqli_query(\$conn,\$comd);\n";
      $config_strings .= "\$arr = mysqli_fetch_assoc(\$sql);\n";
      $config_strings .= "return \$arr['content'];\n";
      $config_strings .= "}\n";
      $config_strings .= "\$url = content(\"url\");         \n//Your website address, don't forget the last'/'\n";
      $config_strings .= "\$title1 = content(\"title1\");   \n//Website title (displayed on the web page)\n";
      $config_strings .= "\$title = content(\"title\");   \n//Website title (shown in the webpage tag)\n";
      $config_strings .= "\$pass = content(\"pass\");       \n//The number of letters or numbers required after the short URL, 4 or more are recommended, and the longest is 20! (Please fill in the numbers)\n";
      $config_strings .= "\$strPolchoice = content(\"strPolchoice\");   \n//The content of the short URL, that is, the characters that will appear after the short URL\n";
      $config_strings .= "\$passwd = content(\"passwd\");   \n//Set administrative password\n";
      $config_strings .= "\$px = content(\"px\");      \n//The number of short domains displayed on the short domain management page at one time\n";
      $config_strings .= "\$version = content(\"version\");      \n//Current version number--please do not modify\n";
      $config_strings.= "?>";
      //document content
      $fp = fopen($config_file,"wb");
      fwrite($fp,$config_strings);
      fclose($fp);
      //write config.php
      $fp2 = fopen($lockfile,'w');
      fwrite($fp2,'Install the lock file, do not delete it!');
      fclose($fp2);
      //Write registration lock
      echo "<br/><center><h1>The installation is successful! After 4s, you will be automatically redirected to the background login interface!</h1></center>";
      echo "<br/><center><h1>You can enter the background to enter more settings!</h1></center>";
      echo "<br/><center><h2>Please note that you also need to manually configure the website pseudo-static. For the website pseudo-static configuration information, please refer to the content written in the `README.md` in the root directory.</h2></center>";
      header("Refresh:4;url=\"./admin/\"");
    }
    ?>
