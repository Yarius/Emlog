<?php 
/**
 * 首页文章列表部分
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div id="content">
<div id="contentleft">
<?php doAction('index_loglist_top'); ?>

<?php 
if (!empty($logs)):
foreach($logs as $value): 
?>
	<h2><?php topflg($value['top']); ?><a href="<?php echo $value['log_url']; ?>"><?php echo $value['log_title']; ?></a></h2>
	<p class="date">Автор: <?php blog_author($value['author']); ?> Опубликовано: <?php echo gmdate('Y-n-j G:i l', $value['date']); ?> 
	<?php blog_sort($value['logid']); ?> 
	<?php editflg($value['logid'],$value['author']); ?>
	</p>
	<?php echo $value['log_description']; ?>
	<p class="tag"><?php blog_tag($value['logid']); ?></p>
	<p class="count">
	<a href="<?php echo $value['log_url']; ?>#comments">Комментировать(<?php echo $value['comnum']; ?>)</a>
	<a href="<?php echo $value['log_url']; ?>#tb">Цитировать(<?php echo $value['tbcount']; ?>)</a>
	<a href="<?php echo $value['log_url']; ?>">Просмотры(<?php echo $value['views']; ?>)</a>
	</p>
	<div style="clear:both;"></div>
<?php 
endforeach;
else:
?>
	<h2>Не найдено</h2>
	<p>Извините, результатов, которые соответствуют вашему запросу не найдено</p>
<?php endif;?>

<div id="pagenavi">
	<?php echo $page_url;?>
</div>

</div><!-- end #contentleft-->
<?php
 include View::getView('side');
 include View::getView('footer');
?>