<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div class=containertitle><b>Редактирование главного меню</b>
<?php if(isset($_GET['active_taxis'])):?><span class="actived">Сортировка успешно обновлена</span><?php endif;?>
<?php if(isset($_GET['active_del'])):?><span class="actived">Удалить навигации успеха</span><?php endif;?>
<?php if(isset($_GET['active_edit'])):?><span class="actived">Изменить успех навигации</span><?php endif;?>
<?php if(isset($_GET['active_add'])):?><span class="actived">Добавить навигации успеха</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">Название навигации и адрес не может быть пустым</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error">Нет сортировки навигации</span><?php endif;?>
<?php if(isset($_GET['error_c'])):?><span class="error">Вы не можете удалять навигации по умолчанию</span><?php endif;?>
<?php if(isset($_GET['error_d'])):?><span class="error">Пожалуйста, выберите классификации вы хотите добавить</span><?php endif;?>
<?php if(isset($_GET['error_e'])):?><span class="error">Пожалуйста, выберите страницу, которую вы хотите добавить</span><?php endif;?>
<?php if(isset($_GET['error_f'])):?><span class="error">Формат навигация адрес ошибки (должно включать префикс HTTP и т.д.)</span><?php endif;?>
</div>
<div class=line></div>
<form action="navbar.php?action=taxis" method="post">
  <table width="100%" id="adm_navi_list" class="item_list">
    <thead>
      <tr>
	  	<th width="50"><b>Сорт.</b></th>
        <th width="230"><b>Навигация</b></th>
        <th width="60" class="tdcenter"><b>Название</b></th>
        <th width="60" class="tdcenter"><b>Статус</b></th>
        <th width="50" class="tdcenter"><b>Просмотр</b></th>
		<th width="360"><b>Адрес</b></th>
        <th width="100"></th>
      </tr>
    </thead>
    <tbody>
	<?php 
	if($navis):
	foreach($navis as $key=>$value):
	$value['type_name'] = '';
	switch ($value['type']) {
		case Navi_Model::navitype_home:
		case Navi_Model::navitype_t:
		case Navi_Model::navitype_admin:
			$value['type_name'] = 'Система';
			break;
		case Navi_Model::navitype_sort:
			$value['type_name'] = 'Категория';
			break;
		case Navi_Model::navitype_page:
			$value['type_name'] = 'страница';
			break;
		case Navi_Model::navitype_custom:
			$value['type_name'] = 'Изменено';
			break;
	}
	doAction('adm_navi_display');
	?>  
      <tr>
		<td><input class="num_input" name="navi[<?php echo $value['id']; ?>]" value="<?php echo $value['taxis']; ?>" maxlength="4" /></td>
		<td><a href="navbar.php?action=mod&amp;navid=<?php echo $value['id']; ?>" title="Редактировать"><?php echo $value['naviname']; ?></a></td>
		<td class="tdcenter"><?php echo $value['type_name'];?></td>
		<td class="tdcenter">
		<?php if ($value['hide'] == 'n'): ?>
		<a href="navbar.php?action=hide&amp;id=<?php echo $value['id']; ?>" title="Нажмите, чтобы скрыть пункт меню">Отображается</a>
		<?php else: ?>
		<a href="navbar.php?action=show&amp;id=<?php echo $value['id']; ?>" title="Нажмите, для отображения пунтка меню" style="color:red;">Скрыто</a>
		<?php endif;?>
		</td>
		<td class="tdcenter">
	  	<a href="<?php echo $value['url']; ?>" target="_blank">
	  	<img src="./views/images/<?php echo $value['newtab'] == 'y' ? 'vlog.gif' : 'vlog2.gif';?>" align="absbottom" border="0" /></a>
	  	</td>
        <td><?php echo $value['url']; ?></td>
        <td>
        <a href="navbar.php?action=mod&amp;navid=<?php echo $value['id']; ?>">Редактировать</a>
        <?php if($value['isdefault'] == 'n'):?>
        <a href="javascript: em_confirm(<?php echo $value['id']; ?>, 'navi');" class="care">Удалить</a>
        <?php endif;?>
        </td>
      </tr>
	<?php endforeach;else:?>
	  <tr><td class="tdcenter" colspan="4">Список пуст</td></tr>
	<?php endif;?>
    </tbody>
  </table>
  <div class="list_footer"><input type="submit" value="Изменить сортировку" class="button" /></div>
</form>
<div id="navi_add">
<form action="navbar.php?action=add" method="post" name="navi" id="navi">
<div>
	<h1 onclick="displayToggle('navi_add_custom', 2);">Добавить пункт меню</h1>
	<ul id="navi_add_custom">
	<li><input maxlength="4" style="width:30px;" name="taxis" /> Сорт.</li>
	<li><input maxlength="200" style="width:100px;" name="naviname" /> Название</li>
	<li>
	<input maxlength="200" style="width:175px;" name="url" id="url" /> Адрес (с http://)</li>
    <li>Открыть в новом окне<input type="checkbox" style="vertical-align:middle;" value="y" name="newtab" /></li>
	<li><input type="submit" name="" value="Сохранить"  /></li>
	</ul>
</div>
</form>
<form action="navbar.php?action=add_sort" method="post" name="navi" id="navi">
<div>
	<h1 onclick="displayToggle('navi_add_sort', 2);">Добавить категории</h1>
	<ul id="navi_add_sort">
	<?php 
	if($sorts):
	foreach($sorts as $key=>$value): 
	?>
	<li>
        <input type="checkbox" style="vertical-align:middle;" name="sort_ids[]" value="<?php echo $value['sid']; ?>" class="ids" />
		<?php echo $value['sortname']; ?>
	</li>
	<?php endforeach;?>
	<li><input type="submit" name="" value="добавлять"  /></li>
	<?php else:?>
	<li>Нет категорий <a href="sort.php">Новая категория</a></li>
	<?php endif;?> 
	</ul>
</div>
</form>
<form action="navbar.php?action=add_page" method="post" name="navi" id="navi">
<div>
	<h1 onclick="displayToggle('navi_add_page', 2);">Добавить страницу</h1>
	<ul id="navi_add_page">
	<?php 
	if($pages):
	foreach($pages as $key=>$value): 
	?>
	<li>
        <input type="checkbox" style="vertical-align:middle;" name="pages[<?php echo $value['gid']; ?>]" value="<?php echo $value['title']; ?>" class="ids" />
		<?php echo $value['title']; ?>
	</li>
	<?php endforeach;?>
	<li><input type="submit" name="" value="добавлять"  /></li>
	<?php else:?>
	<li>Нет страницы <a href="page.php">Новая страница</a></li>
	<?php endif;?> 
	</ul>
</div>
</form>
</div>
<script>
$("#navi_add_custom").css('display', $.cookie('em_navi_add_custom') ? $.cookie('em_navi_add_custom') : '');
$("#navi_add_sort").css('display', $.cookie('em_navi_add_sort') ? $.cookie('em_navi_add_sort') : '');
$("#navi_add_page").css('display', $.cookie('em_navi_add_page') ? $.cookie('em_navi_add_page') : '');
$(document).ready(function(){
	$("#adm_navi_list tbody tr:odd").addClass("tralt_b");
	$("#adm_navi_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")})
});
setTimeout(hideActived,2600);
$("#menu_navbar").addClass('sidebarsubmenu1');
</script>
