<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class=containertitle><b>Управление плагинами</b><div id="msg"></div>
<?php if(isset($_GET['error_a'])):?><span class="error">Формат плагина ZIP</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error">Не удалось загрузить плагин, каталог (content/plugins) не доступен для записи</span><?php endif;?>
<?php if(isset($_GET['error_c'])):?><span class="error">Не поддерживается автоматическа установка. Установите плагин вручную</span><?php endif;?>
<?php if(isset($_GET['error_d'])):?><span class="error">Выберите корректный файл плагина!</span><?php endif;?>
<?php if(isset($_GET['error_e'])):?><span class="error">Сбой установки</span><?php endif;?>
</div>
<div class=line></div>
<?php if(isset($_GET['error_c'])): ?>
<div style="margin:20px 10px;">
<div class="des">
Установка плагина вручную <br />
1. Распаковать архив с плагином и закачать содержимое в /content/plugins/<br />
2. Зайти в панель управления и активировать плагин<br />
</div>
</div>
<?php endif; ?>
<form action="./plugin.php?action=upload_zip" method="post" enctype="multipart/form-data" >
<div style="margin:50px 0px 50px 20px;">
	<li>
	<input name="pluzip" type="file" />
	<input type="submit" value="Установка" class="submit" /> （Формат плагина ZIP）
	</li>
</div>
</form>
<div style="margin:10px 20px;">Больше плагинов: <a href="store.php">Application Center&raquo;</a></div>
<script>
$("#menu_plug").addClass('sidebarsubmenu1');
</script>