<?php
/**
 * Мастер установки
 * @copyright (c) Emlog All Rights Reserved
 * Перевод: One-st.ru
 */

define('EMLOG_ROOT', dirname(__FILE__));
define('DEL_INSTALLER', 1);

require_once EMLOG_ROOT.'/include/lib/function.base.php';

header('Content-Type: text/html; charset=UTF-8');
doStripslashes();

$act = isset($_GET['action'])? $_GET['action'] : '';

if (PHP_VERSION < '5.0'){
    emMsg('emlog начиная с 3,5 больше не поддерживает текущий PHP'.PHP_VERSION.' обновитесь до PHP5 или скачайте emlog3.4.');
}

if(!$act){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Установка Emlog 5.1 - Support by One-st.ru</title>
<style type="text/css">
<!--
body {background-color:#F7F7F7;font-family: Arial;font-size: 12px;line-height:150%;}
.main {background-color:#FFFFFF;font-size: 12px;color: #666666;width:750px;margin:30px auto;padding:10px;list-style:none;border:#DFDFDF 1px solid; border-radius: 4px;}
.logo{background:url(admin/views/images/logo.gif) no-repeat center;padding:30px 0px 30px 0px;margin:30px 0px;}
.title{text-align:center; font-size: 14px;}
.input {border: 1px solid #CCCCCC;font-family: Arial;font-size: 18px;height:28px;background-color:#F7F7F7;color: #666666;margin:0px 0px 0px 25px;}
.submit{cursor: pointer;font-size: 12px;padding: 4px 10px;}
.care{color:#0066CC;}
.title2{font-size:18px;color:#666666;border-bottom: #CCCCCC 1px solid; margin:40px 0px 20px 0px;padding:10px 0px;}
.foot{text-align:center;}
.main li{ margin:20px 0px;}
-->
</style>
</head>
<body>
<form name="form1" method="post" action="install.php?action=install">
<div class="main">
<p class="logo"></p>
<p class="title"><span>Emlog <?php echo Option::EMLOG_VERSION ?></span> Мастер установки</p>
<div class="b">
<p class="title2">1. Данные для доступа к MySQL серверу</p>
<li>
	Сервер MySQL: <br />
    <input name="hostname" type="text" class="input" value="localhost">
	<span class="care">(По-умолчанию localhost)</span>
</li>
<li>
    Имя пользователя: <br /><input name="dbuser" type="text" class="input" value="">
</li>
<li>
     Пароль:<br /><input name="password" type="password" class="input">
</li>
<li>
    Имя базы данных: <br />
      <input name="dbname" type="text" class="input" value="">
	  <span class="care">(Cоздайте пустую базу данных заранее или используйте существующую)</span>
</li>
<li>
    Префикс: <br />
  <input name="dbprefix" type="text" class="input" value="emlog_">
  <span class="care">(Английские символы, должен заканчиваться символом подчеркивания)</span>
</li>
</div>
<div class="c">
<p class="title2">2. Учетная запись администратора</p>
<li>
Логин: <br />
<input name="admin" type="text" class="input">
</li>
<li>
Пароль: <br />
<input name="adminpw" type="password" class="input">
<span class="care">(не менее 6 символов)</span>
</li>
<li>
Повтор пароля: <br />
<input name="adminpw2" type="password" class="input">
</li>
</div>
<div>
<p class="foot">
<input type="submit" class="submit" value="Установить">
</p>
</div>
</div>
</form>
</body>
</html>
<?php
}
if($act == 'install' || $act == 'reinstall'){
	$db_host = isset($_POST['hostname']) ? addslashes(trim($_POST['hostname'])) : '';
	$db_user = isset($_POST['dbuser']) ? addslashes(trim($_POST['dbuser'])) : '';
	$db_pw = isset($_POST['password']) ? addslashes(trim($_POST['password'])) : '';
	$db_name = isset($_POST['dbname']) ? addslashes(trim($_POST['dbname'])) : '';
	$db_prefix = isset($_POST['dbprefix']) ? addslashes(trim($_POST['dbprefix'])) : '';
	$admin = isset($_POST['admin']) ? addslashes(trim($_POST['admin'])) : '';
	$adminpw = isset($_POST['adminpw']) ? addslashes(trim($_POST['adminpw'])) : '';
	$adminpw2 = isset($_POST['adminpw2']) ? addslashes(trim($_POST['adminpw2'])) : '';
	$result = '';

	if($db_prefix == ''){
		emMsg('Префикс не может быть пустым!');
	}elseif(!preg_match("/^[\w_]+_$/",$db_prefix)){
		emMsg('Не верный префикс базы данных!');
	}elseif($admin == '' || $adminpw == ''){
		emMsg('Логин и пароль администратора не могут быть пустыми!');
	}elseif(strlen($adminpw) < 6){
		emMsg('Логин и пароль администратора должны состоять не менее чем из 6 символов!');
	}elseif($adminpw!=$adminpw2)	 {
		emMsg('Пароль и его подтверждение не совпадают');
	}

	//初始化数据库类
	define('DB_HOST',   $db_host);
	define('DB_USER',   $db_user);
	define('DB_PASSWD', $db_pw);
	define('DB_NAME',   $db_name);
	define('DB_PREFIX', $db_prefix);

	$DB = MySql::getInstance();
	$CACHE = Cache::getInstance();

	if($act != 'reinstall' && $DB->num_rows($DB->query("SHOW TABLES LIKE '{$db_prefix}blog'")) == 1){
		echo <<<EOT
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>emlog system message</title>
<style type="text/css">
<!--
body {background-color:#F7F7F7;font-family: Arial;font-size: 12px;line-height:150%;}
.main {background-color:#FFFFFF;font-size: 12px;color: #666666;width:750px;margin:10px auto;padding:10px;list-style:none;border:#DFDFDF 1px solid;}
.main p {line-height: 18px;margin: 5px 20px;}
-->
</style>
</head><body>
<form name="form1" method="post" action="install.php?action=reinstall">
<div class="main">
	<input name="hostname" type="hidden" class="input" value="$db_host">
	<input name="dbuser" type="hidden" class="input" value="$db_user">
	<input name="password" type="hidden" class="input" value="$db_pw">
	<input name="dbname" type="hidden" class="input" value="$db_name">
	<input name="dbprefix" type="hidden" class="input" value="$db_prefix">
	<input name="admin" type="hidden" class="input" value="$admin">
	<input name="adminpw" type="hidden" class="input" value="$adminpw">
	<input name="adminpw2" type="hidden" class="input" value="$adminpw2">
<p>
Ваш emlog, кажется, установлен ранее. Если продолжить установку будут потеряны исходные данные журнала, вы действительно хотите продолжить?
<input type="submit" value="Продолжать&raquo;">
</p>
<p><a href="javascript:history.back(-1);">&laquo;Вернуться назад</a></p>
</div>
</form>
</body>
</html>
EOT;
		exit;
	}

	if(!is_writable('config.php')){
		emMsg('Файл конфигурации (config.php) не доступен для записи. Если вы используете Unix / Linux хостинг, измените права доступа к файлам на 777');
	}
	if(!is_writable(EMLOG_ROOT.'/content/cache')){
		emMsg('Кэш-файл не доступен для записи. Если вы используете Unix / Linux хоста, измените права доступа к файлам на 777 для всего каталога кэша (content/cache)');
	}
	$config = "<?php\n"
	."//mysql database address\n"
	."define('DB_HOST','$db_host');"
	."\n//mysql database user\n"
	."define('DB_USER','$db_user');"
	."\n//database password\n"
	."define('DB_PASSWD','$db_pw');"
	."\n//database name\n"
	."define('DB_NAME','$db_name');"
	."\n//database prefix\n"
	."define('DB_PREFIX','$db_prefix');"
	."\n//auth key\n"
	."define('AUTH_KEY','".getRandStr(32).md5($_SERVER['HTTP_USER_AGENT'])."');"
	."\n//cookie name\n"
	."define('AUTH_COOKIE_NAME','EM_AUTHCOOKIE_".getRandStr(32,false)."');"
	."\n";

	$fp = @fopen('config.php', 'w');
	$fw = @fwrite($fp, $config);
	if (!$fw){
		emMsg('Файл конфигурации (config.php) не доступен для записи. Если вы используете Unix / Linux хостинг, измените права доступа к файлам на 777');
	}
	fclose($fp);

	//Шифрование пароля
	$PHPASS = new PasswordHash(8, true);
	$adminpw = $PHPASS->HashPassword($adminpw);

	$dbcharset = 'utf8';
	$type = 'MYISAM';
	$add = $DB->getMysqlVersion() > '4.1' ? 'ENGINE='.$type.' DEFAULT CHARSET='.$dbcharset.';':'TYPE='.$type.';';
	$setchar = $DB->getMysqlVersion() > '4.1' ? "ALTER DATABASE `{$db_name}` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;" : '';
    
    $widgets = Option::getWidgetTitle();
    $sider_wg = Option::getDefWidget();

	$widget_title = serialize($widgets);
	$widgets = serialize($sider_wg);

	define('BLOG_URL', getBlogUrl());

	$sql = $setchar."
DROP TABLE IF EXISTS {$db_prefix}blog;
CREATE TABLE {$db_prefix}blog (
  gid mediumint(8) unsigned NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  date bigint(20) NOT NULL,
  content longtext NOT NULL,
  excerpt longtext NOT NULL,
  alias VARCHAR(200) NOT NULL DEFAULT '',
  author int(10) NOT NULL default '1',
  sortid tinyint(3) NOT NULL default '-1',
  type varchar(20) NOT NULL default 'blog',
  views mediumint(8) unsigned NOT NULL default '0',
  comnum mediumint(8) unsigned NOT NULL default '0',
  tbcount mediumint(8) unsigned NOT NULL default '0',
  attnum mediumint(8) unsigned NOT NULL default '0',
  top enum('n','y') NOT NULL default 'n',
  hide enum('n','y') NOT NULL default 'n',
  allow_remark enum('n','y') NOT NULL default 'y',
  allow_tb enum('n','y') NOT NULL default 'y',
  password varchar(255) NOT NULL default '',
  PRIMARY KEY  (gid),
  KEY date (date),
  KEY author (author),
  KEY sortid (sortid),
  KEY type (type),
  KEY views (views),
  KEY comnum (comnum),
  KEY hide (hide)
)".$add."
INSERT INTO {$db_prefix}blog (gid,title,date,content,excerpt,author,views,comnum,attnum,tbcount,top,hide, allow_remark,allow_tb,password) VALUES (1, 'Добро пожаловать в Emlog', '".time()."', 'Это Ваша первая статья, которую, конечно же, можно удалить. Пожалуйста, уважайте труд разработчиков и переводчиков, не удаляйте копирайты, ведь в копирайтах нет ничего такого. И спасибо, за то, что Вы выбрали Emlog. Успехов Вам и Вашему сайту.', '', 1, 0, 0, 0, 0, 'n', 'n', 'y', 'y', '');
DROP TABLE IF EXISTS {$db_prefix}attachment;
CREATE TABLE {$db_prefix}attachment (
  aid smallint(5) unsigned NOT NULL auto_increment,
  blogid mediumint(8) unsigned NOT NULL default '0',
  filename varchar(255) NOT NULL default '',
  filesize int(10) NOT NULL default '0',
  filepath varchar(255) NOT NULL default '',
  addtime bigint(20) NOT NULL default '0',
  width smallint(5) NOT NULL default '0',
  height smallint(5) NOT NULL default '0',
  mimetype varchar(40) NOT NULL default '',
  thumfor smallint(5) NOT NULL default 0,
  PRIMARY KEY  (aid),
  KEY blogid (blogid)
)".$add."
DROP TABLE IF EXISTS {$db_prefix}comment;
CREATE TABLE {$db_prefix}comment (
  cid mediumint(8) unsigned NOT NULL auto_increment,
  gid mediumint(8) unsigned NOT NULL default '0',
  pid mediumint(8) unsigned NOT NULL default '0',
  date bigint(20) NOT NULL,
  poster varchar(20) NOT NULL default '',
  comment text NOT NULL,
  mail varchar(60) NOT NULL default '',
  url varchar(75) NOT NULL default '',
  ip varchar(128) NOT NULL default '',
  hide enum('n','y') NOT NULL default 'n',
  PRIMARY KEY  (cid),
  KEY gid (gid),
  KEY date (date),
  KEY hide (hide)
)".$add."
DROP TABLE IF EXISTS {$db_prefix}options;
CREATE TABLE {$db_prefix}options (
option_id INT( 11 ) UNSIGNED NOT NULL auto_increment,
option_name VARCHAR( 255 ) NOT NULL ,
option_value LONGTEXT NOT NULL ,
PRIMARY KEY (option_id),
KEY option_name (option_name)
)".$add."
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('blogname','Мой блог');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('bloginfo','Здесь будет информация о блоге');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('site_title','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('site_description','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('site_key','emlog');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('log_title_style','0');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('blogurl','".BLOG_URL."');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('icp','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('footer_info','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('admin_perpage_num','15');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('rss_output_num','10');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('rss_output_fulltext','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_lognum','10');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_comnum','10');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_twnum','10');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_newtwnum','5');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_newlognum','5');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_randlognum','5');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('index_hotlognum','5');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_subnum','20');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('nonce_templet','default');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('admin_style','default');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('tpl_sidenum','1');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_code','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_needchinese','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_interval',15);
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isgravatar','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isthumbnail','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_paging','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_pnum','15');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('comment_order','newer');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('login_code','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('reply_code','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('iscomment','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('ischkcomment','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('ischkreply','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isurlrewrite','0');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isalias','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isalias_html','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isgzipenable','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('istrackback','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('isxmlrpcenable','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('ismobile','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('istwitter','y');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('istreply','n');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('topimg','content/templates/default/images/top/default.jpg');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('custom_topimgs','a:0:{}');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('timezone','8');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('active_plugins','a:1:{i:0;s:13:\"tips/tips.php\";}');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widget_title','$widget_title');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('custom_widget','a:0:{}');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widgets1','$widgets');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widgets2','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widgets3','');
INSERT INTO {$db_prefix}options (option_name, option_value) VALUES ('widgets4','');
DROP TABLE IF EXISTS {$db_prefix}link;
CREATE TABLE {$db_prefix}link (
  id smallint(4) unsigned NOT NULL auto_increment,
  sitename varchar(30) NOT NULL default '',
  siteurl varchar(75) NOT NULL default '',
  description varchar(255) NOT NULL default '',
  hide enum('n','y') NOT NULL default 'n',
  taxis smallint(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (id)
)".$add."
INSERT INTO {$db_prefix}link (id, sitename, siteurl, description, taxis) VALUES (1, 'emlog', 'http://one-st.ru/', 'Сайт поддержки русской локализации', 0);
DROP TABLE IF EXISTS {$db_prefix}navi;
CREATE TABLE {$db_prefix}navi (
  id smallint(4) unsigned NOT NULL auto_increment,
  naviname varchar(30) NOT NULL default '',
  url varchar(75) NOT NULL default '',
  newtab enum('n','y') NOT NULL default 'n',
  hide enum('n','y') NOT NULL default 'n',
  taxis smallint(4) unsigned NOT NULL default '0',
  isdefault enum('n','y') NOT NULL default 'n',
  type tinyint(3) unsigned NOT NULL default '0',
  type_id mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (id)
)".$add."
INSERT INTO {$db_prefix}navi (id, naviname, url, taxis, isdefault, type) VALUES (1, 'Главная', '', 1, 'y', 1);
INSERT INTO {$db_prefix}navi (id, naviname, url, taxis, isdefault, type) VALUES (2, 'Микроблог', 't', 2, 'y', 2);
INSERT INTO {$db_prefix}navi (id, naviname, url, taxis, isdefault, type) VALUES (3, 'Админпанель', 'admin', 3, 'y', 3);
DROP TABLE IF EXISTS {$db_prefix}tag;
CREATE TABLE {$db_prefix}tag (
  tid mediumint(8) unsigned NOT NULL auto_increment,
  tagname varchar(60) NOT NULL default '',
  gid text NOT NULL,
  PRIMARY KEY  (tid),
  KEY tagname (tagname)
)".$add."
DROP TABLE IF EXISTS {$db_prefix}sort;
CREATE TABLE {$db_prefix}sort (
  sid tinyint(3) unsigned NOT NULL auto_increment,
  sortname varchar(255) NOT NULL default '',
  alias VARCHAR(200) NOT NULL DEFAULT '',
  taxis smallint(4) unsigned NOT NULL default '0',
  pid tinyint(3) unsigned NOT NULL default '0',
  description text NOT NULL,
  PRIMARY KEY  (sid)
)".$add."
DROP TABLE IF EXISTS {$db_prefix}trackback;
CREATE TABLE {$db_prefix}trackback (
  tbid mediumint(8) unsigned NOT NULL auto_increment,
  gid mediumint(8) unsigned NOT NULL default '0',
  title varchar(255) NOT NULL default '',
  date bigint(20) NOT NULL,
  excerpt text NOT NULL,
  url varchar(255) NOT NULL default '',
  blog_name varchar(255) NOT NULL default '',
  ip varchar(16) NOT NULL default '',
  PRIMARY KEY  (tbid),
  KEY gid (gid)
)".$add."
DROP TABLE IF EXISTS {$db_prefix}twitter;
CREATE TABLE {$db_prefix}twitter (
id INT NOT NULL AUTO_INCREMENT,
content text NOT NULL,
img varchar(200) DEFAULT NULL,
author int(10) NOT NULL default '1',
date bigint(20) NOT NULL,
replynum mediumint(8) unsigned NOT NULL default '0',
PRIMARY KEY (id),
KEY author (author)
)".$add."
INSERT INTO {$db_prefix}twitter (id, content, img, author, date, replynum) VALUES (1, '使用微语记录您身边的新鲜事', '', 1, '".time()."', 0);
DROP TABLE IF EXISTS {$db_prefix}reply;
CREATE TABLE {$db_prefix}reply (
  id mediumint(8) unsigned NOT NULL auto_increment,
  tid mediumint(8) unsigned NOT NULL default '0',
  date bigint(20) NOT NULL,
  name varchar(20) NOT NULL default '',
  content text NOT NULL,
  hide enum('n','y') NOT NULL default 'n',
  ip varchar(128) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY gid (tid),
  KEY hide (hide)
)".$add."
DROP TABLE IF EXISTS {$db_prefix}user;
CREATE TABLE {$db_prefix}user (
  uid tinyint(3) unsigned NOT NULL auto_increment,
  username varchar(32) NOT NULL default '',
  password varchar(64) NOT NULL default '',
  nickname varchar(20) NOT NULL default '',
  role varchar(60) NOT NULL default '',
  photo varchar(255) NOT NULL default '',
  email varchar(60) NOT NULL default '',
  description varchar(255) NOT NULL default '',
PRIMARY KEY  (uid),
KEY username (username)
)".$add."
INSERT INTO {$db_prefix}user (uid, username, password, role) VALUES (1,'$admin','".$adminpw."','admin');";

	$array_sql = preg_split("/;[\r\n]/", $sql);
	foreach($array_sql as $sql){
		$sql = trim($sql);
		if ($sql){
			$DB->query($sql);
		}
	}
	//Перестраивание кеша
	$CACHE->updateCache();
	$result .= "
		<p style=\"font-size:24px; border-bottom:1px solid #E6E6E6; padding:10px 0px;\">Поздравляем, установка прошла успешно!</p>
		<p>Ваш Emlog установлен! Теперь Вы можете начинать творить.</p>
		<p><b>Пользователь</b>: {$admin}</p>
		<p><b>Пароль</b>: указанный ранее</p>";
	if (DEL_INSTALLER === 1 && !@unlink('./install.php') || DEL_INSTALLER === 0) {
	    $result .= '<p style="color:red;margin:10px 20px;">Не забудбте удалить файл install.php</p> ';
	}
	$result .= "<p style=\"text-align:right;\"><a href=\"./\">Главная</a> | <a href=\"./admin/\">Админпанель</a></p>";
	emMsg($result, 'none');
}
?>
