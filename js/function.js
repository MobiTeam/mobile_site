var loadRateData = function(){

	var allInf = getJSON('auth_inf', (localStorage.auth_inf != undefined));
	var rateInf = getJSON('user_rate_info', (localStorage.auth_inf != undefined));
	
	if(rateInf == undefined){
		myajax(true, "POST", "oracle/database_dol.php",  {hash : allInf.hash, FIO : allInf.FIO}, false, genRateHtml, true, "user_rate_info");
	} else {
		genRateHtml();
	}

}

var loadIncomeData = function(){

	var allInf = getJSON('auth_inf', (localStorage.auth_inf != undefined));
	/*var rateInf = getJSON('user_rate_info', (localStorage.auth_inf != undefined));

	if(rateInf == undefined){
		myajax(true, "POST", "oracle/database_dol.php",  {hash : allInf.hash, FIO : allInf.FIO}, false, genRateHtml, true, "user_rate_info");
	} else {
		genRateHtml();
	}*/

}

var toogleShowBlock = function(className, statClass){
	$el = $('.' + className);

	if($el.css('display') == "none"){
		$('.' + statClass).html("свернуть");
	} else $('.' + statClass).html("развернуть");

	$el.toggle(100);
}

var genRateHtml = function(obj){

	if(obj != undefined){
		setJSON("user_rate_info", obj, $('.save_password').prop('checked'));
	} else {
		obj = getJSON('user_rate_info', (localStorage.auth_inf != undefined));
	}
	
	var rateHtml = "<div class='fin_block_inform'>";

	if(obj.length == 0){
		rateHtml += "Данные отсутствуют.";
	} else {
		for(var i = 0; i < obj.length; i++){
			rateHtml += "<div class='rate_box contr_shadow'>";
			rateHtml += "<div class='rate_box_head'><b>" + (i + 1) +") " + obj[i].type + "</b></div>";
			rateHtml += "<div class='dog_wrapper'><div class='rate_box_img'></div>";
			rateHtml += "<div class='dog_name'>Договор: " + (obj[i].Numdog == null ? "-" : obj[i].Numdog) + "<br></div></div>";
			rateHtml += "<div class='rate_box_middle'>";
			rateHtml += "Остаток (кон. мес.): " + (obj[i].Ostatok_LA == null ? "-" : obj[i].Ostatok_LA) + "<br>";
			rateHtml += "<span style='color: red;'>Начислено: " + (obj[i].Nachisl == null ? "-" : obj[i].Nachisl) + "</span><br>";
			rateHtml += "<span style='color: green;'>Оплата: " + (obj[i].Oplata == null ? "-" : obj[i].Oplata) + "</span><br>";
			rateHtml += "Остаток: " + (obj[i].Ostatok == null ? "-" : obj[i].Ostatok) + "</div><div style='clear:both;'></div>";
			rateHtml += "<div class='rate_footer'>Дата обновления: " + obj[i].Date + "</div>";
			rateHtml += "</div>";
		}
	}

	rateHtml += "</div>"

	$('.fin_info_box_menu_rate').html(rateHtml);
} 


var showTeachContacts = function(obj){
	
	var personHTML = "Результаты поиска (" + obj.length + "):";
	for (var i = 0; i < obj.length; i++) {
		personHTML += "<div class='person_contacts_info contr_shadow'>";
		personHTML += "<div class='person_contacts_header'><b>" + obj[i].fio + "</b><br><b class='grey_bold_text'>email: " + (obj[i].email == null ? "нет" : obj[i].email) + "</b></div>";
		personHTML += "<div class='person_contacts_img'></div>";
		personHTML += "<div class='person_contacts_middle'>" + obj[i].dol + "<br>«" + obj[i].podr + "»</div>";
		personHTML += "<div style='clear:both'></div>";
		personHTML += "<div class='person_contacts_footer'><span class='phone_block'>тел: " + (obj[i].phone == null ? " - " : obj[i].phone) + "</span> <span class='cabinet_block'>кабинет: " + (obj[i].korp == null ? " - " : obj[i].korp) + "</span><div style='clear:both;'></div></div>"
		personHTML += "</div>";
		

	};

	$('.guide_item_search_result').html(personHTML);
}


