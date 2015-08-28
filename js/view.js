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
		
		var currentHash = location.hash;
		
		if(('#' + hash) != currentHash && hash != undefined){
			location.hash = hash;
		}    
	},

	loadPage(){
		
		this.closeAll();
		
		if(isAuth()){
			
			switch(location.hash){
			    
				case '#menu':
					loadMainMenu();
				break;
						
				case '#person':
				
				break;
						
				case '#auth':
					loadAuth();
				break;
						
				case '#news':
				   loadNewsBlock();
				break;
						
				case '#messages':
				
				break;
				
				default:
				    view.changePage('menu');
				break;
						
					}
			
		} else if(isGuest()){
			
			    switch(location.hash){
					case '#guest':
						loadGuestMenu();
					break;
					
					case '#news':
						loadNewsBlock();
					break;
					
					case '#titetable':
					break;
					
					case '#auth':
						loadAuth();
					break;
					
					default:
						view.changePage('guest'); 
					break;
								
				}				
			} else {
				view.changePage('auth'); 
				loadAuth();
			} 
	}
		
}	

//функции загрузки блоков

function loadAuth(){
	view.$auth.fadeIn(0);
	view.setTitle(stringNames[0]);
	view.displayArrIcon();
}

function loadMainMenu(){
	var userInfo = getJSON('auth_inf', (localStorage.auth_inf != undefined));
					
	$('.previous_info_fullname').html(userInfo.FIO);
	
	if (userInfo.is_student == '1'){
		$('.previous_info_group').html((userInfo.groups).join(','));
	}
		
	view.$menu.stop().fadeTo(250, 1);
	view.$settings.fadeIn();
	view.setTitle(stringNames[1]);
	view.displayMenuIcon();
}

function loadGuestMenu(){
	var userInfo = getJSON('guest_inf', (localStorage.guest_inf != undefined));
					
	$('.previous_info_fullname').html(userInfo.FIO);
	
	$('.authblock').css('display', 'none');
	view.$menu.stop().fadeTo(250, 1);
	view.$settings.fadeIn();
	view.setTitle(stringNames[1]);
	view.displayMenuIcon();
	
}

function loadNewsBlock(){
	view.$news.stop().fadeTo(250, 1);
	view.$settings.fadeIn();
	view.setTitle(stringNames[3]);
	view.displayMenuIcon();
	view.$second_menu.fadeIn(0); 
}