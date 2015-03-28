<div class="content">
				<div class="header index">Управление скриптом</div>
				<a class="no-decorate" href="{configuration-link}"><div class="element">1. Изменение конфигурации</div></a>
				<a class="no-decorate" href="{optimizer-link}"><div class="element last">2. Мастер оптимизации</div></a>
			</div>
			<div class="content">
				<div class="header news">Новости</div>
				<a class="no-decorate" href="{add-news-link}"><div class="element">1. Добавить новость</div></a>
				<a class="no-decorate" href="{add-category-link}"><div class="element">2. Добавить категорию</div></a>
				<a class="no-decorate" href="{news-link}"><div class="element">3. Управление новостями</div></a>
				<a class="no-decorate" href="{categories-link}"><div class="element last">4. Управление категориями</div></a>
			</div>
			<div class="content">
				<div class="header static">Статические страницы</div>
				<a class="no-decorate" href="{add-static-link}"><div class="element">1. Добавить статическую страницу</div></a>
				<a class="no-decorate" href="{static-link}"><div class="element last">2. Управление статическими страницами</div></a>
			</div>
			<div class="content">
				<div class="block info">
					<div class="header info">Информация о движке</div>
					<div class="element">
						<div class="center-text">
							Текущая версия движка: <b>{version}</b>
							<div class="space_10px clearfix"></div>
							[version-error]<font color="#E70024">Ошибка получения версии!</font>[/version-error]
							[version-normal]<font color="#61B329">Вы используете самую последнюю версию движка!</font>[/version-normal]
							[version-oldest]<font color="#E70024">Версия движка устарела! Новая: <b>{new-version}</b>. <a target="_blank" href="https://github.com/Accami/Bravel-Web-Engine/releases/download/BWE-{new-version}/{new-version}.zip">Скачать</a>.</font>[/version-oldest]
							<div class="space_10px"></div>
							<a target="_blank" href="http://core.bravel.ru">Официальный сайт</a><br>
							Автор: <b><a target="_blank" href="http://vk.com/id204403882">Accami</a></b>
						</div>
					</div>
				</div>
				<div class="block stats">
					<div class="header stats">Статистика</div>
					<div class="element">
						<div class="table">
							<div class="tr">
								<label>Всего новостей на сайте:</label>
								<div><b>{all-news}</b></div>
							</div>
							<div class="tr">
								<label>Всего комментариев на сайте:</label>
								<div><b>{all-comments}</b></div>
							</div>
						</div>
						<div class="space_10px clearfix"></div>
						<div class="table">
							<div class="tr">
								<label>Всего пользователей зарегистрировано:</label>
								<div><b>{all-users}</b></div>
							</div>
							<div class="tr">
								<label>Зарегистрированных пользователей онлайн:</label>
								<div><b>{online-users}</b></div>
							</div>
							<!--
							<div class="tr">
								<label>Всего пользователей забанено:</label>
								<div><b>{all-bans}</b></div>
							</div>
							-->
							<div class="tr">
								<label>Первый зарегистрированный:</label>
								<div><b>{first-user}</b></div>
							</div>
							<div class="tr">
								<label>Последний зарегистрированный:</label>
								<div><b>{last-user}</b></div>
							</div>
						</div>
						<div class="space_10px clearfix"></div>
						<div class="table">
							<div class="tr last">
								<label>Общий размер Базы Данных:</label>
								<div><b>{db-size}</b></div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>