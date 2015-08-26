var stringNames = [
	"Авторизация",
	"Главное меню",
	"Настройки",
	"Новости",
	"Персональная информация",
	"Расписание",
	"Сообщения"
]

var toolBar = {
		
	setTitle : function(nameTitle){
		$('.header_line__content_title').html(nameTitle);	
	}	
		
	/* changeLeftIcon : function(){
		
		
	}	 */
	
	
}

$(window).load(function(){
	
	/* $('.content_box').masonry({
		itemSelector: '.content_box_menuitem',
	}); */
	/* $('.wrapper').removeClass('loading'); */
		
	
	
});

$(document).ready(function(){
	
	toolBar.setTitle(stringNames[0]);
	
	$('.authorisation_box_form').on( "submit", function( event ){
		
		event.preventDefault();
				
		if(validateForm()){
			tryAutorisate($(this).serialize());
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

function opBl(){
	$('.overlay').css('display', 'block');
}

function clBl(){
	$('.overlay').css('display', 'none');
}
