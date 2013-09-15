<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="admindex">
<div id="admindex_main">
    <div id="tw">
        <div class="main_img"><a href="./blogger.php"><img src="<?php echo $avatar; ?>" height="52" width="52" /></a></div>
        <div class="right">
        <form method="post" action="twitter.php?action=post">
        <div class="msg2"><a href="blogger.php"><?php echo $name; ?></a></div>
        <div class="box_1"><textarea class="box2" name="t">Напишите, что нового у Вас интересного...</textarea></div>
        <div class="tbutton" style="display:none;"><input type="submit" value="Ок" onclick="return checkt();"/> <a href="javascript:closet();">Отмена</a> <span>(Вы можете ввести 140 символов)</span></div>
        </form>
        </div>
		<div class="clear"></div>
    </div>
</div>
<div class="clear"></div>
<?php if (ROLE == 'admin'):?>
<div style="margin-top: 20px;">
<div id="admindex_servinfo">
<h3>Общая информация</h3>
<ul>
	<li>Всего: <b><?php echo $sta_cache['lognum'];?></b> записей<b>, <?php echo $sta_cache['comnum_all'];?> </b>комментариев<b>, <?php echo $sta_cache['twnum'];?> </b>записей в микроблоге</li>
	<li>Версия PHP：<?php echo $php_ver; ?></li>
	<li>Версия MySQL：<?php echo $mysql_ver; ?></li>
	<li>Веб-серер：<?php echo $serverapp; ?></li>
	<li>Версия GD：<?php echo $gd_ver; ?></li>
	<li>Максимальный размер загружаемого файла <?php echo $uploadfile_maxsize; ?></li>
	<li><a href="index.php?action=phpinfo">Информация о программном обеспечении&raquo;</a></li>
</ul>
<p id="m"><a title="Версия сайта для мобильных устройств "><?php echo BLOG_URL.'m'; ?></a></p>
</div>
<div id="admindex_msg">
<h3>Официальные новости</h3>
<ul></ul>
</div>
<div class="clear"></div>
</div>
</div>
<script>
$(document).ready(function(){
	$("#admindex_msg ul").html("<span class=\"ajax_remind_1\">загрузка...</span>");
	$.getJSON("http://www.emlog.net/services/messenger.php?v=<?php echo Option::EMLOG_VERSION; ?>&callback=?",
	function(data){
		$("#admindex_msg ul").html("");
		$.each(data.items, function(i,item){
			var image = '';
			if (item.image != ''){
				image = "<a href=\""+item.url+"\" target=\"_blank\" title=\""+item.title+"\"><img src=\""+item.image+"\"></a><br />";
			}
			$("#admindex_msg ul").append("<li class=\"msg_type_"+item.type+"\">"+image+"<span>"+item.date+"</span><a href=\""+item.url+"\" target=\"_blank\">"+item.title+"</a></li>");
		});
	});
});
</script>
<?php endif;?>
<script>
$(document).ready(function(){
    $(".box2").focus(function(){
        $(this).val('').css('height','50px').unbind('focus');
        $(".tbutton").show();
    });
    $(".box2").keyup(function(){
       var t=$(this).val();
       var n = 140 - t.length;
       if (n>=0){
         $(".tbutton span").html("(Осталось "+n+" символов)");
       }else {
         $(".tbutton span").html("<span style=\"color:#FF0000\">(Превышено ограничение на " +Math.abs(n)+ " символов)</span>");
       }
    });
});
function closet(){
    $(".tbutton").hide();
    $(".tbutton span").html("(Вы можете ввести 140 символов)");
    $(".box2").val('Напишите что-нибудь  сегодня! ...').css('height','17px').bind('focus',function(){
        $(this).val('').css('height','50px').unbind('focus');
        $(".tbutton").show();});
}
function checkt(){
    var t=$(".box2").val();
    var n=140 - t.length;
    if (n<0){return false;}
}
</script>
