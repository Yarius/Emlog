<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="m">
<?php 
foreach($comment as $value):
	$ishide = ISLOGIN === true && $value['hide']=='y'?'<font color="red" size="1">[Премодерация]</font>':'';
?>
<div class="comcont"><a href="<?php echo BLOG_URL; ?>m/?post=<?php echo $value['gid']; ?>"><?php echo $value['content']; ?></a>
<?php if(ISLOGIN === true): ?>
<a href="./?action=delcom&id=<?php echo $value['cid'];?>"><font size="1">[Удалить]</font></a>
<?php endif;?>
</div>
<?php if(ISLOGIN === true): ?>
<div class="info">Статья: <?php echo $value['title']; ?></div>
<?php endif;?>
<div class="cominfo">
<?php if(ISLOGIN === true && $value['hide'] == 'n'): ?>
<a href="./?action=hidecom&id=<?php echo $value['cid'];?>">Скрыть</a>
<?php elseif(ISLOGIN === true && $value['hide'] == 'y'):?>
<a href="./?action=showcom&id=<?php echo $value['cid'];?>">Показать</a>
<?php endif;?>
<a href="./?action=reply&cid=<?php echo $value['cid'];?>">Ответ</a>
<br />
<?php if(ISLOGIN === true): ?>
<?php echo $value['date']; ?> by:<?php echo $value['poster']; ?>
<?php else:?>
by:<?php echo $value['name']; ?>
<?php endif;?>
</div>
<?php endforeach; ?>
<div id="page"><?php echo $pageurl;?></div>
</div>