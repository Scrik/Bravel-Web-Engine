<div class="content">
				[message]<div class="alert info">{message}</div>[/message]
				<h2>Изменение новости</h2>
				<div class="space_10px"></div>
				[form]
				<form autocomplete="off" action="" method="POST">
					<h3>Заголовок:</h3>
					<div class="space_5px"></div>
					<div class="style-input"><input type="text" name="title" value="{title}"></div>
					<div class="space_10px"></div>
					<h3>Категория:</h3>
					<div class="space_5px"></div>
					{category-selector}
					<div class="space_10px"></div>
					<h3>Краткая новость:</h3>
					<div class="space_5px"></div>
					<textarea type="text" name="short-story" id="short-story">{short-story}</textarea>
					<div class="space_10px"></div>
					<h3>Полная новость:</h3>
					<div class="space_5px"></div>
					<textarea type="text" name="full-story" id="full-story">{full-story}</textarea>
					<div class="space_10px"></div>
					<h3>Превью-картинка:</h3>
					<div class="space_5px"></div>
					<i>*Оставьте поле пустым, если не хотите использовать превью-картинку.</i><br>
					<i>*Вводить полный путь к картинке <b>вместе с http://</b>, ширина - <b>{x-width}px</b>, высота - <b>{x-height}px</b>.</i>
					<div class="space_5px"></div>
					<div class="style-input"><input type="text" name="x-image" value="{x-image}"></div>
					<div class="space_10px"></div>
					<div class="space_5px"></div>
					<button name="edit-news" type="submit" class="button">Изменить</button>
				</form>
				[/form]
			</div>