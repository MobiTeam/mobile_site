//экран мобильного приложения представлен в виде объекта view
//свойства объекта - div и span блоки
//методы объекта - функции отображающие или скрывающие определенные div или span блоки 
var view = {
	
	$button:$('.header_line__content_button'),
	$title:$('.header_line__content_title'),
	$second_menu:$('.header_line_addition_wrapper'),
	$guide_menu:$('.header_line_addition_wrapper_guide'),
	$auth:$('.authorisation_box'),
	$menu:$('.main_menu'),
	$news:$('.news_box'),
	$full_art:$('.news_box_details'),
	$settings:$('.header_line_content_settings'),
	$helper:$('.header_line_content_helper'),
	$settings_box:$('.settings_box'),
	$timetable:$('.timetable_box'),
	$persons:$('.person_box'),
	$search_butt:$('.header_line_content_search'),
	$form:$('.timetable_box_form'),
	$dateline: $('.header_line_addition_datewr'),
	$heightBlock: $('.space_height'),
	$cont_header: $('.header_line__content'),
	$cal_button: $('.header_line_content_calendar'),
	$group_block: $('.group_info_box'),
	$dir_info_block: $('.dir_info_box'),
	$about_block: $('.about_info_box'),
	$fin_info_box: $('.fin_info_box'),
	$coffe_info_box: $('.coffe_info_box'),
	$header_line_my_bag: $('.header_line_my_bag'),
	$shopping_box: $('.shopping_box'),
	$hidden_inf_block: $('.hiddenInfBlock'),
	$lib_box: $('.lib_info_box'),
	$file_box: $('.file_info_box'),
	
	correctHeight: function(){
		this.$heightBlock.css('height', this.$cont_header.css('height'));
	},
	
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
		this.$hidden_inf_block.fadeOut(0);
		this.$shopping_box.fadeOut(0);
		this.$header_line_my_bag.fadeOut(0);
		this.$coffe_info_box.fadeOut(0);
		this.$fin_info_box.fadeOut(0);
		this.$guide_menu.fadeOut(0);
		this.$dir_info_block.fadeOut(0);
		this.$about_block.fadeOut(0);
		this.$group_block.fadeOut(0);
		this.$lib_box.fadeOut(0);
		this.$auth.fadeOut(0);
		this.$menu.fadeOut(0);
		this.$news.fadeOut(0);
		this.$second_menu.fadeOut(0);
		this.$full_art.fadeOut(0);
		this.$timetable.fadeOut(0);
		this.$persons.fadeOut(0);
		this.$search_butt.fadeOut(0);
		this.$dateline.fadeOut(0);
		this.$settings_box.fadeOut(0);
		this.$helper.fadeOut(0);
		this.$file_box.fadeOut(0);
		this.$title.css('display', 'block');
		this.$form.css('display', 'none');
		closeInput();
		this.$cal_button.fadeOut(0);
		clearCurrSidebarItem();
		$('.previous_info_group').html('');
	},
	
	changePage:function(hash){
		
		var currentHash = location.hash;
		
		if(('#' + hash) != currentHash && hash != undefined){
			location.hash = hash;
		}    
	},
	//роутинг между экранами приложения реализован при помощи location.hash
	//в зависимости от hash открывается определенный экран приложения
	//при каждом изменении location.hash происходит перерисовка экрана
	loadPage:function(){
		
		this.closeAll();
		
		if(isAuth()){
			
			$('.auth_only').css('display', 'block');
			//проверка на студента
			var infBlock = getJSON('auth_inf');
			if(infBlock.is_student == "0"){
				$('.only_stud').fadeOut(0);
			} else {
				$('.only_personal').fadeOut(0);
			}
			
			switch(location.hash){
			    
				case '#menu':
					loadMainMenu();
				break;

				// case '#finance_inf':
				// 	loadFinInfo();
				// break;
						
				case '#auth':
					loadAuth();
				break;
						
				case '#news':
				    loadNewsBlock();
				break;
						
				// case '#messages':
				
				// break;
				
				case '#timetable':
					loadTimetable();
				break;
				
				case '#persinf':
					loadPersonBlock();
				break;
				
				case '#group_info':
					loadGroupBlock();
				break;

				case '#colleague_info':
					loadCollegueBlock();
				break;

				case '#settings':
					loadSettingsBlock();
				break;
				
				case '#about_app':
					loadAppInfo();
				break; 

				case '#dir_info':
					loadDirInfo();
				break;

				case '#coffe_block':
					showCoffeBox();
				break;

				case '#lib_info':
					showLibBox();
				break;

				case '#file_info':
					loadFileBlock();
				break;

				default:
					parseHashTag("menu");
				break;
						
					}
			
		} else if(isGuest()){
			
				$('.auth_only').css('display', 'none');
				saveValue("subgroup", "0");
			
			
			    switch(location.hash){
					case '#guest':
						loadGuestMenu();
					break;
					
					case '#news':
						loadNewsBlock();
					break;
					
					case '#timetable':
						loadTimetable();
					break;
					
					case '#auth':
						loadAuth();
					break;
					
					case '#about_app':
						loadAppInfo();
					break; 

					case '#dir_info':
						loadDirInfo();
					break;

					case '#coffe_block':
						showCoffeBox();
					break;

					case '#file_info':
						loadFileBlock();
					break;

					default:
						parseHashTag("guest");
					break;
								
				}				
			} else {
				view.changePage('auth'); 
				loadAuth();
			} 
			
		this.correctHeight();	
		document.documentElement.scrollTop = 0;
		document.body.scrollTop = 0;



		//ie fix
		// if(location.hash != '#timetable'){
		// 	$('.ui-autocomplete').click();
		// } 
	}
		
}	

