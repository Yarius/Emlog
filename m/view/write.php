<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="m">
<form action="./index.php?action=savelog" method="post">
Название статьи:<br /><input type="text" name="title" value="<?php echo $title; ?>" /><br />
Категория:<br />
	      <select name="sort" id="sort">
			<?php
			$sorts[] = array('sid'=>-1, 'sortname'=>'Выберите категорию');
			foreach($sorts as $val):
			$flg = $val['sid'] == $sortid ? 'selected' : '';
			?>
			<option value="<?php echo $val['sid']; ?>" <?php echo $flg; ?>><?php echo $val['sortname']; ?></option>
			<?php endforeach; ?>
	      </select>
<br />
Содержание:<br /><textarea name="content" class="texts"><?php echo $content; ?></textarea><br />
Краткое описание:<br /><textarea name="excerpt" class="excerpt"><?php echo $excerpt; ?></textarea><br />
Теги:<br /><input type="text" name="tag" value="<?php echo $tagStr; ?>" /><br />
<input type="hidden" name="gid" value=<?php echo $logid; ?> />
<input type="hidden" name="author" value=<?php echo $author; ?> />
<input name="date" type="hidden" value="<?php print !empty($date) ? gmdate('d-m-Y H:i:s', $date) : ''; ?>" />
<input type="submit" value="Опубликовать" />
</form>
</div>
