function getChecked(node) {
	var re = false;
	$('input.'+node).each(function(i){
		if (this.checked) {
			re = true;
		}
	});
	return re;
}
function timestamp(){
	return new Date().getTime();
}
function em_confirm (id, property) {
	switch (property){
		case 'tw':
			var urlreturn="twitter.php?action=del&id="+id;
			var msg = "Вы уверены?";break;
		case 'comment':
			var urlreturn="comment.php?action=del&id="+id;
			var msg = "Вы уверены, что хотите удалить этот комментарий?";break;
		case 'link':
			var urlreturn="link.php?action=dellink&linkid="+id;
			var msg = "Вы уверены, что хотите удалить ссылку?";break;
		case 'navi':
			var urlreturn="navbar.php?action=del&id="+id;
			var msg = "Вы уверены, что хотите удалить пункт меню навигации?";break;
		case 'backup':
			var urlreturn="data.php?action=renewdata&sqlfile="+id;
			var msg = "Вы уверены, что хотите импортировать файл резервной копии?";break;
		case 'attachment':
			var urlreturn="attachment.php?action=del_attach&aid="+id;
			var msg = "Вы уверены, что хотите удалить вложение?";break;
		case 'avatar':
			var urlreturn="blogger.php?action=delicon";
			var msg = "Вы уверены, что хотите удалить аватар?";break;
		case 'sort':
			var urlreturn="sort.php?action=del&sid="+id;
			var msg = "Вы уверены, что хотите удалить категорию?";break;
		case 'page':
			var urlreturn="page.php?action=del&gid="+id;
			var msg = "Вы уверены, что хотите удалить страницу?";break;
		case 'user':
			var urlreturn="user.php?action=del&uid="+id;
			var msg = "Вы уверены, что хотите удалить пользователя?";break;
		case 'tpl':
			var urlreturn="template.php?action=del&tpl="+id;
			var msg = "Вы уверены, что хотите удалить этот шаблон?";break;
		case 'reset_widget':
			var urlreturn="widgets.php?action=reset";
			var msg = "Вы действительно хотите восстановить компонент в начальное состояние? Это приведет к потере пользовательских компонентов!";break;
		case 'plu':
			var urlreturn="plugin.php?action=del&plugin="+id;
			var msg = "Вы действительно хотите удалить этот плагин?";break;
	}
	if(confirm(msg)){window.location = urlreturn;}else {return;}
}
function focusEle(id){try{document.getElementById(id).focus();}catch(e){}}
function hideActived(){
	$(".actived").hide();
	//$(".error").hide();
}
function displayToggle(id, keep){
	$("#"+id).toggle();
	if (keep == 1){$.cookie('em_'+id,$("#"+id).css('display'),{expires:365});}
	if (keep == 2){$.cookie('em_'+id,$("#"+id).css('display'));}
}
function isalias(a){
	var reg1=/^[\u4e00-\u9fa5\w-]*$/;
	var reg2=/^[\d]+$/;
	var reg3=/^post(-\d+)?$/;
	if(!reg1.test(a)) {
		return 1;
	}else if(reg2.test(a)){
		return 2;
	}else if(reg3.test(a)){
		return 3;
	}else if(a=='t' || a=='m' || a=='admin'){
		return 4;
	} else {
		return 0;
	}
}
function checkform(){
	var a = $.trim($("#alias").val());
	var t = $.trim($("#title").val());
	if (t==""){
		alert("Название не может быть пустым");
		$("#title").focus();
		return false;
	}else if(0 == isalias(a)){
		return true;
	}else {
		alert("Ошибка ЧПУ");
		$("#alias").focus();
		return false
	};
}
function checkalias(){
	var a = $.trim($("#alias").val());
	if (1 == isalias(a)){
		$("#alias_msg_hook").html('<span id="input_error">Ошибка, используте только буквы, цифры, подчеркивания и тире</span>');
	}else if (2 == isalias(a)){
		$("#alias_msg_hook").html('<span id="input_error">Альтернативное имя не может состоять только из цифр</span>');
	}else if (3 == isalias(a)){
		$("#alias_msg_hook").html('<span id="input_error">Альтернативное имя не может быть \'post\' или \'post-цифры\'</span>');
	}else if (4 == isalias(a)){
		$("#alias_msg_hook").html('<span id="input_error">Альтернативное имя конфликтует с системой ссылок</span>');
	}else {
		$("#alias_msg_hook").html('');
		$("#msg").html('');
	}
}
function addattach_img(fileurl,imgsrc,aid, width, height, alt){
	if (editorMap['content'].designMode === false){
		alert('Пожалуйста, переключиться в режим WYSIWYG');
	}else if (imgsrc != "") {
		editorMap['content'].insertHtml('<a target=\"_blank\" href=\"'+fileurl+'\" id=\"ematt:'+aid+'\"><img src=\"'+imgsrc+'\" title="点击查看原图" alt=\"'+alt+'\" border=\"0\" width="'+width+'" height="'+height+'"/></a>');
	}
}
function addattach_file(fileurl,filename,aid){
	if (editorMap['content'].designMode === false){
		alert('Пожалуйста, переключиться в режим WYSIWYG');
	} else {
		editorMap['content'].insertHtml('<span class=\"attachment\"><a target=\"_blank\" href=\"'+fileurl+'\" >'+filename+'</a></span>');
	}
}
function insertTag (tag, boxId){
	var targetinput = $("#"+boxId).val();
	if(targetinput == ''){
		targetinput += tag;
	}else{
		var n = ',' + tag;
		targetinput += n;
	}
	$("#"+boxId).val(targetinput);
	if (boxId == "tag")
		$("#tag_label").hide();
}
//act:0 auto save,1 click attupload,2 click savedf button, 3 save page, 4 click page attupload
function autosave(act){
	var nodeid = "as_logid";
	if (act == 3 || act == 4){
		editorMap['content'].sync();
		var url = "page.php?action=autosave";
		var title = $.trim($("#title").val());
		var alias = $.trim($("#alias").val());
		var logid = $("#as_logid").val();
		var content = $('#content').val();
		var pageurl = $.trim($("#url").val());
		var allow_remark = $("#page_options #allow_remark").attr("checked") == 'checked' ? 'y' : 'n';
		var is_blank = $("#page_options #is_blank").attr("checked") == 'checked' ? 'y' : 'n';
		var ishide = $.trim($("#ishide").val());
		var ishide = ishide == "" ? "y" : ishide;
		var querystr = "content="+encodeURIComponent(content)
					+"&title="+encodeURIComponent(title)
					+"&alias="+encodeURIComponent(alias)
					+"&allow_remark="+allow_remark
					+"&is_blank="+is_blank
					+"&url="+pageurl
					+"&ishide="+ishide
					+"&as_logid="+logid;
	}else{
	    editorMap['content'].sync();
	    editorMap['excerpt'].sync();
		var url = "save_log.php?action=autosave";
		var title = $.trim($("#title").val());
		var alias = $.trim($("#alias").val());
		var sort = $.trim($("#sort").val());
		var postdate = $.trim($("#postdate").val());
		var date = $.trim($("#date").val());
		var logid = $("#as_logid").val();
		var author = $("#author").val();
		var content = $('#content').val();
		var excerpt = $('#excerpt').val();
		var tag = $.trim($("#tag").val());
		var top = $("#post_options #top").attr("checked") == 'checked' ? 'y' : 'n';
		var allow_remark = $("#post_options #allow_remark").attr("checked") == 'checked' ? 'y' : 'n';
		var allow_tb = $("#post_options #allow_tb").attr("checked") == 'checked' ? 'y' : 'n';
		var password = $.trim($("#password").val());
		var ishide = $.trim($("#ishide").val());
		var ishide = ishide == "" ? "y" : ishide;
		var querystr = "content="+encodeURIComponent(content)
					+"&excerpt="+encodeURIComponent(excerpt)
					+"&title="+encodeURIComponent(title)
					+"&alias="+encodeURIComponent(alias)
					+"&author="+author
					+"&sort="+sort
					+"&postdate="+postdate
					+"&date="+date
					+"&tag="+encodeURIComponent(tag)
					+"&top="+top
					+"&allow_remark="+allow_remark
					+"&allow_tb="+allow_tb
					+"&password="+password
					+"&ishide="+ishide
					+"&as_logid="+logid;
	}
	//check alias
	if(alias != '') {
		if (0 != isalias(alias)){
			$("#msg").html("<span class=\"msg_autosave_error\">Сбой при автоматическом сохранение альтернативного имени ссылки</span>");
			if(act == 0){setTimeout("autosave(0)",60000);}
			return;
		}
	}
	if(act == 0){
		if(ishide == 'n'){return;}
		if (content == ""){
			setTimeout("autosave(0)",60000);
			return;
		}
	}
	if(act == 1 || act == 4){
		var gid = $("#"+nodeid).val();
		if (gid != -1){return;}
	}
	$("#msg").html("<span class=\"msg_autosave_do\">Сохранение...</span>");
	var btname = $("#savedf").val();
	$("#savedf").val("Сохранение");
	$("#savedf").attr("disabled", "disabled");
	$.post(url, querystr, function(data){
		data = $.trim(data);
		var isrespone=/autosave\_gid\:\d+\_df\:\d*\_/;
		if(isrespone.test(data)){
			var getvar = data.match(/\_gid\:([\d]+)\_df\:([\d]*)\_/);
			var logid = getvar[1];
			if (act != 3){
				var dfnum = getvar[2];
				if(dfnum > 0){$("#dfnum").html("("+dfnum+")")};
			}
    		$("#"+nodeid).val(logid);
    		var digital = new Date();
    		var hours = digital.getHours();
    		var mins = digital.getMinutes();
    		var secs = digital.getSeconds();
    		$("#msg_2").html("<span class=\"ajax_remind_1\">Успешно сохранено в "+hours+":"+mins+":"+secs+" </span>");
    		$("#savedf").attr("disabled", false);
    		$("#savedf").val(btname);
    		$("#msg").html("");
		}else{
		    $("#savedf").attr("disabled", false);
		    $("#savedf").val(btname);
		    $("#msg").html("<span class=\"msg_autosave_error\">Сбой сети, система могла не сохранить...</span>");
	    }
	});
	if(act == 0){
		setTimeout("autosave(0)",60000);
	}
}
