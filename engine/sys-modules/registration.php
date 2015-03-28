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

if(isset($_POST['registration-send'])) {
	switch($user->checkRegister($functions->strip($_POST['name']), $functions->strip($_POST['username']), $functions->strip($_POST['password']), $functions->strip($_POST['re-password']), $functions->strip($_POST['day']).'.'.$functions->strip($_POST['month']).'.'.$functions->strip($_POST['year']), $functions->strip($_POST['mail']), $functions->strip($_POST['keystring']))) {
		case 1: $message = $templates->info('error', LANG('NAME_REQUIRED')); break;
		case 11: $message = $templates->info('error', LANG('NAME_BIG_LENGTH')); break;
		case 2: $message = $templates->info('error', LANG('LOGIN_IS_INVALID')); break;
		case 3: $message = $templates->info('error', LANG('EMAIL_IS_INVALID')); break;
		case 4: $message = $templates->info('error', LANG('PASSWORD_IS_INVALID')); break;
		case 5: $message = $templates->info('error', LANG('PASSWORDS_DO_NOT_MATCH')); break;
		case 6: $message = $templates->info('error', LANG('DATE_IS_INVALID')); break;
		case 7: $message = $templates->info('error', LANG('LOGIN_ALREADY_EXISTS')); break;
		case 8: $message = $templates->info('error', LANG('EMAIL_ALREADY_EXISTS')); break;
		case 9: $message = $templates->info('error', LANG('IP_ALREADY_EXISTS')); break;
		case 10:
			$status = 'NO';
			if(is_uploaded_file($_FILES['avatar']['tmp_name'])) {
				$extension = @end(explode('.', basename($_FILES['avatar']['name'])));
				if($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg') {
					$size = ceil($_FILES['avatar']['size']/1024);
					if($size < $user->avatarSize) {
						if(move_uploaded_file($_FILES['avatar']['tmp_name'], BASE.'uploads/avatars/'.$functions->strip($_POST['username']).'.png')) {
							$status = 'OK';
						} else { $message = $templates->info('error', LANG('UPLOADING_ERROR')); }
					} else { $message = $templates->info('error', LANG('UPLOADING_FILE_TOO_LARGE'), array('{size}' => $size, '{max-size}' => $user->avatarSize)); }
				} else { $message = $templates->info('error', LANG('UPLOADING_EXTENSION_ERROR')); }
			} else { $status = 'OK'; }
			if($status == 'OK') {
				if($database->getParam('reg-mail-accept') == 'true') {
					$user->registration->sendMail();
					$checked = '0';
				} else { $checked = '1'; }
				$user->registration->register($checked);
				if($database->getParam('write-user-passwords') == 'true') { $user->registration->writePassword(); }
				if($checked == '1') {
					$message = $templates->info('success', LANG('REGISTRATION_FINISHED'));
				} elseif($checked == '0') { $message = $templates->info('success', LANG('REGISTRATION_MAIL_FINISHED'), array('{mail}' => $functions->strip($_POST['mail']))); }
			}
		break;
		case 12: $message = $templates->info('error', LANG('CAPTCHA_IS_INVALID')); break;
	}
}

$templates->load('registration.tpl', 'registration');
$templates->assign('str', '{day-options}', $user->registration->getDayOptions(), 'registration');
$templates->assign('str', '{month-options}', $user->registration->getMonthOptions(), 'registration');
$templates->assign('str', '{year-options}', $user->registration->getYearOptions(), 'registration');
$templates->assign('str', '{name}', isset($_POST['name'])?$functions->strip($_POST['name'], false, true):'', 'registration');
$templates->assign('str', '{username}', isset($_POST['username'])?$functions->strip($_POST['username']):'', 'registration');
$templates->assign('str', '{mail}', isset($_POST['mail'])?$functions->strip($_POST['mail']):'', 'registration');
$templates->assign('str', '{captcha-link}', CAPTCHA_LINK, 'registration');

$pagesData['p-content'] = $templates->display('registration');
$pagesData['p-info'] = $message;
$pagesData['p-title'] = 'Регистрация пользователя';
?>