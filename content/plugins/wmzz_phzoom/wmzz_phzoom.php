<?php
/*
Plugin Name: Phzoom查看图片
Version: 1.0
Plugin URL: http://zhizhe8.net
Description: 使用Phzoom查看图片大图，非常精美
Author: 无名智者
Author Email: kenvix@vip.qq.com
Author URL: http://zhizhe8.net
*/
!defined('EMLOG_ROOT') && exit('access deined!');

function wmzz_phft(){
echo '<link rel="stylesheet" type="text/css" href="'.BLOG_URL.'content/plugins/wmzz_phzoom/js/colortip-1.0-jquery.css"/> ';
echo '<script type="text/javascript" src="'.BLOG_URL.'content/plugins/wmzz_phzoom/js/jquery-1.4.1.min.js"></script>';
echo '<script type="text/javascript" src="'.BLOG_URL.'content/plugins/wmzz_phzoom/js/phzoom.js"></script>';
echo '<link href="'.BLOG_URL.'content/plugins/wmzz_phzoom/js/phzoom.css" rel="stylesheet" type="text/css" />';
echo '<script type="text/javascript">jQuery(document).ready(function($){$("a[href$=jpg],a[href$=gif],a[href$=png],a[href$=jpeg],a[href$=bmp],a[phzoom$=yes]").phzoom({});}); </script>';
}
addAction('index_footer','wmzz_phft');
?>