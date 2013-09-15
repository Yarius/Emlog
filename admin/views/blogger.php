<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="containertitle2">
<?php if (ROLE == 'admin'):?>
<a class="navi1" href="./configure.php">Основные</a>
<a class="navi4" href="./seo.php">ЧПУ</a>
<a class="navi4" href="./style.php">Стиль (ЦУ)</a>
<a class="navi2" href="./blogger.php">Профиль</a>
<?php else:?>
<a class="navi1" href="./blogger.php">Профиль</a>
<?php endif;?>
<?php if(isset($_GET['active_edit'])):?><span class="actived">Профиль успешно изменен</span><?php endif;?>
<?php if(isset($_GET['active_del'])):?><span class="actived">Изображение успешно удалено</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">Ник не может быть слишком длинным</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error">Введите свой e-mail</span><?php endif;?>
</div>
<div style="margin-left:30px;">
<form action="blogger.php?action=update" method="post" name="blooger" id="blooger" enctype="multipart/form-data">
<div class="item_edit">
	<li>
	<?php echo $icon; ?><input type="hidden" name="photo" value="<?php echo $photo; ?>"/><br />
	Аватар<br />
    <input name="photo" type="file" /> (размер изображения 120x120, JPG или PNG)
	</li>
	<li>Логин<br /><input maxlength="50" style="width:185px;" value="<?php echo $nickname; ?>" name="name" /> </li>
	<li>Электронная почта<br /><input name="email" value="<?php echo $email; ?>" style="width:185px;" maxlength="200" /></li>
	<li>О себе<br /><textarea name="description" style="width:300px; height:65px;" type="text" maxlength="500"><?php echo $description; ?></textarea></li>
	<li><input type="submit" value="Сохранить" class="button" /></li>
</div>
</form>
<div style="margin:30px 0px 10px;"><a href="javascript:displayToggle('chpwd', 2);">Изменение пароля и логина</a></div>
<form action="blogger.php?action=update_pwd" method="post" name="blooger" id="blooger">
<div id="chpwd">
	<li><input type="password" maxlength="200" style="width:185px;" value="" name="oldpass" /> Текущий пароль</li>
	<li><input type="password" maxlength="200" style="width:185px;" value="" name="newpass" /> Новый пароль (не менее 6 символов)</li>
	<li><input type="password" maxlength="200" style="width:185px;" value="" name="repeatpass" /> Повторите новый пароль</li>
	<li><input maxlength="200" style="width:185px;" name="username" /> Логин</li>
	<li><input type="submit" value="Сохранить" class="button" /></li>
</div>
</form>
</div>
<script>
$("#chpwd").css('display', $.cookie('em_chpwd') ? $.cookie('em_chpwd') : 'none');
setTimeout(hideActived,2600);
</script>