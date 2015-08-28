$(document).ready(function(){
	
	window.addEventListener('hashchange', function(event){
		view.loadPage();
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