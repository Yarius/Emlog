<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b>Редактирование ссылки</b></div>
<div class=line></div>
<form action="link.php?action=update_link" method="post">
<div class="item_edit">
	<li><input size="25" value="<?php echo $sitename; ?>" name="sitename" /> Название</li>
	<li><input size="40" value="<?php echo $siteurl; ?>" name="siteurl" /> Адрес</li>
	<li>Описание<br /><textarea name="description" rows="3" cols="45"><?php echo $description; ?></textarea></li>
	<li>
	<input type="hidden" value="<?php echo $linkId; ?>" name="linkid" />
	<input type="submit" value="Сохранить" class="button" />
	<input type="button" value="Отмена" class="button" onclick="javascript: window.history.back();" /></li>
</div>
</form>
<script>
$("#menu_link").addClass('sidebarsubmenu1');
</script>