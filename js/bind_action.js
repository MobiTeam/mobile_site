$(document).ready(function(){
	
	window.addEventListener('hashchange', function(event){
		view.loadPage();
	});
	
	$('.header_line__content_button ').click(function(){
		if($(this).hasClass('menu_button')){
			/* $('body').css('overflow', 'hidden'); */
			$('.menuoverlay').stop().fadeTo(250, 0.6);	
			$('.sidebar_menu_block').addClass('contr_shadow')
									.animate({
										'margin-left': "0px"
									}, 250);
				
		}
	});
	
	$('.sidebar_menu_block_back_arr').click(function(){
		/* $('body').css('overflow', 'scroll'); */
		$('.menuoverlay').stop().fadeTo(250, 0);
		$menuBlock = $('.sidebar_menu_block');
		$menuBlock.removeClass('contr_shadow')
									.animate({
										'margin-left': '-' + $menuBlock.css('width')
									}, 250, function(){
										$('.menuoverlay').css('display','none');
									});
	});
	
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
		
		sessionStorage.clear();
		localStorage.user_inf = undefined;
		
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