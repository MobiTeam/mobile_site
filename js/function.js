///////////////////////////////////////////
// работа с хранилищем данных 15.01.2016 //
///////////////////////////////////////////

// сохранять данные в постоянную или переменную сессию
function remMe(){
	return localStorage.auth_inf != undefined || $('.save_password').prop('checked');
}

// сохранение JSON в localStorage/sessionStorage
function setJSON(key, value) {

	var flag = remMe();

	try {   
	    if(flag == true){
	        if(localStorage[key] == undefined || localStorage[key] == "undefined"){
				localStorage[key] = JSON.stringify(value);
			} else {
				localStorage[key] = JSON.stringify($.extend(JSON.parse(localStorage[key]), value));
			}			
		} else {
			if(sessionStorage[key] == undefined || sessionStorage[key] == "undefined"){
				sessionStorage[key] = JSON.stringify(value);
			} else {
				sessionStorage[key] = JSON.stringify($.extend(JSON.parse(sessionStorage[key]), value));
			}
		}			
	} catch(ex){}
}

// получение JSON из localStorage/sessionStorage
function getJSON(key) {
	
	var value, 
		flag = remMe();
	
	if(flag == true){
		value = localStorage[key];				
	} else {
		value = sessionStorage[key];
	}
	
	if(value == undefined || value == "undefined"){
		return null;
	} else {
		return JSON.parse(value)
	}
	
}

// получение значения переменной из localStorage/sessionStorage
function getValue(key){

	var flag = remMe();

	if(flag == true){
	 	return localStorage[key];
	} else {
	 	return sessionStorage[key];
	}
}

// запись переменной в localStorage/sessionStorage
function saveValue(key, value){

	console.log(key + ' saved');
	var flag = remMe();

	 if(flag == true){
	 	localStorage[key] = value;
	 } else {
	 	sessionStorage[key] = value;
	 }
}

/////////////////////////////////////////
// проверка на авторизацию  15.01.2016 //
/////////////////////////////////////////


function isAuth() {
	if(localStorage.auth_inf != undefined || sessionStorage.auth_inf != undefined){
		return true;
	} 
	return false;
}

function isGuest() {
	if(localStorage.guest_inf != undefined || sessionStorage.guest_inf != undefined){
		return true;
	} 
	return false;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// унифицированная обертка на функцию $.ajax [boolean, string, string, object, boolean, callback, boolean, string, boolean] 28.01.2016 //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function myajax(async, type, url, data, notResponse, functionCallBack, issetArgs, savePlace, doAfterErr){ 
	
	opBl();
	var jsonObj;
		
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
						if(responseTxt.length > 5) {
							setJSON(savePlace, jsonObj);
						}
						functionCallBack();
					} else {
						functionCallBack(jsonObj);
					}
					
				}
			},
		error: function(){

			if(doAfterErr){
				functionCallBack();
			}

			showTooltip(errMessages[1], 3000);

		},
		complete: function(){
			clBl();
		}
	});

	return jsonObj;
	
}

var dishes = [];

function loadTeachInformation(hash, FIO){
	
	var teachInfoApp = getJSON('teachInfo_app');
	var teachInfoLoad = getJSON('teachInfo_load');
	var teachHolidayInfo = getJSON('teachHolidayInfo');

	if(teachInfoApp == undefined){
		myajax(true, "POST", "oracle/database_full_appoint_teac.php",  {hash : hash, FIO : FIO}, false, showTeachAppoint, false, "teachInfo_app");
	} else {
		showTeachAppoint();
	}

	if(teachInfoLoad == undefined){
		myajax(true, "POST", "oracle/database_nagruzka_teac.php",  {hash : hash, FIO : FIO}, false, showTeachLoad, false, "teachInfo_load");
	} else {
		showTeachLoad();
	}

	if(teachHolidayInfo == undefined){
		myajax(true, "POST", "oracle/database_holiday_teach.php",  {hash : hash, FIO : FIO}, false, showTeachHoliday, false, "teachHolidayInfo");
	} else {
		showTeachHoliday();
	}



}


function loadStudentInformation(hash, FIO, groups){
	
	var studInfoApp = getJSON('studInfo_app');
	var studInfoLoad = getJSON('studInfo_load');
	var studInfoMarks = getJSON('studInfo_marks');

	if(studInfoApp == undefined){
		myajax(true, "POST", "oracle/database_full_appoint_student.php",  {hash : hash, FIO : FIO}, false, showStudAppoint, false, "studInfo_app");
	} else {
		showStudAppoint();
	}

	if(studInfoLoad == undefined){
		myajax(true, "POST", "oracle/database_object_student.php",  {hash : hash, FIO : FIO, groups: groups}, false, showStudLoad, false, "studInfo_load");
	} else {
		showStudLoad();
	}

	if(studInfoMarks == undefined){
		myajax(true, "POST", "oracle/database_marks_student.php",  {hash : hash, FIO : FIO, groups: groups}, false, showStudMarks, false, "studInfo_marks");
	} else {
		showStudMarks();
	}


}

