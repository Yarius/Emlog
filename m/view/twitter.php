<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="m">
<?php if(ISLOGIN === true): ?>
<form method="post" action="./index.php?action=t" enctype="multipart/form-data">
Микроблог: <br />
<textarea cols="20" rows="3" name="t"></textarea><br />
Выберите изображение для загрузки: <br />
<input type="file" name="img" /><br />
<input type="submit" value="Загрузить" />
</form>
<?php endif;?>
<?php 
foreach($tws as $value):
$img = empty($value['img']) ? "" : '<a title="Просмотр изображения" href="'.BLOG_URL.str_replace('thum-', '', $value['img']).'" target="_blank"><img style="border: 1px solid #EFEFEF;" src="'.BLOG_URL.$value['img'].'"/></a>';
$by = $value['author'] != 1 ? 'by:'.$user_cache[$value['author']]['name'] : '';
?>
<div class="twcont"><?php echo $value['content'];?><p><?php echo $img;?></p></div>
<div class="twinfo"><?php echo $by.' '.$value['date'];?>
<?php if(ISLOGIN === true && $value['author'] == UID || ROLE == 'admin'): ?>
 <a href="./?action=delt&id=<?php echo $value['id'];?>">Удалить</a>
<?php endif;?>
</div>
<?php endforeach; ?>
<div id="page"><?php echo $pageurl;?></div>
</div>