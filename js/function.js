//загрузка с сервера [boolean, string, string, object]
function myajax(async, type, url, data){ 
	
	var jsonObj;
	opBl();
	$.ajax({
		async: async,
		type: type,
		url:url,
		data: data,
		success: function(responseTxt){
			var clrResp = clearUTF8(responseTxt);

			try {
			
				jsonObj = JSON.parse(clrResp);
				
			} catch(e){
				showTooltip(errMessages[0], 2000);
			}
		},
		error: function(){
			showTooltip(errMessages[1], 2000);	
		},
		complete: function(){
			clBl();
		}
	});
	
	return jsonObj;
		
}

// проверка на авторизацию
function isAuth(){
	if(localStorage.auth_inf != undefined || sessionStorage.auth_inf != undefined){
		return true;
	} 
	return false;
}

function isGuest(){
	if(localStorage.guest_inf != undefined || sessionStorage.guest_inf != undefined){
		return true;
	} 
	return false;
}

//скрыть предзагрузочный экран
function hideLoader(){
	$('.pre_loader').fadeOut(200);
}

// показать Tooltip
function showTooltip(toolText, duration){
	
	var dur = duration!=undefined ? duration: 1000;
	
	$tooltip = $('.tooltip');
	$tooltip.fadeIn(200).html(toolText);
	
	setTimeout(function(){
		$tooltip.fadeOut(200);
	}, dur);
	
}

// открытие/закрытие фона заглушки
function opBl(){ 
	$('.overlay').css('display', 'block');
}

function clBl(){
	$('.overlay').css('display', 'none');
}

function opMenBl(){ 
	$('.menuoverlay').css('display', 'block');
}

function clMenBl(){
	$('.menuoverlay').css('display', 'none');
}

// сохранение JSON в localStorage/sessionStorage
function setJSON(key, value, flag) {
	try {   
	        if(flag == true){
				localStorage[key] = JSON.stringify(value);				
			} else {
				sessionStorage[key] = JSON.stringify(value);
			}
			
		} catch(ex){
					
		}
}

// получение JSON из localStorage/sessionStorage
function getJSON(key, flag) {
	
	var value;
	
	if(flag == true){
		value = localStorage[key];				
	} else {
		value = sessionStorage[key];
	}
	
	return value ? JSON.parse(value) : null;
}

// удаление BOM символов из строки
function clearUTF8(str) {
	
	var clrStr = '';
	var i = 0;
	
	while(str[i] != '{' && str[i] != '['){
		i++;
	} 
	
	clrStr = str.substr(i, str.length);
	return clrStr;
}

function newsWrap(obj){
	
	$newsblock = $('.news_box');
	$newsblock.html('');
	for(var i = 0; i < obj.length; i++){
		var imglink = 'news/pre_images/img_' + obj[i].id + '.jpg';
		$newsblock.append('<div class="news_box_item contr_shadow" idnews="' + obj[i].id + '">\
						  <div class="news_box_item_image" style="background-image:url(' + imglink + ');">\
						  </div>\
						  <div class="news_box_item_text">\
						  <div class="news_box_item_title">\
						  ' + obj[i].name_news + '\
						  </div>\
						  '	+ obj[i].descr + 
						  '</div>\
						  <div style="clear:both"></div>\
						  </div>');
		} 
	
}

function closeSidebar(){
	$('.menuoverlay').stop().fadeTo(250, 0);
		$menuBlock = $('.sidebar_menu_block');
		$menuBlock.removeClass('contr_shadow')
									.animate({
										'margin-left': '-' + $menuBlock.css('width')
									}, 250, function(){
										$('.menuoverlay').css('display','none');
									});	
}

function openSidebar(){
	$('.menuoverlay').stop().fadeTo(250, 0.6);	
			$('.sidebar_menu_block').addClass('contr_shadow')
									.animate({
										'margin-left': "0px"
									}, 250);	
}