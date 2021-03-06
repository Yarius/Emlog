<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
$isdraft = $pid == 'draft' ? '&pid=draft' : '';
$isDisplaySort = !$sid ? "style=\"display:none;\"" : '';
$isDisplayTag = !$tagId ? "style=\"display:none;\"" : '';
$isDisplayUser = !$uid ? "style=\"display:none;\"" : '';
?>
<div class=containertitle><b><?php echo $pwd; ?></b>
<?php if(isset($_GET['active_del'])):?><span class="actived">Статья успешно удалена</span><?php endif;?>
<?php if(isset($_GET['active_up'])):?><span class="actived">Топ успешно добавлен</span><?php endif;?>
<?php if(isset($_GET['active_down'])):?><span class="actived">Топ успешно отменен </span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">Пожалуйста, выберите журнал, чтобы обрабатывать</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error">Пожалуйста, выберите действие для выполнения</span><?php endif;?>
<?php if(isset($_GET['active_post'])):?><span class="actived">Успешное добавление статьи</span><?php endif;?>
<?php if(isset($_GET['active_move'])):?><span class="actived">Перемещение выполнено</span><?php endif;?>
<?php if(isset($_GET['active_change_author'])):?><span class="actived">Автор успешно изменен</span><?php endif;?>
<?php if(isset($_GET['active_hide'])):?><span class="actived">Черновики успешно переданы</span><?php endif;?>
<?php if(isset($_GET['active_savedraft'])):?><span class="actived">Черновик успешно сохранен</span><?php endif;?>
<?php if(isset($_GET['active_savelog'])):?><span class="actived">Статья успешно сохранена</span><?php endif;?>
</div>
<div class=line></div>
<div class="filters">
<div id="f_title">
	<div style="float:left; margin-top:8px;">
		<span <?php echo !$sid && !$tagId && !$uid && !$keyword ? "class=\"filter\"" : ''; ?>><a href="./admin_log.php?<?php echo $isdraft; ?>">Все</a></span>
		<span id="f_t_sort"><a href="javascript:void(0);">Категории</a></span>
		<span id="f_t_tag"><a href="javascript:void(0);">Теги</a></span>
		<span id="f_t_user"><a href="javascript:void(0);">Автор</a></span>
	</div>
	<div style="float:right;">
		<form action="admin_log.php" method="get">
		<input type="text" id="input_s" name="keyword">
		<?php if($pid):?>
		<input type="hidden" id="pid" name="pid" value="draft">
		<?php endif;?>
		</form>
	</div>
	<div style="clear:both"></div>
</div>
<div id="f_sort" <?php echo $isDisplaySort ?>>
	Категория: <span <?php echo $sid == -1 ?  "class=\"filter\"" : ''; ?>><a href="./admin_log.php?sid=-1<?php echo $isdraft; ?>">без категории</a></span>
	<?php foreach($sorts as $val):
		$a = "sort_{$val['sid']}";
		$$a = '';
		$b = "sort_$sid";
		$$b = "class=\"filter\"";
	?>
	<span <?php echo $$a; ?>><a href="./admin_log.php?sid=<?php echo $val['sid'].$isdraft; ?>"><?php echo $val['sortname']; ?></a></span>
	<?php endforeach;?>
</div>
<div id="f_tag" <?php echo $isDisplayTag ?>>
	Теги:
	<?php foreach($tags as $val):
		$a = 'tag_'.$val['tid'];
		$$a = '';
		$b = 'tag_'.$tagId;
		$$b = "class=\"filter\"";
	?>
	<span <?php echo $$a; ?>><a href="./admin_log.php?tagid=<?php echo $val['tid'].$isdraft; ?>"><?php echo $val['tagname']; ?></a></span>
	<?php endforeach;?>
</div>
<div id="f_user" <?php echo $isDisplayUser ?>>
	Автор:
	<?php foreach($user_cache as $key => $val):
		if (ROLE != 'admin' && $key != UID){
			continue;
		}
		$a = 'user_'.$key;
		$$a = '';
		$b = 'user_'.$uid;
		$$b = "class=\"filter\"";
		$val['name'] = $val['name'];
	?>
	<span <?php echo $$a; ?>><a href="./admin_log.php?uid=<?php echo $key.$isdraft; ?>"><?php echo $val['name']; ?></a></span>
	<?php endforeach;?>
