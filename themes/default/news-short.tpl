<div class="content-container">
	<div class="content-title">
		<div class="left">{title}</div>
		[admin]<div class="right">
			<span class="edit"><a><div class="pencil-icon"></div></a>
				<ul class="dropdown">
					<a href="{edit-link}"><li>Изменить новость</li></a>
					<a href="{nullify-link}"><li>Обнулить просмотры</li></a>
					<a href="{delete-link}"><li>Удалить новость</li></a>
				</ul>
			</span>
		</div>[/admin]
		<div class="right"><b class="news-date">{date}</b></div>
		<div class="clearfix"></div>
	</div>
	<div class="content-text">
		[with-x-image]
		<div class="news-left"><img class="img-polaroid" src="{x-image}" alt="X-Image"></div>
		<div class="news-right">{short-story}</div>
		<div class="clearfix"></div>
		[/with]
		[without-x-image]<div class="news-text">{short-story}</div>[/without]
	</div>
	<div class="content-footer">
		<div class="left">[category]<a target="_blank" href="{category-link}">{category}</a> | [/category]Просмотров: <b>{views}</b> | Комментариев: <b>{comments}</b> | <a target="_blank" href="{author-link}">{author}</a></div>
		<div class="right no-padding"><a href="{full-link}" class="button">Читать полностью</a></div>
		<div class="clearfix"></div>
	</div>
</div>