<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div class=containertitle><b>Управление ссылками</b>
<?php if(isset($_GET['active_taxis'])):?><span class="actived">Отсортировано</span><?php endif;?>
<?php if(isset($_GET['active_del'])):?><span class="actived">Ссылка успешно удалена</span><?php endif;?>
<?php if(isset($_GET['active_edit'])):?><span class="actived">Ссылка успешно изменена</span><?php endif;?>
<?php if(isset($_GET['active_add'])):?><span class="actived">Ссылка успешно добавлена</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">Название и адрес сайта не могут быть пустым</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error">Не возможно отсортировать</span><?php endif;?>
</div>
<div class=line></div>
<form action="link.php?action=link_taxis" method="post">
  <table width="100%" id="adm_link_list" class="item_list">
    <thead>
      <tr>
	  	<th width="50"><b>№</b></th>
        <th width="230"><b>Ссылка</b></th>
        <th width="80" class="tdcenter"><b>Статус</b></th>
		<th width="80" class="tdcenter"><b>Просмотр</b></th>
		<th width="400"><b>Описание</b></th>
        <th width="100"></th>
      </tr>
    </thead>
    <tbody>
	<?php 
	if($links):
	foreach($links as $key=>$value):
	doAction('adm_link_display');
	?>  
      <tr>
		<td><input class="num_input" name="link[<?php echo $value['id']; ?>]" value="<?php echo $value['taxis']; ?>" maxlength="4" /></td>
		<td><a href="link.php?action=mod_link&amp;linkid=<?php echo $value['id']; ?>" title="Редактировать"><?php echo $value['sitename']; ?></a></td>
		<td class="tdcenter">
		<?php if ($value['hide'] == 'n'): ?>
		<a href="link.php?action=hide&amp;linkid=<?php echo $value['id']; ?>" title="Нажмите для скрытия ссылки">Активна</a>
		<?php else: ?>
		<a href="link.php?action=show&amp;linkid=<?php echo $value['id']; ?>" title="Нажмите для отображения ссылки" style="color:red;">Скрыта</a>
		<?php endif;?>
		</td>
		<td class="tdcenter">
	  	<a href="<?php echo $value['siteurl']; ?>" target="_blank" title="Показать ссылку">
	  	<img src="./views/images/vlog.gif" align="absbottom" border="0" /></a>
	  	</td>
        <td><?php echo $value['description']; ?></td>
        <td>
        <a href="link.php?action=mod_link&amp;linkid=<?php echo $value['id']; ?>">Редактировать</a>
        <a href="javascript: em_confirm(<?php echo $value['id']; ?>, 'link');" class="care">Удалить</a>
        </td>
      </tr>
	<?php endforeach;else:?>
	  <tr><td class="tdcenter" colspan="6">Еще не добавлены ссылки</td></tr>
	<?php endif;?>
    </tbody>
  </table>
  <div class="list_footer"><input type="submit" value="Сортировка" class="button" /></div>
</form>
<form action="link.php?action=addlink" method="post" name="link" id="link">
<div style="margin:30px 0px 10px 0px;"><a href="javascript:displayToggle('link_new', 2);">Добавить ссылку</a></div>
<div id="link_new">
	<li>№</li>
	<li><input maxlength="4" style="width:30px;" name="taxis" /></li>
	<li>Название сайта</li>
	<li><input maxlength="200" style="width:228px;" name="sitename" /></li>
	<li>Адрес</li>
	<li><input maxlength="200" style="width:228px;" name="siteurl" /></li>
	<li>Описание</li>
	<li><textarea name="description" type="text" style="width:230px;height:60px;overflow:auto;"></textarea></li>
	<li><input type="submit" name="" value="Добавить"  /></li>
</div>
</form>
<script>
$("#link_new").css('display', $.cookie('em_link_new') ? $.cookie('em_link_new') : 'none');
$(document).ready(function(){
	$("#adm_link_list tbody tr:odd").addClass("tralt_b");
	$("#adm_link_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")})
});
setTimeout(hideActived,2600);
$("#menu_link").addClass('sidebarsubmenu1');
</script>