var displayTimetable = function(date){
	
	date = getCurrentDate(date);
						 
	if(date != undefined && sessionStorage.timetable != "undefined"){
		
		closeTimetableAlert();
		
		var timetable = JSON.parse(sessionStorage.timetable);
		
		if($('.item_ch_1').prop('checked') == undefined){
			createHtmlSettings();
			setUserSettings(+localStorage.settingsCode);
			
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
			
			$('.timetable_lessons').html(weekHTMLtimetable).css('display','none').fadeIn(120);
			
			setTimeout(function(){
				$('.redTag').click();
			}, 100);
			
		} else {
			$('.timetable_lessons').html(createTimetableHTML(date, timetable)).css('display','none').fadeIn(120);
		}


				
	} else {
		showTimetableAlert();
	}						 
	view.correctHeight();
}

var getAuthInfo = function(infoObj){
			
			authObj = infoObj;
						
			if (authObj.FIO != "undefined"){
				setJSON("auth_inf", authObj, $('.save_password').prop('checked'));
				
				$('.authblock').css('display','inline-block');	
				
				localStorage.settingsCode = authObj.settings;
					
			}
			view.changePage('menu');
			showTooltip(authObj.serverRequest, 2000);
			
			createHtmlSettings();
			setUserSettings(+localStorage.settingsCode);
			
			var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
			
			elems.forEach(function(html) {
				var switchery = new Switchery(html);
			});
	
}

function tryAutorisate(userData){
	return myajax(true, 'POST', 'mobile_reciever.php', userData, false, getAuthInfo, true);
}


// открытие/закрытие фона заглушки
function opBl(){ 
	$('#overlay').css('display', 'block'); 
}

function clBl(){
	
    $('#overlay').css('display', 'none'); 
	
}

function opMenBl(){ 
	$('.menuoverlay').css('display', 'block');
}

function clMenBl(){
	$('.menuoverlay').css('display', 'none');
}

//загрузка с сервера [boolean, string, string, object, boolean, callback, boolean, string]
function myajax(async, type, url, data, notResponse, functionCallBack, issetArgs, savePlace){ 
	
	var jsonObj;
	opBl();
	
			$.ajax({
			async: async,
			type: type,
			url: url,
			data: data,
			success: function(responseTxt){
				
				if(notResponse == undefined || !notResponse){
					var clrResp = clearUTF8(responseTxt);

					try {
						jsonObj = JSON.parse(clrResp);
					} catch(e){
						showTooltip(errMessages[0], 2000);
					}
				}
				
				if(functionCallBack != undefined) {
					
					if(issetArgs == undefined || !issetArgs){
						setJSON(savePlace, jsonObj, false);
						functionCallBack();
					} else {
						functionCallBack(jsonObj);
					}
					return;
				}
				
			},
			error: function(){
				showTooltip(errMessages[1], 2000);
			},
			complete: function(){
				clBl();
			}
		});
		
	return jsonObj; 		
}

// проверка на авторизацию
function isAuth(){
	if(localStorage.auth_inf != undefined || sessionStorage.auth_inf != undefined){
		return true;
	} 
	return false;
}

function isGuest(){
	if(localStorage.guest_inf != undefined || sessionStorage.guest_inf != undefined){
		return true;
	} 
	return false;
}

//скрыть предзагрузочный экран
function hideLoader(){
	$('.pre_loader').fadeOut(200);
}

// показать Tooltip
function showTooltip(toolText, duration){
	
	var dur = duration!=undefined ? duration: 1000;
	
	$tooltip = $('.tooltip');
	$tooltip.fadeIn(200).html(toolText);
	
	setTimeout(function(){
		$tooltip.fadeOut(200);
	}, dur);
	
}

