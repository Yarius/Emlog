~function($){var $w=$(window),$d=$(document),$lay=$('<div id=ph_lay/>'),$zoom=$('<div id=ph_zoom/>'),$both=$lay.add($zoom),PHZOOM=function(e,x,y,z){this.opt=x;this.idx=y;this.all=z;this.len=z.length;this.end=this.len>y+1;this.img=$('img:first',e);this.lnk=e.addClass('phzoom').unbind('click').bind(this.imgFn()).append(this.hov=$('<span class=ph_hover/>').hide())[0];this.cap=$('<div/>',{css:{color:x.capColor},id:'ph_cap',html:$([$('<span/>',{id:'ph_txt',text:this.img[0].title||this.lnk.title||'No title'})[0],$('<span/>',{id:'ph_idx',text:y+1+' / '+this.len})[0]])}).add(this.nav=$('<div/>',{id:'ph_nav',css:{color:x.navColor},html:(y?'<span id=ph_prev>'+x.prevText+'</span>':'')+(this.end?'<span id=ph_next>'+x.nextText+'</span>':'')}));$both.click($.proxy(this,'imgQuit'));window.XMLHttpRequest||e.height(this.img.height())};PHZOOM.prototype={imgFn:function(){var that=this,s=function(){return that.hov.not('.loading').stop(0,1)};return{mouseover:function(){s().fadeIn()},mouseout:function(){s().fadeOut()},click:function(){that.imgLoad();return false}}},imgPos:function(oriW,oriH){var A=this.img,L=$w.scrollLeft(),T=$w.scrollTop(),pos=[oriW,oriH,A.width(),A.height(),A.offset().left,A.offset().top,$w.width(),$w.height()];this.opt.limitWidth&&pos[0]>pos[6]&&(pos[1]=pos[6]*pos[1]/pos[0],pos[0]=pos[6]);return pos.concat((pos[6]-pos[0])/2+L,(pos[7]-pos[1])/2+T,(pos[6]-pos[2])/2+L,(pos[7]-pos[3])/2+T)},imgLoad:function(){$lay.fadeTo(this.opt.layDur,this.opt.layOpacity);var that=this,B=new Image;this.hov.addClass('loading');B.className='zoomed';B.onload=function(){B.onload=null;that.hov.hasClass('loading')&&($zoom.height($d.height()).append(B).show(),that.imgAnim(B),that.preLoad())};B.src=this.lnk.href},imgAnim:function(B){var that=this,$B=$(B),pos=this.imgPos(B.width||+$B.attr('width'),B.height||+$B.attr('height')),oFlow=pos[6]<pos[0],E=this.evtMon(pos[6],pos[6]-pos[0],!oFlow,$B);$B.after(this.cap.hide()).css({left:pos[4],top:pos[5],width:pos[2],height:pos[3]}).animate({left:pos[10],top:pos[11]},this.opt.animDurA,function(){$B.animate({left:pos[8],top:pos[9],width:pos[0],height:pos[1]},that.opt.animDurB,function(){that.hov.removeClass('loading');that.cap.css({top:pos[1]+pos[9],left:oFlow?0:pos[8],width:oFlow?pos[6]:pos[0]}).fadeTo(300,.7);that.nav.bind(E).css('top',pos[1]/3+pos[9]);that.keyBind()}).bind(E)})},imgQuit:function(isQuit){this.hov.hide().hasClass('loading')?this.hov.removeClass('loading'):$d.unbind('.phzoom');$zoom.hide().empty();isQuit&&$lay.fadeOut();return false},imgChange:function(num){this.imgQuit();$('.ph_hover',$(this.all[this.idx+num]).click()).show();return false},preLoad:function(x,y){this.idx&&(x=new Image,x.src=this.all[this.idx-1].href,delete x);this.end&&(y=new Image,y.src=this.all[this.idx+1].href,delete y)},keyBind:function(){var that=this;$d.bind('keydown.phzoom',function(e){e=e.which;return e==27?that.imgQuit(1):e==39&&that.end?that.imgChange(1):e^37||!that.idx||that.imgChange(-1)})},evtMon:function(a,b,c,$B){var that=this,nav=$('span',this.nav).hide();return{click:function(e){e=e.pageX>a/2;return that.len<2||(that.idx?that.end?that.imgChange(e||-1):e||that.imgChange(-1):!e||that.imgChange(1))},mouseout:function(){nav.hide()},mousemove:function(e,i){e=e.pageX,i=e>a/2;that.idx?(nav.eq(i).show(),nav.eq(1-i).hide()):nav[i?'show':'hide']();c||(e=e<a/3?0:e>a*2/3?b:b/2)==$B.position().left||$B.not(':animated').animate({left:e},200)}}}};$.phzoom=function(Z,x,z){x=$.extend({layOpacity:.7,layDur:300,animDurA:300,animDurB:300,navColor:'#cf0',capColor:'#cf0',prevText:'Prev',nextText:'Next',limitWidth:false,returnOrigin:true},x),(z=Z.has('img'))[0]&&($('#ph_lay')[0]||$('body').append($both),z.each(function(y,t){$.data(t,'phzoom',new PHZOOM($(t),x,y,z))}));return x.returnOrigin?Z:z};$.fn.phzoom=function(x){return $.phzoom(this,x)}}(jQuery);