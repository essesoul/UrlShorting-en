<!-- This source code is based on apache2 open source, you can modify other content arbitrarily without modifying the copyright -->
<!--To modify the site construction date, please go to line 41-->
<br />
<footer>
    <?php //Extract host from url
    $arr = parse_url($url);
    echo $host = $arr['host'];
    ?>

    <center>

        <div class="mdui-divider"></div>
        <p><a class="mdui-text-color-grey-800" href=<?php echo $url ?>>👉Go to homepage👈</a></p>
        <p id="hitokoto">:D Acquiring...</p>
        <div class="footer-copyright">Copyright © 2019-
            <?php echo date( 'Y') ?> <a class="mdui-text-color-grey-800" href="http://xsot.cn">XCSOFT</a> All rights reserved.⚡ 
            <p>Secondary Developed By <?php echo date( 'Y') ?>-<a class="mdui-text-color-grey-800" href=""> k6o</a>.😉</p>
        </div>
       
        
            <!--Website running time, please modify the date value by yourself(line 41)-->
            <p id="RunTime" style="color:Dark;"></p>
               <script>
                 var BootDate = new Date("2021/06/13 00:00:00");
                 function ShowRunTime(id) {
                 var NowDate = new Date();
                 var RunDateM = parseInt(NowDate - BootDate);
                 var RunDays = Math.floor(RunDateM/(24*3600*1000));
                 var RunHours = Math.floor(RunDateM%(24*3600*1000)/(3600*1000));
                 var RunMinutes = Math.floor(RunDateM%(24*3600*1000)%(3600*1000)/(60*1000));
                 var RunSeconds = Math.round(RunDateM%(24*3600*1000)%(3600*1000)%(60*1000)/1000);
                 var RunTime = RunDays + "Day" + RunHours + "Hour" + RunMinutes + "Minute" + RunSeconds + "Second";
                 document.getElementById(id).innerHTML = "This site has been operating stably:" + RunTime;
                 }
                 setInterval("ShowRunTime('RunTime')", 1000);
               </script>      
    </center>
</footer>