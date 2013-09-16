<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script charset="utf-8" src="./editor/kindeditor.js"></script>
<div class=containertitle><b>Публикация статьи</b><span id="msg_2"></span></div>
<div id="msg"></div>
<form action="save_log.php?action=add" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
<div id="post">
<div>
    <label for="title" id="title_label">Введите название статьи</label>
    <input type="text" maxlength="200" style="width:792px;" name="title" id="title"/>
</div>
<div id="post_bar">
	<div>
	    <span onclick="displayToggle('FrameUpload', 0);autosave(1);" class="show_advset">Загрузить</span>
	    <?php doAction('adm_writelog_head'); ?>
	    <span id="asmsg"></span>
	    <input type="hidden" name="as_logid" id="as_logid" value="-1">
    </div>
    <div id="FrameUpload" style="display: none;">
        <iframe width="800" height="330" frameborder="0" src="attachment.php?action=selectFile"></iframe>
    </div>
</div>
<div>
    <textarea id="content" name="content" cols="100" rows="8" style="width:800px; height:460px;"></textarea>
</div>
<div style="margin:10px 0px 5px 0px;">
    <label for="tag" id="tag_label">Введите метки через запятую (теги)</label>
    <input name="tag" id="tag" maxlength="200" style="width:368px;" />
    <span style="color:#2A9DDB;cursor:pointer;margin-right: 40px;"><a href="javascript:displayToggle('tagbox', 0);">Теги+</a></span>
    <select name="sort" id="sort" style="width:130px;">
        <option value="-1">Категория</option>
        <?php foreach($sorts as $val):?>
        <option value="<?php echo $val['sid']; ?>"><?php echo $val['sortname']; ?></option>
        <?php endforeach;?>
    </select>
    Дата: <input maxlength="200" style="width:139px;" name="postdate" id="postdate" value="<?php echo $postDate; ?>"/>
    <input name="date" id="date" type="hidden" value="" >
</div>
<div id="tagbox" style="width:688px;margin:0px 0px 0px 30px;display:none;">
<?php
    if ($tags) {
        foreach ($tags as $val){
            echo " <a href=\"javascript: insertTag('{$val['tagname']}','tag');\">{$val['tagname']}</a> ";
        }
    } else {
        echo 'Список пока пуст';
    }
?>
</div>
<div class="show_advset" onclick="displayToggle('advset', 1);">Дополнительно</div>
<div id="advset">
<div>Вводный текст: </div>
<div><textarea id="excerpt" name="excerpt" style="width:800px; height:260px; border:#CCCCCC solid 1px;"></textarea></div>
<div><span id="alias_msg_hook"></span>ЧПУ URL статьи: (Работает только при включенном ЧПУ в <a href="./seo.php" target="_blank">настройках</a>)<span id="alias_msg_hook"></span></div>
<div><input name="alias" id="alias" style="width:798px;" /></div>
<?php if (Option::get('istrackback') == 'y'): ?>
<div>Trackbacks:</b>( (каждый адрес с новой строки)</div>
<div><textarea name="pingurl" id="pingurl" style="width:795px; height:50px;" class="input"></textarea></div>
<?php endif;?>
<div>
    Пароль для доступа: <input type="text" value="" name="password" id="password" style="width:80px;" />
    <span id="post_options">
        <input type="checkbox" value="y" name="top" id="top" />
        <label for="top">Закрепить</label>
        <input type="checkbox" value="y" name="allow_remark" id="allow_remark" checked="checked" />
        <label for="allow_remark">Комментарии</label>
        <input type="checkbox" value="y" id="allow_tb" name="allow_tb" checked="checked" />
        <label for="allow_tb">Трекбэки</label>
    </span>
</div>
</div>
<div id="post_button">
    <input type="hidden" name="ishide" id="ishide" value="">
    <input type="submit" value="Опубликовать" onclick="return checkform();" class="button" />
    <input type="hidden" name="author" id="author" value=<?php echo UID; ?> />	 
    <input type="button" name="savedf" id="savedf" value="Сохранить" onclick="autosave(2);" class="button" />
</div>
</div>
</form>
<div class=line></div>
<script>
loadEditor('content');
loadEditor('excerpt');
$("#menu_wt").addClass('sidebarsubmenu1');
$("#advset").css('display', $.cookie('em_advset') ? $.cookie('em_advset') : '');
$("#alias").keyup(function(){checkalias();});
$("#title").focus(function(){$("#title_label").hide();});
$("#title").blur(function(){if($("#title").val() == '') {$("#title_label").show();}});
$("#tag").focus(function(){$("#tag_label").hide();});
$("#tag").blur(function(){if($("#tag").val() == '') {$("#tag_label").show();}});
setTimeout("autosave(0)",60000);
</script>
