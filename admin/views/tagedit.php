<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b>Редактирование метки(тега)</b>
<?php if(isset($_GET['error_a'])):?><span class="error">Тег не может быть пустым</span><?php endif;?>
</div>
<div class=line></div>
<form  method="post" action="tag.php?action=update_tag">
<div>
<li><input size="40" value="<?php echo $tagname; ?>" name="tagname" /></li>
<li style="margin:10px 0px">
<input type="hidden" value="<?php echo $tagid; ?>" name="tid" />
<input type="submit" value="Сохранить" class="button" />
<input type="button" value="Отмена" class="button" onclick="javascript: window.location='tag.php';"/>
</li>
</div>
</form>
<script>
$("#menu_tag").addClass('sidebarsubmenu1');
</script>