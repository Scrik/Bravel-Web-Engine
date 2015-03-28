<form action="" method="POST">
	<table class="left" width="400px" border="0" cellpadding="0" cellspacing="0">
		Опция удаления старых таблиц - это в том случае, если вы уже<br>
		устанавливали движок ранее и старые таблицы остались.<br><br>
		<tr style="margin-bottom: 10px;">
			<td width="192px"><div class="td-space">Адрес MySQL</div></td>
			<td width="208px"><div class="style-input"><input type="text" name="db-host" value="{db-host}"></div></td>
		</tr>
		<tr style="margin-bottom: 10px;">
			<td width="192px"><div class="td-space">Пользователь MySQL</div></td>
			<td width="208px"><div class="style-input"><input type="text" name="db-user" value="{db-user}"></div></td>
		</tr>
		<tr style="margin-bottom: 10px;">
			<td width="192px"><div class="td-space">Пароль пользователя MySQL</div></td>
			<td width="208px"><div class="style-input"><input type="password" name="db-pass" value="{db-pass}"></div></td>
		</tr>
		<tr style="margin-bottom: 20px;">
			<td width="192px"><div class="td-space">Имя базы MySQL</div></td>
			<td width="208px"><div class="style-input"><input type="text" name="db-base" value="{db-base}"></div></td>
		</tr>
		<tr style="margin-bottom: 10px;">
			<td width="192px"><div class="td-space">Префикс таблиц</div></td>
			<td width="208px"><div class="style-input"><input type="text" name="db-prefix" value="{db-prefix}"></div></td>
		</tr>
		<tr style="margin-bottom: 10px;">
			<td width="192px"></td>
			<td width="208px"><label><input class="checkbox" type="checkbox" name="drop-tables"> Удалить старые таблицы</label></td>
		</tr>
		<tr>
			<td width="192px"></td>
			<td width="208px"><button type="submit" name="goToStep3" class="button">Далее</button></td>
		</tr>
	</table>
</form>