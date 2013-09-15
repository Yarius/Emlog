<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class="containertitle2">
<a class="navi3" href="./configure.php">Основное</a>
<a class="navi4" href="./seo.php">ЧПУ</a>
<a class="navi4" href="./style.php">Стиль (ЦУ)</a>
<a class="navi4" href="./blogger.php">Профиль</a>
<?php if(isset($_GET['activated'])):?><span class="actived">Настройки успешно сохранены</span><?php endif;?>
</div>
<form action="configure.php?action=mod_config" method="post" name="input" id="input">
  <table cellspacing="8" cellpadding="4" width="95%" align="center" border="0">
      <tr>
        <td width="18%" align="right">Название блога: </td>
        <td width="82%"><input maxlength="200" style="width:180px;" value="<?php echo $blogname; ?>" name="blogname" /></td>
      </tr>
      <tr>
        <td align="right" valign="top">Описание блога(описание на сайте): </td>
        <td><textarea name="bloginfo" cols="" rows="2" style="width:300px;"><?php echo $bloginfo; ?></textarea></td>
      </tr>
      <tr>
        <td align="right">Адрес блога: </td>
        <td><input maxlength="200" style="width:300px;" value="<?php echo $blogurl; ?>" name="blogurl" /></td>
      </tr>
      <tr>
        <td align="right">Кол-во статей на страницу:</td>
        <td><input maxlength="5" size="4" value="<?php echo $index_lognum; ?>" name="index_lognum" /> </td>
      </tr>
	  <tr>
        <td valign="top" align="right">Часовой пояс:<br /></td>
        <td>
		<select name="timezone">
<?php
		$tzlist = array('-12'=>'UTC−12 — Линия перемены даты',
							'-11'=>'UTC−11 — Самоа (X-ray)',
							'-10'=>'UTC−10 — Гавайи',
							'-9'=>'UTC−9 — Аляска',
							'-8'=>'UTC−8 — Североамериканское тихоокеанское время (США и Канада)',
							'-7'=>'UTC−7 — Горное время (США и Канада), Мексика (Чиуауа, Ла-Пас, Масатлан)',
							'-6'=>'UTC−6 — Центральное время (США и Канада), Центральноамериканское время, Мексика',
							'-5'=>'UTC−5 — Североамериканское восточное время (США и Канада), Южноамериканское тихоокеанское время',
							'-4'=>'UTC−4 — Атлантическое время (Канада), Ла-Пас, Сантьяго)',
							'-3.5'=>'UTC−3:30 — Ньюфаундленд',
							'-3'=>'UTC−3 — Южноамериканское восточное время (Бразилиа, Буэнос-Айрес, Джорджтаун), Гренландия',
							'-2'=>'UTC−2 — Среднеатлантическое время',
							'-1'=>'UTC−1 — Азорские острова, Кабо-Верде',
							'0'=>'UTC+0 — Западноевропейское время (Дублин, Эдинбург, Лиссабон, Лондон, Касабланка, Монровия)',
							'1'=>'UTC+1 — Центральноевропейское время (Амстердам, Берлин, Берн, Брюссель, Вена)',
							'2'=>'UTC+2 — Восточноевропейское время',
							'3'=>'UTC+3 — Калининградское время',
							'3.5'=>'UTC+3:30 — Тегеранское время',
							'4'=>'UTC+4 — Московское время',
							'4.5'=>'UTC+4:30 — Афганистан',
							'5'=>'UTC+5 — Западный Казахстан, Пакистан, Таджикистан, Туркменистан, Узбекистан (Echo)',
							'5.5'=>'UTC+5:30 — Индия, Шри-Ланка',
							'6'=>'UTC+6 — Екатеринбургское время, центральная и восточная части Казахстана, Киргизия)',
							'7'=>'UTC+7 — Омское время, Новосибирск, Кемерово, Юго-Восточная Азия (Бангкок, Джакарта, Ханой) ',
							'8'=>'UTC+8 — Красноярское время, Улан-Батор, Гонконг, Китай, западноавстралийское время',
							'9'=>'UTC+9 — Иркутское время, Корея, Япония',
							'9.5'=>'UTC+9:30 — Центральноавстралийское время (Аделаида, Дарвин)',
							'10'=>'UTC+10 — Якутское время, Восточноавстралийское время ',
							'11'=>'UTC+11 — Владивостокское время, Центрально-тихоокеанское время',
							'12'=>'UTC+12 — Магаданское время, Маршалловы Острова, Фиджи, Новая Зеландия',
		);
foreach($tzlist as $key=>$value):
$ex = $key==$timezone?"selected=\"selected\"":'';
?>
		<option value="<?php echo $key; ?>" <?php echo $ex; ?>><?php echo $value; ?></option>
