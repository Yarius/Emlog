<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="containertitle2">
<a class="navi1" href="./template.php">Шаблоны</a>
<a class="navi2" href="./template.php?action=install">Установка</a>
<?php if(isset($_GET['error_a'])):?><span class="error">Поддерживается архивы zip</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error">Ошибка, нет доступа к (content/templates)</span><?php endif;?>
<?php if(isset($_GET['error_c'])):?><span class="error">Неподдерживаемый тип архива.</span><?php endif;?>
<?php if(isset($_GET['error_d'])):?><span class="error">Выберите zip-архив с шаблоном</span><?php endif;?>
<?php if(isset($_GET['error_e'])):?><span class="error">Сбой установки, не соответствует стандартному пакету установки шаблона</span><?php endif;?>
</div>
<?php if(isset($_GET['error_c'])): ?>
<div style="margin:20px 20px;">
<div class="des">
Установка шаблона вручную: <br />
1. Распаковать шаблон и загрузить в папку /content/templates/<br />
2. Активировать шаблон в Панели управления <br />
</div>
</div>
<?php endif; ?>
<form action="./template.php?action=upload_zip" method="post" enctype="multipart/form-data" >
<div style="margin:50px 0px 50px 20px;">
	<li>
	<input name="tplzip" type="file" />
	<input type="submit" value="Установить" class="submit" /> (Выберите zip-архив с шаблоном)
	</li>
</div>
</form>
<div style="margin:10px 20px;">Получить больше шаблонов: <a href="store.php">Application Center&raquo;</a></div>
<script>
setTimeout(hideActived,2600);
$("#menu_tpl").addClass('sidebarsubmenu1');
</script>