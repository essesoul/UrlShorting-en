<html>
    <head>
    <?php require_once('../config.php'); ?>
        <?php require_once("./header.php");?>
    </head>
    <body>
        <?php
          session_destroy();
          echo("<center><h2><br/>✔️You have successfully logged out! Jumping!</h2></center>");
          header("Refresh:1;url=\"../index.php\"");
        ?>
    </body>
  <?php require_once("../footer.php"); ?>
</html>