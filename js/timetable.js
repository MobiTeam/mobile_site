/////////////////////////////////////////////
// блок работы с расписанием [18.01.2016]  //
/////////////////////////////////////////////

// проверка наличия расписания в хранилище браузера
///////////////////////////////////////////////////

function issetTimetable() {

	var tmtb = getJSON("timetable");
	return tmtb != "undefined" && tmtb != null && tmtb != undefined;

}

// проверка наличия записи о номере группы 
////////////////////////////////////////////
function issetUserGroup(){

	var uGroup = getJSON("auth_inf").groups[0];
	return uGroup != "undefined" && uGroup != null && uGroup != undefined;

}

// вывод сообщения об ошибке
//////////////////////////////

function showTimetableAlert(){
	$('.timetable_box_info').fadeIn(100);
}

function closeTimetableAlert(){
	$('.timetable_box_info').fadeOut(100); 
}

// понедельник текущей недели
///////////////////////////////

function getCurrentMonday(date) {

	var dt = date || new Date(),
		diff = dt.getDay() == 0 ? -1 : dt.getDay() - 1;
    
    dt.setDate(dt.getDate() - diff);

    return dt;
}

// получение выбранной даты
////////////////////////////////

function getCurrentDate(date){
	$currDate = $('.redTag');
	$userSelectDate = $('.dt1');
	return date = date != undefined ? date : !!$userSelectDate.size() 
							 ? $userSelectDate.attr('date_quer') : !!$currDate.size() 
							 ? $currDate.attr('date_quer') : null;
}


// отрисовка недели в зависимости от переданной даты
/////////////////////////////////////////////////////

function renderWeekTable(date) {

	var dt = date || new Date(),
		currDay = new Date(),
		thisWeekDay = dt;


	currDay.setHours(12, 0, 0, 0);
	thisWeekDay.setHours(12, 0, 0, 0); 	

	dt = getCurrentMonday(dt);

	for(var i = 0; i < 6; i++){
		
		var className = currDay.valueOf() > thisWeekDay.valueOf() ? 'greyTag' 
											  : currDay.valueOf() == thisWeekDay.valueOf() ? 'redTag'
											  : '';
		
	    var curr_date = dt.getDate();
		var curr_day = dt.getDay();
		var curr_month = dt.getMonth() + 1;
		var curr_year = dt.getFullYear();

		$('.dt' + (i + 1)).attr('date_quer', ( curr_date <= 9 ? '0' + curr_date : curr_date ) + '.' + ( curr_month <= 9 ? '0' + curr_month : curr_month ) + '.' + curr_year )
		                  .addClass(className)
						  .html('<span>' + curr_date + ' ' + dateNames[curr_month + 5] + '</span><br><span>' + dateNames[curr_day - 1] + '</span>');
		
		dt.setDate(dt.getDate() + 1);		
		
	}

}

// получить понедельник отрисованной недели
//////////////////////////////////////////////

function getTimetableWeek(toString, diff){
	var rendMondayStr = ($('.dt1').attr('date_quer')).split('.'),
		dt = new Date(rendMondayStr[2] + '/' + rendMondayStr[1] + '/' + rendMondayStr[0] + ' 12:00:00');

	dt.setDate(dt.getDate() + (diff || 0));	
		
	if(toString){
		var day   = dt.getDate() > 9 ? dt.getDate() : "0" + dt.getDate(), 
		    month = dt.getMonth() + 1;

		month = month > 9 ? month : "0" + month;
		return (day + "." + month + "." + dt.getFullYear());
	} 

	return dt;	
}


// загрузка расписания по запросу
//////////////////////////////////

function loadTimetableInf(dataQuery, loadDate){

	$('.timetable_box_info').fadeOut(100);
	
	if (dataQuery == undefined) {
		
		var auth_inf  = getJSON("auth_inf"),
		    group_arr = auth_inf.groups;
		
		if (group_arr.length >= 1) {
			dataQuery = group_arr[0];
			saveValue('query', dataQuery);
		}
		
	} else {
		saveValue('query', dataQuery);
	}

	var sendObj = {"timetable_query" : dataQuery, "date_query" : loadDate || getTimetableWeek(true, 0)};

	myajax(true, 'POST', 'oracle/database_timetable.php', sendObj, false, displayTimetable, false, 'timetable');
	
}


