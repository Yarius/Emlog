<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b>Управление комментариями</b>
<?php if(isset($_GET['active_del'])):?><span class="actived">Крмментарий успешно удален</span><?php endif;?>
<?php if(isset($_GET['active_show'])):?><span class="actived">Кооментарий успешно проверен</span><?php endif;?>
<?php if(isset($_GET['active_hide'])):?><span class="actived">Комментарий успешно скрыт</span><?php endif;?>
<?php if(isset($_GET['active_edit'])):?><span class="actived">Комментарий успешно отредактирован</span><?php endif;?>
<?php if(isset($_GET['active_rep'])):?><span class="actived">Ответ на комментарий успешно добавлен</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">Не выбрано действий с комментариями</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error">Пожалуйста, выберите нужное действие</span><?php endif;?>
<?php if(isset($_GET['error_c'])):?><span class="error">Ваш ответ не может быть пустым</span><?php endif;?>
<?php if(isset($_GET['error_d'])):?><span class="error">Ваш ответ слишком длинный</span><?php endif;?>
<?php if(isset($_GET['error_e'])):?><span class="error">Комментарий не может быть пустым</span><?php endif;?>
</div>
<div class=line></div>
<?php if ($hideCommNum > 0) : 
$hide_ = $hide_y = $hide_n = '';
$a = "hide_$hide";
$$a = "class=\"filter\"";
?>
<div class="filters">
<span <?php echo $hide_; ?>><a href="./comment.php?<?php echo $addUrl_1 ?>">Все</a></span>
<span <?php echo $hide_y; ?>><a href="./comment.php?hide=y&<?php echo $addUrl_1 ?>">Премодерация
<?php
$hidecmnum = ROLE == 'admin' ? $sta_cache['hidecomnum'] : $sta_cache[UID]['hidecommentnum'];
if ($hidecmnum > 0) echo '('.$hidecmnum.')';
?>
</a></span>
<span <?php echo $hide_n; ?>><a href="comment.php?hide=n&<?php echo $addUrl_1 ?>">Одобренные</a></span>
</div>
<?php endif; ?>
<form action="comment.php?action=admin_all_coms" method="post" name="form_com" id="form_com">
  <table width="100%" id="adm_comment_list" class="item_list">
  	<thead>
      <tr>
        <th width="369" colspan="2"><b>Содержание</b></th>
		<th width="300"><b>Автор</b></th>
        <th width="250"><b>Статья</b></th>
      </tr>
    </thead>
    <tbody>
	<?php
	if($comment):
	foreach($comment as $key=>$value):
	$ishide = $value['hide']=='y'?'<font color="red">[Премодерация]</font>':'';
	$mail = !empty($value['mail']) ? "({$value['mail']})" : '';
	$ip = !empty($value['ip']) ? "<br />IP: {$value['ip']}" : '';
	$poster = !empty($value['url']) ? '<a href="'.$value['url'].'" target="_blank">'. $value['poster'].'</a>' : $value['poster'];
	$value['content'] = str_replace('<br>',' ',$value['content']);
	$sub_content = subString($value['content'], 0, 500);
	$value['title'] = subString($value['title'], 0, 100);
	doAction('adm_comment_display');
	?>
     <tr>
        <td width="19"><input type="checkbox" value="<?php echo $value['cid']; ?>" name="com[]" class="ids" /></td>
        <td width="350"><a href="comment.php?action=reply_comment&amp;cid=<?php echo $value['cid']; ?>" title="<?php echo $value['content']; ?>"><?php echo $sub_content; ?></a> 	<?php echo $ishide; ?>
        <br /><?php echo $value['date']; ?>
		<span style="display:none; margin-left:8px;">    
		<a href="javascript: em_confirm(<?php echo $value['cid']; ?>, 'comment');" class="care">Удалить</a>
		<?php if($value['hide'] == 'y'):?>
		<a href="comment.php?action=show&amp;id=<?php echo $value['cid']; ?>">Одобрить</a>
		<?php else: ?>
		<a href="comment.php?action=hide&amp;id=<?php echo $value['cid']; ?>">Премодерация</a>
		<?php endif;?>
		<a href="comment.php?action=reply_comment&amp;cid=<?php echo $value['cid']; ?>">Ответ</a>
        <a href="comment.php?action=edit_comment&amp;cid=<?php echo $value['cid']; ?>">Изменить</a>
		</span>
		</td>
		<td><?php echo $poster;?> <?php echo $mail;?> <?php echo $ip;?></td>
        <td><a href="<?php echo Url::log($value['gid']); ?>" target="_blank" title="Просмотр статьи"><?php echo $value['title']; ?></a></td>
     </tr>
	<?php endforeach;else:?>
	  <tr><td class="tdcenter" colspan="4">Список комментариев пуст</td></tr>
	<?php endif;?>
	</tbody>
  </table>
	<div class="list_footer">
	<a href="javascript:void(0);" id="select_all">Все</a> Выбранное:
    <a href="javascript:commentact('del');" class="care">Удалить</a>
	<a href="javascript:commentact('hide');">Премодерация</a>
	<a href="javascript:commentact('pub');">Опубликовать</a>
	<input name="operate" id="operate" value="" type="hidden" />
	</div>
    <div class="page"><?php echo $pageurl; ?> (Всего: <?php echo $cmnum; ?> комментариев)</div> 
</form>
<script>
$(document).ready(function(){
	$("#select_all").toggle(function () {$(".ids").attr("checked", "checked");},function () {$(".ids").removeAttr("checked");});
	$("#adm_comment_list tbody tr:odd").addClass("tralt_b");
	$("#adm_comment_list tbody tr")
		.mouseover(function(){$(this).addClass("trover");$(this).find("span").show();})
		.mouseout(function(){$(this).removeClass("trover");$(this).find("span").hide();})
});
setTimeout(hideActived,2600);
function commentact(act){
	if (getChecked('ids') == false) {
		alert('Пожалуйста, выберите комментарий');
		return;
	}
	if(act == 'del' && !confirm('Вы уверены, что хотите удалить выбранные комментарии?')){return;}
	$("#operate").val(act);
	$("#form_com").submit();
}
$("#menu_cm").addClass('sidebarsubmenu1');
</script>