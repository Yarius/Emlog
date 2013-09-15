<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<script>setTimeout(hideActived,2600);</script>
<div class=containertitle><b>Управление категориями</b>
<?php if(isset($_GET['active_taxis'])):?><span class="actived">Сортировка категорий выполнена</span><?php endif;?>
<?php if(isset($_GET['active_del'])):?><span class="actived">Категория успешно удалена</span><?php endif;?>
<?php if(isset($_GET['active_edit'])):?><span class="actived">Категория успешно переименована</span><?php endif;?>
<?php if(isset($_GET['active_add'])):?><span class="actived">Категория успешно добавлена</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">Имя категории не может быть пустым</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error">Там нет сортировки классификации</span><?php endif;?>
<?php if(isset($_GET['error_c'])):?><span class="error">Псевдоним не может состоять только из букв, цифр, символов подчеркивания, тире</span><?php endif;?>
<?php if(isset($_GET['error_d'])):?><span class="error">Псевдоним не может быть повторен</span><?php endif;?>
<?php if(isset($_GET['error_e'])):?><span class="error">Псевдонима не может содержать системы зарезервированные ключевые слова</span><?php endif;?>
</div>
<div class=line></div>
<form  method="post" action="sort.php?action=taxis">
	<table width="100%" id="adm_sort_list" class="item_list">
		<thead>
			<tr>
			<th width="55"><b>№</b></th>
			<th width="160"><b>Название</b></th>
            <th width="250"><b>Псевдоним</b></th>
			<th width="160"><b>Просмотр</b></th>
			<th width="40" class="tdcenter"><b>Просмотр</b></th>
			<th width="40" class="tdcenter"><b>Статьи</b></th>
			<th width="60"></th>
		</tr>
		</thead>
		<tbody>
<?php 
if($sorts):
foreach($sorts as $key=>$value):
	if ($value['pid'] != 0) {
		continue;
	}
?>
	<tr>
		<td>
			<input type="hidden" value="<?php echo $value['sid'];?>" class="sort_id" />
			<input maxlength="4" class="num_input" name="sort[<?php echo $value['sid']; ?>]" value="<?php echo $value['taxis']; ?>" />
		</td>
		<td class="sortname"><a href="sort.php?action=mod_sort&sid=<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?></a><br /></td>
		<td><?php echo $value['description']; ?></td>
        <td class="alias"><?php echo $value['alias']; ?></td>
		<td class="tdcenter">
			<a href="<?php echo Url::sort($value['sid']); ?>" target="_blank"><img src="./views/images/vlog.gif" align="absbottom" border="0" /></a>
		</td>
		<td class="tdcenter"><a href="./admin_log.php?sid=<?php echo $value['sid']; ?>"><?php echo $value['lognum']; ?></a></td>
		<td>
			<a href="sort.php?action=mod_sort&sid=<?php echo $value['sid']; ?>">Изменить</a>
			<a href="javascript: em_confirm(<?php echo $value['sid']; ?>, 'sort');" class="care">Удалить</a>
		</td>
	</tr>
	<?php
		$children = $value['children'];
		foreach ($children as $key):
		$value = $sorts[$key];
	?>
	<tr>
		<td>
			<input type="hidden" value="<?php echo $value['sid'];?>" class="sort_id" />
			<input maxlength="4" class="num_input" name="sort[<?php echo $value['sid']; ?>]" value="<?php echo $value['taxis']; ?>" />
		</td>
		<td class="sortname">---- <a href="sort.php?action=mod_sort&sid=<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?></a></td>
		<td><?php echo $value['description']; ?></td>
        <td class="alias"><?php echo $value['alias']; ?></td>
		<td class="tdcenter">
			<a href="<?php echo Url::sort($value['sid']); ?>" target="_blank"><img src="./views/images/vlog.gif" align="absbottom" border="0" /></a>
		</td>
		<td class="tdcenter"><a href="./admin_log.php?sid=<?php echo $value['sid']; ?>"><?php echo $value['lognum']; ?></a></td>
		<td>
			<a href="sort.php?action=mod_sort&sid=<?php echo $value['sid']; ?>">Изменить</a>
			<a href="javascript: em_confirm(<?php echo $value['sid']; ?>, 'sort');" class="care">Удалить</a>
		</td>
	</tr>
	<?php endforeach; ?>
<?php endforeach;else:?>
	  <tr><td class="tdcenter" colspan="6">Список пока пуст</td></tr>
<?php endif;?>  
</tbody>
</table>
<div class="list_footer"><input type="submit" value="Сортировать" class="button" /></div>
</form>
<form action="sort.php?action=add" method="post">
<div style="margin:30px 0px 10px 0px;"><a href="javascript:displayToggle('sort_new', 2);">Добавить категорию+</a></div>
<div id="sort_new" class="item_edit">
    <li><input maxlength="4" style="width:30px;" name="taxis" /> №</li>
	<li><input maxlength="200" style="width:200px;" name="sortname" id="sortname" /> Название</li>
	<li><input maxlength="200" style="width:200px;" name="alias" id="alias" /> Псевдоним (Для ЧПУ)</li>
	<li>
		<select name="pid" id="pid">
			<option value="0">Нет</option>
			<?php
				foreach($sorts as $key=>$value):
					if($value['pid'] != 0) {
						continue;
					}
			?>
			<option value="<?php echo $key; ?>"><?php echo $value['sortname']; ?></option>
			<?php endforeach; ?>
		</select>
        Родитель
	</li>
	<li>Описание<br />
	<textarea name="description" type="text" style="width:230px;height:60px;overflow:auto;"></textarea></li>
	<li><input type="submit" id="addsort" value="Добавить" class="button"/><span id="alias_msg_hook"></span></li>
</div>
</form>
<script>
$("#sort_new").css('display', $.cookie('em_sort_new') ? $.cookie('em_sort_new') : 'none');
$("#alias").keyup(function(){checksortalias();});
function issortalias(a){
	var reg1=/^[\w-]*$/;
	var reg2=/^[\d]+$/;
	if(!reg1.test(a)) {
		return 1;
	}else if(reg2.test(a)){
		return 2;
	}else if(a=='post' || a=='record' || a=='sort' || a=='tag' || a=='author' || a=='page'){
		return 3;
	} else {
		return 0;
	}
}
function checksortalias(){
	var a = $.trim($("#alias").val());
	if (1 == issortalias(a)){
		$("#addsort").attr("disabled", "disabled");
		$("#alias_msg_hook").html('<span id="input_error">Альтернативное имя может состоять только из букв, цифр, символов подчеркивания, тире</span>');
	}else if (2 == issortalias(a)){
		$("#addsort").attr("disabled", "disabled");
		$("#alias_msg_hook").html('<span id="input_error">Альтернативное имя не может состоять только из цифр </span>');
	}else if (3 == issortalias(a)){
		$("#addsort").attr("disabled", "disabled");
		$("#alias_msg_hook").html('<span id="input_error">Ошибка альтернативное имя конфликтует с системой ссылок</span>');
	}else {
		$("#alias_msg_hook").html('');
		$("#msg").html('');
		$("#addsort").attr("disabled", false);
	}
}
$(document).ready(function(){
	$("#adm_sort_list tbody tr:odd").addClass("tralt_b");
	$("#adm_sort_list tbody tr")
	.mouseover(function(){$(this).addClass("trover")})
	.mouseout(function(){$(this).removeClass("trover")});
	$("#menu_sort").addClass('sidebarsubmenu1');
});
</script>