function showTeachAppoint(){
	var appoint = getJSON('teachInfo_app');
	var htmlCode = "";

	if(!appoint) return;
	//$('.person_box_menu_app').html(JSON.stringify(appoint));

	for(var i = 0; i < appoint.length; i++){
		htmlCode += "<div class='rate_box contr_shadow'>";
		htmlCode += "<div class='rate_box_head'><b>Должность: " + appoint[i].Post + " [" + appoint[i].Rate + "]</b></div>";
		htmlCode += "<div class='rate_box_middle' style='width:100%; float:none;box-sizing: border-box; padding: 10px; margin-top: 0px;'>\
		<b>Отдел:</b> " + appoint[i].Inst + "<br><b>Признак:</b> " + appoint[i].Prizn + "<br>\
		<b>Бюджет:</b> " + appoint[i].Bud + "</div>";
		
		htmlCode += "<div style='clear:both'></div><div class='rate_footer'>Дата договора: " + appoint[i].Reg + "</div>";
		htmlCode += "</div>";
	}

	$('.person_box_menu_app').html(htmlCode);
}

function showTeachLoad(){

	var htmlCode = "<div style='margin-bottom: 10px;'><b style='color:grey;margin: 5px;'>Семестр:</b><select style='padding: 3px; border: 1px solid #BDBDBD;' onchange='getTeachLoadbySem()' class='selected_load_sem'><option val='Осень' selected>Осень</option><option val='Зима'>Зима</option></select></div>";
	$('.person_box_menu_load').html(htmlCode + "<div class='teach_load_sem'></div>");
	getTeachLoadbySem();

}

function showTeachHoliday(){

	var holidays = getJSON('teachHolidayInfo');
	var htmlCode = "";
	if(!holidays) return;
	//$('.person_box_menu_hol').html(JSON.stringify(holidays));

	for(var i = 0; i < holidays.length; i++){
		htmlCode += "<div class='rate_box contr_shadow' style='margin-top:10px'>";
		htmlCode += "<div class='rate_box_head'><b>Должность:</b> " + holidays[i].dol + "</div>";
		htmlCode += "<div class='rate_box_middle' style='width:100%; float:none;box-sizing: border-box; padding: 10px; margin-top: 0px;'>\
		<b>Отдел:</b> " + holidays[i].podr + "<br><b>Дата начала:</b> " + holidays[i].date_beg + "<br><b>Дата окончания:</b> " + holidays[i].date_end + "<br></div>";
		
		if(holidays[i].ligot == "1") htmlCode += "<div style='clear:both'></div><div class='rate_footer' style='color:#4E4E4E;'><b>Сумма возврата:</b> " + holidays[i].summa + " <b>Количество иждевенцев:</b> " + holidays[i].child + "</div>";
		htmlCode += "</div>";
	}

	$('.person_box_menu_hol').html(htmlCode);

}

function getTeachLoadbySem(){

	var loadJS = getJSON('teachInfo_load');
	var htmlCode = "";
	var currSem = $('.selected_load_sem').val();
    if(!loadJS) return;
	for(var i = 0; i < loadJS.length; i++){

		if(loadJS[i].Sezon === currSem){
			htmlCode += "<div class='rate_box contr_shadow'>";
			htmlCode += "<div class='rate_box_head'><b>Предмет: " + loadJS[i].Subj + " [" + loadJS[i].Sezon + " " + loadJS[i].Year + " г.]</b></div>";
			htmlCode += "<div class='rate_box_middle' style='width:100%; float:none;box-sizing: border-box; padding: 10px; margin-top: 0px;'>\
			<b>Группа:</b> " + loadJS[i].Group + " (" + loadJS[i].Course_gr + " курс)<br><b>Количество студентов:</b> " + loadJS[i].Group_count + "<br>\
			</div>";
			
			htmlCode += "<div style='clear:both'></div><div class='rate_footer'><b style='color:brown;'>Нагрузка:</b> " + loadJS[i].Itog + " часов</div>";
			htmlCode += "</div>";
		}
		
	}

	$('.teach_load_sem').html(htmlCode == "" ? "Занятий по данному критерию не найдено." : htmlCode);
}

function showStudLoad(){
	var load = getJSON('studInfo_load');
	var htmlCode = "";
    if(!load) return;
	for(var i = 0; i < load.length; i++){

			htmlCode += "<div class='rate_box contr_shadow'>";
			htmlCode += "<div class='rate_box_head'><b>" + load[i].Disclipline + " [" + load[i].Type + "]</b></div>";
			htmlCode += "<div class='rate_box_middle' style='width:100%; float:none;box-sizing: border-box; padding: 10px; margin-top: 0px;'>\
			<b>Группа:</b> " + load[i].group + " (" + load[i].Semestr + " семестр)</div>";
			
			htmlCode += "<div style='clear:both'>";
			htmlCode += "</div></div>";
				
	}

	$('.person_box_menu_ses').html(htmlCode);

}

