var stringNames = [
	"Авторизация",
	"Главное меню",
	"Настройки",
	"Новости",
	"Персональная информация",
	"Расписание",
	"Сообщения"
]

var messages = [
	"Вы точно хотите уйти из приложения?"
]

var errMessages = [
	"Ошибка получения данных, проверьте интернет соединение.",
	"Ошибка подключения к серверу. Проверьте наличие интернет соединения."
]

var toolBar = {
	
	$button:$('.header_line__content_button'),
	$title:$('.header_line__content_title'),
	$second_menu:$('.header_line_addition_wrapper'),
	
	setTitle : function(nameTitle){
		this.$title.html(nameTitle);	
	},
			
	displayArrIcon : function(){
		this.$button.removeClass('menu_button');
		this.$button.addClass('arr_button');
	},
	
	displayMenuIcon : function(){
		this.$button.removeClass('arr_button');
		this.$button.addClass('menu_button');
	},
	
	displaySecMenu: function(){
		this.$second_menu.fadeIn();		
	},
	
	hideSecMenu: function(){
		this.$second_menu.fadeOut();		
	},
}

var contentZone = {
	
	$auth:$('.authorisation_box'),
	$menu:$('.main_menu'),
	$news:$('.news_box'),
	$settings:$('.header_line_content_settings'),
	
	showAuth:function(dur){
		this.$auth.fadeIn(dur);
		location.hash = '#auth';
	},
	
	hideAuth:function(dur){
		this.$auth.fadeOut(dur);
	},
	
	showMenu:function(dur){
		this.$menu.fadeIn(dur);
		this.$settings.fadeIn();
		location.hash = '#menu';
	},
	
	hideMenu:function(dur){
		this.$menu.fadeOut(dur);
	},
	
	showNews:function(dur){
		this.$news.fadeIn(dur);
	},
	
	hideNews:function(dur){
		this.$news.fadeOut(dur);
	}
	
}

$(window).load(function(){
	
	hideLoader();
	/* $('.content_box').masonry({
		itemSelector: '.content_box_menuitem',
	}); */

});

$(document).ready(function(){
	
	if(location.hash != ''){
		
		switch(location.hash){
			
			case '#menu':
				loadMenuPage();
			break;
			
			case '#person':
			break;
			
			case '#auth':
				loadAuthPage();
			break;
			
			case '#news':
				loadNewsPage();
			break;
			
			case '#messages':
			break;
			
			default:
			    location.hash = '';
				loadMenuPage();
			break;
			
		}
		
	} else {
		loadMenuPage();
	}
	
	$('.authorisation_box_form').on( "submit", function( event ){
		
		event.preventDefault();
				
		if(validateForm()){
			
			authObj = (tryAutorisate($(this).serialize()));
			
			if (authObj.FIO != "undefined"){
				setJSON("auth_inf", authObj, $('.save_password').prop('checked'));
				contentZone.hideAuth(0);
				loadMenuPage();	
			}
			
			showTooltip(authObj.serverRequest, 2000);
		}  
		
		
		
	})
	
	$('.header_line_addition_menu_item').click(function(){
		$('.header_line_addition_menu_item').each(function(){
			$(this).removeClass('current_item');
		});
		$(this).addClass('current_item');
	}); 
	
	
})

function validateForm(){
	
	var login = $('.logininp').val();
	var pass = $('.passinp').val();
		
		if(login == ''){
			clearTagInput('pass');
			tagInput('login');
			return false;
		} else if(pass == ''){
			clearTagInput('login');
			tagInput('pass');
		    return false;
		}
	
	return true;
}

function tagInput(className){
	alert('Input ' + className + 'was tagged');
}

function clearUTF8(str) {
	var clrStr = '';
	if (str[0] != '{'){
		clrStr = str.substr(3, str.length);
	}
    return clrStr;
}

function tryAutorisate(userData){
    
	var jsonObj;
	
	opBl();
	$.ajax({
		async: false,
		type: 'POST',
		url: 'mobile_reciever.php',
		data: userData,
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
	})
	
	return jsonObj;
}

function showTooltip(toolText, duration){
	
	$tooltip = $('.tooltip');
	$tooltip.fadeIn(200);
	$tooltip.html(toolText);
	setTimeout(function(){
		$tooltip.fadeOut(200);
	}, duration);
	
}

function opBl(){
	$('.overlay').css('display', 'block');
}

function clBl(){
	$('.overlay').css('display', 'none');
}

function hideLoader(){
	$('.pre_loader').fadeOut(200);
}

function isAuth(){
	if(localStorage.auth_inf != undefined || sessionStorage.auth_inf != undefined){
		return true;
	} else loadAuthPage();
	return false;
}

function loadAuthPage(){
		contentZone.showAuth();
		toolBar.setTitle(stringNames[0]);
		toolBar.displayArrIcon();
}

function loadMenuPage(){
	if(isAuth()){
		var userInfo;
		if(localStorage.auth_inf != undefined){
			userInfo = getJSON('auth_inf', true);
		} else {
			userInfo = getJSON('auth_inf', false);
		}
		
		$('.previous_info_fullname').html(userInfo.FIO);
		if (userInfo.is_student == '1'){
			$('.previous_info_group').html((userInfo.groups).join(','));
		}
		
		contentZone.showMenu();
		toolBar.setTitle(stringNames[1]);
		toolBar.displayMenuIcon();
	}
}

function loadNewsPage(){
	if(isAuth()){
		contentZone.showNews();
		toolBar.setTitle(stringNames[3]);	
		toolBar.displayMenuIcon();
		toolBar.displaySecMenu();
	}
}

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

function getJSON(key, flag) {
	
	var value;
	
	if(flag == true){
				value = localStorage[key];				
			} else {
				value = sessionStorage[key];
			}
	
	return value ? JSON.parse(value) : null;
}