//функции загрузки блоков

function loadAppInfo(){
	tagMenuItem('about_item');
	view.setTitle(stringNames[9]);
	view.displayMenuIcon();
	view.$about_block.fadeIn(0);
}

function loadAuth(){
	sessionStorage.clear();
	localStorage.clear();
	$('.timetable_lessons').html('');
	view.$helper.fadeIn(0);
	view.$auth.fadeIn(0);
	view.setTitle(stringNames[0]);
	view.displayArrIcon();
}

function loadMainMenu(){
	
	tagMenuItem('main_item');
	var userInfo = getJSON('auth_inf');
					
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
	
	tagMenuItem('main_item');
	var userInfo = getJSON('guest_inf');
					
	$('.previous_info_fullname').html(userInfo.FIO);
	
	$('.authblock').css('display', 'none');
	view.$menu.stop().fadeTo(250, 1);
	view.$settings.fadeIn();
	view.setTitle(stringNames[1]);
	view.displayMenuIcon();
	
}

function loadNewsBlock(){
	
	tagMenuItem('news_item');
	view.$news.stop().fadeTo(250, 1).scrollTop(0);
	view.$settings.fadeIn();
	view.setTitle(stringNames[3]);
	view.displayMenuIcon();
	view.$second_menu.fadeIn(0); 
	saveAndShow();
	
}

// Блок работы с расписанием [18.01.2016]
//////////////////////////////////////////

function loadTimetable(){
	
	tagMenuItem('timetable_item');
	view.$cal_button.fadeIn(0);
	view.$timetable.stop().fadeTo(250, 1);
	view.$settings.fadeIn();
	view.setTitle(stringNames[5]);
	view.displayMenuIcon();
	view.$search_butt.fadeIn(0).removeClass('opened_input');
	view.$dateline.fadeIn(0);
	
	renderWeekTable();
	
	if(!issetTimetable()){
		
		var uInfo = getJSON("auth_inf");

		if(!!uInfo && uInfo.default_query != null && uInfo.default_query != "") {

			saveValue("query", getValue('default_query') || uInfo.default_query);
			loadTimetableInf(getValue('default_query'));
		
		} else if(issetUserGroup()){
			saveValue("query", uInfo.groups[0]);
			loadTimetableInf(uInfo.groups[0]);
		} else {

			if(!isGuest()){
				if(uInfo.is_student == "0"){
					var personFio = (uInfo.FIO).replace(/(.*)\s+(.).*\s+(.).*/, '$1 $2.$3.');
					saveValue("query", personFio);
					loadTimetableInf(personFio);
				} else {
					$('.timetable_lessons').html('');
					showTimetableAlert();
				}		

			} else {
				showTimetableAlert();
			}					
		}
		
	} else {
		
		displayTimetable();
		
	}
}