function showStudMarks(){

	var userInfo = getJSON('auth_inf')['groups'];
	var groupsOptions = "";
    if(!userInfo) return;
	for(var i = 0; i < userInfo.length; i++){
		groupsOptions += "<option value='" + userInfo[i] + "'>" + userInfo[i] + "</option>";
	}

	var marks = getJSON('studInfo_marks');
    var semArr = [];
    var semArrOption = "";

	for(var group in marks){
		for(var i = 0; i < marks[group].length; i++){
			if(semArr.indexOf(marks[group][i].semestr) == -1){
				semArr.push(marks[group][i].semestr);
			}
		}
	}

	for(var i = 0; i < semArr.length; i++){
		if(i == semArr.length - 1){
			semArrOption += "<option value='" + semArr[i] + "' selected>" + semArr[i] + "</option>";
		} else semArrOption += "<option value='" + semArr[i] + "'>" + semArr[i] + "</option>";
	}


	

	var htmlCode = "<div style='margin-bottom: 10px;'><b style='color:grey;margin: 5px;'>Группа:</b><select style='padding: 3px; border: 1px solid #BDBDBD;' onchange='createHTMLMarks()' class='selected_load_mks_gr'>" + groupsOptions + "</select></div>";
	htmlCode += "<div style='margin-bottom: 10px;'><b style='color:grey;margin: 5px;'>Семестр:</b><select style='padding: 3px; border: 1px solid #BDBDBD;' onchange='createHTMLMarks()' class='selected_load_mks_sem'>" + semArrOption + "</select></div>";
	$('.person_box_menu_als').html(htmlCode + "<div class='teach_load_mks'></div>");

	createHTMLMarks();

}

function createHTMLMarks(){
	
	var htmlCode = "";
	var marks = getJSON('studInfo_marks');
	if(!marks) return;
	var currSem = $('.selected_load_mks_sem').val();
	var currGroup = $('.selected_load_mks_gr').val();

	for(var group in marks){

		for(var i = 0; i < marks[group].length; i++){

			if(marks[group][i].group != currGroup) break;

			if(marks[group][i].semestr == currSem){
				
				htmlCode += "<div style='border-bottom: 1px dashed grey; padding: 3px;'><b>" + marks[group][i].type + ":</b> " + marks[group][i].discipline + " <span style='color:brown'><b>[" + (marks[group][i].mark == 1 ? "Зачет" : marks[group][i].mark <= 0 ? "Не сдан" : marks[group][i].mark) + "]</span></b></div>";
										
			}
			
		}
	}

	$('.teach_load_mks').html("<div class='rate_box contr_shadow'><div class='rate_box_middle' style='width:100%; float:none;box-sizing: border-box; padding: 10px; margin-top: 0px;'>" + htmlCode + "</div></div>");	
}


function showStudAppoint(){
	var appoint = getJSON('studInfo_app');
	var htmlCode = "";
	if(!appoint) return;
	for(var i = 0; i < appoint.length; i++){
		htmlCode += "<div class='rate_box contr_shadow'>";
		htmlCode += "<div class='rate_box_head'><b>Номер зачетной книжки: " + appoint[i].Tabnmb + "</b></div>";
		htmlCode += "<div class='rate_box_middle' style='width:100%; float:none;box-sizing: border-box; padding: 10px; margin-top: 0px;'>\
		<b>Факультет:</b> " + appoint[i].Faculty + "<br><b>Направление:</b> " + appoint[i].Spec + "<br>\
		<b>Специальность: </b> " + appoint[i].Post + "<br><b>Степень:</b> " + appoint[i].Degree + "<br><b>Бюджет:</b> " + appoint[i].Bud + "</div>";
		
		htmlCode += "<div style='clear:both'></div><div class='rate_footer'>Дата зачисления: " + appoint[i].date_zach + "</div>";
		htmlCode += "</div>";
	}

	$('.person_box_menu_app').html(htmlCode);
	
}

var loadCoffeInfo = function(){

	var cookInf = getJSON('cook_info');
	if(cookInf == undefined){
		myajax(true, "POST", "cookshop/parse.php",  {}, false, showCookCalc, true, "cook_info");
	} else {
		showCookCalc(cookInf);
	}

}

