[!logged]
<div class="content-container">
	<div class="content-title">Регистрация пользователя</div>
	<div class="content-text">
		<i class="read-terms">*При нажатии кнопки "Зарегистрироваться" вы автоматически соглашаетесь <a target="_blank" href="{terms-link}">с нашими правилами</a></i><br><br>
		<form enctype="multipart/form-data" autocomplete="off" action="" method="POST">
			<table class="left" width="400px" border="0" cellpadding="0" cellspacing="0">
				<tr style="margin-bottom: 10px;">
					<td width="192px"><div class="td-space">Ваше имя</div></td>
					<td width="208px"><div class="style-input big"><input type="text" name="name" value="{name}"></div></td>
				</tr>
				<tr style="margin-bottom: 10px;">
					<td width="192px"><div class="td-space">Логин</div></td>
					<td width="208px"><div class="style-input big"><input type="text" name="username" value="{username}"></div></td>
				</tr>
				<tr style="margin-bottom: 10px;">
					<td width="192px"><div class="td-space">Ваш E-Mail</div></td>
					<td width="208px"><div class="style-input big"><input type="text" name="mail" value="{mail}"></div></td>
				</tr>
				<tr style="margin-bottom: 10px;">
					<td width="192px"><div class="td-space">Пароль (<a id="show-hide"></a>)</div></td>
					<td width="208px"><div class="style-input big"><input type="password" id="reg-password" name="password"></div></td>
				</tr>
				<tr style="margin-bottom: 10px;">
					<td width="192px"><div class="td-space">Повторите пароль</div></td>
					<td width="208px"><div class="style-input big"><input type="password" id="reg-re-password" name="re-password"></div></td>
				</tr>
				<tr style="margin-bottom: 10px;">
					<td width="192px"><div class="td-space">Аватар</div></td>
					<td width="208px"><input type="file" id="avatar" name="avatar"></td>
				</tr>
				<tr style="margin-bottom: 20px;">
					<td width="192px"><div class="td-space">Дата рождения</div></td>
					<td width="208px">
						<div class="right">
							<select name="day">{day-options}</select>
							<select name="month">{month-options}</select>
						</div>
						<div class="clearfix space_5px"></div>
						<div class="right">
							<select name="year">{year-options}</select>
						</div>
					</td>
				</tr>
				<tr>
					<td width="192px"></td>
					<td width="208px"><button type="submit" name="registration-send" class="button">Зарегистрироваться</button></td>
				</tr>
			</table>
			<div class="right">
				<img id="captcha" class="img-polaroid" src="{captcha-link}">
				<p class="center-text"><a href="javascript:reload('#captcha', '{captcha-link}');">Обновить картинку</a></p>
				<p><div class="style-input"><input style="text-align: center;" type="text" id="keystring" name="keystring" placeholder="Код с картинки"></div></p>
			</div>
			<div class="clearfix"></div>
		</form>
	</div>
</div>
[/!logged]
[logged]
[info="error"]Вы уже авторизированы.[/info]
[/logged]