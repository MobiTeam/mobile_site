// �������� �� �����������
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

//������ ��������������� �����
function hideLoader(){
	$('.pre_loader').fadeOut(200);
}

// �������� Tooltip
function showTooltip(toolText, duration){
	
	var dur = duration!=undefined ? duration: 1000;
	
	$tooltip = $('.tooltip');
	$tooltip.fadeIn(200).html(toolText);
	
	setTimeout(function(){
		$tooltip.fadeOut(200);
	}, dur);
	
}

// ��������/�������� ���� ��������
function opBl(){ 
	$('.overlay').css('display', 'block');
}

function clBl(){
	$('.overlay').css('display', 'none');
}

// ���������� JSON � localStorage/sessionStorage
function setJSON(key, value, flag) {
	try {   
	        if(flag == true){
				localStorage[key] = JSON.stringify(value);				
			} else {
				sessionStorage[key] = JSON.stringify(value);
			}
			
		} catch(ex){
					
		}
}

// ��������� JSON �� localStorage/sessionStorage
function getJSON(key, flag) {
	
	var value;
	
	if(flag == true){
		value = localStorage[key];				
	} else {
		value = sessionStorage[key];
	}
	
	return value ? JSON.parse(value) : null;
}

// �������� BOM �������� �� ������
function clearUTF8(str) {
	var clrStr = '';
	if (str[0] != '{'){
		clrStr = str.substr(3, str.length);
	}
    return clrStr;
}