function showCookCalc(obj){
	
	if(!obj) return;
	//setJSON('cook_info', obj);
	var htmlCoffeBlock = "<div class='shopping_box'></div><span class='menu_title_coffe'>Меню столовой «Большая перемена»:</span><table class='calc_coffe_table contr_shadow unselected'>";
	for(var i = 0; i < obj.length; i++){
		htmlCoffeBlock += "<tr class='title_coffe'><td colspan='3'>" + obj[i].title + "</td></tr>";
		for(var j = 0; j < obj[i].cat.length; j++){
			if(obj[i].cat[j].cat_name != ""){
				htmlCoffeBlock += "<tr class='title_coffe_sub'><td colspan='3'>" + obj[i].cat[j].cat_name + "</td></tr>";
			}
			var dishes = obj[i].cat[j].dishes;
			if(dishes.length > 0){
				htmlCoffeBlock += "<tr class='info_tr'><td>Наименование</td><td>Кол-во</td><td>Цена</td></tr>";
			}
			for (var z = 0; z < dishes.length; z++) {
				htmlCoffeBlock += "<tr class='menu_item' onclick=\"changeWeight('" + ((dishes[z].title).replace(/"/g, '')) + "', " + dishes[z].price + ")\"><td>" + dishes[z].title + "</td><td>" + dishes[z].weight + "</td><td style='color:#DF7401; font-weight:bold;'>" + dishes[z].price + "</td></tr>";
			};		
		}
	}

	htmlCoffeBlock += "</table>";
	
	htmlCoffeBlock += "<div class='adding_menu contr_shadow'>\
							<div class='adding_menu_info'><span class='adding_menu_info_title' name_dish=''></span><br><span class='adding_menu_info_price'></span><br> <b>Количество :</b> <input class='num_del_inp' onkeyup='inp_sum_n(this,2)' onpaste='inp_sum_n(this,2)' onfocus='inp_sum_n(this,2)' type='text' value='1' />\
							</div>\
							<div class='adding_menu_button' onclick='addToBag()'></div>\
						</div>";
	view.$coffe_info_box.html(htmlCoffeBlock);
}

function changeWeight(title, price){
	$('.adding_menu').show(150);
	$('.adding_menu_info_title').attr("name_dish", title).html(title.substr(0,16) + "...");
	$('.adding_menu_info_price').html("<b>Цена :</b> <span class='curr_item_cost'>" + price + "</span> руб.");
}

function addToBag(){
	var currSumm = parseFloat($('.header_line_my_bag').text().trim());
	var addingSumm = parseFloat($('.curr_item_cost').text().trim());
	dishes.push({
		title_dish: $('.adding_menu_info_title').attr("name_dish"),
		amount: $('.num_del_inp').val(),
		summ: addingSumm * $('.num_del_inp').val(),
		order: dishes.length,
		show: true
	});
	
	$('.header_line_my_bag').html(" " + (currSumm + addingSumm * $('.num_del_inp').val()) + " руб.");
	$('.num_del_inp').val(1);


	$('.adding_menu').hide(150);

}

function closeBag(){
	$('.shopping_box').hide(100);
}

function delete_dish(index){
	var currSumm = parseFloat($('.header_line_my_bag').text().trim());
	dishes[index].show = false;
	$('.header_line_my_bag').html(currSumm - dishes[index].summ);
	showBag();
}

function showBag(){

	var htmlDishes = "<b>Ваш заказ <div style='margin-top: -1px;' class='news_box_exit_button' onclick='closeBag()'></div>:</b><br><table class='calc_coffe_table'>";
    htmlDishes += "<tr class='info_tr'><td>Наименование</td><td>Кол-во</td><td>Цена</td><td></td></tr>";

	for(var i = 0; i < dishes.length; i++){
		if(dishes[i].show){
			htmlDishes += "<tr class='menu_item' style='color:black;'><td>" + dishes[i].title_dish + "</td><td>" + dishes[i].amount + "</td><td style='color:#DF7401; font-weight:bold;'>" + dishes[i].summ + "</td><td><span onclick='delete_dish(" + dishes[i].order + ")'><b style='color: brown;'>удалить</b></span></td></tr>";
		}
	}

	htmlDishes += "</table>"

	$('.shopping_box').html("<div style='overflow-y:scroll;height:100%;'>" + htmlDishes + "</div>").show(100);
}

var loadRateData = function(){

	var allInf = getJSON('auth_inf');
	var rateInf = getJSON('user_rate_info');
	if(!rateInf) return;
	if(rateInf == undefined){
		myajax(true, "POST", "oracle/database_dol.php",  {hash : allInf.hash, FIO : allInf.FIO}, false, genRateHtml, true, "user_rate_info");
	} else {
		genRateHtml();
	}

}

var loadIncomeData = function(){

	var allInf = getJSON('auth_inf');
    if(!allInf) return;
	if(allInf.is_student == "1"){
		var studIncInf = getJSON('student_income_inf');
		if(studIncInf == undefined){
			myajax(true, "POST", "oracle/database_awards_students.php",  {hash : allInf.hash, FIO : allInf.FIO}, false, getStudentAwards, true, "student_income_inf");
		} else {
			getStudentAwards(studIncInf);
		}
	} else {
		var teachIncInf = getJSON('teach_income_inf');
		if(teachIncInf == undefined){
			myajax(true, "POST", "oracle/database_stimul_teac.php",  {hash : allInf.hash, FIO : allInf.FIO}, false, showTeachIcome, true, "teach_income_inf");
		} else {
			showTeachIcome(teachIncInf);
		}
	}
	
}

var getStudentAwards = function(obj){
	
	setJSON("student_income_inf", obj);
	var years = Object.keys(obj);	
	var select = "<div style='margin-bottom: 10px;'><b style='color:grey;margin: 5px;'>Выберите год:</b><select style='padding: 3px; border: 1px solid #BDBDBD;' onchange='createHtmlAvard()' class='selected_aw_year'>";
	for(var i = 0; i < years.length; i++){
		if (i == years.length - 1) {
			select += "<option selected>" + years[i] + "</option>";
		} else select += "<option>" + years[i] + "</option>";
	}
	
	select += "</select></div>";
	var incomeHTML = "<div class='fin_block_inform'>" + select;
	incomeHTML += "<div class='award_block'></div>";
	
	incomeHTML += "</div>"

	$('.fin_info_box_menu_income').html(incomeHTML);
	createHtmlAvard(obj);

}

var createHtmlAvard = function(obj){

	if(obj == undefined){
		obj = getJSON('student_income_inf');
	} 
	if(!obj) return;
	var selYearObj = obj[$('.selected_aw_year').val()];
	var incomeHTML = "";

	if(selYearObj.length == 0){
		incomeHTML += "Данные отсутствуют.";
	} else {

		for(var key in selYearObj){
			
			if(selYearObj[key]["summ"].length > 0){
				var n = selYearObj[key];
				
				incomeHTML += "<div class='rate_box contr_shadow'>";
				incomeHTML += "<div class='rate_box_head'>" + fullMonthNames2[key] + "</div>";
				incomeHTML += "<div class='rate_box_middle' style='float: none; box-sizing: border-box; width: 100%; padding: 10px; margin-top:0px;'>";
				var sum = 0;
				for (var i = 0; i < selYearObj[key]["summ"].length; i++) {
					
					incomeHTML += "<div style='border-bottom:1px dashed grey;padding: 8px;'><b style='color:#2E2E2E;'>" + selYearObj[key]["names"][i] + ":</b> " + selYearObj[key]["summ"][i] + " руб.</div>";
					sum += parseFloat(selYearObj[key]["summ"][i].replace(",","."));
				};
				
				incomeHTML += "</div><div style='clear:both'></div>";
				incomeHTML += "<div class='rate_footer'><b style='color:grey;'>Итого:</b>  " + sum + " руб. </div>";
				incomeHTML += "</div>";
				
			}
		}
		
	}

	$('.award_block').html(incomeHTML);

}

var showTeachIcome = function(obj){
	setJSON("teach_income_inf", obj);
		
	var incomeHTML = "<div class='fin_block_inform'>";

	if(obj.length == 0){
		incomeHTML += "Данные отсутствуют.";
	} else {
		for(var i = 0; i < obj.length; i++){
			
			incomeHTML += "<div class='rate_box contr_shadow'>";
			incomeHTML += "<div class='rate_box_head'><b>" + (i + 1) +") " + obj[i].name + "</b></div>";
			incomeHTML += "<div class='dog_wrapper'><div class='rate_box_img'></div>";
			incomeHTML += "</div><div class='rate_box_middle' style='margin-top:10px;'>";
			incomeHTML +=  (obj[i].type == 3 ? "Ставка: " : "Баллы: ") + (obj[i].ball == null ? "-" : obj[i].ball) + "<br>";
			incomeHTML += "<span style='color: green;'>" + (obj[i].type == 3 ? "Оклад: " : "Сумма: ") + (obj[i].summa == null ? "-" : obj[i].summa) + "</span><br>";
			incomeHTML += "</div><div style='clear:both;'></div>";
			if(obj[i].type == 3){
				incomeHTML += "<div class='rate_footer'><b style='color:grey;'>Должность:</b> " + (obj[i].post == null ? "-" : obj[i].post) + "</div>";
			}	
			incomeHTML += "</div>";
		}
	}

	incomeHTML += "</div>"

	$('.fin_info_box_menu_income').html(incomeHTML);

}

var toogleShowBlock = function(className, statClass){
	$el = $('.' + className);

	if($el.css('display') == "none"){
		$('.' + statClass).html("свернуть");
	} else $('.' + statClass).html("развернуть");

	$el.toggle(10, function(){
		$('body').scrollTo($el, {duration: 10, offset: -126});
	});

	
	//$('body').scrollTo($('.' + statClass), { offset: - 100, duration: 150 });
}

var genRateHtml = function(obj){

	if(obj != undefined){
		setJSON("user_rate_info", obj);
	} else {
		obj = getJSON('user_rate_info');
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
			rateHtml += "Остаток (с пред. мес.): " + (obj[i].Ostatok_LA == null ? "-" : obj[i].Ostatok_LA) + "<br>";
			rateHtml += "<span style='color: red;'>Начислено в тек.месяце: " + (obj[i].Nachisl == null ? "-" : obj[i].Nachisl) + "</span><br>";
			rateHtml += "<span style='color: green;'>Оплата: " + (obj[i].Oplata == null ? "-" : obj[i].Oplata) + "</span><br>";
			rateHtml += "Остаток (на кон.тек.месяца): " + (obj[i].Ostatok == null ? "-" : obj[i].Ostatok) + "</div><div style='clear:both;'></div>";
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




var getAuthInfo = function(infoObj){
			
	if(infoObj == undefined){
		showTooltip("Данного пользователя нет в базе данных", 4000);
		return false;
	}

	authObj = infoObj;
			
	if (authObj.FIO != "undefined"){
		setJSON("auth_inf", authObj);
		
		$('.authblock').css('display','inline-block');	
		saveValue('settingsCode', authObj.settings);
		saveValue('subgroup', authObj.subgroup);
		saveValue('default_query', authObj.default_query);
		saveValue('formular', getValue('formular_id') || authObj.formular_id);

	}
	view.changePage('menu');
	showTooltip(authObj.serverRequest, 2000);
	
	createHtmlSettings();
	setUserSettings(getValue("settingsCode"));
	
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

	clBl();
	
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

function newsWrap(obj, append) {

	if(obj == undefined){
		clBl();
		return false;
	}
	
	$newsblock = $('.news_box');
	var resHtml = '';
	
	for(var i = 0; i < obj.length; i++){
		
		resHtml += getHtmlNews(obj[i]);
		
	} 
		
	$newsblock.html('').css('display', 'none');
	
	if(append != undefined && append == true){
		var htmlNewsCode = getValue('news_' + $('.current_item').attr('newstype')) + resHtml;
		$newsblock.append(htmlNewsCode).fadeTo(0, 1);
		saveValue('news_' + $('.current_item').attr('newstype'), htmlNewsCode);
	} else {
		$newsblock.html(resHtml).fadeTo(150, 1);
		saveValue('news_' + $('.current_item').attr('newstype'), view.$news.html());
	}

	activateWaterfall();
  	
}

function getHtmlNews(obj) {

	var id = obj.type == '3' ? 'default_bg' : obj.id;
	
	return '<div class="news_box_item contr_shadow" onclick="loadDetails(' + obj.id + ');" idnews="' + obj.id + '">\
			  <div class="news_box_item_image" style="background-image:url(' + obj.img + ');">\
			  </div>\
			  <div class="news_box_item_text">\
			  <div class="news_box_item_title">\
			  ' + obj.name_news + '\
			  </div>\
			  <span class="prev_text_news">'	+ obj.descr +  '</span>\
			  </div><span class="source">' + obj.source_addr + '</span>\
			  <div style="clear:both"></div>\
			  </div>';

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
	
	var htmlArtCode = getValue('news_' + $('.current_item').attr('newstype'));

	if(htmlArtCode == undefined){
		
		saveValue('l_n_query', new Date());
		myajax(true, 'POST', 'oracle/database_news.php', {type: $('.current_item').attr('newstype')}, false, newsWrap, true);
		
	} else {

		var lastNewsQuery = getValue('l_n_query');

		var d = new Date(lastNewsQuery);
		var currDate = new Date();

		if(currDate - d > 15000000){
			var lastId = htmlArtCode.match(/idnews="(\d*)?"/)[1];
			myajax(true, 'POST', 'oracle/database_news.php', {type: $('.current_item').attr('newstype'), first_article: lastId}, false, newsAppend, true, undefined, true);
		} else {
			newsAppend();
		}
		
	}

}

function newsAppend(obj){

	$newsblock = $('.news_box');
	$newsblock.html(' ');
	var resHtml = '';

	if(obj == undefined){
		clBl();
		$newsblock.html(getValue('news_' + $('.current_item').attr('newstype'))).fadeIn(20);

		activateWaterfall();

		return false;
	}

	for(var i = 0; i < obj.length; i++){
		
		resHtml += getHtmlNews(obj[i]);
		
	} 
	
	if(resHtml != ""){
		$newsblock.html('').css('display', 'none');
		var htmlNewsCode = resHtml + getValue('news_' + $('.current_item').attr('newstype'));
		saveValue('news_' + $('.current_item').attr('newstype'), htmlNewsCode);
		$newsblock.append(htmlNewsCode).fadeIn(20);
	} else {
		$newsblock.html('').css('display', 'none');
		$newsblock.html(getValue('news_' + $('.current_item').attr('newstype'))).fadeIn(20);
	}	

	activateWaterfall();

}

function activateWaterfall(){
	if(window.innerWidth > 600){
		$('.news_box').css('width', '94%');
		$newsblock.waterfall();		
	} else {
		$('.news_box').css('width', '100%');
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



function loadGroupInfo(){

	var allInf = getJSON('auth_inf');
	var groupsArr = allInf.groups;
	
	if(allInf.is_student != "1") {
		location.hash = "menu";
	}

	if(getValue("groups_students") == undefined){
		myajax(true, "POST", "oracle/database_group_student.php", {groups: groupsArr, hash : allInf.hash, FIO : allInf.FIO}, false, showGroupInfo, false, "groups_students");
	} else {
		showGroupInfo();
	}
	
}

function showGroupInfo(){
	
	var groupsStud = getJSON('groups_students');
	var htmlCode = "";
	if(!groupsStud) return;
	for(var key in groupsStud){
		var group = groupsStud[key];
		htmlCode += "<span class='group_name_header'>Группа: " + group.number + "</span>";
		for (var i = 0; i < group.fio.length; i++) {

			htmlCode += "<div class='group_student_line " + (group.sex[i] == "М" ? "man_student" : "girl_student" ) + "'>" + (i + 1) + ") " + group.fio[i] + "</div>";
		};	
	}

	view.$group_block.html(htmlCode);
	
}


function loadCollegueInfo(){

	var allInf = getJSON('auth_inf');

	if(allInf.is_student != "0") {
		location.hash = "menu";
	}
		
	if(getValue("collegue_info") == "undefined" || getValue("collegue_info") == undefined){
	 	myajax(true, "POST", "oracle/database_teach_onekafedra.php", {hash : allInf.hash, FIO : allInf.FIO}, false, showCollegueInfo, false, "collegue_info");
	} else {
		showCollegueInfo();
	}
	
}

function showCollegueInfo() {

	var groupsStud = getJSON('collegue_info');
	var htmlCode = "";
	if(!groupsStud) return;

	for(var key in groupsStud){
		var group = groupsStud[key];
		htmlCode += "<span class='group_name_header'>" + group.cafidra + "</span>";
		for (var i = 0; i < group.fio.length; i++) {
			htmlCode += "<div class='group_student_line'>" + (i + 1) + ") " + group.fio[i] + " - <b>" +  group.dol[i] + "</b></div>";
		};	
	}

	view.$group_block.html(htmlCode);
	
}


function issetNumbersInQuery(query){
	return !!query.match(/\d/g);
}


function getColorTypeLesson(typeLesson) {
	switch(typeLesson.toLowerCase()) {
		case 'лек':
			return 'green';
		break;
		
		case 'у':
		case 'п':
		case 'лб':
		case 'пр':
		case 'консул':
		case 'кст':
			return 'orange';
		break;
		
		case 'кп':
		case 'зачет':
		case 'тест':
		case 'кр':
		case 'экзам':
			return 'red';
		break;
	}
}


function setUserSettings() {

	var settingsCode = getValue("settingsCode");
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

	$('.select_subgroup').val(getValue("subgroup"));

	$('.formular_num_inp').val(getValue("formular"));

	var default_query = getValue("default_query");

	if(default_query != null && default_query != "null"){
		$('.default_query_inp').val(default_query).attr('default_query', default_query);
	}

	
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

	htmlSettings += '<div class="settings_box_inputs"><div class="settings_box_inputs_item">Искать расписание по запросу<br> <input class="default_query_inp" default_query="" value="" type="text" placeholder="Введите запрос для поиска расписания..." /></div></div>';
	
	htmlSettings += '<div class="settings_box_inputs">\
							<div class="settings_box_inputs_item">\
							Номер подгруппы\
								<select class="select_subgroup">\
									<option value="0">Нет</option>\
									<option value="1">1</option>\
									<option value="2">2</option>\
									<option value="3">3</option>\
									<option value="4">4</option>\
								</select><div style="clear: both;"></div>\
						</div>\
					</div>';

	htmlSettings += '<div class="settings_box_inputs"><div class="settings_box_inputs_item">Номер читательского билета (изображен под штрих кодом)<br> <input class="formular_num_inp" value="" type="text" placeholder="Введите номер читательского билета" /></div></div>';				

	$('.settings_box_inputs').html(htmlSettings);

	$('.default_query_inp').autocomplete({	
		source:"oracle/database_get_timetable_info.php",
		minLength:2
	});

	$('.default_query_inp').on('autocompleteselect',function(event, ui){
        $('.default_query_inp').attr('default_query', ui.item.value);
    });				
	
}

function changeStatus(thisObj, num) {
	var str = thisObj.checked ? "Вкл." : "Выкл.";
	$('.word_stat' + num).text(str);
}

function loadMap(){
	
	var $block = $('.informationMap');

	if($block.html().length < 25){
		$block.load('university_map.html');
	}

}

function loadCollectives(){

	var $block = $('.informationColls');

	if($block.html().length < 25){
		$block.load('university_coll.html');
	}

}

function loadDorm(){
	var $block = $('.informationDorm');

	if($block.html().length < 25){
		$block.load('university_stud.html');
	}	
}
function loadCity(){
	var $block = $('.informationCity');

	if($block.html().length < 25){
		$block.load('aboutCity.html');
	}	
}

function showSendingForm(){


	var userInfo = getJSON("auth_inf");

	if(userInfo){
		$('.fio_input_txt').val(userInfo.FIO);
	}

	opBl();
	$('#modalForm').fadeIn(20);
	

}

function showTmtbBox(){

	opBl();
	$('#weeek_tmtb_box').fadeIn(20);

}

function closeModalForm(){

	$("#modalForm").fadeOut(20, function(){
		clBl();
	});

}

function closeInformBox(){

	$("#helper_box").fadeOut(20, function(){
		clBl();
	});

}

function closeTmtbBox(){
	$("#weeek_tmtb_box").fadeOut(20, function(){
		clBl();
	});
}

function clearText(){
	$textarea = $('.modalForm_fm_textarea');
	if ($textarea.html() == 'Введите текст сообщения...') $textarea.html("");
}

function loadFormularInfo(){

	var second_name = (getJSON('auth_inf').FIO).split(" ")[0];
	var code = getValue("formular");

	if(code == undefined || code == "") {
		showTooltip("Необходимо заполнить поле \"Номер читательского билета\" в настройках.", 3500);
	} else {
		myajax(true, "POST", "lib/parse_lib.php",  {FFIO: second_name, id_bibl: code}, false, showLibInfo, true);
	}
	
}

function showLibInfo(obj){

	if(obj.no_books != undefined){
		view.$lib_box.html(obj.no_books);
	} else {

		if(obj.err != undefined){
			showTooltip(obj.err, 3500);
		} else {

			var htmlBooks = "";
			var cnt = 1;
			for(var key in obj){
				htmlBooks += "<div class='rate_box contr_shadow'>";
				htmlBooks += parseBookInfo(obj[key], cnt++);
				htmlBooks += "</div>";
			}	

			view.$lib_box.html(htmlBooks);
		}		
	} 
}

function parseBookInfo(info, cnt){
	
	var regStrFr = /Выдан (\d{2}.\d{2}.\d{4})/,
		regStrTo = /вернуть до (\d{2}.\d{2}.\d{4})/,
		codeStr = /Шифр: ([\d\.-а-яА-Я]*)/,
		num = /Инв\.№ ([\d\.-а-яА-Я]*)/,
		bookInfo = {
			fullText : info,
			dateStart : "",
			dateEnd : "",
			bookCode : "",
			bookNum : "",
			aboutBook: "",
			errFlag : false,
			count : cnt,
			generateHTML : function(){

				var date_arr = this.dateEnd.split('.'),
					rdate = new Date(date_arr[1] + "." + date_arr[0] + "." + date_arr[2]),
					flag = rdate < new Date() ? "redStyle" : "";



				return "<div class='rate_box_head " + flag + "' style='padding:5px 10px;'><b>" + this.count + ": Выдан</b> " + this.dateStart + "   <b>требуется вернуть:</b> " + this.dateEnd + "</div>\
						<div class='rate_box_middle' style='width:100%; float:none;box-sizing: border-box; padding: 10px; margin-top: 0px;'>" + this.aboutBook + "</div>\
						<div class='rate_footer' style='color: #4E4E4E; padding:5px 10px;'><b>Шифр</b> " + this.codeStr + "   <b>Инв.№</b> " + this.bookNum + "</div>";
			},
			toString : function(){
				if(this.errFlag) return this.fullText;
				return this.generateHTML();
			}	
		};

    bookInfo.dateStart = info.match(regStrFr)[1];
    bookInfo.dateEnd = info.match(regStrTo)[1];
    bookInfo.codeStr = info.match(codeStr)[1];
    bookInfo.bookNum = info.match(num)[1];
    bookInfo.aboutBook = info.split(num)[2];
    
    for(var key in bookInfo){
    	if(bookInfo[key] == null){
    		bookInfo.errFlag = true;
    		break;
    	}
    }

	return bookInfo;
}


function loadFileIframe(){
	view.$file_box.html('<iframe id="fileFrame" style="width:100%;height:' + document.body.clientHeight + "px" + ';" />');
    $('#fileFrame').attr('src', 'http://lir.ugrasu.ru/index_short.php');
    $('#fileFrame').load(function()
    {
      clBl();
    });
}