<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b>Редактирование пунтка меню</b></div>
<div class=line></div>
<form action="navbar.php?action=update" method="post">
<div class="item_edit">
	<li><input size="20" value="<?php echo $naviname; ?>" name="naviname" /> Перейдите название</li>
	<li>
	<input size="50" value="<?php echo $url; ?>" name="url" <?php echo $conf_isdefault; ?> />
	Открываеть в новом окне <input type="checkbox" style="vertical-align:middle;" value="y" name="newtab" <?php echo $conf_newtab; ?> /></li>
	<li>
	<input type="hidden" value="<?php echo $naviId; ?>" name="navid" />
	<input type="hidden" value="<?php echo $isdefault; ?>" name="isdefault" />
	<input type="submit" value="Сохранить" class="button" />
	<input type="button" value="Отмена" class="button" onclick="javascript: window.history.back();" />
	</li>
</div>
</form>
<script>
$("#menu_navbar").addClass('sidebarsubmenu1');
</script>