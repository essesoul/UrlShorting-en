<?php require_once "header.php"; ?>
<title>Home</title>
<div class="mdui-container">
  <h2 style="font-weight:400">system message</h2>
  <ul class="mdui-list">
    <li class="mdui-list-item mdui-ripple">
      <i class="mdui-list-item-icon mdui-icon material-icons">grain</i>
      <div class="mdui-list-item-content">
      Short domain: <?php getNum($conns,'information') ?>
      </div>
    </li>
    <li class="mdui-list-item mdui-ripple">
      <i class="mdui-list-item-icon mdui-icon material-icons">not_interested</i>
      <div class="mdui-list-item-content">
        BAN: <?php getNum($conns,'ban') ?>
      </div>
    </li>
    <li class="mdui-list-item mdui-ripple">
      <i class="mdui-list-item-icon mdui-icon material-icons">panorama_vertical</i>
      <div class="mdui-list-item-content">
        PHP: <?PHP echo PHP_VERSION; ?>
      </div>
    </li>
    <li class="mdui-list-item mdui-ripple">
      <i class="mdui-list-item-icon mdui-icon material-icons">airplay</i>
      <div class="mdui-list-item-content">
      system: <?PHP echo php_uname('s'); ?>
      </div>
    </li>
    <li class="mdui-list-item mdui-ripple">
      <i class="mdui-list-item-icon mdui-icon material-icons">web</i>
      <div class="mdui-list-item-content">
        server: <?PHP echo $_SERVER['SERVER_SOFTWARE']; ?>
      </div>
    </li>
    <li class="mdui-list-item mdui-ripple">
      <i class="mdui-list-item-icon mdui-icon material-icons">dns</i>
      <div class="mdui-list-item-content">
        host name: <?PHP echo php_uname('n');  ?>
      </div>
    </li>
  </ul>
</div>
<?php
function getNum($conns,$tablename){
    echo mysqli_fetch_assoc(mysqli_query($conns,"select * from `TABLES` where `TABLE_NAME`='$tablename'"))['TABLE_ROWS'];
}
?>
<script>
var $ = mdui.JQ;
$.ajax({
  method: 'get',
  url: 'https://xsot.cn/api/update/notice.php',
  timeout: 10000,
  data: {
    app: 'urlshorting'
  },
  success: function(data)
  {
    data = eval('(' + data + ')');
    //console.log(data)
    len = Object.keys(data).length;
    len = len > 5 ? 5 : len;
    //console.log(len)
    //console.log(data['0']['content'])
    html = '';
    for(i = 0;i <= len-1;i++)
    {
      content = data[i]['content'];
      url = data[i]['url'];
      date = data[i]['date'];
      if(date == '')
      {
        info = content
      }else{
        info = date + ' | ' + content;
      }
      html += '\
      <li class="mdui-list-item mdui-ripple">\
        <div class="mdui-list-item-content" onclick="window.open(\'' + url + '\')">\
          ' + info + '\
        </div>\
      </li>';
    }
    //console.log(html)
    $('#officalInfo').replaceWith(html);
  },
  complete: function (xhr, textStatus) 
    {
      if(textStatus == 'timeout')
      {
        $('#officalInfo').replaceWith('<li class="mdui-list-item mdui-ripple"><div class="mdui-list-item-content">请求超时...</div></li>');
      }
    }
});
</script>
<?php require_once "../footer.php";  ?>