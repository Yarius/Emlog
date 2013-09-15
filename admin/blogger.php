<?php
/**
 * 个人资料
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

if ($action == '') {
	$User_Model = new User_Model();
	$row = $User_Model->getOneUser(UID);
	extract($row);
	$icon = '';
	if ($photo) {
		$imgsize = chImageSize($photo, Option::ICON_MAX_W, Option::ICON_MAX_H);
		$icon = "<img src=\"{$photo}\" width=\"{$imgsize['w']}\" height=\"{$imgsize['h']}\" style=\"border:1px solid #CCCCCC;padding:1px;\" />
		<br /><a href=\"javascript: em_confirm(0, 'avatar');\">Удалить</a>";
	} else {
		$icon = '<img src="./views/images/avatar.jpg" />';
	}
	include View::getView('header');
	require_once(View::getView('blogger'));
	include View::getView('footer');
	View::output();
}

if ($action == 'update') {
	$User_Model = new User_Model();
	$photo = isset($_POST['photo']) ? addslashes(trim($_POST['photo'])) : '';
	$nickname = isset($_POST['name']) ? addslashes(trim($_POST['name'])) : '';
	$email = isset($_POST['email']) ? addslashes(trim($_POST['email'])) : '';
	$description = isset($_POST['description']) ? addslashes(trim($_POST['description'])) : '';

	if (strlen($nickname) > 20) {
		emDirect("./blogger.php?error_a=1");
	} else if ($email != '' && !checkMail($email)) {
		emDirect("./blogger.php?error_b=1");
	}

	$photo_type = array('gif', 'jpg', 'jpeg','png');
	$usericon = $photo;
	if ($_FILES['photo']['size'] > 0) {
		$file_info = uploadFile($_FILES['photo']['name'], $_FILES['photo']['error'], $_FILES['photo']['tmp_name'], $_FILES['photo']['size'], $photo_type, true);
		if (!empty($file_info['file_path'])) {
			$usericon = !empty($file_info['thum_file']) ? $file_info['thum_file'] : $file_info['file_path'];
		}
	}
	$User_Model->updateUser(array('nickname'=>$nickname, 'email'=>$email, 'photo'=>$usericon, 'description'=>$description), UID);
	$CACHE->updateCache('user');
	emDirect("./blogger.php?active_edit=1");
}

if ($action == 'delicon') {
	$DB = MySql::getInstance();
	$query = $DB->query("select photo from ".DB_PREFIX."user where uid=" . UID);
	$icon = $DB->fetch_array($query);
	$icon_1 = $icon['photo'];
	if (file_exists($icon_1)) {
		$icon_2 = str_replace('thum-', '', $icon_1);
		if ($icon_2 != $icon_1 && file_exists($icon_2)) {
			unlink($icon_2);
		}
		$icon_3 = preg_replace("/^(.*)\/(.*)$/", "\$1/thum52-\$2", $icon_2);
		if ($icon_3 != $icon_2 && file_exists($icon_3)) {
			unlink($icon_3);
		}
		unlink($icon_1);
	}
	$DB->query("UPDATE ".DB_PREFIX."user SET photo='' where uid=" . UID);
	$CACHE->updateCache('user');
	emDirect("./blogger.php?active_del=1");
}

if ($action == 'update_pwd') {

	$User_Model = new User_Model();

	$login = isset($_POST['username']) ? addslashes(trim($_POST['username'])) : '';
	$newpass = isset($_POST['newpass']) ? addslashes(trim($_POST['newpass'])) : '';
	$oldpass = isset($_POST['oldpass']) ? addslashes(trim($_POST['oldpass'])) : '';
	$repeatpass = isset($_POST['repeatpass']) ? addslashes(trim($_POST['repeatpass'])) : '';

	$PHPASS = new PasswordHash(8, true);
	$ispass = LoginAuth::checkPassword($oldpass, $userData['password']);

	if (true !== $ispass) {
		emMsg('Введите текущий пароль');
	} elseif (!empty($login) && $User_Model->isUserExist($login, UID)) {
		emMsg('Пользователь уже существует');
	} elseif (strlen($newpass)>0 && strlen($newpass) < 6) {
		emMsg('Длина пароля должна быть не менее 6 символов');
	} elseif (!empty($newpass) && $newpass != $repeatpass) {
		emMsg('Пароль и его подтверждение не совпадают');
	}

	if (!empty($newpass) && empty($login))//只修改密码
	{
		$newpass = $PHPASS->HashPassword($newpass);
		$User_Model->updateUser(array('password'=>$newpass), UID);
		emMsg('Пароль успешно изменен','./');
	} elseif (!empty($newpass) && !empty($login))//修改密码及用户
	{
		$newpass = $PHPASS->HashPassword($newpass);
		$User_Model->updateUser(array('username'=>$login, 'password'=>$newpass), UID);
		emMsg('Учетная запись успешно изменена','./');
	} elseif (empty($newpass) && !empty($login))//只修改后台登录名
	{
		$User_Model->updateUser(array('username'=>$login), UID);
		emMsg('Данные учетной записи обновлены, выйдете из админпанели и зайдите снова','./');
	} else{
		emMsg('Пожалуйста, выберите пункт, который Вы хотите изменить');
	}
}