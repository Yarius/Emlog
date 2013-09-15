<?php 
/*
* Подвал
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
</div><!--end #content-->
<div style="clear:both;"></div>
<div id="footerbar">
	Powered by <a href="http://www.emlog.net" title="emlog <?php echo Option::EMLOG_VERSION;?>">emlog</a> <br>
	Русский перевод и поддержка <a href="http://www.one-st.ru" title="">One-st.ru</a> <?php echo $footer_info; ?>
	<?php doAction('index_footer'); ?>
</div><!--end #footerbar-->
</div><!--end #wrap-->
<script>prettyPrint();</script>
</body>
</html>