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

if($user->checkLogged()) {
	$username = $user->getArray('username');
	$_POST['name'] = $user->getArray('name');
	$_POST['mail'] = $user->getArray('mail');
} else { $username = '---'; }

if(isset($_POST['feedBack-send'])) {
	switch($user->checkFeed_back($functions->strip($_POST['name']), $functions->strip($_POST['mail']), $functions->strip($_POST['subject']), $functions->strip($_POST['message']), $functions->strip($_POST['keystring']))) {
		case 1: $message = $templates->info('error', LANG('ALL_FIELDS_REQUIRED')); break;
		case 2:
			$mail->setTo($database->getParam('admin-mail'));
			$mail->setSubject(MAIL_MSG('FEED-BACK_T'));
			$mail->setMessage(str_replace(
				array('{name}', '{mail}', '{username}', '{subject}', '{message}', '{site-name}'),
				array($functions->strip($_POST['name'], false, true), $functions->strip($_POST['mail']), $username, $functions->strip($_POST['subject'], false, true), $functions->strip($_POST['message'], true), $database->getParam('title')),
				MAIL_MSG('FEED-BACK')
			));
			$mail->send();
			$message = $templates->info('success', LANG('MESSAGE_WERE_SENDED'));
		break;
		case 3: $message = $templates->info('error', LANG('CAPTCHA_IS_INVALID')); break;
	}
}

$templates->load('feed-back.tpl', 'feed-back');
$templates->assign('str', '{name}', isset($_POST['name'])?$functions->strip($_POST['name'], false, true):'', 'feed-back');
$templates->assign('str', '{mail}', isset($_POST['mail'])?$functions->strip($_POST['mail']):'', 'feed-back');
$templates->assign('str', '{subject}', isset($_POST['subject'])?$functions->strip($_POST['subject'], false, true):'', 'feed-back');
$templates->assign('str', '{message}', isset($_POST['message'])?$functions->strip($_POST['message'], false, true):'', 'feed-back');
$templates->assign('str', '{captcha-link}', CAPTCHA_LINK, 'feed-back');

$pagesData['p-content'] = $templates->display('feed-back');
$pagesData['p-info'] = $message;
$pagesData['p-title'] = 'Обратная связь';
?>