<div class="content configuration">
				[message]<div class="alert info margin">{message}</div>[/message]
				<ul class="tabs">
					<li data-type="tab"><a data-href="#main">Данные о сайте</a></li>
					<li data-type="tab"><a data-href="#other">Другое</a></li>
					<li data-type="tab"><a data-href="#x-image">x-Image</a></li>
				</ul>
				<div class="tabs-container">
					<form autocomplete="off" action="" method="POST">
						<div id="main" class="tabs-content">
							<h3>Временная зона:</h3>
							<div class="space_5px"></div>
							{time-zone-selector}
							<div class="space_10px"></div>
							<h3>Заголовок сайта:</h3>
							<div class="space_5px"></div>
							<div class="style-input"><input type="text" name="title" value="{title}"></div>
							<div class="space_10px"></div>
							<h3>Краткое описание сайта:</h3>
							<div class="space_5px"></div>
							<div class="style-input"><input type="text" name="description" value="{description}"></div>
							<div class="space_10px"></div>
							<h3>Ключевые слова (теги, через запятую):</h3>
							<div class="space_5px"></div>
							<div class="style-input textarea"><textarea name="keywords">{keywords}</textarea></div>
							<div class="space_10px"></div>
							<h3>Причина для отключения сайта:</h3>
							<div class="space_5px"></div>
							<div class="style-input textarea"><textarea name="off-reason">{off-reason}</textarea></div>
						</div>
						<div id="other" class="tabs-content">
							<h3>E-Mail Главного администратора (для оповещений):</h3>
							<div class="space_5px"></div>
							<div class="style-input"><input type="text" name="admin-mail" value="{admin-mail}"></div>
							<div class="space_10px"></div>
							<h3>Максимум новостей на страницу:</h3>
							<div class="space_5px"></div>
							<div class="style-input"><input type="text" name="news-on-page" value="{news-on-page}"></div>
							<div class="space_10px"></div>
							<h3>Максимум комментариев на страницу:</h3>
							<div class="space_5px"></div>
							<div class="style-input"><input type="text" name="comments-on-page" value="{comments-on-page}"></div>
							<div class="space_10px"></div>
							<h3>Максимум символов в комментарии:</h3>
							<div class="space_5px"></div>
							<div class="style-input"><input type="text" name="comment-max-sym" value="{comment-max-sym}"></div>
							<div class="space_10px"></div>
							<h3>Группа администратора (через запятую, номера групп, пример: 5, 6) (если не знаете, что это - то лучше не меняйте):</h3>
							<div class="space_5px"></div>
							<div class="style-input"><input type="text" name="admin-group" value="{admin-group}"></div>
							<div class="space_10px"></div>
							<h3>Используемый шаблон на сайте:</h3>
							<div class="space_5px"></div>
							{theme-selector}
							<div class="space_10px"></div>
							<h3>Выключить сайт:</h3>
							<div class="space_5px"></div>
							{off-site-selector}
							<div class="space_10px"></div>
							<h3>Отправлять сообщение при добавлении нового комментария:</h3>
							<div class="space_5px"></div>
							{send-mail-oncomment-selector}
							<div class="space_10px"></div>
							<h3>Запрашивать подтверждение регистрации по E-Mail:</h3>
							<div class="space_5px"></div>
							{reg-mail-accept-selector}
							<div class="space_10px"></div>
							<h3>Запретить регистрацию с одинаковых IP-адресов:</h3>
							<div class="space_5px"></div>
							{reg-one-ip-selector}
							<div class="space_10px"></div>
							<h3>Записывать незашифрованные пароли пользователей в отдельную таблицу:</h3>
							<div class="space_5px"></div>
							{write-user-passwords-selector}
						</div>
						<div id="x-image" class="tabs-content">
							<i>*<b>x-Image</b> - модуль превью-картинки в новостях.</i><br><br>
							<h3>Высота изображения:</h3>
							<div class="space_5px"></div>
							<div class="style-input"><input type="text" name="x-img-height" value="{x-img-height}"></div>
							<div class="space_10px"></div>
							<h3>Ширина изображения:</h3>
							<div class="space_5px"></div>
							<div class="style-input"><input type="text" name="x-img-width" value="{x-img-width}"></div>
						</div>
						<button style="margin: 0 0 20px 15px;" name="edit-configuration" type="submit" class="button">Изменить</button>
					</form>
				</div>
			</div>