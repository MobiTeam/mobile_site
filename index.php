<!DOCTYPE HTML>
<html>
	
	<head>
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta charset="UTF-8">
				
		<title>Мобильное приложение Югорского Государственного Университета</title>
		
		<link href="css/style.css" rel="stylesheet" />
		<link href="css/switchery.min.css" rel="stylesheet" />
		<link href="css/jqui.css" rel="stylesheet" />
		<link href="css/large_icons.css" rel="stylesheet" />
		<link href="css/portrait_phone.css" media="screen and (min-width: 480px)" rel="stylesheet"/> 
		<link href="css/small_phone.css" media="screen and (max-width: 480px)" rel="stylesheet"/> 
		<link href="css/large_phone.css" media="screen and (min-width: 736px)" rel="stylesheet"/> 

		<link href="css/roboto_font.css" rel="stylesheet"/>
	
	</head>

		<body>

		<div class="pre_loader">
			Югорский Государственный <br>Университет
		</div>
		<div id="overlay"></div>
		
		<div id="weeek_tmtb_box">
					
			<div class="news_box_exit_button" onclick="closeTmtbBox();"></div>

			<div class="currentWeekTimetable">
				

			</div>
					
		</div>

		<div id="helper_box">
			
			<div class="news_box_exit_button" onclick="closeInformBox();"></div>

			<div class="helper_text">Здравствуйте. Вы зашли на страницу личного кабинета.<br><br> Для входа в систему необходим персональный <b>логин</b> и <b>пароль</b>. Логин и пароль заводятся 
			на студентов очной формы обучения при их зачислении. Для того, чтобы узнать свой логин и пароль
			необходимо обратиться в учебную часть своего института. В случае утраты пароля его можно изменить,
			для этого обращайтесь в <b>«Отдел сетевых технологий и телекоммуникаций»</b> (4 корпус, 111 кабинет)<br>
			<br>Личный кабинет также работает и в <b>гостевом режиме</b>, который ограничен по функционалу.
			</div>

		</div>

		<div id="modalForm">
			
			<div class="news_box_exit_button" onclick="closeModalForm();"></div>

			<form class="modalForm_fm" method="POST">
				<input class="formInformationInput contr_shadow fio_input_txt" name="FIO" type="text" placeholder="ФИО" required />
				<input class="formInformationInput contr_shadow" name="E-mail" type="text" placeholder="E-mail" required />
				
				<textarea class="contr_shadow no-resize modalForm_fm_textarea" name="Message_text" onclick="clearText()" required>Введите текст сообщения...</textarea><br>

				<input class="infoSubmBtn" type="submit" value="Отправить" />

			</form>

		</div>

		<div id="menu">
			
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
					<!-- <li class="sidebar_menu_block_menu_item group_item" hashtag="group_info">Моя группа</li> -->
					<li class="sidebar_menu_block_menu_item persinf_item auth_only" hashtag="persinf">Персональная</li>
					<li class="sidebar_menu_block_menu_item finance_item auth_only" hashtag="finance_inf">Финансы</li>
					<!-- <li class="sidebar_menu_block_menu_item message_item" hashtag="message">Сообщения</li>		 -->
					<li class="sidebar_menu_block_menu_item guide_item" hashtag="dir_info">Справочник</li>		
					<!-- <li class="sidebar_menu_block_menu_item coffee_item" hashtag="coffe_block">Столовая</li>		 -->	
					<li class="sidebar_menu_block_menu_item set_item auth_only settings" hashtag="settings">Настройки</li>
					<li class="sidebar_menu_block_menu_item about_item" hashtag="about_app">О приложении</li>
					<li class="sidebar_menu_block_menu_item close_item" hashtag="auth">Сменить пользователя</li>
			</ul>
		
		</div>

		<div id="panel">
		<div class="wrapper">
		 
		<div class="menuoverlay" style='display:none;' onclick="slideout.close()"></div>
			
			<div class="header_line unselected" unselectable="on" onselectstart="return false;">
				<div class="header_line__content">
					<div class="header_line__helper">
						<div class="header_line__content_button">
						
						</div>
						
						<span class="header_line__content_title"></span>
																		
						<div class="header_line_content_search" onclick="event.stopPropagation();">
						  
						</div>

						<div class="header_line_content_helper" onclick="event.stopPropagation();">
						  
						</div>
												
						<!-- <div class="header_line_content_calendar" onclick="event.stopPropagation();">
						  
						</div> -->
						
						<div class="header_line_search_input">
							<form class="timetable_box_form" method="post" action="">
								<input class="timetable_box_input" name="timetable_query" onclick="event.stopPropagation();" placeholder="Поиск расписания..." type="text" required="">
								<input style="display:none;" onclick="event.stopPropagation();" type="submit" class="timetable_box_submit" />
							</form>
						</div>

						<div class="header_line_my_bag" onclick="showBag()">
						   0  
						</div>
						
						<!-- <div class="header_line_content_settings auth_only" hashtag="settings">
						  
						</div> -->
						
						<!--<div class="header_line_content_refresh" onclick="event.stopPropagation();">
						  
						</div>-->
											
						
					</div>
					
					<div class="header_line_addition_datewr">
						
						<div class="header_line_addition_data">
							<div class="date_item_back date_item_bt" diffDate="-7"></div>
							<div class="date_item dt1" name="dt_s1"></div>
							<div class="date_item dt2" name="dt_s2"></div>
							<div class="date_item dt3" name="dt_s3"></div>
							<div class="date_item dt4" name="dt_s4"></div>
							<div class="date_item dt5" name="dt_s5"></div>
							<div class="date_item dt6" name="dt_s6"></div>
							<div class="date_item_next date_item_bt" diffDate="7"></div>
						</div>
						
					</div>	
					
					
					<div class="header_line_addition_wrapper">
						<div class="header_line_addition_menu">
							<div class="header_line_addition_menu_item current_item" newstype="1">Новости</div>
							<div class="header_line_addition_menu_item" newstype="2">Объявления</div>
							<div class="header_line_addition_menu_item" newstype="3">Анонсы</div>
						</div>
					</div>	

					<div class="header_line_addition_wrapper_guide">
						<div class="header_line_addition_menu_guide">
							<div class="header_line_addition_menu_guide_item current_item" guidetype="1">Поиск</div>
							<div class="header_line_addition_menu_guide_item" guidetype="2">Студенту</div>
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
					<div class="fin_info_box_menu_item person_info_box_menu_appitem unselected" onclick="toogleShowBlock('person_box_menu_app', 'rate_stat');">Назначение<br><span class='fin_info_box_menu_item_stat rate_stat'>развернуть</span></div>
					<div class="person_box_menu_app hiddenInfBlock">Загрузка..</div>
					<div class="fin_info_box_menu_item person_info_box_menu_loaditem unselected notStud" onclick="toogleShowBlock('person_box_menu_load', 'loadstat');">Нагрузка<br><span class='fin_info_box_menu_item_stat loadstat'>развернуть</span></div>
					<div class="person_box_menu_load hiddenInfBlock">Загрузка..</div>
