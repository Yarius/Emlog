<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
$isdraft = $hide == 'y' ? true : false;
?>
<script charset="utf-8" src="./editor/kindeditor.js"></script>
<script charset="utf-8" src="./editor/lang/en.js"></script>
<div class=containertitle><b><?php if ($isdraft) :?>Редактирование статьи<?php else:?>Редактирование статьи<?php endif;?></b><span id="msg_2"></span></div><div id="msg"></div>
<form action="save_log.php?action=edit" method="post" id="addlog" name="addlog">
<div id="post">
<div>
    <label for="title" id="title_label">Введите название статьи</label>
    <input type="text" maxlength="200" style="width:792px;" name="title" id="title" value="<?php echo $title; ?>" />
</div>
<div id="post_bar">
	<div>
	    <span onclick="displayToggle('FrameUpload', 0);autosave(1);" class="show_advset">Загрузить файл</span>
	    <?php doAction('adm_writelog_head'); ?>
	    <span id="asmsg"></span>
	    <input type="hidden" name="as_logid" id="as_logid" value="<?php echo $logid; ?>">
    </div>
    <div id="FrameUpload" style="display: none;">
        <iframe width="800" height="330" frameborder="0" src="attachment.php?action=attlib&logid=<?php echo $logid; ?>"></iframe>
    </div>
</div>
<div>
    <textarea id="content" name="content" style="width:800px; height:460px; border:#CCCCCC solid 1px;"><?php echo $content; ?></textarea>
</div>
<div style="margin:10px 0px 5px 0px;">
    <label for="tag" id="tag_label">Введите метки через запятую (теги)</label>
    <input name="tag" id="tag" maxlength="200" style="width:368px;" value="<?php echo $tagStr; ?>" />
    <span style="color:#2A9DDB;cursor:pointer;margin-right: 40px;"><a href="javascript:displayToggle('tagbox', 0);">Теги+</a></span>
    <select name="sort" id="sort" style="width:130px;">
     <?php
     $sorts[] = array('sid'=>-1, 'sortname'=>'Категория');
     foreach($sorts as $val):
         $flg = $val['sid'] == $sortid ? 'selected' : '';
     ?>
        <option value="<?php echo $val['sid']; ?>" <?php echo $flg; ?>><?php echo $val['sortname']; ?></option>
     <?php endforeach; ?>
    </select>
    Дата: <input maxlength="200" style="width:139px;" name="postdate" id="postdate" value="<?php echo gmdate('Y-m-d H:i:s', $date); ?>"/>
    <input name="date" id="date" type="hidden" value="<?php echo $orig_date; ?>" >
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
<div class="show_advset" onclick="displayToggle('advset', 1);">Дополнительные параметры</div>
<div id="advset">
<div>Вводный текст: </div>
<div><textarea id="excerpt" name="excerpt" style="width:800px; height:260px; border:#CCCCCC solid 1px;"><?php echo $excerpt; ?></textarea></div>
<div><span id="alias_msg_hook"></span>ЧПУ URL статьи: (Работает только при включенном ЧПУ <a href="./seo.php" target="_blank">в настройках</a>)</div>
<div><input name="alias" id="alias" value="<?php echo $alias;?>" style="width:798px;" /></div>
<?php if (Option::get('istrackback') == 'y'): ?>
<div><b>Посылать уведомление (трекбек) </b>(каждый адрес с новой строки)</div>
<div><textarea name="pingurl" id="pingurl" style="width:795px; height:50px;" class="input"></textarea></div>
<?php endif;?>
<div>
	Пароль для статьи:
    <input type="text" value="<?php echo $password; ?>" name="password" id="password" style="width:80px;" />
    <span id="post_options">
        <input type="checkbox" value="y" name="top" id="top" <?php echo $is_top; ?> />
        <label for="top">Прикрепить</label>
        <input type="checkbox" value="y" name="allow_remark" id="allow_remark" <?php echo $is_allow_remark; ?> />
        <label for="allow_remark">Комментарии</label>
        <input type="checkbox" value="y" id="allow_tb" name="allow_tb" <?php echo $is_allow_tb; ?> />
        <label for="allow_tb">Трекбэки</label>
    </span>
</div>
</div>
<div id="post_button">
    <input type="hidden" name="ishide" id="ishide" value="<?php echo $hide; ?>" />
    <input type="hidden" name="gid" value=<?php echo $logid; ?> />
    <input type="hidden" name="author" id="author" value=<?php echo $author; ?> />
    <input type="submit" value="Сохранить и вернуться" onclick="return checkform();" class="button" />
    <input type="button" name="savedf" id="savedf" value="Сохранить" onclick="autosave(2);" class="button" />
    <?php if ($isdraft) :?>
    <input type="submit" name="pubdf" id="pubdf" value="Опубликовать" onclick="return checkform();" class="button" />
    <?php endif;?>
</div>
</div>
</form>
<div class=line></div>
<script>
loadEditor('content');
loadEditor('excerpt');
checkalias();
$("#alias").keyup(function(){checkalias();});
$("#advset").css('display', $.cookie('em_advset') ? $.cookie('em_advset') : '');
$("#title").focus(function(){$("#title_label").hide();});
$("#title").blur(function(){if($("#title").val() == '') {$("#title_label").show();}});
$("#tag").focus(function(){$("#tag_label").hide();});
$("#tag").blur(function(){if($("#tag").val() == '') {$("#tag_label").show();}});
if ($("#title").val() != '')$("#title_label").hide();
if ($("#tag").val() != '')$("#tag_label").hide();
setTimeout("autosave(0)",60000);
<?php if ($isdraft) :?>
$("#menu_draft").addClass('sidebarsubmenu1');
<?php else:?>
$("#menu_log").addClass('sidebarsubmenu1');
<?php endif;?>
</script>
