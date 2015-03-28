<!DOCTYPE html>
<html>
	<head>
		{p-headers}
		<link rel="shortcut icon" href="{THEME}/admin/images/favicon.ico">
		<link type="text/css" rel="stylesheet" href="{THEME}/admin/css/styles.css">
		<script type="text/javascript" src="{THEME}/js/jQuery-1.9.1.min.js"></script>
		<title>{p-title} » {engine-name}</title>
	</head>
	<body>
		<div class="wrapper login">
			<div class="title-cp">Панель управления</div>
			<div class="divider"><span></span></div>
			<form autocomplete="on" action="" method="POST">
				[message]<div class="login-error"><b>Ошибка</b> (<a title="{message}">?</a>)</div>[/message]
				<div class="style-input input-login"><input type="text" name="username" placeholder="Логин"></div>
				<div class="space_5px"></div>
				<div class="style-input input-login"><input type="password" name="password" placeholder="Пароль"></div>
				<div class="divider"><span></span></div>
				<div class="left" style="padding-top: 4px;"><label><input class="checkbox" type="checkbox" id="remember" name="remember"> Запомнить</label></div>
				<div class="right"><button type="submit" name="admin-send" class="button">Войти в ПУ</button></div>
			</form>
			<div class="clearfix"></div>
		</div>
	</body>
</html>