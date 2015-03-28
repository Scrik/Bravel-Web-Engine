<!DOCTYPE html>
<html>
	<head>
		{p-headers}
		<link rel="shortcut icon" href="{THEME}/images/favicon.ico">
		<link type="text/css" rel="stylesheet" href="{THEME}/css/styles.css">
		<link type="text/css" rel="stylesheet" href="{THEME}/css/jQuery.FormStyler.css">
		<script type="text/javascript" src="{THEME}/js/jQuery.FormStyler.js"></script>
		<script type="text/javascript" src="{THEME}/js/scripts.js"></script>
		<title>{p-title} » {site-name}</title>
	</head>
	<body>
		<div class="header">
			<div class="wrap">
				<a href="{main-link}"><div class="logotype"></div></a>
			</div>
		</div>
		<div class="wrapper">
			<div class="top">
				<div class="left">
					<ul class="menu">
						<li><a href="{main-link}" class="m-button">Главная</a></li>
						<li><a href="{statistics-link}" class="m-button">Статистика</a></li>
						<li><a href="{feed-back-link}" class="m-button">Написать нам</a></li>
						<li><a href="{terms-link}" class="m-button">Правила</a></li>
						<li class="last">
							<a href="javascript:void(0)" class="m-button">Dropdown »</a>
							<div class="subs"><div>
								<ul>
									<li><a href="#">Item 1</a></li>
									<li><a href="#">Item 2</a></li>
									<li><a class="seperator"></a></li>
									<li><a href="#">Item 1</a></li>
									<li><a href="#">Item 2</a></li>
									<li><a href="#">Item 3</a></li>
								</ul>
							</div></div>
						</li>
					</ul>
				</div>
				<div class="right"><div class="fix"></div></div>
				<div class="clearfix"></div>
			</div>
			<div class="sidebar">
				<a target="blank" href="http://bravel.ru/" class="developer">
					<div class="padding">Перейти на сайт<br>разработчика движка</div>
				</a>
				{login}
			</div>
			<div class="content">
				{p-info}{p-content}
			</div>
			<div class="clearfix"></div>
			<div class="footer">
				<div class="left">
					<a href="{main-link}">{config="title"}</a> - Copyright © 2013<br>
					<small>Powered by <a target="_blank" href="http://bravel.ru/">Bravel Web Studio</a>.</small>
				</div>
				<div class="right">
					Ваши изображения <b>&lt;img&gt;</b>...
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</body>
</html>