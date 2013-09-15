<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="containertitle2">
<a class="navi3" href="./template.php">Шаблоны</a>
<a class="navi4" href="./template.php?action=install">Установка</a>
<?php if(isset($_GET['activated'])):?><span class="actived">Шаблон успешно установлен</span><?php endif;?>
</div>
<?php if(!$nonceTplData): ?>
<div class="error_msg">Используемый в настоящее время шаблон (<?php echo $nonce_templet; ?>) был удален или поврежден, пожалуйста, выберите другой шаблон.</div>
<?php else:?>
<table cellspacing="20" cellpadding="0" width="80%" border="0">
    <tr>
      <td width="27%">
	  <img src="<?php echo TPLS_URL.$nonce_templet; ?>/preview.jpg" width="240" height="180"  border="1" />	  </td>
	  <td width="73%">
	  <?php echo $tplName; ?> <em><?php echo $tplVer; ?></em><br>
	  <?php echo $tplAuthor; ?><br>
	  <?php echo $tplForEm; ?><br>
	  <p><?php echo $tplDes; ?></p>
	  <?php if ('default' == $nonce_templet): ?>
	  <div class="custom_top_button"><a href="./template.php?action=custom-top">Настройка</a></div>
	  <?php endif; ?>
	  </td>
    </tr>
</table>
<?php endif;?>
<div class="containertitle2">
<span class="navi3">Шаблоны (<?php echo $tplnums; ?>)</span>
<a name="tpllib"></a>
<?php if(isset($_GET['activate_install'])):?><span class="actived">Шаблон успешно загружен</span><?php endif;?>
<?php if(isset($_GET['activate_del'])):?><span class="actived">Шаблон успешно удален</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">Удалить не удается, проверьте разрешения файлов шаблона</span><?php endif;?>
</div>
<table cellspacing="0" cellpadding="0" width="99%" border="0" class="adm_tpl_list">
<?php 
$i = 0;
foreach($tpls as $key=>$value):
if($i % 3 == 0){echo "<tr>";}
$i++;
?>
      <td align="center" width="300">
	  <a href="template.php?action=usetpl&tpl=<?php echo $value['tplfile']; ?>&side=<?php echo $value['sidebar']; ?>">
	  <img alt="Нажмите, чтобы использовать шаблон" src="<?php echo TPLS_URL.$value['tplfile']; ?>/preview.jpg" width="180" height="150" border="0" />
	  </a><br />
      <?php echo $value['tplname']; ?>
      <span> | <a href="javascript: em_confirm('<?php echo $value['tplfile']; ?>', 'tpl');" class="care">Удалить</a></span>
      </td>
<?php 
if($i > 0 && $i % 3 == 0){echo "</tr>";}
endforeach; 
?>
</table>
<script>
setTimeout(hideActived,2600);
$("#menu_tpl").addClass('sidebarsubmenu1');
</script>