// сохранение JSON в localStorage/sessionStorage
function setJSON(key, value, flag) {
	try {   
	        if(flag == true){
				localStorage[key] = JSON.stringify(value);				
			} else {
				if(sessionStorage[key] == undefined || sessionStorage[key] == "undefined"){
					sessionStorage[key] = JSON.stringify(value);
				} else {
					sessionStorage[key] = JSON.stringify($.extend(JSON.parse(sessionStorage[key]), value));
				}
			}
			
		} catch(ex){
					
		}
}

// получение JSON из localStorage/sessionStorage
function getJSON(key, flag) {
	
	var value;
	
	if(flag == true){
		value = localStorage[key];				
	} else {
		value = sessionStorage[key];
	}
	
	return value ? JSON.parse(value) : null;
}

// удаление BOM символов из строки
function clearUTF8(str) {
	
	var clrStr = '';
	var i = 0;
	
	while(str[i] != '{' && str[i] != '[' && i<20){
		i++;
	} 
	
	clrStr = str.substr(i, str.length);
	return clrStr;
}

function newsWrap(obj, append){
	
	$newsblock = $('.news_box');
	var resHtml = '';
	
	for(var i = 0; i < obj.length; i++){
		
		var id = obj[i].type == '3' ? 'default_bg' : obj[i].id;
		
		var imglink = 'news/pre_images/img_' + id + '.jpg';
		resHtml += '<div class="news_box_item contr_shadow" onclick="loadDetails(' + obj[i].id + ');" idnews="' + obj[i].id + '">\
						  <div class="news_box_item_image" style="background-image:url(' + imglink + ');">\
						  </div>\
						  <div class="news_box_item_text">\
						  <div class="news_box_item_title">\
						  ' + obj[i].name_news + '\
						  </div>\
						  '	+ obj[i].descr + 
						  '</div>\
						  <div style="clear:both"></div>\
						  </div>';
		} 
		
		$newsblock.html('').css('display', 'none');
		
		if(append != undefined && append == true){
			$newsblock.append(sessionStorage['news_' + $('.current_item').attr('newstype')] + resHtml).fadeTo(0, 1);
			sessionStorage['news_' + $('.current_item').attr('newstype')] += resHtml;	
		} else {
			$newsblock.html(resHtml).fadeTo(250, 1);
			sessionStorage['news_' + $('.current_item').attr('newstype')] = view.$news.html();	
		}
		
}

function closeSidebar(){
	$("html,body").css("overflow","");
	$('.menuoverlay').stop().fadeTo(250, 0);
		$menuBlock = $('.sidebar_menu_block');
		$menuBlock.removeClass('contr_shadow')
				       .animate({ 'margin-left': '-' + $menuBlock.css('width')
									}, 250, function(){
										$('.menuoverlay').css('display','none');
										$menuBlock.removeClass('fixed_block').css('display','none');
									});	
}

function openSidebar(){
	$("html,body").css("overflow","hidden");
	$('.menuoverlay').stop().fadeTo(250, 0.6);	
			$('.sidebar_menu_block').css('display','block')
									.addClass('contr_shadow')
									.addClass('fixed_block')
									.animate({
										'margin-left': "0px"
									}, 150);	
}

function loadDetails(id){
	
	location.hash = '#id' + id;
	
}

function saveAndShow(){
	
	if(sessionStorage['news_' + $('.current_item').attr('newstype')] == undefined){
		//придумать callback функцию
		//myajax(async, type, url, data, notResponse, functionCallBack, issetArgs, savePlace)
		myajax(true, 'POST', 'oracle/database_news.php', {type: $('.current_item').attr('newstype')}, false, newsWrap, true);
		
	} else {
		opBl();
		view.$news.html(sessionStorage['news_' + $('.current_item').attr('newstype')]).fadeTo(50, 1);
		clBl();
	}

}

function clearCurrSidebarItem(){
	$('.sidebar_menu_block_menu_item').each(function(){
		$(this).removeClass('sidebar_menu_block_menu_item_curr');
	});
}

function tagMenuItem(className){
	$('.' + className).addClass('sidebar_menu_block_menu_item_curr');
}

