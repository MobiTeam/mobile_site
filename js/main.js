$(window).load(function(){
	
	hideLoader();
	/* $('.content_box').masonry({
		itemSelector: '.content_box_menuitem',
	}); */

});

$(document).ready(function(){
	
	view.loadPage();
	
	$menu_bl = $('.sidebar_menu_block');
	$menu_bl.css('margin-left', '-'+$menu_bl.css('width'));
	
	$('.sidebar_wr').css('width', $menu_bl.width()+15+'px');
	
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
    return myajax(false, 'POST', 'mobile_reciever.php', userData);
}