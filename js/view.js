//экран мобильного приложения представлен в виде объекта view
//свойства объекта - div и span блоки
//методы объекта - функции отображающие или скрывающие определенные div или span блоки 
var view = {
	
	$button:$('.header_line__content_button'),
	$title:$('.header_line__content_title'),
	$second_menu:$('.header_line_addition_wrapper'),
	$auth:$('.authorisation_box'),
	$menu:$('.main_menu'),
	$news:$('.news_box'),
	$full_art:$('.news_box_details'),
	$settings:$('.header_line_content_settings'),
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
		this.$group_block.fadeOut(0);
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
		this.$title.css('display', 'block');
		this.$form.css('display', 'none');
		closeInput();
		this.$cal_button.fadeOut(0);
		closeSidebar();
		clearCurrSidebarItem();
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
			var infBlock = getJSON('auth_inf', (localStorage.auth_inf != undefined));
			if(infBlock.is_student == "0"){
				$('.only_stud').fadeOut(0);
			}
			
			switch(location.hash){
			    
				case '#menu':
					loadMainMenu();
				break;
						
				case '#auth':
					loadAuth();
				break;
						
				case '#news':
				    loadNewsBlock();
				break;
						
				case '#messages':
				
				break;
				
				case '#timetable':
					loadTimetable();
				break;
				
				case '#persinf':
					loadPersonBlock();
				break;
				
				case '#group_info':
					loadGroupBlock();
				break;

				case '#settings':
					loadSettingsBlock();
				break;
				
				default:
					parseHashTag("menu");
				break;
						
					}
			
		} else if(isGuest()){
			
				$('.auth_only').css('display', 'none');
			
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
					
					default:
						parseHashTag("guest");
					break;
								
				}				
			} else {
				view.changePage('auth'); 
				loadAuth();
			} 
			
		this.correctHeight();	
	}
		
}	

//функции загрузки блоков

function loadAuth(){
	sessionStorage.clear();
	localStorage.clear();
	$('.timetable_lessons').html('');
	view.$auth.fadeIn(0);
	view.setTitle(stringNames[0]);
	view.displayArrIcon();
}

function loadMainMenu(){
	
	tagMenuItem('main_item');
	var userInfo = getJSON('auth_inf', (localStorage.auth_inf != undefined));
					
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
	var userInfo = getJSON('guest_inf', (localStorage.guest_inf != undefined));
					
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

function loadTimetable(){
	
	tagMenuItem('timetable_item');
	view.$cal_button.fadeIn(0);
	view.$timetable.stop().fadeTo(250, 1);
	view.$settings.fadeIn();
	view.setTitle(stringNames[5]);
	view.displayMenuIcon();
	view.$search_butt.fadeIn(0).removeClass('opened_input');
	view.$dateline.fadeIn(0);
	
	showCurrentWeek();
	
	if(!issetTimetable()){
		
		if(issetUserGroup()){
			loadTimetableInf();
		} else {
			$('.timetable_lessons').html('');
			showTimetableAlert();
		}
		
	} else {
		
		displayTimetable();
		
	}
}

function loadPersonBlock(){
	tagMenuItem('pers_item');
	view.$persons.stop().fadeTo(250, 1);
	view.$settings.fadeIn();
	view.setTitle(stringNames[4]);
	view.displayMenuIcon();
}

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
	
	var obj = myajax(false, 'POST', 'oracle/database_news.php', {news_id: id});
			
		
			
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