// Анимация строки поиска
///////////////////////////////

function slideInput(){
	$target = $('.header_line_content_search');
	$target.addClass('opened_input');
	$('.timetable_box_form').animate({
		width: '60%'
	}, 150, function(){
		$inp = $('.timetable_box_input');
		$inp.autocomplete("search");
		}).css('display', 'block');
	view.setTitle('');
}

function closeInput(){
	
	$target = $('.header_line_content_search');
	$target.removeClass('opened_input');
			
	$('.timetable_box_form').animate({
		width: '0'
	}, 150, function(){
		
		$(this).css('display', 'none');
		view.$title.fadeIn();
		$('.ui-autocomplete').fadeOut();
		if(location.hash == '#timetable'){
			$('.header_line_content_calendar').fadeIn(0);
			var queryTag = getValue("query");
			if(queryTag != undefined){
				view.setTitle('<span class="full_sentense">По запросу:</span> "' + (queryTag).substr(0,8) + '..."');
			} else view.setTitle(stringNames[5]);
		}
		
	});
}

// отображение расписания по переданной дате [18.01.2016]
///////////////////////////////////////////////////////////

var displayTimetable = function(date){
	
	date = getCurrentDate(date);
	var loadTimeTb = getJSON("timetable");
	
	if(date != undefined && loadTimeTb != "undefined" && loadTimeTb != null){
		
		closeTimetableAlert();
		
		var timetable = loadTimeTb;
		
		if($('.item_ch_1').prop('checked') == undefined){
			
			createHtmlSettings();
			setUserSettings(getValue("settingsCode"));
			
			var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
			
			elems.forEach(function(html) {
				var switchery = new Switchery(html);
			});
		}
		
		if($('.item_ch_1').prop('checked')){
			
			var weekHTMLtimetable = '';
			$('.date_item').each(function(index){
				var chunks = $(this).attr('date_quer').split('.');
				var currClassName = '';
				currClassName = $(this).hasClass('redTag') ? 'current_day' : '';
				weekHTMLtimetable += '<div id="' + $(this).attr('name') + '" class="day_header ' + currClassName + '">' + fullWeekNames[index] + " " + chunks[0] + " " + fullMonthNames[+chunks[1]] + '</div>'; 
				weekHTMLtimetable += createTimetableHTML($(this).attr('date_quer'), timetable);
			});
			
			$('.timetable_lessons').html(weekHTMLtimetable).css('display','none').fadeIn(250);
			
			setTimeout(clickByActualDate(), 100);
			
		} else {
			$('.timetable_lessons').html(createTimetableHTML(date, timetable)).css('display','none').fadeIn(250);
		}


				
	} else {
		showTimetableAlert();
	}

	view.correctHeight();

}

// открыть актуальное расписание [18.01.2016]
///////////////////////////////////////////////

function clickByActualDate(){
	var issetEl = $('.redTag').size();
	if(issetEl){
		$('.redTag').click();
	} else {
		$('.dt1').click();
	}	 			
}

// создание каркаса расписания
/////////////////////////////////