function loadPersonBlock(){
	tagMenuItem('pers_item');
	view.$persons.stop().fadeTo(250, 1);

	var allInf = getJSON('auth_inf');

	if(allInf.is_student == 0){
		$('.forStud').css('display', 'none');
		$('.notStud').css('display', 'block');
		loadTeachInformation(allInf.hash, allInf.FIO);
	} else {
		$('.forStud').css('display', 'block');
		$('.notStud').css('display', 'none');
		loadStudentInformation(allInf.hash, allInf.FIO, allInf.groups);
	}

	view.$settings.fadeIn();
	view.setTitle(stringNames[4]);
	view.displayMenuIcon();
}

function showLibBox(){
	view.displayMenuIcon();
	view.$lib_box.stop().fadeTo(250, 1);
	view.setTitle(stringNames[13]);
	loadFormularInfo();
}

function loadFileBlock(){
	view.displayMenuIcon();
	view.$file_box.stop().fadeTo(250, 1);
	view.setTitle(stringNames[14]);
	opBl();
	loadFileIframe();
}

function showCoffeBox(){
	view.displayMenuIcon();
	view.$coffe_info_box.stop().fadeTo(250, 1);
	view.setTitle(stringNames[12]); 
	view.$header_line_my_bag.fadeIn(0);
	loadCoffeInfo();
	//loadRateData();
	//loadIncomeData();
}

// function loadFinInfo(){
// 	tagMenuItem('finance_item');
// 	view.displayMenuIcon();
// 	view.$fin_info_box.stop().fadeTo(250, 1);
// 	view.setTitle(stringNames[11]); 
// 	loadRateData();
// 	loadIncomeData();
// }

function loadSettingsBlock(){
	tagMenuItem('settings');
	view.displayMenuIcon();
	view.$settings_box.stop().fadeTo(250, 1);
	view.setTitle(stringNames[2]); 
}

function loadGroupBlock(){
	tagMenuItem('group_info');
	view.displayMenuIcon();
	view.$group_block.stop().fadeTo(250, 1);
	view.setTitle(stringNames[8]);
	loadGroupInfo();
}

function loadCollegueBlock(){
	tagMenuItem('collegue_info');
	view.displayMenuIcon();
	view.$group_block.stop().fadeTo(250, 1);
	view.setTitle(stringNames[15]);
	loadCollegueInfo();
}

function loadDirInfo(){
	tagMenuItem('guide_item');
	view.$dir_info_block.stop().fadeTo(250, 1);
	view.setTitle(stringNames[10]);
	view.displayMenuIcon();
	view.$guide_menu.fadeIn(0);
	view.$guide_menu.find('.current_item').click();

}

function parseHashTag(access){
	
	tagMenuItem('news_item');
	var hash = location.hash;
	$('.news_box').css('display', 'none');
	$newsblock = $('.news_box_details');
	$newsblock.html('').css('display', 'none');
	
	if(hash.substr(0,3) == '#id'){
		
		var id = +hash.replace(/\D+/g,"");
		
		if( typeof(id) === "number" ){
			loadFullNews(id);			
		} else {
			$newsblock.html('Новости с заданным идентификатором не обнаружено.').fadeTo(150, 1);	
		}
				
	} else {
		view.changePage(access);	
	}
}


function loadFullNews(id){
	
	view.setTitle(stringNames[3]);
	view.displayMenuIcon();
	
	myajax(true, 'POST', 'oracle/database_news.php', {news_id: id, type: $('.current_item').attr('newstype')}, false, showFullNews, true, undefined, true);
			
}

function showFullNews(obj){

	if(obj == undefined){
		$('.news_box_details').html('<div class="news_box_exit_button" onclick="history.back();"></div><div class="full_article_news">\
				<div class="full_article_title"> Отсутствует соедиение с интернетом. Новость не была загружена.\
				</div></div>').fadeTo(150, 1).css('height', '100%');
	} else {
		$('.news_box_details').html('<div class="news_box_exit_button" onclick="history.back();"></div><div class="full_article_news">\
				<div class="full_article_title">\
				' + obj.name_news + '\
				</div>\
				<div class="full_article_date">\
				' + obj.date + '\
				</div>\
				<div class="full_article_text">\
				' + (obj.text).replace(/(href=")(\/.*?)(")/, "$1http://www.ugrasu.ru$2$3 target='blank'") + '\
				</div>\
				</div>').fadeTo(150, 1).scrollTop(0);
	}
}		