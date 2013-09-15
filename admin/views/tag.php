<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b>Метки (теги)</b>
<?php if(isset($_GET['active_del'])):?><span class="actived">Метки успешно удалены</span><?php endif;?>
<?php if(isset($_GET['active_edit'])):?><span class="actived">Метка успешно изменена</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">Пожалуйста, выберите метку, которую требуется удалить</span><?php endif;?>
</div>
<div class=line></div>
<form action="tag.php?action=dell_all_tag" method="post" name="form_tag" id="form_tag">
<div>
<li>
<?php 
if($tags):
foreach($tags as $key=>$value): ?>	
<input type="checkbox" name="tag[<?php echo $value['tid']; ?>]" class="ids" value="1" >
<a href="tag.php?action=mod_tag&tid=<?php echo $value['tid']; ?>"><?php echo $value['tagname']; ?></a> &nbsp;&nbsp;&nbsp;
<?php endforeach; ?>
</li>
<li style="margin:20px 0px">
<a href="javascript:void(0);" id="select_all">Выбор</a> Избранное:
<a href="javascript:deltags();" class="care">Удалить</a>
</li>
<?php else:?>
<li style="margin:20px 30px">Список меток (тегов) берется из опубликованных статей</li>
<?php endif;?>
</div>
</form>
<script>
$("#select_all").toggle(function () {$(".ids").attr("checked", "checked");},function () {$(".ids").removeAttr("checked");});
function deltags(){
	if (getChecked('ids') == false) {
		alert('Пожалуйста, выберите метку, которую хотите удалить');
		return;
	}
	if(!confirm('Вы уверены, что хотите удалить выбранные теги?')){return;}
	$("#form_tag").submit();
}
setTimeout(hideActived,2600);
$("#menu_tag").addClass('sidebarsubmenu1');
</script>