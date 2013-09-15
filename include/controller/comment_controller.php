<?php
/**
 * Комментарии
 *
 * @copyright (c) Emlog All Rights Reserved
 * Перевод: One-st.ru
 */

class Comment_Controller {
	function addComment($params) {
		$name = isset($_POST['comname']) ? addslashes(trim($_POST['comname'])) : '';
		$content = isset($_POST['comment']) ? addslashes(trim($_POST['comment'])) : '';
		$mail = isset($_POST['commail']) ? addslashes(trim($_POST['commail'])) : '';
		$url = isset($_POST['comurl']) ? addslashes(trim($_POST['comurl'])) : '';
		$imgcode = isset($_POST['imgcode']) ? strtoupper(trim($_POST['imgcode'])) : '';
		$blogId = isset($_POST['gid']) ? intval($_POST['gid']) : -1;
		$pid = isset($_POST['pid']) ? intval($_POST['pid']) : 0;

		if (ISLOGIN === true) {
			$CACHE = Cache::getInstance();
			$user_cache = $CACHE->readCache('user');
			$name = addslashes($user_cache[UID]['name_orig']);
			$mail = addslashes($user_cache[UID]['mail']);
			$url = addslashes(BLOG_URL);
		}

		if ($url && strncasecmp($url,'http://',7)) {
			$url = 'http://'.$url;
		}

		doAction('comment_post');

		$Comment_Model = new Comment_Model();
		$Comment_Model->setCommentCookie($name,$mail,$url);
		if($Comment_Model->isLogCanComment($blogId) === false) {
			emMsg('Запрещено добавление комментариев к данной статье');
		} elseif ($Comment_Model->isCommentExist($blogId, $name, $content) === true) {
			emMsg('Такой комментарий уже существует');
		} elseif ($Comment_Model->isCommentTooFast() === true) {
			emMsg('Комментарий не будет опубликован. Вы слишком часто пытаетесь опубликовать комментарии');
		} elseif (empty($name)) {
			emMsg('Введите Ваш логин');
		} elseif (strlen($name) > 30) {
			emMsg('Ваш логин слишком длинный');
		} elseif ($mail != '' && !checkMail($mail)) {
			emMsg('Введите корректный адрес электронной почты');
		} elseif (ISLOGIN == false && $Comment_Model->isNameAndMailValid($name, $mail) === false) {
			emMsg('Ваш логин и/или электронная почта заблокированы!');
		} elseif (!empty($url) && preg_match("/^(http|https)\:\/\/[^<>'\"]*$/", $url) == false) {
			emMsg('Введите корректный адрес Вашего сайта','javascript:history.back(-1);');
		} elseif (empty($content)) {
			emMsg('Введите текст комментария');
		} elseif (strlen($content) > 10000) {
			emMsg('Ваш комментарий слишком большой');
		//} elseif (ROLE == 'visitor' && Option::get('comment_needchinese') == 'y' && !preg_match('/[\x{4e00}-\x{9fa5}]/iu', $content)) {
			//emMsg('Комментарии должны содержать китайских комментарии не удалось:');
		} elseif (ISLOGIN == false && Option::get('comment_code') == 'y' && session_start() && $imgcode != $_SESSION['code']) {
			emMsg('Введите проверочный код!');
		} else {
			$Comment_Model->addComment($name, $content, $mail, $url, $imgcode, $blogId, $pid);
		}
	}
}
