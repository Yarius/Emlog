<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class="containertitle2">
<a class="navi1" href="./configure.php">Основное</a>
<a class="navi2" href="./seo.php">ЧПУ</a>
<a class="navi4" href="./style.php">Стиль (ЦУ)</a>
<a class="navi4" href="./blogger.php">Профиль</a>
<?php if(isset($_GET['activated'])):?><span class="actived">Настройки успешно сохранены</span><?php endif;?>
<?php if(isset($_GET['error'])):?><span class="error">Сохранить не удалось: .htaccess недоступен для записи</span><?php endif;?>
</div>
<div style="margin-left:10px;">
<form action="seo.php?action=update" method="post">
<div style="font-size: 14px; margin: 10px 0px 10px 10px;"><b>Настройки ЧПУ</b></div>
<div class="des" style="margin-left:10px;">
    Здесь Вы можете настроить ЧПУ (человеко-понятные урлы), если Ваш веб-сервер не поддерживает функцию mod_rewrite и блог не отображается корректно, верните настройки по-умолчанию.
<br />Далее перечислены варианты отображения ЧПУ
</div>
<div style="margin:10px 8px;">
	<li><input type="radio" name="permalink" value="0" <?php echo $ex0; ?>>Формат по умолчанию: <span class="permalink_url"><?php echo BLOG_URL; ?>?post=1</span></li>
    <li><input type="radio" name="permalink" value="1" <?php echo $ex1; ?>>Формат файла: <span class="permalink_url"><?php echo BLOG_URL; ?>post-1.html</span></li>
    <li><input type="radio" name="permalink" value="2" <?php echo $ex2; ?>>В виде каталога: <span class="permalink_url"><?php echo BLOG_URL; ?>post/1</span></li>
	<li><input type="radio" name="permalink" value="3" <?php echo $ex3; ?>>Название категории: <span class="permalink_url"><?php echo BLOG_URL; ?>category/1.html</span></li>
    <div style="border-top:1px solid #F7F7F7; width:521px; margin:10px 0px 10px 0px;"></div>
	<li>Включить ЧПУ статьи: <input type="checkbox" style="vertical-align:middle;" value="y" name="isalias" id="isalias" <?php echo $isalias; ?> /></li>
	<li>Включить индекс HTML в конце: <input type="checkbox" style="vertical-align:middle;" value="y" name="isalias_html" id="isalias_html" <?php echo $isalias_html; ?> /></li>
</div>
<div style="border-top:1px solid #F7F7F7; width:521px; margin:10px 0px 10px 0px;"></div>
<div style="font-size: 14px; margin: 20px 0px 10px 10px;"><b>СЕО настройки: </b></div>
<div class="item_edit" style="margin-left:10px;">
    <li>Заголовок (title)<br /><input maxlength="200" style="width:300px;" value="<?php echo $site_title; ?>" name="site_title" /></li>
    <li>Ключевые слова (keywords)<br /><input maxlength="200" style="width:300px;" value="<?php echo $site_key; ?>" name="site_key" /></li>
    <li>Мета-описание (description)<br /><textarea name="site_description" cols="" rows="4" style="width:300px;"><?php echo $site_description; ?></textarea></li>
    <li>Режим отображения: 
        <select name="log_title_style">
		<option value="0" <?php echo $opt0; ?>>Заголовок статьи</option>
		<option value="1" <?php echo $opt1; ?>>Название статьи - Название сайта</option>
        <option value="2" <?php echo $opt2; ?>>Название статьи - название сайта браузере</option>
        </select>
    </li>
    <li style="margin-top:10px;"><input type="submit" value="Применить" class="button" /></li>
</div>
</form>
</div>
