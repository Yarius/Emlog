<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div class=containertitle><b>Резервное копирование и восстановление</b>
<?php if(isset($_GET['active_del'])):?><span class="actived">Успешно удалено</span><?php endif;?>
<?php if(isset($_GET['active_backup'])):?><span class="actived">Успешно</span><?php endif;?>
<?php if(isset($_GET['active_import'])):?><span class="actived">Импорт успешно завершен</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">Выберите файл для удаления</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error">Ошибка в названии файла</span><?php endif;?>
<?php if(isset($_GET['error_c'])):?><span class="error">Сервер не поддерживает ZIP, импорт невозможен</span><?php endif;?>
<?php if(isset($_GET['error_d'])):?><span class="error">Загрузить резервной копии не удалась</span><?php endif;?>
<?php if(isset($_GET['error_e'])):?><span class="error">Не корректная резервная копия</span><?php endif;?>
<?php if(isset($_GET['error_f'])):?><span class="error">Сервер не поддерживает ZIP, экспорт невозможен</span><?php endif;?>
</div>
<div class=line></div>
<form  method="post" action="data.php?action=dell_all_bak" name="form_bak" id="form_bak">
<table width="100%" id="adm_bakdata_list" class="item_list">
  <thead>
    <tr>
      <th width="683" colspan="2"><b>Резервная копия</b></th>
      <th width="226"><b>Дата</b></th>
      <th width="149"><b>Размер файла</b></th>
      <th width="87"></th>
    </tr>
  </head>
  <tbody>
	<?php
		if($bakfiles):
		foreach($bakfiles  as $value):
		$modtime = smartDate(filemtime($value),'Y-m-d H:i:s');
		$size =  changeFileSize(filesize($value));
		$bakname = substr(strrchr($value,'/'),1);
	?>
    <tr>
      <td width="22"><input type="checkbox" value="<?php echo $value; ?>" name="bak[]" class="ids" /></td>
      <td width="661"><a href="../content/backup/<?php echo $bakname; ?>"><?php echo $bakname; ?></a></td>
      <td><?php echo $modtime; ?></td>
      <td><?php echo $size; ?></td>
      <td><a href="javascript: em_confirm('<?php echo $value; ?>', 'backup');">Импорт</a></td>
    </tr>
	<?php endforeach;else:?>
	  <tr><td class="tdcenter" colspan="5">Пока нет резервных копий</td></tr>
	<?php endif;?>
	</tbody>
</table>
<div class="list_footer">
<a href="javascript:void(0);" id="select_all">Все</a> Выбранные элементы: <a href="javascript:bakact('del');" class="care">Удалить</a></div>
</form>
<div style="margin:20px 0px 20px 0px;"><a href="javascript:$('#import').hide();displayToggle('backup', 0);">Резервное копирование+</a>　<a href="javascript:$('#backup').hide();displayToggle('import', 0);">导入本地备份+</a></div>
<form action="data.php?action=bakstart" method="post">
<div id="backup">
	<p>Выберите таблицы для резервного копирования базы данных:<br /><select multiple="multiple" size="12" name="table_box[]">
		<?php foreach($tables  as $value): ?>
		<option value="<?php echo DB_PREFIX; ?><?php echo $value; ?>" selected="selected"><?php echo DB_PREFIX; ?><?php echo $value; ?></option>
		<?php endforeach; ?>
      	</select></p>
	<p>Экспорт файлов резервных копий на: 
	<select name="bakplace" id="bakplace">
		<option value="local" selected="selected">Скачать</option>
		<option value="server">Сохранить на сервере</option>
	</select>
	</p>
	<p id="local_bakzip">Архив (ZIP формат):<input type="checkbox" style="vertical-align:middle;" value="y" name="zipbak" id="zipbak"></p>
	<p id="server_bakfname" style="display:none;">Имя файла резервной копии:<input maxlength="200" size="35" value="<?php echo $defname; ?>" name="bakfname" /><b>.sql</b></p>
	<p><input type="submit" value="Начать резервное копирование" class="button" /></p>
</div>
</form>
<form action="data.php?action=import" enctype="multipart/form-data" method="post">
<div id="import">
	<p><input type="file" name="sqlfile" /> <input type="submit" value="Импорт" class="submit" /> (Поддержка emlog экспорта SQL и почтового формата резервного копирования)</p>
</div>
</form>
<div class=containertitle><b>Системный кеш</b>
<?php if(isset($_GET['active_mc'])):?><span class="actived">Кэш успешно обновлен</span><?php endif;?>
</div>
<div class=line></div>
<div style="margin:0px 0px 20px 0px;">
	<p class="des">Кэширование может значительно ускорить загрузку домашней страницы блога. Как правило, система будет автоматически обновлять кэш, но некоторые особые обстоятельства требуют от вас обновлять кеш вручную, например, если вручную изменять базу данных.</p>
	<p><input type="button" onclick="window.location='data.php?action=Cache';" value="Обновить кэш" class="button" /></p>
</div>
<script>
setTimeout(hideActived,2600);
$(document).ready(function(){
	$("#select_all").toggle(function () {$(".ids").attr("checked", "checked");},function () {$(".ids").removeAttr("checked");});
	$("#adm_bakdata_list tbody tr:odd").addClass("tralt_b");
	$("#adm_bakdata_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")});
	$("#bakplace").change(function(){$("#server_bakfname").toggle();$("#local_bakzip").toggle();});
});
function bakact(act){
	if (getChecked('ids') == false) {
		alert('Пожалуйста, выберите Файлы резервных копий');
		return;
	}
	if(act == 'del' && !confirm('Вы уверены, что хотите удалить выбранный файл резервной копии?')){return;}
	$("#operate").val(act);
	$("#form_bak").submit();
}
$("#menu_data").addClass('sidebarsubmenu1');
</script>