<div class="content">
				[message]<div class="alert info">{message}</div>[/message]
				<h2>Изменение статической страницы</h2>
				<div class="space_10px"></div>
				[form]
				<form autocomplete="off" action="" method="POST">
					<h3>Заголовок:</h3>
					<div class="space_5px"></div>
					<div class="style-input"><input type="text" name="title" value="{title}"></div>
					<div class="space_10px"></div>
					<h3>URL (адрес страницы, пример результата: <i>http://{site-link}/do/<u>URL</u>/</i>):</h3>
					<div class="space_5px"></div>
					<div class="style-input"><input type="text" name="url" value="{url}"></div>
					<div class="space_10px"></div>
					<h3>Содержимое страницы:</h3>
					<div class="space_5px"></div>
					<textarea type="text" name="content" id="content">{content}</textarea>
					<div class="space_10px"></div>
					<div class="space_5px"></div>
					<button name="edit-static" type="submit" class="button">Изменить</button>
				</form>
				[/form]
			</div>