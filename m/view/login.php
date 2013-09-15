<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="m">
	<form method="post" action="./index.php?action=auth">
		Пользователь<br />
	    <input type="text" name="user" /><br />
	    Пароль<br />
	    <input type="password" name="pw" /><br />
	    <?php echo $ckcode; ?>
	    <br /><input type="submit" value=" Вход" />
	</form>
</div>