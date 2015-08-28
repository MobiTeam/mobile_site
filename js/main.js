var view = {
	
	$button:$('.header_line__content_button'),
	$title:$('.header_line__content_title'),
	$second_menu:$('.header_line_addition_wrapper'),
	$auth:$('.authorisation_box'),
	$menu:$('.main_menu'),
	$news:$('.news_box'),
	$settings:$('.header_line_content_settings'),
	
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
	
	closeAll: function(currentHash){
		this.$auth.fadeOut(0);
		this.$menu.fadeOut(0);
		this.$news.fadeOut(0);
		this.$second_menu.fadeOut(0);
	},
	
	changePage:function(hash){
		
		location.hash = hash != undefined ? ('#' + hash) : location.hash;
     
	},

	loadPage(){
		
		this.closeAll();
		
		if(isAuth()){
			
			switch(location.hash){
			    
				case '#menu':
					
					var userInfo = getJSON('auth_inf', (localStorage.auth_inf != undefined));
					
					$('.previous_info_fullname').html(userInfo.FIO);
					
					if (userInfo.is_student == '1'){
						$('.previous_info_group').html((userInfo.groups).join(','));
					}
						
					this.$menu.fadeIn(250);
					this.$settings.fadeIn();
					this.setTitle(stringNames[1]);
					this.displayMenuIcon();
							
				break;
						
				case '#person':
				
				break;
						
				case '#auth':
					loadAuth();
				break;
						
				case '#news':
					this.$news.fadeIn(250);
					this.$settings.fadeIn();
					this.setTitle(stringNames[3]);
					this.displayMenuIcon();
					this.$second_menu.fadeIn(0); 
				break;
						
				case '#messages':
				
				break;
				
				default:
					location.hash = '#menu';
				break;
						
					}
			
		} else if(isGuest()){
			
			    switch(location.hash){
					case '#guest':
					
						var userInfo = getJSON('guest_inf', (localStorage.guest_inf != undefined));
										
						$('.previous_info_fullname').html(userInfo.FIO);
						
						$('.authblock').css('display', 'none');
						this.$menu.fadeIn(250);
						this.$settings.fadeIn();
						this.setTitle(stringNames[1]);
						this.displayMenuIcon();
					
					break;
					
					case '#news':
						this.$news.fadeIn(250);
						this.$settings.fadeIn();
						this.setTitle(stringNames[3]);
						this.displayMenuIcon();
						this.$second_menu.fadeIn(0); 
					break;
					
					case '#titetable':
					break;
					
					case '#auth':
						loadAuth();
					break;
					
					default:
						location.hash = '#guest';
					break;
								
				}				
			} else {
				location.hash = '#auth'; 
				loadAuth();
			} 
	}
		
}	

$(window).load(function(){
	
	hideLoader();
	/* $('.content_box').masonry({
		itemSelector: '.content_box_menuitem',
	}); */

});

function loadAuth(){
	view.$auth.fadeIn(0);
	view.setTitle(stringNames[0]);
	view.displayArrIcon();
}

$(document).ready(function(){
	
	window.addEventListener('hashchange', function(event){
		view.loadPage();
	});
	
	location.hash = '#firt_in';
	
	$('.authorisation_box_form').on( "submit", function( event ){
		
		event.preventDefault();
				
		if(validateForm()){
			
			authObj = (tryAutorisate($(this).serialize()));
			
			if (authObj.FIO != "undefined"){
				setJSON("auth_inf", authObj, $('.save_password').prop('checked'));
				
				$('.authblock').css('display','inline-block');				
			}
			view.changePage('menu');
			showTooltip(authObj.serverRequest, 2000);
		}  
		
	})
	
	$('.authorisation_box_button').click(function(){
		
		authObj = {"FIO":"Здравствуйте, Гость","serverRequest":"Гостевой вход","is_student":"undefined","groups":[]};
		setJSON("guest_inf", authObj, $('.save_password').prop('checked'));
		view.changePage('guest');
		showTooltip(authObj.serverRequest, 2000);
		
	});
	
	
	$('.header_line_addition_menu_item').click(function(){
		$('.header_line_addition_menu_item').each(function(){
			$(this).removeClass('current_item');
		});
		$(this).addClass('current_item');
	}); 
	
	$('.content_box_menuitem').click(function(){
		view.changePage($(this).attr('hashtag'));
	}) 
	
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