<?php endforeach;?>
        </select>
        (Местное время:<?php echo gmdate('Y-m-d H:i:s', time() + $timezone * 3600); ?>)
        </td>
      </tr>
      <tr>
        <td align="right" width="18%" valign="top">Защитный код: <br /></td>
        <td width="82%">
        <input type="checkbox" style="vertical-align:middle;" value="y" name="login_code" id="login_code" <?php echo $conf_login_code; ?> />Авторизация<br />
        <input type="checkbox" style="vertical-align:middle;" value="y" name="isthumbnail" id="isthumbnail" <?php echo $conf_isthumbnail; ?> />Вложения<br />
        <input type="checkbox" style="vertical-align:middle;" value="y" name="isgzipenable" id="isgzipenable" <?php echo $conf_isgzipenable; ?> />Сжатие Gzip<br />
        <input type="checkbox" style="vertical-align:middle;" value="y" name="isxmlrpcenable" id="isxmlrpcenable" <?php echo $conf_isxmlrpcenable; ?> />XML-RPC<br />
      	<input type="checkbox" style="vertical-align:middle;" value="y" name="istrackback" id="istrackback" <?php echo $conf_istrackback; ?> />Трекбеки<br />
      	<input type="checkbox" style="vertical-align:middle;" value="y" name="ismobile" id="ismobile" <?php echo $conf_ismobile; ?> />Адрес мобильной версии: <span id="m"><a title="Просмотр сайта с помощью мобильных устройств"><?php echo BLOG_URL.'m'; ?></a></span>
      	</td>
      <tr>
  </table>
  <div class="setting_line"></div>
  <table cellspacing="8" cellpadding="4" width="95%" align="center" border="0">
      <tr>
        <td align="right" width="18%" valign="top">Микроблог: <br /></td>
        <td width="82%">
			<input type="checkbox" style="vertical-align:middle;" value="y" name="istwitter" id="istwitter" <?php echo $conf_istwitter; ?> />Кол-во комментариев
		на страницу: <input type="text" name="index_twnum" maxlength="3" value="<?php echo Option::get('index_twnum'); ?>" style="width:25px;" /><br />
		<input type="checkbox" style="vertical-align:middle;" value="y" name="istreply" id="istreply" <?php echo $conf_istreply; ?> />Включить комментарии
		<input type="checkbox" style="vertical-align:middle;" value="y" name="reply_code" id="reply_code" <?php echo $conf_reply_code; ?> />Защитный код
		<input type="checkbox" style="vertical-align:middle;" value="y" name="ischkreply" id="ischkreply" <?php echo $conf_ischkreply; ?> />Премодерация<br />
		</td>
      </tr>
  </table>
  <div class="setting_line"></div>
  <table cellspacing="8" cellpadding="4" width="95%" align="center" border="0">
      <tr>
        <td align="right" width="18%">Кол-во экспортируемых статей в RSS:<br /></td>
        <td width="82%">
		<input maxlength="5" size="4" value="<?php echo $rss_output_num; ?>" name="rss_output_num" /> <select name="rss_output_fulltext">
		<option value="y" <?php echo $ex1; ?>>Полный текст</option>
		<option value="n" <?php echo $ex2; ?>>Вступление</option>
        </select>
		</td>
      </tr>
  </table>
  <div class="setting_line"></div>
  <table cellspacing="8" cellpadding="4" width="95%" align="center" border="0">
      <tr>
        <td align="right" width="18%" valign="top">Комментарии: <br /></td>
        <td width="82%">
        <input type="checkbox" style="vertical-align:middle;" value="y" name="iscomment" id="iscomment" <?php echo $conf_iscomment; ?> />Включить комментарии<br />
		<input type="checkbox" style="vertical-align:middle;" value="y" name="ischkcomment" id="ischkcomment" <?php echo $conf_ischkcomment; ?> />Премодерация<br />
		<input type="checkbox" style="vertical-align:middle;" value="y" name="comment_code" id="comment_code" <?php echo $conf_comment_code; ?> />Проверочный код<br />
		<input type="checkbox" style="vertical-align:middle;" value="y" name="isgravatar" id="isgravatar" <?php echo $conf_isgravatar; ?> />Gravatar (использование сервиса для комментаторов)<br />
		<input type="checkbox" style="vertical-align:middle;" value="y" name="comment_paging" id="comment_paging" <?php echo $conf_comment_paging; ?> />Страницы<br />
		Кол-во комментариев на страницу: <input maxlength="5" size="4" value="<?php echo $comment_pnum; ?>" name="comment_pnum" /><br />
		Порядок сортировки комментариев<select name="comment_order"><option value="newer" <?php echo $ex3; ?>>По убыванию</option><option value="older" <?php echo $ex4; ?>>По возрастанию</option></select><br />
		Интервал между комментариями: <input maxlength="5" size="2" value="<?php echo $comment_interval; ?>" name=comment_interval />секунд<br />
		</td>
      </tr>
  </table>
  <div class="setting_line"></div>
  <table cellspacing="8" cellpadding="4" width="95%" align="center" border="0">
      <tr>
        <td align="right">ICP(только для Китая): </td>
        <td><input maxlength="200" style="width:180px;" value="<?php echo $icp; ?>" name="icp" /></td>
      </tr>
      <tr>
        <td align="right" width="18%" valign="top">Надпись в нижней части блога: <br /></td>
        <td width="82%">
		<textarea name="footer_info" cols="" rows="6" style="width:300px;"><?php echo $footer_info; ?></textarea><br />
	   (Поддержка HTML, может быть использовано для добавления кода, счетчиков)
		</td>
      </tr>
  </table>
  <div class="setting_line"></div>
  <table cellspacing="8" cellpadding="4" width="95%" align="center" border="0">
      <tr>
        <td align="center" colspan="2"><input type="submit" value="Применить" class="button" /></td>
      </tr>
  </table>
</form>