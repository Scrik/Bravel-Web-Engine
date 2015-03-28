[!logged]
<div class="content-container">
	<div class="content-title">Восстановление пароля</div>
	<div class="content-text">
		<form autocomplete="off" action="" method="POST">
			<table class="left" width="400px" border="0" cellpadding="0" cellspacing="0">
				<tr style="margin-bottom: 10px;">
					<td width="212px"><div class="td-space">Логин от забытого аккаунта</div></td>
					<td width="188px"><div class="style-input"><input type="text" name="username" value="{username}"></div></td>
				</tr>
				<tr style="margin-bottom: 10px;">
					<td width="212px"><div class="td-space">E-Mail от забытого аккаунта</div></td>
					<td width="188px"><div class="style-input"><input type="text" name="mail" value="{mail}"></div></td>
				</tr>
				<tr style="margin-bottom: 10px;">
					<td width="212px"><div class="td-space">Код с картинки</div></td>
					<td width="188px"><div class="style-input"><input type="text" name="keystring"></div></td>
				</tr>
				<tr>
					<td width="212px"></td>
					<td width="188px"><button type="submit" name="forgotPassword-send" class="button">Отправить</button></td>
				</tr>
			</table>
			<div class="right">
				<img id="captcha" class="img-polaroid" src="{captcha-link}">
				<p class="center-text"><a href="javascript:reload('#captcha', '{captcha-link}');">Обновить картинку</a></p>
			</div>
			<div class="clearfix"></div>
		</form>
	</div>
</div>
[/!logged]
[logged]
[info="error"]Вы уже авторизированы.[/info]
[/logged]