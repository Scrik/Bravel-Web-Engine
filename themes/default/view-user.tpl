<div class="content-container">
	<div class="content-title">Профиль пользователя <b>{username}</b></div>
	<div class="content-text">
		<div class="left" style="width: 180px;"><a target="_blank" href="{avatar-link}"><img class="img-polaroid" src="{avatar}" alt="User avatar"></a></div>
		<div class="right" style="width: 438px;">
			<div class="table" style="width: 100%;">
				<div class="tr">
					<label>Имя:</label>
					<div><b>{name}</b></div>
				</div>
				<div class="tr">
					<label>Логин:</label>
					<div><b>{username}</b></div>
				</div>
				<div class="tr">
					<label>Статус:</label>
					<div><b>[online]<b style="color: #61B329;">Онлайн</b>[/online][offline]<b style="color: #E70024;">Оффлайн</b>[/offline]</b></div>
				</div>
				<div class="tr">
					<label>Группа пользователя:</label>
					<div><b>{group}</b></div>
				</div>
				<div class="tr">
					<label>Дата регистрации:</label>
					<div><b>{reg-date}</b></div>
				</div>
				<div class="tr">
					<label>Последний визит:</label>
					<div><b>{last-date}</b></div>
				</div>
				[referral]
				<div class="tr">
					<label>Был приглашен:</label>
					<div><b><a target="_blank" href="{referral-link}">{referral}</a></b></div>
				</div>
				[/referral]
				<div class="tr last">
					<label>Пригласил:</label>
					<div><b>{referrers} человек(-а)</b></div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>