function showCurrentWeek(date){
	
	var dt = date == undefined ? new Date() : date;
	var currDay = new Date();
	var thisWeekDay = dt;
	
	currDay.setHours(12, 0, 0, 0);
	thisWeekDay.setHours(12, 0, 0, 0); 

	var diff = dt.getDay() == 0 ? -1 : dt.getDay() - 1;

	dt.setDate(dt.getDate() - diff);
	
	for(var i = 0; i < 6; i++){
		

		//разобраться с датами
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

function getFirstWeekDay(notStr, thisDate) {

	var dt = thisDate == undefined ? new Date() : thisDate;
	var diff = dt.getDay() == 0 ? -1 : dt.getDay() - 1;
	dt.setDate(dt.getDate() - diff);
	
	if(notStr != undefined && notStr == true){
		return dt;
	}
	
	var day = dt.getDate() > 9 ? dt.getDate() : "0" + dt.getDate();
	var month = dt.getMonth() + 1;
	month = month > 9 ? month : "0" + month;
	return (day + "." + month + "." + dt.getFullYear());

}

function issetTimetable(){
	return sessionStorage.timetable != undefined;
}

function getTimetableWeek(diff, onlyDate, returnStr){
	
	var str = ($('.dt1').attr('date_quer')).split('.');
	var dt = new Date(str[2] + '/' + str[1] + '/' + str[0] + ' 12:00:00');
	
	dt.setDate(dt.getDate() + diff);
	
	if(onlyDate){
		if(returnStr){
			var day = dt.getDate() > 9 ? dt.getDate() : "0" + dt.getDate();
			var month = dt.getMonth() + 1;
			month = month > 9 ? month : "0" + month;
			return (day + "." + month + "." + dt.getFullYear());
		} else return dt;
	}
	
	if (localStorage.lastTmtQuery != undefined){
		loadTimetableInf(localStorage.lastTmtQuery, getFirstWeekDay(false, dt), true);
	} else {
		showTimetableAlert();
	}  
}

function loadTimetableInf(dataQuery, loadDate, changeWeek){
	$('.timetable_box_info').fadeOut(100);
	
	if (dataQuery == undefined){
		var auth_inf = getJSON('auth_inf', (localStorage.auth_inf != undefined));
		var group_arr = auth_inf.groups;
		
		if(group_arr.length >= 1){
			dataQuery = group_arr[0];
			sessionStorage.query = dataQuery;
		}
		
	}

	localStorage.lastTmtQuery = dataQuery;
	if(changeWeek){
		myajax(true, 'POST', 'oracle/database_timetable.php', {"timetable_query" : dataQuery, "date_query" : loadDate != undefined ? loadDate : getTimetableWeek(0, true, true)}, false, chWeek, true, 'timetable');
	} else myajax(true, 'POST', 'oracle/database_timetable.php', {"timetable_query" : dataQuery, "date_query" : loadDate != undefined ? loadDate : getTimetableWeek(0, true, true)}, false, displayTimetable, false, 'timetable');

}

function chWeek(respTxt) {
	
	if(Object.keys(respTxt).length == 0){
		$('.timetable_lessons').html('');
		showTooltip("Расписание на следующую неделю еще не готово", 4500);
		displayTimetable();
	} else { 
		showCurrentWeek(getTimetableWeek(parseInt(sessionStorage.diffDate), true));
		setJSON('timetable', respTxt, false);
		displayTimetable();
		closeTimetableAlert();
	} 
}

function issetUserGroup(){
	return localStorage.user_inf == undefined && sessionStorage.user_inf == undefined;
}

function showTimetableAlert(){
	$('.timetable_box_info').fadeIn(100);
}

function closeTimetableAlert(){
	$('.timetable_box_info').fadeOut(100); 
}

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
			if(sessionStorage.query != undefined){
				view.setTitle('<span class="full_sentense">По запросу:</span> "' + (sessionStorage.query).substr(0,8) + '..."');
			} else view.setTitle(stringNames[5]);
		}
		
	});
}

