$(window).load(function(){
	
	hideLoader();
	/* $('.content_box').masonry({
		itemSelector: '.content_box_menuitem',
	}); */

});



$(document).ready(function(){
	
	view.loadPage();
	
	createHtmlSettings();
	setUserSettings(+localStorage.settingsCode);
			
	var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
	
	elems.forEach(function(html) {
		var switchery = new Switchery(html);
	});	
 
	
	$menu_bl = $('.sidebar_menu_block');
	$menu_bl.css('margin-left', '-'+$menu_bl.css('width'));
	$('.sidebar_wr').css('width', $menu_bl.width()+15+'px').css('height', $(window).height());
	
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

