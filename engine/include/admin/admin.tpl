<!DOCTYPE html>
<html>
	<head>
		{p-headers}
		<link rel="shortcut icon" href="{THEME}/admin/images/favicon.ico">
		<link type="text/css" rel="stylesheet" href="{THEME}/admin/css/styles.css">
		<link type="text/css" rel="stylesheet" href="{THEME}/admin/css/jQuery.FormStyler.css">
		<link type="text/css" rel="stylesheet" href="{THEME}/wysibb/theme/default/wbbtheme.css">
		<script type="text/javascript" src="{THEME}/admin/js/jQuery.FormStyler.js"></script>
		<script type="text/javascript" src="{THEME}/wysibb/jQuery.WysiBB.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				var wbbOpt = { buttons: 'bold,italic,underline,strike,|,img,link,|,bullist,numlist,|,fontcolor,fontsize,fontfamily,|,justifyleft,justifycenter,justifywidth,justifyright,|,removeFormat' }
				$('textarea#short-story, textarea#full-story, textarea#content').wysibb(wbbOpt);
				$('select').styler();
				$('div.tabs-content').hide();
				$('ul.tabs li:first').addClass('active').show();
				$('div.tabs-content:first').show();
				$('ul.tabs li[data-type="tab"]').click(function() {
					$('ul.tabs li').removeClass('active');
					$(this).addClass('active');
					$('div.tabs-content').hide();
					var activeTab = $(this).find('a').attr('data-href');
					$(activeTab).show();
					return false;
				});
			});
		</script>
		<title>{p-title} » Панель управления {engine-name}</title>
	</head>
	<body>
		<div class="wrapper">
			<div class="login-panel">
				Здравствуйте, <b>{username}</b>!<br>
				<a href="{logout-link}">Выйти</a>
			</div>
			<div class="title-panel">{engine-name}</div>
			<div class="links-panel">
				<a href="{admin-link}">Главная</a><br>
				<a target="_blank" href="{main-link}">Просмотр сайта</a>
			</div>
			<div class="divider"><span></span></div>
			{p-content}
			<div class="divider"><span></span></div>
			<div class="footer">
				<a href="{admin-link}">{engine-name}</a> © 2014-2015 - All rights reserved<br>
				<em>Powered by <a target="_blank" href="http://bravel.ru/">Bravel Web Studio</a></em>
			</div>
		</div>
	</body>
</html>