function loadGroupInfo(){

	var allInf = getJSON('auth_inf', (localStorage.auth_inf != undefined));
	var groupsArr = allInf.groups;
	
	if(sessionStorage.groups_students == undefined){
		myajax(true, "POST", "oracle/database_group_student.php", {groups: groupsArr, hash : allInf.hash, FIO : allInf.FIO}, false, showGroupInfo, false, "groups_students");
	} else {
		showGroupInfo();
	}
	
}

function showGroupInfo(){
	
	var groupsStud = getJSON('groups_students', (localStorage.groups_students != undefined));
	var htmlCode = "";

	for(var key in groupsStud){
		var group = groupsStud[key];
		htmlCode += "<span class='group_name_header'>Группа: " + group.number + "</span>";
		for (var i = 0; i < group.fio.length; i++) {

			htmlCode += "<div class='group_student_line " + (group.sex[i] == "М" ? "man_student" : "girl_student" ) + "'>" + (i + 1) + ") " + group.fio[i] + "</div>";
		};	
	}

	view.$group_block.html(htmlCode);
	
}

function issetNumbersInQuery(query){
	return !!query.match(/\d/g);
}

function createTimetableHTML(date, timetable, showEmptyFields){
	
	showEmptyFields = $('.item_ch_2').prop('checked');
	
	var dateNumbers = date.replace(/\./g,''),
		timetableHTML = '<table class="timetable_style">',
		notNameQuery = issetNumbersInQuery(sessionStorage.query);
	
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
							/* var num = twoLessonsInOneTime || !(item.GR_NUM == timetable[dateNumbers][firstNumLesson]['GR_NUM']) ? i+1 : i; */
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

function getCurrentDate(date){
	$currDate = $('.redTag');
	$userSelectDate = $('.greenTag');
	return date = date != undefined ? date : !!$userSelectDate.size() 
							 ? $userSelectDate.attr('date_quer') : !!$currDate.size() 
							 ? $currDate.attr('date_quer') : null;
}

function getColorTypeLesson(typeLesson) {
	switch(typeLesson.toLowerCase()) {
		case 'лек':
			return 'green_td_tag';
		break;
		
		case 'у':
		case 'п':
		case 'лб':
		case 'пр':
		case 'консул':
		case 'кст':
			return 'orange_td_tag';
		break;
		
		case 'кп':
		case 'зачет':
		case 'тест':
		case 'кр':
		case 'экзам':
			return 'red_td_tag';
		break;
	}
}


function setUserSettings(settingsCode) {
	
	var binarCode = "" + (settingsCode == undefined ? (0).toString(2) : (+settingsCode).toString(2));
	
	var num = $('[class *= "item_ch"]').size();
	 
	for(i = 0; i < num - binarCode.length; i++){
		binarCode = "0" + binarCode; 	
	}
	 
	$('[class *= "item_ch"]').each(function(index, value){
		if (binarCode[index] == "1") {
			$(this).attr("checked", true);
			$('.word_stat' + (index + 1)).text("Вкл.");
		} else {
			$(this).attr("checked", false);
			$('.word_stat' + (index + 1)).text("Выкл.");
		}
	});	
	
}

function createHtmlSettings() {
	
	var htmlSettings = '';
	for (var i = 0; i < settingsTitle.length; i++) {
		htmlSettings += '<div class="settings_box_inputs"><div class="settings_box_inputs_item">\
							<div class="settings_box_inputs_item_text">'
								+ settingsTitle[i] + 
								'<br><span class="settings_box_inputs_item_button_status word_stat' + (i + 1) + '"></span>\
							</div>\
							<div class="settings_box_inputs_item_button">\
								<input class="item_ch_' + (i + 1) + ' js-switch" onchange="changeStatus(this, ' + (i + 1) + ')"  type="checkbox" name="item_ch_' + (i + 1) + '" checked>\
							</div>\
							<div style="clear:both;"></div>\
						</div></div>'
	}
							
	$('.settings_box_inputs').html(htmlSettings);				
	
}

function changeStatus(thisObj, num) {
	var str = thisObj.checked ? "Вкл." : "Выкл.";
	$('.word_stat' + num).text(str);
}