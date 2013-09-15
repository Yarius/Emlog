<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="m">
	<div class="posttitle"><?php echo $log_title; ?></div>
	<div class="postinfo">post by:<?php echo $user_cache[$author]['name'];?> <?php echo gmdate('j-n-Y G:i', $date); ?>
	<?php if(ROLE == 'admin' || $author == UID): ?>
	<a href="./?action=dellog&gid=<?php echo $logid;?>">Удалить</a>
	<?php endif;?>
	</div>
	<div class="postcont"><?php echo $log_content; ?></div>
	<div class="t">Комментарии: </div>
	<div class="c">
		<?php foreach($commentStacks as $cid):
			$comment = $comments[$cid];
			$comment['poster'] = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank">'.$comment['poster'].'</a>' : $comment['poster'];
		?>
		<div class="l">
		<b><?php echo $comment['poster']; ?></b>
		<div class="info"><?php echo $comment['date']; ?> <a href="./?action=reply&cid=<?php echo $comment['cid'];?>">回复</a></div>
		<div class="comcont"><?php echo $comment['content']; ?></div>
		</div>
		<?php endforeach; ?>
		<div id="page"><?php echo $commentPageUrl;?></div>
	</div>
	<div class="t">Комментарий: </div>
	<div class="c">
		<form method="post" action="./index.php?action=addcom&gid=<?php echo $logid; ?>">
		<?php if(ISLOGIN == true):?>
		Вы авторизовались, как: <b><?php echo $user_cache[UID]['name']; ?></b><br />
		<?php else: ?>
		Пользователь <br /><input type="text" name="comname" value="" /><br />
		E-mail (не обязательно) <br /><input type="text" name="commail" value="" /><br />
		Сайт (не обязательно) <br /><input type="text" name="comurl" value="" /><br />
		<?php endif; ?>
		Комментарий <br /><textarea name="comment" rows="10"></textarea><br />
		<?php echo $verifyCode; ?><br /><input type="submit" value="Отправить" />
		</form>
	</div>
</div>