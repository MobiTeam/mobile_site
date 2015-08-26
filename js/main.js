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

var toolBar = {
	
	$button:$('.header_line__content_button'),
	$title:$('.header_line__content_title'),
	
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
	}
	
}

var contentZone = {
	
	$auth:$('.authorisation_box'),
	$menu:$('.main_menu'),
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
	}
	
}

$(window).load(function(){
	
	hideLoader();
	/* $('.content_box').masonry({
		itemSelector: '.content_box_menuitem',
	}); */
	/* $('.wrapper').removeClass('loading'); */
		
	
	
});

$(document).ready(function(){
	
	toolBar.setTitle(stringNames[0]);
	
	$('.authorisation_box_form').on( "submit", function( event ){
		
		event.preventDefault();
				
		/* if(validateForm()){
			tryAutorisate($(this).serialize());
		}  */
		
		if(true){
				
			toolBar.setTitle(stringNames[1]);	
			toolBar.displayMenuIcon();
			contentZone.hideAuth(300);
			contentZone.showMenu(300);
			
			
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

function tryAutorisate(userData){

	opBl();
	$.ajax({
		type: 'POST',
		url: 'mobile_reciever.php',
		data: userData,
		success: function(responseTxt){
			console.log(responseTxt);
		},
		error: function(){
			alert('Ошибка подключения к серверу. Проверьте наличие интернет соединения.');	
		},
		complete: function(){
			clBl();
		}
	})
}

function showTooltip(toolText){
	
	$tooltip = $('.tooltip');
	$tooltip.fadeIn(200);
	$tooltip.html(toolText);
	setTimeout(function(){
		$tooltip.fadeOut(200);
	}, 1000);
	
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