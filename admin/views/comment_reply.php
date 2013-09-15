<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b>Ответ на комментарий</b>
</div>
<div class=line></div>
<form action="comment.php?action=doreply" method="post">
<div class="item_edit">
	<li>Комментарии: <?php echo $poster; ?></li>
	<li>Дата: <?php echo $date; ?></li>
	<li>Содержание:<?php echo $comment; ?></li>
	<li><textarea name="reply" rows="5" cols="60"></textarea></li>
	<li>
	<input type="hidden" value="<?php echo $commentId; ?>" name="cid" />
	<input type="hidden" value="<?php echo $gid; ?>" name="gid" />
	<input type="hidden" value="<?php echo $hide; ?>" name="hide" />
	<input type="submit" value="Ответ" class="submit" />
	<?php if ($hide == 'y'): ?>
	    <input type="submit" value="Ответ и премодерация" name="pub_it" class="button" />
	<?php endif; ?>
	<input type="button" value="Отмена" class="button" onclick="javascript: window.history.back();"/></li>
</div>
</form>
<script>
$("#menu_cm").addClass('sidebarsubmenu1');
</script>