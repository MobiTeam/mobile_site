/**/$(window).load(function(){
	
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
 
	
	$(window).scroll(function(){
		//#4368FD
		var sc = $(this).scrollTop(); 
		
		$(window).clearQueue();
		$('.header_line__content').stop();
		if(sc > 30){
			$('.header_shadow_box').fadeIn(100);
			$('.header_line__content').animate({
				backgroundColor : '#4368FD'
			}, 100);
		} else {
			$('.header_line__content').animate({
				backgroundColor : '#5677fc'
			}, 100);
			$('.header_shadow_box').fadeOut(100);
		}
		
		if(location.hash == "#news") {
			if ($(window).scrollTop() > $(document).height() - $(window).height() - 10) {
				loadNextNews($('.current_item').attr('newstype'), ($('.news_box_item').last()).attr("idnews"));
			}
		}
		
	});
	
	$menu_bl = $('.sidebar_menu_block');
	$menu_bl.css('margin-left', '-'+$menu_bl.css('width'));
	$('.sidebar_wr').css('width', $menu_bl.width()+15+'px').css('height', $(window).height());
	
	$(window).resize(function(){
		view.correctHeight();
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