function createTimetableHTML(date, timetable, showEmptyFields){
	
	showEmptyFields = $('.item_ch_2').prop('checked');
	
	var dateNumbers = date.replace(/\./g,''),
		timetableHTML = '<table class="timetable_style">',
		notNameQuery = issetNumbersInQuery(getValue("query"));
	
	if(!!timetable[dateNumbers]){
		var firstNumLesson = 0;
		var twoLessonsInOneTime = false;
		
		for(var i = 1, numLession = 6; i <= numLession; i++) {
			
			var item = timetable[dateNumbers][firstNumLesson];
			
			if (+item.PAIR == i) {
				
				if((item.KORP).toLowerCase() == 'сок' && notNameQuery){
							
							timetableHTML += '<tr class="timetable_tr">\
											<td class="date_td">' + numLessonsArr[i] + '</td>\
											<td class="' + getColorTypeLesson(item.VID) + '" >\
											<span class="timetable_disp">' + item.DISCIPLINE + '</span><br>';
											
							var counter = 0;
									
						    while((item.KORP).toLowerCase() == 'сок'){
								
								if (counter == 0){
									timetableHTML += '<div class="hide_timetable_information">';
								}
								
								
								item = timetable[dateNumbers][firstNumLesson];
								if((item.KORP).toLowerCase() == 'сок'){
									
								
									timetableHTML += '<span class="timetable_place">' + (item.VID).toLowerCase() + ' ' + (item.SUBGRUP != null ? ' (' + item.SUBGRUP + ' п/г) ' : '') + item.AUD + '/' + item.KORP + '</span> <br> \
												<span class="timetable_fio"><span class="found_by_sel_text">' + item.TEAC_FIO + '</span></span><br>';
									counter++;
									
								}
								
								firstNumLesson++;
								if (firstNumLesson == timetable[dateNumbers].length - 1){
									break;
								}	
							
							} 
							
								timetableHTML += '</div>';
							
							if(counter > 1) {
								timetableHTML += '<input class="hide_information_button" type="button" value="Развернуть" />';
							}
							
							timetableHTML += '</td>\
										   </tr>';
							firstNumLesson --;
								
					}  else {
												
						if (firstNumLesson < timetable[dateNumbers].length - 1){
							firstNumLesson++;
							if (+item.PAIR == timetable[dateNumbers][firstNumLesson]['PAIR']){
									i--;
									if(item.GR_NUM == timetable[dateNumbers][firstNumLesson]['GR_NUM']) twoLessonsInOneTime = true;	
							} 
						}		
					
						if(twoLessonsInOneTime == undefined){
							timetableHTML += '<tr class="timetable_tr">\
											<td class="' + getColorTypeLesson(item.VID) + '" >\
											<span class="timetable_disp">' + item.DISCIPLINE + '</span><br>\
											<span class="timetable_place">' + (item.VID).toLowerCase() + ' ' + item.AUD + '/' + item.KORP + (notNameQuery == false ? ' - гр ' + item.GR_NUM : '') + (item.SUBGRUP != null ? ' (' + item.SUBGRUP + ' п/г) ' : '') + '</span><br>\
											<span class="timetable_fio"><span class="found_by_sel_text">' + item.TEAC_FIO + '</span></span><br>\
											</td>\
										  </tr>';
							twoLessonsInOneTime = false;			  
						} else {
							
							if(twoLessonsInOneTime){
								num = i + 1;
							} else {
								num = i;
							} 
							
							timetableHTML += '<tr class="timetable_tr">\
											<td class="date_td" ' + (twoLessonsInOneTime ? 'rowspan="2"' : '') + '>' + numLessonsArr[num] + '</td>\
											<td class="' + getColorTypeLesson(item.VID) + '">\
											<span class="timetable_disp">' + item.DISCIPLINE + '</span><br>\
											<span class="timetable_place">' + (item.VID).toLowerCase() + ' ' + item.AUD + '/' + item.KORP + (notNameQuery == false ? ' - гр ' + item.GR_NUM : '') + (item.SUBGRUP != null ? ' (' + item.SUBGRUP + ' п/г) ' : '') + '</span><br>\
											<span class="timetable_fio"><span class="found_by_sel_text">' + item.TEAC_FIO + '</span></span><br>\
											</td>\
										  </tr>';						
						}
						
						twoLessonsInOneTime = twoLessonsInOneTime ? undefined : false;	
										
					}
				
			} else if (showEmptyFields) {
				
				timetableHTML += '<tr class="timetable_tr">\
										<td class="date_td">' + numLessonsArr[i] + '</td>\
										<td></td>\
									  </tr>';
				
			}
			
		}		
		
		timetableHTML += '</table>';
		
	} else {
			timetableHTML = '<span class="no_lessons">Занятий нет.</span>';
		} 
	
	return timetableHTML;
	
}