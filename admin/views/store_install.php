<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle>
<b>Центр приложений<?php echo $source_typename;?></b>
<div class=line></div>
<div id="addon_ins"><span id="addonload"><?php echo $source_typename;?>Скачивание установочных</span></div>
</div>
<script>
$("#menu_store").addClass('sidebarsubmenu1');
$(document).ready(function(){
    $.get('./store.php', {action:'addon', source:"<?php echo $source;?>", type:"<?php echo $source_type;?>" },
      function(data){
        if (data.match("succ")) {
            $("#addon_ins").html('<span id="addonsucc"><?php echo $source_typename;?>Успешная установка，<?php echo $source_typeurl;?></span>');
        } else if(data.match("error_down")){
            $("#addon_ins").html('<span id="addonerror"><?php echo $source_typename;?>Не удается скачать,возможно, сервер не доступен, скачайте вручную и установите, <a href="store.php">вернуться назад</a></span>');
        } else if(data.match("error_zip")){
            $("#addon_ins").html('<span id="addonerror"><?php echo $source_typename;?>Ошибка, возможно, Ваш сервер не поддерживает работу с zip，<a href="store.php">вернуться назад</a></span>');
        } else if(data.match("error_dir")){
            $("#addon_ins").html('<span id="addonerror"><?php echo $source_typename;?>Ошибка, каталог не доступе для записи/чтения <a href="store.php">вернуться назад</a></span>');
        }else{
            $("#addon_ins").html('<span id="addonerror"><?php echo $source_typename;?>Сбой установки,<a href="store.php">вернуться назад</a></span>');
        }
      });
})
</script>
