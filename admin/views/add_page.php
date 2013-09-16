<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script charset="utf-8" src="./editor/kindeditor.js"></script>
<script charset="utf-8" src="./editor/lang/en.js"></script>
<div class=containertitle><b>Создание страницы</b><span id="msg_2"></span></div>
<div id="msg"></div>
<form action="page.php?action=add" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
<div id="post">
<div>
    <label for="title" id="title_label">Введите заголовок</label>
    <input type="text" maxlength="200" style="width:710px;" name="title" id="title"/>
    <input name="date" id="date" type="hidden" value="" >
</div>
<div id="post_bar">
	<div>
	    <span onclick="displayToggle('FrameUpload', 0);autosave(4);" class="show_advset">Загрузить файл</span>
	    <?php doAction('adm_writelog_head'); ?>
	    <span id="asmsg"></span>
	    <input type="hidden" name="as_logid" id="as_logid" value="-1">
    </div>
    <div id="FrameUpload" style="display: none;">
        <iframe width="800" height="330" frameborder="0" src="attachment.php?action=selectFile"></iframe>
    </div>
</div>
<div><textarea id="content" name="content" style="width:800px; height:460px; border:#CCCCCC solid 1px;"></textarea></div>
<div>
    <span id="alias_msg_hook"></span>
    ЧПУ URL: </b>(Работает только при включенном ЧПУ в <a href="./seo.php" target="_blank">настройках</a><br />
    <input name="alias" id="alias" style="width:798px;" />
</div>
<div>
    <span id="page_options">
        <label for="allow_remark">Комментарии</label>
        <input type="checkbox" value="y" name="allow_remark" id="allow_remark" />
    </span>
</div>
<div id="post_button">
    <input type="hidden" name="ishide" id="ishide" value="">
    <input type="submit" value="Опубликовать" onclick="return checkform();" class="button" />
    <input type="button" name="savedf" id="savedf" value="Сохранить" onclick="autosave(3);" class="button" />
</div>
</div>
</form>
<div class=line></div>
<script>
loadEditor('content');
$("#menu_page").addClass('sidebarsubmenu1');
$("#alias").keyup(function(){checkalias();});
$("#title").focus(function(){$("#title_label").hide();});
$("#title").blur(function(){if($("#title").val() == '') {$("#title_label").show();}});
</script>