<!-- 				<div class="fin_info_box_menu_item  person_info_box_menu_holiday unselected notStud" onclick="toogleShowBlock('person_box_menu_hol','hol_stat');">Запланированный отпуск<br><span class="fin_info_box_menu_item_stat hol_stat">развернуть</span></div>
					<div class="person_box_menu_hol hiddenInfBlock">Загрузка...</div> -->	
					<div class="fin_info_box_menu_item person_info_box_menu_alsitem unselected forStud" onclick="toogleShowBlock('person_box_menu_als', 'income_stat');">Зачетная книжка<br><span class='fin_info_box_menu_item_stat income_stat'>развернуть</span></div>
					<div class="person_box_menu_als hiddenInfBlock">Загрузка..</div>
					<div class="fin_info_box_menu_item person_info_box_menu_session unselected forStud" onclick="toogleShowBlock('person_box_menu_ses', 'curr_session');">Текущая сессия<br><span class='fin_info_box_menu_item_stat curr_session'>развернуть</span></div>
					<div class="person_box_menu_ses hiddenInfBlock">Загрузка..</div>
				</div>
				
				<div class="fin_info_box">
					<div class="fin_info_box_menu_item fin_info_box_menu_rateitem unselected" onclick="toogleShowBlock('fin_info_box_menu_rate', 'rate_stat');">Расходы<br><span class='fin_info_box_menu_item_stat rate_stat'>развернуть</span></div>
					<div class="fin_info_box_menu_rate hiddenInfBlock">Загрузка..</div>
					<div class="fin_info_box_menu_item fin_info_box_menu_incomeitem unselected" onclick="toogleShowBlock('fin_info_box_menu_income', 'income_stat');">Доходы<br><span class='fin_info_box_menu_item_stat income_stat'>развернуть</span></div>
					<div class="fin_info_box_menu_income hiddenInfBlock">Загрузка..</div>
				</div>

				<div class="group_info_box">
				
				</div>

				<div class="lib_info_box">
					
				</div>

				<div class="dir_info_box">
					
				</div>

				<div class="coffe_info_box">
					
				</div>				

				<div class="about_info_box">
					
					<div class="about_info_box_text contr_shadow">
					<div class="authorisation_box_logo" style="margin:16px auto 26px;"></div>

					<p><b>mob.ugrasu.ru</b> <span class='about_span'>(ver 0.41 alpha)</span> - личный кабинет студентов и сотрудников Югорского Государственного университета.</p>
					<p>Данное приложение создано с целью упрощения доступа студентов и сотрудников к информации из корпоративной сети университета.</p>
					<p>С помощью данного приложения Вы с легкостью можете посмотреть расписание занятий, свежие новости с сайта университета, 
					а также персональную информацию, такую как - список группы, успеваемость, назначение, финансовую информацию и пр.</p>
					
					<p class="alert_message">
						Работоспособность сервиса проверена в браузерах Google Chrome, Mozilla Firefox и Safari. При использовании Android Browser и 
						Internet Explorer возможны проблемы с отображением материала.						
					</p>

					<p style='display:block; border-top:1px dashed grey; padding-top: 5px;'>
						<span class='about_span'>Разработчики:</span><br> 
						Петроченко Владислав - vladonxp@mail.ru <br>
						Якимчук Александр - viking0607@mail.ru

						<input class="sendInfoButton contr_shadow" type="button" value="Сообщить об ошибке" onclick="showSendingForm()" />
					</p>
					
					<p style='border-top:1px dashed grey; padding-top: 5px;'><span class='about_span'>Благодарности:</span>
						<ul style='margin-left:20px;'>
							<li>Бурлуцкому Владимиру Владимировичу</li>
							<li>Татаринцеву Ярославу Борисовичу</li>
							<li>Карпову Дмитрию Викторовичу</li>
							<li>Шавкуну Алексею Евгеньевичу</li>
							<li>Русанову Михаилу Александровичу</li>
						</ul>
					</div>					
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
							
							<div class="main_calendar_icon main_icon_block"></div>
							 <!-- <img src="img/calendar_icon.png" /> -->
							
							<div class="content_box_name_item">	
							  Расписание
							</div>
						</div>

						<div class="content_box_menuitem contr_shadow" hashtag="coffe_block">
							
							<!-- <img src="img/coffee_icon.png" /> -->
							<div class="main_coffe_icon main_icon_block"></div>
						   
							<div class="content_box_name_item coffe_content">	
							  Столовая
							</div>
						</div>

						<div class="content_box_menuitem contr_shadow" hashtag="news">
						
							<div class="main_news_icon main_icon_block"></div> -->
							<!-- <img src="img/news_new.png" /> -->
						
							<div class="content_box_name_item news_content"> 
							  Новости
							</div>
						</div>
						 
						<div class="content_box_menuitem contr_shadow authblock" hashtag="lib_info">
							
							<div class="main_lib_icon main_icon_block"></div>
							<!-- <img src="img/group_new.png" /> -->
						   
							<div class="content_box_name_item lib_content">	
							  Библиотека
							</div>
						</div>
 
						
						<div class="content_box_menuitem contr_shadow authblock only_stud" hashtag="group_info">
							
							<div class="main_group_icon main_icon_block"></div>
							<!-- <img src="img/group_new.png" /> -->
						   
							<div class="content_box_name_item group_content">	
							  Моя группа
							</div>
						</div>

						<div class="content_box_menuitem contr_shadow authblock" hashtag="persinf">
							
							<div class="main_person_icon main_icon_block"></div>
							<!-- <img src="img/personal_new.png" /> -->
						
							<div class="content_box_name_item pers_content">	
							  Персональная инф.
							</div>
						</div>
						
						<div class="content_box_menuitem contr_shadow authblock" hashtag="finance_inf">
							
							<!-- <img src="img/money_rub.png" style='width:70px;' /> -->
							<div class="main_rouble_icon main_icon_block"></div>
						
							<div class="content_box_name_item finance_content">	
							  Финансовая инф.
							</div>
						</div>
						
						<!-- <div class="content_box_menuitem contr_shadow authblock" hashtag="message">
							
							<img src="img/message_new.png" />
						   
							<div class="content_box_name_item message_content">	
							  Сообщения
							</div>
						</div> -->
						
						<div class="content_box_menuitem contr_shadow" hashtag="dir_info">
							
							<!-- <img src="img/contacts_new.png" /> -->
							<div class="main_directory_icon main_icon_block"></div>
						   
							<div class="content_box_name_item contacts_content">	
							  Справочник
							</div>
						</div>
						
						<div class="content_box_menuitem contr_shadow" hashtag="about_app">
							
							<!-- <img src="img/info.png"  style='width:80px;' /> -->
							<div class="main_info_icon main_icon_block"></div>
						   
							<div class="content_box_name_item app_info">	
							  О приложении
							</div>
						</div> 
						
						<div style="clear:both">
						</div>
					</div>
				  </div>	
			</div>
		    
		</div> 
		
		<div class="tooltip">
				
		</div>
	    </div>
			<script src="js/jquery-2.1.4.min.js"></script>
			<script src="js/slideout.min.js"></script>
			<script src="js/timetable.js"></script>
			<script src="js/money_coffee.js"></script>
			<script src="js/bind_action.js"></script>
			<script src="js/view.js"></script>
			<script src="js/news_loader.js"></script>
			<script src="js/waterfall-light.js"></script>
			<script src="js/function.js"></script>
			<script src="js/mess.js"></script>
			<script src="js/main.js"></script>
			<script src="js/switchery.min.js"></script>
			<script src="js/scrollTo.min.js"></script>
			<script src="js/jq_min.js"></script>
		</body>
		
		<!-- Yandex.Metrika counter -->
		<script type="text/javascript">
			(function (d, w, c) {
				(w[c] = w[c] || []).push(function() {
					try {
						w.yaCounter34858050 = new Ya.Metrika({
							id:34858050,
							clickmap:true,
							trackLinks:true,
							accurateTrackBounce:true,
							webvisor:true,
							trackHash:true,
							ut:"noindex"
						});
					} catch(e) { }
				});

				var n = d.getElementsByTagName("script")[0],
					s = d.createElement("script"),
					f = function () { n.parentNode.insertBefore(s, n); };
				s.type = "text/javascript";
				s.async = true;
				s.src = "https://mc.yandex.ru/metrika/watch.js";

				if (w.opera == "[object Opera]") {
					d.addEventListener("DOMContentLoaded", f, false);
				} else { f(); }
			})(document, window, "yandex_metrika_callbacks");
		</script>
		<noscript><div><img src="https://mc.yandex.ru/watch/34858050?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->
</html>