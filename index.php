<!DOCTYPE HTML>
<html><!--manifest="off.manifest"-->
	
	<head>
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta charset="UTF-8">
				
		<title>Мобильное приложение Югорского Государственного Университета</title>
		
		<link href="css/style.css" rel="stylesheet" />
		<link href="css/switchery.min.css" rel="stylesheet" />
		<link href="css/jqui.css" rel="stylesheet" />
		<link href="css/large_icons.css" rel="stylesheet" />
		<link href="css/portrait_phone.css" media="screen and (min-width: 480px)" rel="stylesheet"/> 
		<link href="css/large_phone.css" media="screen and (min-width: 736px)" rel="stylesheet"/> 
		<link href="css/roboto_font.css" rel="stylesheet"/>
	
	</head>
	
	<body>
		
		<div class="wrapper">
		 
		<div class="pre_loader">
			Югорский Государственный <br>Университет
		</div>
		<div id="overlay"></div>
		
		<div class="menuoverlay"></div>
			
			<div class="sidebar_menu_block">
				
				<div class="sidebar_wr">
					<div class="sidebar_menu_block_back_arr">
					</div>
					
					<div class="authorisation_box_logo menu_box_logo">
										
					</div>
					
					<ul class="sidebar_menu_block_menu unselected" unselectable="on" onselectstart="return false;">
							<li class="sidebar_menu_block_menu_item main_item sidebar_menu_block_menu_item_curr" hashtag="menu">Главная страница</li>
							<li class="sidebar_menu_block_menu_item news_item" hashtag="news">Новости</li>
							<li class="sidebar_menu_block_menu_item timetable_item" hashtag="timetable">Расписание</li>
							<!--<li class="sidebar_menu_block_menu_item pers_item auth_only" hashtag="persinf">Персональная информация</li>
							<li class="sidebar_menu_block_menu_item mes_item auth_only" hashtag="message">Сообщения</li>-->
							<li class="sidebar_menu_block_menu_item set_item auth_only" hashtag="settings">Настройки</li>
							<li class="sidebar_menu_block_menu_item close_item " hashtag="auth">Сменить пользователя</li>
					</ul>
				</div>
			</div>
			
			<div class="header_line unselected" unselectable="on" onselectstart="return false;">
				<div class="header_line__content">
					<div class="header_line__helper">
						<div class="header_line__content_button">
						
						</div>
						
						<span class="header_line__content_title"></span>
																		
						<div class="header_line_content_search" onclick="event.stopPropagation();">
						  
						</div>
												
						<!--<div class="header_line_content_calendar" onclick="event.stopPropagation();">
						  
						</div>-->
						
						<div class="header_line_search_input">
							<form class="timetable_box_form" method="post" action="">
								<input class="timetable_box_input" name="timetable_query" onclick="event.stopPropagation();" placeholder="Поиск расписания..." type="text" required="">
								<input style="display:none;" onclick="event.stopPropagation();" type="submit" class="timetable_box_submit" />
							</form>
						</div>
						
						<!--<div class="header_line_content_settings" hashtag="settings">
						  
						</div>
						
						<div class="header_line_content_refresh" onclick="event.stopPropagation();">
						  
						</div>-->
											
						
					</div>
					
					<div class="header_line_addition_datewr">
						
						<div class="header_line_addition_data">
							<div class="date_item_back date_item_bt"></div>
							<div class="date_item dt1" name="dt_s1"></div>
							<div class="date_item dt2" name="dt_s2"></div>
							<div class="date_item dt3" name="dt_s3"></div>
							<div class="date_item dt4" name="dt_s4"></div>
							<div class="date_item dt5" name="dt_s5"></div>
							<div class="date_item dt6" name="dt_s6"></div>
							<div class="date_item_next date_item_bt"></div>
						</div>
						
					</div>	
					
					
					<div class="header_line_addition_wrapper">
						<div class="header_line_addition_menu">
							<div class="header_line_addition_menu_item current_item" newstype="1">Новости</div>
							<div class="header_line_addition_menu_item" newstype="2">Объявления</div>
							<div class="header_line_addition_menu_item" newstype="3">Анонсы</div>
						</div>
					</div>	
					
					<div class="header_shadow_box contr_shadow_2">
						
					
					</div>
					
				</div>
				
			</div>
			
			<div class="content_box">
			
				<div class="space_height"></div>
			
				<div class="settings_box">
					
					<div class="settings_box_header">Блок пользовательских настроек</div>
					
					<div class="settings_box_inputs unselected" unselectable="on" onselectstart="return false;">
						
						
						
					</div>
					
					<input class="settings_box_button_save " type="button" value="Сохранить изменения" >
					
				</div>
			
				<div class="timetable_box">
					<div class="timetable_box_info contr_shadow">
						Мы не смогли определить номер вашей группы или расписания на эту неделю еще не существует. Для просмотра расписания необходимо воспользоваться поиском и ввести номер группы, ФИО преподавателя или кафедру.
					</div>
					
					<div class="timetable_lessons">
					
					</div>
					
				</div>
				
				<div class="person_box">
					Персональная информация
				</div>
				
				<div class="news_box">
				</div>
							
				<div class="news_box_details contr_shadow">
				</div>
				
				<div class="authorisation_box">
				
					<div class="authorisation_box_logo">
					</div>
					
					 <form class="authorisation_box_form" method="post" action="">
						<input class="authorisation_box_input logininp contr_shadow" name="login" placeholder="Логин" type="text" required="">
						<input class="authorisation_box_input passinp contr_shadow" name="password" placeholder="Пароль" type="password" required="">
						
						<span class="authorisation_box_passtext">Запомнить меня</span><input type="checkbox" class="save_password" name="save_password" value="1"><br>
						
						<br>
						<input class="authorisation_box_submit contr_shadow" type="submit" value="Войти" >
					    <input class="authorisation_box_button contr_shadow" type="button" value="Пропустить" >
					</form> 
				
				</div>
				
				  <div class="main_menu">
					<div class="previos_info shadow">
			
						<div class="previos_info_circle">
						</div>
						
						<span class="previous_info_text">
						
							<span class="previous_info_fullname"></span><br>
							<span class="previous_info_group"></span>
						
						</span>
						
						
						<div style="clear:both;"></div>
					</div>
				
				    <div class="content_box_itemwrapper unselected" unselectable="on" onselectstart="return false;">
						<div class="content_box_menuitem contr_shadow" hashtag="timetable">
							
							<img src="/img/calendar_icon.png" />
							
							<div class="content_box_name_item">	
							  Расписание
							</div>
						</div>
						
						<div class="content_box_menuitem contr_shadow" hashtag="news">
						
							<img src="/img/news_icon.png" />
						
							<div class="content_box_name_item"> 
							  Новости
							</div>
						</div>
						
						<!--
						<div class="content_box_menuitem contr_shadow authblock" hashtag="persinf">
							
							<img src="/img/pers_icon.png" />
						
							<div class="content_box_name_item">	
							  Персональная инф.
							</div>
						</div>
						
						<div class="content_box_menuitem contr_shadow authblock" hashtag="message">
							
							<img src="/img/message_icon.png" />
						   
							<div class="content_box_name_item">	
							  Сообщения
							</div>
						</div>-->
						
						<div style="clear:both">
						</div>
					</div>
				  </div>	
			</div>
		    
		</div> 
		
		<div class="tooltip">
				
		</div>
		
		<script src="js/jquery-2.1.4.min.js"></script>
		<script src="js/view.js"></script>
		<script src="js/news_loader.js"></script>
		<!--<script src="js/waterfall.js"></script>-->
		<script src="js/function.js"></script>
		<script src="js/mess.js"></script>
		<script src="js/bind_action.js"></script>
		<script src="js/main.js"></script>
		<script src="js/switchery.min.js"></script>
		<script src="js/scrollTo.min.js"></script>
		<script src="js/jq_min.js"></script>
	</body>
</html>