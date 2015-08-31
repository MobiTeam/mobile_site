$(document).ready(function(){
	
	window.addEventListener('hashchange', function(event){
		view.loadPage();
		
	});
	
	$( window ).on( "resize", function(){
	
		$menu_bl = $('.sidebar_menu_block');
		$('.sidebar_wr').css('width', $menu_bl.width()+15+'px').css('height', $(window).height());
		if($('.menuoverlay').css('display') != 'block'){
			$menu_bl.css('margin-left', '-'+$menu_bl.css('width'));
		}
		
	});
		
	$('.header_line__content_button ').click(function(){
		if($(this).hasClass('menu_button')){
			/* $('body').css('overflow', 'hidden'); */
			openSidebar();
				
		}
	});
	
	$('.sidebar_menu_block_back_arr').click(function(){
		/* $('body').css('overflow', 'scroll'); */
		closeSidebar();
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
	
	$('.content_box_menuitem, .sidebar_menu_block_menu_item, .header_line_content_settings').click(function(){
		view.changePage($(this).attr('hashtag'));
		if($('.menuoverlay').css('display') == 'block'){
			closeSidebar();
		}
	}) 
	
	$('.menuoverlay').click(function(){
		closeSidebar();
	});
	
})