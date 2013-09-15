<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b>Изменения данных</b>
<?php if(isset($_GET['error_login'])):?><span class="error">Имя пользователя не может быть пустым</span><?php endif;?>
<?php if(isset($_GET['error_exist'])):?><span class="error">Имя пользователя уже существует</span><?php endif;?>
<?php if(isset($_GET['error_pwd_len'])):?><span class="error">Длина пароля должна быть не менее чем на 6</span><?php endif;?>
<?php if(isset($_GET['error_pwd2'])):?><span class="error">Введите пароль дважды несовместимы</span><?php endif;?>
</div>
<div class=line></div>
<form action="user.php?action=update" method="post">
<div class="item_edit">
	<li><input type="text" value="<?php echo $username; ?>" name="username" style="width:200px;" /> Настоящее имя</li>
	<li><input type="text" value="<?php echo $nickname; ?>" name="nickname" style="width:200px;" /> Никнейм (логин)</li>
	<li><input type="password" value="" name="password" style="width:200px;" /> Новый пароль (оставьте пустым, если не хотите изменить)</li>
	<li><input type="password" value="" name="password2" style="width:200px;" /> Повторите новый пароль</li>
	<li><input type="text"  value="<?php echo $email; ?>" name="email" style="width:200px;" /> Электронная почта</li>
	<li>
	<select name="role">
		<option value="writer" <?php echo $ex1; ?>>Писатель</option>
		<option value="admin" <?php echo $ex2; ?>>Администратор</option>
	</select>
	</li>
	<li>Описание<br />
	<textarea name="description" rows="5" style="width:260px;"><?php echo $description; ?></textarea></li>
	<li>
	<input type="hidden" value="<?php echo $uid; ?>" name="uid" />
	<input type="submit" value="Применить" class="button" />
	<input type="button" value="Отмена" class="button" onclick="window.location='user.php';" /></li>
</div>
</form>
<script>
setTimeout(hideActived,2600);
$("#menu_user").addClass('sidebarsubmenu1');
</script>