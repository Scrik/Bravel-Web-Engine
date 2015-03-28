<div class="content-container">
	<div class="content-title">Обратная связь</div>
	<div class="content-text">
		<form autocomplete="off" action="" method="POST">
			<table class="left" width="400px" border="0" cellpadding="0" cellspacing="0">
				<tr style="margin-bottom: 10px;">
					<td width="192px"><div class="td-space">Ваше имя</div></td>
					<td width="208px"><div class="style-input big[logged] readonly[/logged]"><input type="text" name="name" value="{name}"[logged] readonly[/logged]></div></td>
				</tr>
				<tr style="margin-bottom: 10px;">
					<td width="192px"><div class="td-space">Ваш E-Mail</div></td>
					<td width="208px"><div class="style-input big[logged] readonly[/logged]"><input type="text" name="mail" value="{mail}"[logged] readonly[/logged]></div></td>
				</tr>
				<tr style="margin-bottom: 10px;">
					<td width="192px"><div class="td-space">Тема сообщения</div></td>
					<td width="208px"><div class="style-input big"><input type="text" name="subject" value="{subject}"></div></td>
				</tr>
				<tr style="margin-bottom: 10px;">
					<td width="192px"><div class="td-space">Текст сообщения</div></td>
					<td width="208px"><div class="style-input big textarea"><textarea type="text" name="message">{message}</textarea></div></td>
				</tr>
				<tr>
					<td width="192px"></td>
					<td width="208px"><button type="submit" name="feedBack-send" class="button">Отправить</button></td>
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