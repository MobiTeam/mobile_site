$(window).load(function(){
	
	/* $('.content_box').masonry({
		itemSelector: '.content_box_menuitem',
	}); */
	/* $('.wrapper').removeClass('loading'); */
		
	
	
});

$(document).ready(function(){
	
	$('.authorisation_box_form').on( "submit", function( event ){
		
		event.preventDefault();
				
		if(validateForm()){
			tryAutorisate($(this).serialize());
		} 
		
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
	var response = '';
	console.log(userData);
}
