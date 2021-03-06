// объявление бокового меню [18.01.2016]
/////////////////////////////////////////

var slideout;

window.onload = function() {
	slideout = new Slideout({
	  'panel': document.getElementById('panel'),
	  'menu': document.getElementById('menu'),
	  'side': 'left',
	  'touch': false
	});
	
};

// назначение обработчиков [18.01.2016]
////////////////////////////////////////

$(document).ready(function(){

	// abit ui

	// $('.timetable_box_input').autocomplete({	
	// 	source:"oracle/database_get_timetable_info.php",
	// 	minLength:2
	// });

	// $('.timetable_box_input').on('autocompleteselect',function(event, ui){

 //        saveValue('timetable',"undefined");
 //        saveValue('query', ui.item.value);
        
 //        $('.timetable_lessons').html('')
 //        loadTimetableInf(ui.item.value);	
	// 	displayTimetable();
	// 	closeInput();		
   
 //   });	



	window.addEventListener('hashchange', function(event){
		view.loadPage();
	});
		
	
//  GUI расписания [18.01.2016]
//////////////////////////////////////////////////////////////////////////////////////////////

	$('body').click(function(event) {
	    if (event.target.className != 'timetable_box_input' && location.hash == '#timetable') {
		   closeInput();
		}
	})

	$('.abit_item_text').autocomplete({
    	minLength: 1,
     	source: function(request, response, url) {

	        var searchParam  = {term: (request.term.toLowerCase()).replace(/ё/ig, 'е')};


    		$.ajax({
	            url: 'oracle/database_get_abiturient_autoinfo.php',
	            data : searchParam,
	            dataType: "json",
	            type: "GET",
           		success: function (data) {

                    response($.map(data, function(item) {

                    	var loadedObj = item;
                    		loadedObj.label = item.FIO;
                    		loadedObj.value = item.FIO;

                    	return loadedObj;

                    }));
                }
            });
        },
	        select: function(event, ui) {

	        	//ui.item
	        	$('.abit_results').html(JSON.stringify(ui)).css('padding-top', ($('.abit_form_block').height() + 30)+ "px");
	        	// console.log(ui);
	        	return true;
	        	        		
	        }
	    })

	$('.timetable_query').click(function() {
		$('.ui-autocomplete').css('display', 'block');
	});

	window.onerror = function (errorMsg, url, lineNumber) {

	  var errorMsg = 'Error: ' + errorMsg + ' Script: ' + url + ' Line: ' + lineNumber;

	  new Image().src = "oracle/errorReport.php?e=" + encodeURIComponent(errorMsg);
   	  showTooltip('Произошла непредвиденная ошибка. Возможно потребуется перезагрузка сервиса.', 4000);
   	  clBl();

   	}

	var bisy = false;
	$(window).on('resize', function() {

		if(location.hash == "#news" && !bisy) {
			bisy = true;
			setTimeout(function(){
				activateWaterfall();
				bisy = false;
			}, 500);
		}

		if(location.hash == "#abit") {
			$('.abit_results').css('padding-top', ($('.abit_form_block').height() + 30) + "px");
		}		

	});


	$('.timetable_box_form').on("submit", function(event) {
		event.preventDefault();
	}); 

	$('.timetable_box_input').autocomplete({	
		source:"oracle/database_get_timetable_info.php",
		minLength:2
	});

	$('.timetable_box_input').on('autocompleteselect',function(event, ui){

        saveValue('timetable',"undefined");
        saveValue('query', ui.item.value);
        
        $('.timetable_lessons').html('')
        loadTimetableInf(ui.item.value);	
		displayTimetable();
		closeInput();		
   
   });	
	
	$('.timetable_lessons').click(function(event){

		if(event.target.className == 'found_by_sel_text') {

			saveValue("query", (event.target.innerHTML).trim());
			saveValue("timetable", "undefined");
			
			loadTimetableInf(event.target.innerHTML);

		} else if (event.target.className == 'hide_information_button') {

			var targetTd = $( event.target.parentNode );
			

			if (event.target.value == 'Развернуть'){
				event.target.value = 'Свернуть';
			} else {
				event.target.value = 'Развернуть';
			}
			
			targetTd.find('.hide_timetable_information').toggle(200);
		}
	});

	$('.date_item_back, .date_item_next').click(function(){
		
		var diff = $(this).attr('diffDate'),
			dateStr = getTimetableWeek(true, parseInt(diff)),
			date = getTimetableWeek(false, parseInt(diff));
		
		$('.greyTag').removeClass('greyTag');
		$('.redTag').removeClass('redTag');
		$('.dt1').addClass('greyTag');

		loadTimetableInf(getValue('query'), dateStr);
		renderWeekTable(date);
		
		
	});
	
	view.$helper.click(function(){

		opBl();
		$('#helper_box').fadeIn(20);


	});

	$('.header_line__content_button ').click(function(){
		
		if($(this).hasClass('menu_button')){
			
			slideout.toggle();
				
		} else if($(this).hasClass('arr_button')){
			
			if(location.hash == '#auth'){
				if (confirm('Вы действительно хотите закрыть приложение?')) location.href = 'http://google.com';
			}
		
		}
	});
	
	$('.sidebar_menu_block_back_arr').click(function(){
		slideout.toggle();
	});
	
	
	
	$('.authorisation_box_form').on( "submit", function( event ){
		
		event.preventDefault();
				
		if(validateForm()){
			
			tryAutorisate($(this).serialize() + "&time_send_query=" + new Date().getTime());
		
		}  
		
	})
	
	
	$('.authorisation_box_button').click(function(){
		
		sessionStorage.clear();
		localStorage.user_inf = undefined;
		
		authObj = {"FIO":"Здравствуйте, Гость","serverRequest":"Гостевой вход","is_student":"undefined","groups":[]};
		setJSON("guest_inf", authObj);
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

	$('.header_line_content_calendar').click(function(){

		var htmlTMTB = "",
			currWeek = getTimetableWeek(true),
			timetable = getJSON('timetable'),
			dateNumbers = currWeek.replace(/\./g,'');

		if(!!timetable && !!timetable[dateNumbers]){
			
			
			for(var i = 0; i < 6; i++){

			}

			showTmtbBox();
			$('.currentWeekTimetable').html('<b>Расписание на текущую неделю</b>');
		} else {
			showTooltip("Для начала необходимо загрузить расписание.", 4000);
		}		

	});
	
	$('.date_item').click(function(){
					
		$('.date_item').each(function(){
			$(this).removeClass('greenTag');
		}); 
		
		$(this).addClass('greenTag');
		
				
		if(issetTimetable()){
			
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
	
	$('.sidebar_menu_block_menu_item').click(function(){ view.changePage($(this).attr('hashtag')); slideout.toggle();})

	$('.content_box_menuitem, .header_line_content_settings').click(function(){ view.changePage($(this).attr('hashtag')); }) 
	
	$('.settings_box_button_save').click(function(){
		
		var codeSetString = '';
		$('[class *= "item_ch_"]').each(function(){
			codeSetString += $(this).prop("checked") ? '1' : '0';
		});
		
		var id = getJSON('auth_inf').id;
		var default_query = $('.default_query_inp').attr('default_query');
		var formular = $('.formular_num_inp').val();

		saveValue("settingsCode", parseInt(codeSetString, 2));
		saveValue("subgroup", $('.select_subgroup').val());
		saveValue("default_query", default_query);
		saveValue("formular", formular);
		saveValue('timetable', "undefined");

		myajax(true, 'POST', 'oracle/database_set_settings.php', {formular_id: formular, code: getValue("settingsCode"), subgrp: $('.select_subgroup').val() , id_user: id, def_query: default_query}, true); 
		
	})


	$('.modalForm_fm').on( "submit", function( e ){

		e.stopPropagation();
		e.preventDefault();

		$sbm_btn = $('.infoSubmBtn');
		$sbm_btn.prop("disabled", true);

		$elements = $('.modalForm_fm input[type="text"], .modalForm_fm textarea');

		$elements.each(function(){

			if($(this).val() == ""){
				$(this).css('background', '#F6CED8');
				showTooltip("Заполните все обязательные поля", 2500);
				return false;
			} else {
				$(this).css('background', '#E3F6CE');
			}

		});


		$.ajax({
			type: 'POST',
			url: 'oracle/database_insert_reviews.php',
			data: $('.modalForm_fm').serialize(),
			success: function(response){
				
				if(response.length < 5){
					showTooltip("Сообщение было успешно отправлено", 2500);
				} else showTooltip("Сообщение не было отправлено!", 2500);
				
			},
			error: function(){
				showTooltip("Нет соединения с сервером. Повторите попытку позже", 2500);
			},
			complete: function(){
				$sbm_btn.prop("disabled", false);
				closeModalForm();
			}
		})

		


	});


})