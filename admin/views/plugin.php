<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b>Управление плагинами</b><div id="msg"></div>
<?php if(isset($_GET['activate_install'])):?><span class="actived">Успешная загрузка плагинов, пожалуйста, используйте активацию</span><?php endif;?>
<?php if(isset($_GET['active'])):?><span class="actived">Активация прошла успешно</span><?php endif;?>
<?php if(isset($_GET['activate_del'])):?><span class="actived">Успешно удален</span><?php endif;?>
<?php if(isset($_GET['active_error'])):?><span class="error">Активация плагинов невыполнена </span><?php endif;?>
<?php if(isset($_GET['inactive'])):?><span class="actived">Плагин успешно отключен</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">Удалить не удалось, проверьте права доступа к файлам</span><?php endif;?>
</div>
<div class=line></div>
<form action="trackback.php?action=dell_all_tb" method="post">
  <table width="100%" id="adm_plugin_list" class="item_list">
  <thead>
      <tr>
        <th width="100"></th>
        <th width="36" class="tdcenter"><b>Статус</b></th>
		<th width="30" class="tdcenter"><b>Версия</b></th>
		<th width="500" class="tdcenter"><b>Описание</b></th>
		<th width="30" class="tdcenter"></th>
      </tr>
  </thead>
  <tbody>
	<?php 
	if($plugins):
	$i = 0;
	foreach($plugins as $key=>$val):
		$plug_state = 'inactive';
		$plug_action = 'active';
		$plug_state_des = 'Неактивирован';
		if (in_array($key, $active_plugins))
		{
			$plug_state = 'active';
			$plug_action = 'inactive';
			$plug_state_des = 'Активирован';
		}
		$i++;
	?>	
      <tr>
        <td class="tdcenter"><?php echo $val['Name']; ?></td>
		<td class="tdcenter" id="plugin_<?php echo $i;?>">
		<a href="./plugin.php?action=<?php echo $plug_action;?>&plugin=<?php echo $key;?>"><img src="./views/images/plugin_<?php echo $plug_state; ?>.gif" title="<?php echo $plug_state_des; ?>" align="absmiddle" border="0"></a>
		</td>
        <td class="tdcenter"><?php echo $val['Version']; ?></td>
        <td>
		<?php echo $val['Description']; ?>
		<?php if ($val['Url'] != ''):?><a href="<?php echo $val['Url'];?>" target="_blank">Подробнее&raquo;</a><?php endif;?>
		<div style="margin-top:5px;">
		<?php if ($val['ForEmlog'] != ''):?>Для emlog: <?php echo $val['ForEmlog'];?>&nbsp | &nbsp<?php endif;?>
		<?php if ($val['Author'] != ''):?>
		Автор: <?php if ($val['AuthorUrl'] != ''):?>
			<a href="<?php echo $val['AuthorUrl'];?>" target="_blank"><?php echo $val['Author'];?></a>
			<?php else:?>
			<?php echo $val['Author'];?>
			<?php endif;?>
		<?php endif;?>
		</div>
		</td>
		<td><a href="javascript: em_confirm('<?php echo $key; ?>', 'plu');" class="care">Удалить</a></td>
      </tr>
	<?php endforeach;else: ?>
	  <tr>
        <td class="tdcenter" colspan="5">Список пуст</td>
      </tr>
	<?php endif;?>
	</tbody>
  </table>
</form>
<div class="add_plugin"><a href="./plugin.php?action=install">Добавить</a></div>
<script>
$("#adm_plugin_list tbody tr:odd").addClass("tralt_b");
$("#adm_plugin_list tbody tr")
	.mouseover(function(){$(this).addClass("trover")})
	.mouseout(function(){$(this).removeClass("trover")})
setTimeout(hideActived,2600);
$("#menu_plug").addClass('sidebarsubmenu1');
</script>