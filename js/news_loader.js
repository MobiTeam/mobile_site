var alredyLoad = false;

function loadNextNews(typeNews, lastId){
	
	if(!alredyLoad){
		
		alredyLoad = true;	
		//myajax(async, type, url, data, notResponse, functionCallBack, issetArgs, savePlace);	
		myajax(true, 'POST', 'oracle/database_news.php', {type: typeNews, last_article: lastId}, false, saveNewArticles, true);
	} 
	
}

function saveNewArticles(resp) {
	newsWrap(resp, true);
	alredyLoad = false;
}