[logged]
<div class="sidebar-container">
	<div class="sidebar-title">Здравствуйте, <b title="{username-full}">{username}</b></div>
	<div class="sidebar-text lb-logged">
		<ul>
			<li><a class="button" href="{cabinet-link}">Личный кабинет</a></li>
			<li><a class="button" href="{profile-link}">Профиль на сайте</a></li>
			[admin]<li><a class="button" target="_blank" href="{admin-link}">Панель управления</a></li>[/admin]
			<li class="last"><a class="button" href="{logout-link}">Выход из аккаунта</a></li>
		</ul>
	</div>
</div>
[/logged]
[!logged]
<div class="sidebar-container">
	<div class="sidebar-title">Вход в систему</div>
	<div class="sidebar-text">
		<form autocomplete="on" action="{cabinet-link}" method="POST">
			<div class="lb-main">
				<div class="lb-field padding">
					<div class="field-input left"><input type="text" name="username" placeholder="Логин"></div>
					<div class="field-text right"><a href="{registration-link}">Еще нет?</a></div>
					<div class="clearfix"></div>
				</div>
				<div class="lb-field password padding">
					<div class="field-input left"><input type="password" name="password" placeholder="*****"></div>
					<div class="field-text password right"><a href="{forgot-link}">Забыли?</a></div>
					<div class="clearfix"></div>
				</div>
				<div class="lb-remember-field">
					<label><input class="checkbox" type="checkbox" name="remember"> Запомнить меня</label>
				</div>
				<div>
					<div class="button-login left"><button type="submit" name="login-send" class="button">Войти</button></div>
					<div class="button-show-hide right"><button type="button" class="button" onClick="toggle('.lb-field.password input')">Показать / Скрыть</button></div>
					<div class="clearfix"></div>
				</div>
			</div>
		</form>
	</div>
</div>
[/!logged]