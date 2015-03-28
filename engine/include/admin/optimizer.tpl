<div class="content">
				[message]<div class="alert info">{message}</div>[/message]
				<h2>Мастер оптимизации</h2>
				<div class="space_10px"></div>
				<i>
					Мастер оптимизации - модуль, который поможет оптимизировать вашу базу данных.<br>
					В новых версиях количество параметров будет увеличиваться.
				</i>
				<div class="space_10px"></div>
				<form autocomplete="off" action="" method="POST">
					<div class="left">
						<div class="item" style="border-radius: 0; padding: 15px; width: 260px;">
							<h2 class="center-text">DANGER!!!</h2>
							<div class="space_10px"></div>
							<label><input class="checkbox" type="checkbox" name="clear-comments"{clear-comments-status}> Очистить таблицу комментариев</label>
							<div class="space_5px"></div>
							<label><input class="checkbox" type="checkbox" name="clear-users"{clear-users-status}> Очистить таблицу пользователей</label>
							<div class="space_5px"></div>
							<label><input class="checkbox" type="checkbox" name="clear-news"{clear-news-status}> Очистить таблицу новостей</label>
							<div class="space_5px"></div>
							<label><input class="checkbox" type="checkbox" name="clear-static"{clear-static-status}> Очистить таблицу статических страниц</label>
							<div class="space_5px"></div>
							<label><input class="checkbox" type="checkbox" name="clear-passwords"{clear-passwords-status}> Очистить таблицу паролей</label>
							<div class="space_5px"></div>
							<label><input class="checkbox" type="checkbox" name="clear-categories"{clear-categories-status}> Очистить таблицу категорий</label>
						</div>
					</div>
					<div style="width: 500px;" class="right">
						<label><input class="checkbox" type="checkbox" name="non-activated"{non-activated-status}> Удалить всех неактивированных пользователей<!--, которые регистрировались больше часа назад --></label>
						<div class="clearfix space_10px"></div>
						<div class="space_5px"></div>
						<button name="optimize" type="submit" class="button">Выполнить</button>
					</div>
					<div class="clearfix"></div>
				</form>
			</div>