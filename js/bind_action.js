$(document).ready(function(){
	
	window.addEventListener('hashchange', function(event){
		view.loadPage();
	});
	
	$('body').click(function(event){
	    if (event.target.className != 'timetable_box_input' && location.hash == '#timetable') {
		   closeInput();
		}
	})
	
	$('.timetable_box_input').autocomplete({	
			source:"oracle/database_get_timetable_info.php",
			minLength:2
		});
		
	$('.timetable_box_input').on('autocompleteselect',function(event, ui){
        sessionStorage.timetable = undefined;
        sessionStorage.query = ui.item.value;
        $('.timetable_lessons').html('')
        loadTimetableInf(ui.item.value);	
		displayTimetable();
		closeInput();		
   });	
	
	$('.timetable_lessons').click(function(event){
		if(event.target.className == 'found_by_sel_text') {
			sessionStorage.query = (event.target.innerHTML).trim();
			sessionStorage.timetable = undefined;
			loadTimetableInf(event.target.innerHTML);
			view.setTitle(sessionStorage.query);
		} else if (event.target.className == 'hide_information_button') {
			if (event.target.value == 'Развернуть'){
				event.target.value = 'Свернуть';
			} else {
				event.target.value = 'Развернуть';
			}
			$('.hide_timetable_information').toggle(200);
		}
	})
	
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
				
		} else if($(this).hasClass('arr_button')){
			
			if(location.hash == '#auth'){
				if (confirm('Вы действительно хотите закрыть приложение?')) location.href = 'http://google.com';
			}
			
	
		}
	});
	
	$('.sidebar_menu_block_back_arr').click(function(){
		/* $('body').css('overflow', 'scroll'); */
		closeSidebar();
	});
	
	$('.timetable_box_form').on("submit", function(event){
		event.preventDefault();
		/* sessionStorage.query = $('.timetable_box_input').val();
		setJSON('timetable', myajax(false, 'POST', 'oracle/database_timetable.php', $(this).serialize()), false);
		displayTimetable();
		closeInput(); */
	}); 
	
	$('.authorisation_box_form').on( "submit", function( event ){
		
		event.preventDefault();
				
		if(validateForm()){
			
			tryAutorisate($(this).serialize());
		
		}  
		
	})
	
	$('.header_line_content_calendar').click(function(){
		
	})
	
	$('.date_item_next').click(function(){
		$('.greyTag').removeClass('greyTag');
		$('.redTag').removeClass('redTag');
		sessionStorage.diffDate = 7;
		getTimetableWeek(7);		
	});
	
	$('.date_item_back').click(function(){
		$('.greyTag').removeClass('greyTag');
		$('.redTag').removeClass('redTag');
		sessionStorage.diffDate = -7;
		getTimetableWeek(-7);
	});
	
	$('.authorisation_box_button').click(function(){
		
		sessionStorage.clear();
		localStorage.user_inf = undefined;
		
		authObj = {"FIO":"Здравствуйте, Гость","serverRequest":"Гостевой вход","is_student":"undefined","groups":[]};
		setJSON("guest_inf", authObj, $('.save_password').prop('checked'));
		view.changePage('guest');
		showTooltip(authObj.serverRequest, 2000);
		
	});
	
	$('.header_line_content_search').click(function(){
		if($(this).hasClass('opened_input')){
			
			$('.timetable_box_input').val('');
			
		} else {
			$('.header_line_content_calendar').fadeOut(0);
			slideInput();
		}
	});
	
	$('.date_item').click(function(){
					
		$('.date_item').each(function(){
			$(this).removeClass('greenTag');
		}); 
		
		$(this).addClass('greenTag');
		
				
		if(sessionStorage.timetable != undefined){
			
			if($('.item_ch_1').prop('checked')){
				
				$(window).clearQueue();
				$('body').scrollTo("#" + $(this).attr('name'), { offset: - 110, duration: 450 });
				
			} else {
				displayTimetable($(this).attr('date_quer'));
			}
			
			
		}  
	
	})
	

	$('.header_line_addition_menu_guide_item').click(function(){
		$('.header_line_addition_menu_guide_item').each(function(){
			$(this).removeClass('current_item');
		});
		$(this).addClass('current_item');
		
		//функция для открытия блока

		if($(this).attr('guidetype') == 1){

			if($('.search_form_block').size() == 0){


				view.$dir_info_block.html('<div class="search_form_block contr_shadow"><span class="search_form_block_span">Форма поиска:</span>\
				               <input class="guide_item_text" type="text" value="" /><br>\
							<span class="search_form_block_descr">Посредством данной формы поиска можно получить необходимую информацию о преподавателе или сотруднике университета.\
							<br>Для того, чтобы найти интересующего вас человека, необходимо начать вводить его фамилию или имя в строке поиска, а затем выбрать из предложенных вариантов.</span>\
							</div>\
							<div class="guide_item_search_result">Загрузка...</div>');

	 			$('.guide_item_text').autocomplete({	
					source:"oracle/database_get_guidenames_info.php",
					minLength:2
				});

				$('.guide_item_text').on('autocompleteselect',function(event, ui){
 				$('.search_form_block_descr').hide(150, function(){
 					$('.guide_item_search_result').css("padding-top", ($('.search_form_block').height() + 25) + "px");
 				});

 					myajax(true, "POST", "oracle/database_contact_teac.php", {FIO : ui.item.value}, false, showTeachContacts, true);
		  	 	});	

			}

 		} else {
			view.$dir_info_block.load('university_guide.html');
		}
		
		document.documentElement.scrollTop = 0;
		document.body.scrollTop = 0;
	});

	$('.header_line_addition_menu_item').click(function(){
		$('.header_line_addition_menu_item').each(function(){
			$(this).removeClass('current_item');
		});
		$(this).addClass('current_item');
		saveAndShow();
		document.documentElement.scrollTop = 0;
		document.body.scrollTop = 0;
	}); 
	
	$('.content_box_menuitem, .sidebar_menu_block_menu_item, .header_line_content_settings').click(function(){
		view.changePage($(this).attr('hashtag'));
		if($('.menuoverlay').css('display') == 'block'){
			closeSidebar();
		}
	}) 
	
	
	/* $('.sidebar_menu_block_menu_item').click(function(){
		clearCurrSidebarItem();
		$(this).addClass('sidebar_menu_block_menu_item_curr');
	}); */
	
	$('.menuoverlay').click(function(){
		closeSidebar();
	});
	
	$('.settings_box_button_save').click(function(){
		
		var codeSetString = '';
		$('[class *= "item_ch_"]').each(function(){
			codeSetString += $(this).prop("checked") ? '1' : '0';
		});
		
		var id = getJSON('auth_inf', (localStorage.auth_inf != undefined)).id;
		
		localStorage.settingsCode = parseInt(codeSetString, 2);
		myajax(true, 'POST', 'oracle/database_set_settings.php', {code: localStorage.settingsCode, id_user: id}, true); 
		
	})
	

})