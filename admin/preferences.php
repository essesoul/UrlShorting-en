<?php require_once("./header.php");?>
<title>Preferences</title>
<div class="mdui-container">
  <div class="mdui-typo">
    <h2 class="doc-chapter-title doc-chapter-title-first">Preferences</h2>
    <div class="mdui-container">
      <div class="mdui-typo">
        <h4 class="doc-chapter-title doc-chapter-title-first">Anti-red setting</h4>
        <ul class="mdui-list">
          <li class="mdui-list-item mdui-ripple">
            <i class="mdui-list-item-icon mdui-icon material-icons">chat</i>
            <div class="mdui-list-item-content">
              Wechat
            </div>
            <label class="mdui-switch mdui-valign">
              <input id="wechat" onclick="switchx('wechat')" type="checkbox" />
              <i class="mdui-switch-icon"></i>
            </label>
          </li>
          <li class="mdui-list-item mdui-ripple"> <i class="mdui-list-item-icon mdui-icon material-icons">chat_bubble_outline</i>
            <div class="mdui-list-item-content">
              QQ
            </div>
            <label class="mdui-switch mdui-valign">
              <input id="QQ" onclick="switchx('QQ')" type="checkbox" />
              <i class="mdui-switch-icon"></i>
            </label>
          </li>
        </ul>
      </div>
    </div>
    <div class="mdui-container">
      <div class="mdui-typo">
        <h4 class="doc-chapter-title doc-chapter-title-first">Jump settings</h4>
        <ul class="mdui-list">
          <li class="mdui-list-item mdui-ripple">
            <i class="mdui-list-item-icon mdui-icon material-icons">rotate_90_degrees_ccw</i>
            <div class="mdui-list-item-content">
            Jump and stay
            </div>
            <label class="mdui-switch mdui-valign">
              <input id="jump" onclick="switchx('jump')" type="checkbox" />
              <i class="mdui-switch-icon"></i>
            </label>
          </li>
          <li class="mdui-list-item mdui-ripple">
            <i class="mdui-list-item-icon mdui-icon material-icons">gavel</i>
            <div class="mdui-list-item-content">
            URL detection
            </div>
            <label class="mdui-switch mdui-valign">
              <input id="urlcheck" onclick="switchx('urlcheck')" type="checkbox" />
              <i class="mdui-switch-icon"></i>
            </label>
          </li>
        </ul>
      </div>
    </div>
</div>
</div>
<div class="mdui-container">
    <div class="mdui-typo">
      <h2 class="doc-chapter-title doc-chapter-title-first">Notice</h2>
      &emsp;1. Anti-red setting: whether it prompts the browser to open when the designated software is opened.<br/>
      &emsp;2. Jump and stay: whether the user is prompted to jump to the web page when accessing the short domain<br/>
      &emsp;3. URL detection: Check whether the URL is safe in the jump and stay interface (it is valid when the jump and stay must be turned on)<br/>
    </div>
</div>
<br />
<?php 
  function getResult($conn,$type)
  {
    $retun = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM `config` WHERE `type` = '$type'")); 
    return $retun['content'] == "true" ? true:false; 
  }
?>
<script>
var $ = mdui.JQ;
function switchx(type) {
    $('#' + type + '').attr("disabled", true);
    var x = $('#' + type + '').is(':checked', true);
    //console.log(type + "=>" + x);
    $.ajax({
    method: 'GET',
    timeout: 10000, //10 secondes timeout
    url: '../app/preferences.php',
    data: {
        method: 'set',
        content: type,
        status: x?true:false,
        password: '<?php echo md5($password) ?>'
    },
    success: function(data) {
      $('#' + type + '').removeAttr('disabled')
        mdui.snackbar({
         message: 'Successful operation!',
         position: 'right-top'
       });
        if(type == 'jump')
        {
          if(x?true:false){
            $('#urlcheck').removeAttr("disabled");
          }else{
            $('#urlcheck').attr("disabled", true);
          }
        }
    },
    complete: function (xhr, textStatus) 
    {
       $('#' + type + '').removeAttr('disabled')
      if(textStatus == 'timeout')
      {
        mdui.snackbar({
         message: 'Timeout!',
         position: 'right-top'
       });
      }
    }
    });
}
        //console.log(QQ+'  '+wechat)
        $('#QQ').prop('checked', <?php echo getResult($conn,"QQ") ?>);
        $('#wechat').prop('checked', <?php echo getResult($conn,"wechat"); ?>);
        $('#jump').prop('checked', <?php echo getResult($conn,"jump") ?>);
        //Jump stay must be turned on
        if("<?php echo getResult($conn,"jump") ?>"==""?true:false)
        {
          $('#urlcheck').prop('checked', <?php echo getResult($conn,"urlcheck") ?>); 
          $('#urlcheck').attr("disabled", true);
        }else{
          $('#urlcheck').prop('checked', <?php echo getResult($conn,"urlcheck") ?>); 
        }
</script>
<?php require_once("../footer.php");
?>