</div>
</div>
<form action="admin_log.php?action=operate_log" method="post" name="form_log" id="form_log">
  <input type="hidden" name="pid" value="<?php echo $pid; ?>">
  <table width="100%" id="adm_log_list" class="item_list">
  <thead>
      <tr>
        <th width="511" colspan="2"><b>Статья</b></th>
		<?php if ($pid != 'draft'): ?>
		<th width="40" class="tdcenter"><b>Просмотр</b></th>
		<?php endif; ?>
		<th width="100"><b>Автор</b></th>
        <th width="146"><b>Категория</b></th>
        <th width="130"><b><a href="./admin_log.php?sortDate=<?php echo $sortDate.$sorturl; ?>">Дата</a></b></th>
		<th width="39" class="tdcenter"><b><a href="./admin_log.php?sortComm=<?php echo $sortComm.$sorturl; ?>">Комментарии</a></b></th>
		<th width="59" class="tdcenter"><b><a href="./admin_log.php?sortView=<?php echo $sortView.$sorturl; ?>">Просмотры</a></b></th>
      </tr>
	</thead>
 	<tbody>
	<?php
	if($logs):
	foreach($logs as $key=>$value):
	$sortName = $value['sortid'] == -1 && !array_key_exists($value['sortid'], $sorts) ? 'Без категории' : $sorts[$value['sortid']]['sortname'];
	$author = $user_cache[$value['author']]['name'];
	?>
      <tr>
      <td width="21"><input type="checkbox" name="blog[]" value="<?php echo $value['gid']; ?>" class="ids" /></td>
      <td width="490"><a href="write_log.php?action=edit&gid=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a>
      <?php if($value['top'] == 'y'): ?><img src="./views/images/top.gif" align="top" title="топ" /><?php endif; ?>
	  <?php if($value['attnum'] > 0): ?><img src="./views/images/att.gif" align="top" title="Вложение:<?php echo $value['attnum']; ?>" /><?php endif; ?>
      </td>
	  <?php if ($pid != 'draft'): ?>
	  <td class="tdcenter">
	  <a href="<?php echo Url::log($value['gid']); ?>" target="_blank" title="Открыть в новом окне">
	  <img src="./views/images/vlog.gif" align="absbottom" border="0" /></a>
	  </td>
	  <?php endif; ?>
      <td><a href="./admin_log.php?uid=<?php echo $value['author'].$isdraft;?>"><?php echo $author; ?></a></td>
      <td><a href="./admin_log.php?sid=<?php echo $value['sortid'].$isdraft;?>"><?php echo $sortName; ?></a></td>
      <td><?php echo $value['date']; ?></td>
	  <td class="tdcenter"><a href="comment.php?gid=<?php echo $value['gid']; ?>"><?php echo $value['comnum']; ?></a></td>
	  <td class="tdcenter"><?php echo $value['views']; ?></a></td>
      </tr>
	<?php endforeach;else:?>
	  <tr><td class="tdcenter" colspan="8">Нет статей</td></tr>
	<?php endif;?>
	</tbody>
	</table>
	<input name="operate" id="operate" value="" type="hidden" />
	<div class="list_footer">
	<a href="javascript:void(0);" id="select_all">Все</a> Выбранное:
    <a href="javascript:logact('del');">Удалить</a> | 
	<?php if($pid == 'draft'): ?>
	<a href="javascript:logact('pub');">Опубликовать</a>
	<?php else: ?>
	<a href="javascript:logact('hide');">В черновики</a> | 

	<?php if (ROLE == 'admin'):?>
	<a href="javascript:logact('top');">Прикрепить</a> | 
    <a href="javascript:logact('notop');">Открепить</a> | 
    <?php endif;?>

	<select name="sort" id="sort" onChange="changeSort(this);" style="width:130px;">
	<option value="" selected="selected">Категория</option>
	<?php foreach($sorts as $val):?>
	<option value="<?php echo $val['sid']; ?>"><?php echo $val['sortname']; ?></option>
	<?php endforeach;?>
	<option value="-1">Без категории</option>
	</select>

	<?php if (ROLE == 'admin' && count($user_cache) > 1):?>
	<select name="author" id="author" onChange="changeAuthor(this);">
	<option value="" selected="selected">Автор</option>
	<?php foreach($user_cache as $key => $val):
	$val['name'] = $val['name'];
	?>
	<option value="<?php echo $key; ?>"><?php echo $val['name']; ?></option>
	<?php endforeach;?>
	</select>
	<?php endif;?>

	<?php endif;?>
	</div>
</form>
<div class="page"><?php echo $pageurl; ?> (Всего <?php echo $logNum; ?> <?php echo $pid == 'draft' ? 'черновиков' : 'статей'; ?>)</div>
<script>
$(document).ready(function(){
	$("#adm_log_list tbody tr:odd").addClass("tralt_b");
	$("#adm_log_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")});
	$("#f_t_sort").click(function(){$("#f_sort").toggle();$("#f_tag").hide();$("#f_user").hide();});
	$("#f_t_tag").click(function(){$("#f_tag").toggle();$("#f_sort").hide();$("#f_user").hide();});
	$("#f_t_user").click(function(){$("#f_user").toggle();$("#f_sort").hide();$("#f_tag").hide();});
	$("#select_all").toggle(function () {$(".ids").attr("checked", "checked");},function () {$(".ids").removeAttr("checked");});
});
setTimeout(hideActived,2600);
function logact(act){
	if (getChecked('ids') == false) {
		alert('Вы не выбрали ни одной статьи!');
		return;}
	if(act == 'del' && !confirm('Вы действительно хотите удалить выбранную статью?')){return;}
	$("#operate").val(act);
	$("#form_log").submit();
}
function changeSort(obj) {
	var sortId = obj.value;
	if (getChecked('ids') == false) {
		alert('Вы не выбрали ни одной статьи!');
		return;}
	if($('#sort').val() == '')return;
	$("#operate").val('move');
	$("#form_log").submit();
}
function changeAuthor(obj) {
	var sortId = obj.value;
	if (getChecked('ids') == false) {
		alert('Вы не выбрали ни одной статьи!');
		return;}
	if($('#author').val() == '')return;
	$("#operate").val('change_author');
	$("#form_log").submit();
}
<?php if ($isdraft) :?>
$("#menu_draft").addClass('sidebarsubmenu1');
<?php else:?>
$("#menu_log").addClass('sidebarsubmenu1');
<?php endif;?>
</script>