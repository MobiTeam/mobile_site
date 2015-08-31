<?php 

    $str = '<title>Перечень журналов, исключенных из БД Scopus | Югорский государственный университет</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="robots" content="index, follow" />
<meta name="keywords" content="Перечень журналов, исключенных из БД Scopus, Perechnem_zhurnalov_isklyuchennykh_iz_BD_Scopus" />
<meta name="description" content="&amp;lt;p&amp;gt;
	 Уважаемые преподаватели и сотрудники Университета!
&amp;lt;/p&amp;gt;
&amp;lt;p&amp;gt;
&amp;lt;/p&amp;gt;
Предлагаем ознакомиться с «Перечнем журналов, исключенных из БД Scopus
(по данным на июнь 2015 г.)»" />
<link href="/bitrix/js/main/core/css/core.min.css?14326139672854" type="text/css"  rel="stylesheet" />
<link href="/bitrix/js/altasib.errorsend/css/window.css?14139165282860" type="text/css"  rel="stylesheet" />
<link href="/bitrix/templates/main/components/bitrix/news.detail/news/style.css?1426763543314" type="text/css"  rel="stylesheet" />
<link href="/bitrix/components/bitrix/main.share/templates/.default/style.min.css?14326139671293" type="text/css"  rel="stylesheet" />
<link href="/bitrix/themes/.default/imyie.littleadmin.css?14139165382309" type="text/css"  data-template-style="true"  rel="stylesheet" />
<link href="/bitrix/templates/main/components/bitrix/search.title/template/style.css?14139165372867" type="text/css"  data-template-style="true"  rel="stylesheet" />';

	preg_match('~name="description" content="([\s\S]*?)"~', $str, $descrarr);
	echo($descrarr[1]);
	/* $descr = ; */

?>