[logged]
<div class="content-container">
	<div class="content-title">Здравствуйте, {username} | <a target="_blank" href="{profile-link}">Профиль на сайте</a></div>
	<div class="content-text account">
		<ul class="tabs">
			<li class="lt" data-type="tab"><a data-href="#main">Главная</a></li>
			<li class="lt" data-type="tab"><a data-href="#data">Изменение данных</a></li>
			<li class="lt" data-type="tab"><a data-href="#security">Безопасность</a></li>
			<li class="lt" data-type="tab"><a data-href="#other">Другое</a></li>
			<li class="rt"><a href="{logout-link}">Выход</a></li>
			[admin]<li class="rt"><a target="_blank" href="{admin-link}">ПУ</a></li>[/admin]
		</ul>
		<div class="tabs-container">
			<div id="main" class="tabs-content">
				[birthday]<div class="birthday">С днем рождения, <b>{name}</b>! Сегодня вам исполнилось <b>{age}</b>? :)</div>[/birthday]
				<div class="table" style="width: 100%;">
					<div class="left" style="width: 180px;"><a target="_blank" href="{avatar-link}"><img class="img-polaroid" src="{avatar}" alt="User avatar"></a></div>
					<div class="right" style="width: 438px;">
						<div class="tr">
							<label>Ваше имя:</label>
							<div><b>{name}</b></div>
						</div>
						<div class="tr">
							<label>Ваш логин:</label>
							<div><b>{username}</b></div>
						</div>
						<div class="tr">
							<label>Ваш день рождения:</label>
							<div><b>{birth}</b></div>
						</div>
						<div class="tr">
							<label>Ваш E-Mail:</label>
							<div><b>{mail}</b></div>
						</div>
						<div class="tr">
							<label>Ваша группа:</label>
							<div><b>{group}</b></div>
						</div>
						<div class="tr">
							<label>Дата регистрации:</label>
							<div><b>{reg-date}</b></div>
						</div>
						<div class="tr">
							<label>Последний визит:</label>
							<div><b>{last-date}</b></div>
						</div>
						<p class="center-text ip">IP-Адрес:</p>
						<div class="tr">
							<label>При регистрации:</label>
							<div><b>{reg-ip}</b></div>
						</div>
						<div class="tr last">
							<label>Сейчас:</label>
							<div><b>{now-ip}</b></div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div id="data" class="tabs-content">
				<form enctype="multipart/form-data" autocomplete="off" action="" method="POST">
					<table width="400px" border="0" cellpadding="0" cellspacing="0">
						<tr style="margin-bottom: 10px;">
							<td width="192px"><div class="td-space">Логин</div></td>
							<td width="208px"><div class="style-input big readonly"><input type="text" value="{username}" readonly></div></td>
						</tr>
						<tr style="margin-bottom: 10px;">
							<td width="192px"><div class="td-space">Имя</div></td>
							<td width="208px"><div class="style-input big"><input type="text" name="name" value="{name-value}"></div></td>
						</tr>
						<tr style="margin-bottom: 10px;">
							<td width="192px"><div class="td-space">E-Mail</div></td>
							<td width="208px"><div class="style-input big"><input type="text" name="mail" value="{mail-value}"></div></td>
						</tr>
						<tr style="margin-bottom: 10px;">
							<td width="192px"><div class="td-space">Аватар (<a title="Выбирайте как можно более квадратные изображения, для их лучшего отображения">совет</a>)</div></td>
							<td width="208px">
								<input type="file" id="avatar" name="avatar">
								<div class="space_5px"></div>
								<label><input class="checkbox" type="checkbox" name="delete-current-avatar"> Удалить текущий аватар</label>
							</td>
						</tr>
						<tr>
							<td width="192px"></td>
							<td width="208px"><button type="submit" name="data-send" class="button">Изменить</button></td>
						</tr>
					</table>
				</form>
			</div>
			<div id="security" class="tabs-content">
				<form autocomplete="off"action="" method="POST">
					<table width="400px" border="0" cellpadding="0" cellspacing="0">
						<tr style="margin-bottom: 10px;">
							<td width="192px"><div class="td-space">Старый пароль</div></td>
							<td width="208px"><div class="style-input big"><input type="password" id="old-password" name="old-password"></div></td>
						</tr>
						<tr style="margin-bottom: 10px;">
							<td width="192px"><div class="td-space">Новый пароль</div></td>
							<td width="208px"><div class="style-input big"><input type="password" id="new-password" name="new-password"></div></td>
						</tr>
						<tr style="margin-bottom: 10px;">
							<td width="192px"><div class="td-space">Повторите пароль</div></td>
							<td width="208px"><div class="style-input big"><input type="password" id="re-new-password" name="re-new-password"></div></td>
						</tr>
						<tr>
							<td width="192px"></td>
							<td width="208px">
								<div class="left"><button type="submit" name="changePassword-send" class="button">Изменить</button></div>
								<div class="right"><button type="button" class="button" onClick="toggle('#old-password'), toggle('#new-password'), toggle('#re-new-password')">Показать / Скрыть</button></div>
								<div class="clearfix"></div>
							</td>
						</tr>
					</table>
				</form>
			</div>
			<div id="other" class="tabs-content">
				<div style="width: 50%;" class="table">
					[referral]
					<div class="tr">
						<label>Вас пригласил:</label>
						<div><b><a target="_blank" href="{referral-link}">{referral}</a></b></div>
					</div>
					[/referral]
					<div class="tr">
						<label>Вы пригласили:</label>
						<div><b>{referrers} человек(-а)</b></div>
					</div>
				</div>
				<div class="clearfix space_10px"></div>
				Ваша реферальная ссылка:
				<div class="clearfix space_5px"></div>
				<div class="style-input big readonly"><input type="text" value="{invite-link}" readonly></div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
[/logged]
[!logged]
<div class="content-container">
	<div class="content-title">Вход в систему</div>
	<div class="content-text">
		<form autocomplete="on" action="" method="POST">
			<table width="400px" border="0" cellpadding="0" cellspacing="0">
				<tr style="margin-bottom: 10px;">
					<td width="192px"><div class="td-space">Логин (<a href="{registration-link}">Еще нет?</a>)</div></td>
					<td width="208px"><div class="style-input big"><input type="text" name="username" value="{username}"></div></td>
				</tr>
				<tr style="margin-bottom: 10px;">
					<td width="192px"><div class="td-space">Пароль (<a href="{forgot-link}">Забыли?</a>)</div></td>
					<td width="208px"><div class="style-input big"><input type="password" id="password" name="password" value="{password}"></div></td>
				</tr>
				<tr style="margin-bottom: 10px;">
					<td width="192px"></td>
					<td width="208px"><label><input class="checkbox" type="checkbox" name="remember"> Запомнить меня</label></td>
				</tr>
				<tr>
					<td width="192px"></td>
					<td width="208px">
						<div class="left"><button type="submit" name="login-send" class="button">Отправить</button></div>
						<div class="right"><button type="button" onClick="toggle('#password')" class="button">Показать / Скрыть</button></div>
						<div class="clearfix"></div>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
[/!logged]