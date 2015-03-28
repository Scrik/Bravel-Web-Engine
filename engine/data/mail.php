<?php
/* *
 * Bravel Web Engine – Content Management System <http://core.bravel.ru/>
 * Copyright © 2015 Popov Andrey <http://bravel.ru/>
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License,
 * or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

if(!defined('INC_CHECK')) { die('Scat!'); }

function MAIL_MSG($message) {
	$messages = array(
		
		'REGISTRATION_T'     => 'Регистрация',
		'REGISTRATION'       => '<div style="background: #F7F7F8; padding: 20px; font-family: Verdana; font-size: 12px; font-weight: normal; font-style: normal; line-height: 20px;">'.
								'<h1>Подтверждение регистрации</h1><br>'.
								'Здравствуйте, {username}.<br>'.
								'Для подтверждения регистрации перейдите по следующей ссылке:<br>'.
								'{accept-link}<br><br>'.
								'С уважением, администрация <u>{site-name}</u>.'.
								'</div>',
		
		'FORGOT-PASSWORD_T'  => 'Восстановление пароля',
		'FORGOT-PASSWORD'    => '<div style="background: #F7F7F8; padding: 20px; font-family: Verdana; font-size: 12px; font-weight: normal; font-style: normal; line-height: 20px;">'.
								'<h1>Восстановление пароля</h1><br>'.
								'Здравствуйте, <b>{username}</b>.<br>'.
								'Ваш новый пароль (<b>желательно сменить его после входа</b>):<br>'.
								'{password}<br><br>'.
								'С уважением, администрация <u>{site-name}</u>.'.
								'</div>',
		
		'FEED-BACK_T'        => 'Новое письмо',
		'FEED-BACK'          => '<div style="background: #F7F7F8; padding: 20px; font-family: Verdana; font-size: 12px; font-weight: normal; font-style: normal; line-height: 20px;">'.
								'Здравствуйте, уважаемый администратор сайта <u>{site-name}</u>.<br>'.
								'Вам было отправлено сообщение:<br><br>'.
								'Имя отправителя: <b>{name}</b><br>'.
								'E-Mail отправителя: <b>{mail}</b><br>'.
								'Логин отправителя: <b>{username}</b><br>'.
								'Тема сообщения: <b>{subject}</b><br>'.
								'Сообщение:<br>'.
								'<i>{message}</i>'.
								'</div>',
		
		'NEW-COMMENT_T'      => 'Оповещение',
		'NEW-COMMENT'        => '<div style="background: #F7F7F8; padding: 20px; font-family: Verdana; font-size: 12px; font-weight: normal; font-style: normal; line-height: 20px;">'.
								'Здравствуйте, уважаемый администратор сайта <u>{site-name}</u>.<br>'.
								'На сайте только что был добавлен новый комментарий.<br><br>'.
								'Ссылка на новость: <b>{news-link}</b><br>'.
								'Имя комментатора: <b>{name}</b><br>'.
								'E-Mail комментатора: <b>{mail}</b><br>'.
								'Логин комментатора: <b>{username}</b><br>'.
								'Комментарий:<br>'.
								'<i>{comment}</i>'.
								'</div>'
		
	);
	return $messages[$message];
}
?>