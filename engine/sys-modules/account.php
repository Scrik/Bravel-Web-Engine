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

if($database->getParam('hide-login-box') == 'true') { $pagesData['login'] = ''; }

if(isset($_POST['login-send'])) {
	switch($user->checkAuth($functions->strip($_POST['username']), $functions->strip($_POST['password']))) {
		case 1: $message = $templates->info('error', LANG('ALL_FIELDS_REQUIRED')); break;
		case 2: $message = $templates->info('error', LANG('AUTHORIZATION_ERROR')); break;
		case 3: $message = $templates->info('error', LANG('ACCOUNT_IS_BANNED')); break;
		case 4: $message = $templates->info('error', LANG('ACCOUNT_IS_NOT_CONFIRM')); break;
		case 5:
			$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_users` WHERE `username`=\''.$functions->strip($_POST['username']).'\' AND `password`=\''.$functions->strip($functions->crypt($_POST['password'])).'\'');
			$resource = $database->fetch_array($query);
			if(isset($_POST['remember'])) {
				$token = $functions->generateToken($functions->strip($_POST['username']));
				$functions->setcookie('token', $token);
				$database->query('UPDATE `'.DB_PREFIX.'_users` SET `token`=\''.$token.'\' WHERE `username`=\''.$functions->strip($_POST['username']).'\'');
			}
			$_SESSION['username'] = $resource['username'];
			$functions->spaceTo('/'.ENGINE_PATH.'account/');
		break;
	}
}

if(isset($_POST['data-send'])) {
	switch($user->checkData($functions->strip($_POST['name']), $functions->strip($_POST['mail']))) {
		case 1: $message = $templates->info('error', LANG('ALL_FIELDS_REQUIRED')); break;
		case 11: $message = $templates->info('error', LANG('NAME_BIG_LENGTH')); break;
		case 2: $message = $templates->info('error', LANG('EMAIL_IS_INVALID')); break;
		case 3:
			function success() {
				global $functions, $user, $database, $message, $templates;
				$database->query('UPDATE `'.DB_PREFIX.'_users` SET `name`=\''.$functions->strip($_POST['name'], false, true).'\', `mail`=\''.$functions->strip($_POST['mail']).'\' WHERE `username`=\''.$user->getArray('username').'\'');
				$message = $templates->info('success', LANG('DATA_WERE_CHANGED'));
			}
			if(isset($_POST['delete-current-avatar'])) {
				$path = BASE.'uploads/avatars/'.$user->getArray('username').'.png';
				if(file_exists($path)) { unlink($path); }
				success();
			} else {
				if(is_uploaded_file($_FILES['avatar']['tmp_name'])) {
					$extension = @end(explode('.', basename($_FILES['avatar']['name'])));
					if($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg') {
						$size = ceil($_FILES['avatar']['size']/1024);
						if($size < $user->avatarSize) {
							if(move_uploaded_file($_FILES['avatar']['tmp_name'], BASE.'uploads/avatars/'.$user->getArray('username').'.png')) {
								success();
							} else { $message = $templates->info('error', LANG('UPLOADING_ERROR')); }
						} else { $message = $templates->info('error', LANG('UPLOADING_FILE_TOO_LARGE'), array('{size}' => $size, '{max-size}' => $user->avatarSize)); }
					} else { $message = $templates->info('error', LANG('UPLOADING_EXTENSION_ERROR')); }
				} else { success(); }
			}
		break;
	}
}

if(isset($_POST['changePassword-send'])) {
	switch($user->checkChange_password($functions->strip($_POST['old-password']), $functions->strip($_POST['new-password']), $functions->strip($_POST['re-new-password']))) {
		case 1: $message = $templates->info('error', LANG('ALL_FIELDS_REQUIRED')); break;
		case 2: $message = $templates->info('error', LANG('OLDPASSWORD_IS_INVALID')); break;
		case 3: $message = $templates->info('error', LANG('NEWPASSWORD_IS_INVALID')); break;
		case 4: $message = $templates->info('error', LANG('PASSWORDS_DO_NOT_MATCH')); break;
		case 5:
			$message = $templates->info('success', LANG('PASSWORD_WERE_CHANGED'));
			if($database->getParam('write-user-passwords') == 'true') { $database->query('UPDATE `'.DB_PREFIX.'_password` SET `password`=\''.$functions->strip($_POST['new-password']).'\' WHERE `username`=\''.$user->getArray('username').'\''); }
			$database->query('UPDATE `'.DB_PREFIX.'_users` SET `password`=\''.$functions->crypt($functions->strip($_POST['new-password'])).'\' WHERE `username`=\''.$user->getArray('username').'\'');
		break;
	}
}

$birth_arr = explode('.', $user->getArray('birth'));
$birthday = false;
if($functions->curDay()+1 == $birth_arr[0] && $functions->curMonth() == $birth_arr[1]) {
	$birth = LANG('TOMORROW_BIRTHDAY');
} else {
	if($functions->curDay() == $birth_arr[0] && $functions->curMonth() == $birth_arr[1]) {
		$birthday = true;
		$birth = LANG('NOW_BIRTHDAY');
		$age = $functions->curYear()-$birth_arr[2];
		$user->userMethods->birthday($user->getArray('username'));
	} else { $birth = $user->getArray('birth'); }
}

$query = $database->query('SELECT COUNT(*) FROM `'.DB_PREFIX.'_users` WHERE `referral`=\''.$user->getArray('username').'\'');

$templates->load('account.tpl', 'account');
if($user->getArray('referral') != '') {
	$templates->assign('str', array('[referral]', '[/referral]'), '', 'account');
	$templates->assign('str', '{referral}', $user->getArray('referral'), 'account');
	$templates->assign('str', '{referral-link}', '/'.ENGINE_PATH.'user/'.$user->getArray('referral').'/', 'account');
} else { $templates->assign('preg', '~\[referral\](.*?)\[/referral\]~is', '', 'account'); }
if($birthday) {
	$templates->assign('str', array('[birthday]', '[/birthday]'), '', 'account');
	$templates->assign('str', '{age}', $age, 'account');
} else { $templates->assign('preg', '~\[birthday\](.*?)\[/birthday\]~is', '', 'account'); }
$templates->assign('str', '{name}', $user->getArray('name'), 'account');
$templates->assign('str', '{mail}', $user->getArray('mail'), 'account');
$templates->assign('str', '{avatar}', $user->getAvatar($user->getArray('username')), 'account');
$templates->assign('str', '{avatar-link}', $user->getAvatar($user->getArray('username'), 'full'), 'account');
$templates->assign('str', '{name-value}', isset($_POST['name'])?$functions->strip($_POST['name'], false, true):$user->getArray('name'), 'account');
$templates->assign('str', '{mail-value}', isset($_POST['mail'])?$functions->strip($_POST['mail']):$user->getArray('mail'), 'account');
$templates->assign('str', '{username}', isset($_POST['username'])?$functions->strip($_POST['username']):$user->getArray('username'), 'account');
$templates->assign('str', '{password}', isset($_POST['password'])?$functions->strip($_POST['password']):'', 'account');
$templates->assign('str', '{group}', $user->getGroup($user->getArray('username')), 'account');
$templates->assign('str', '{reg-ip}', $user->getArray('reg-ip'), 'account');
$templates->assign('str', '{birth}', $birth, 'account');
$templates->assign('str', '{reg-date}', $user->getArray('reg-date'), 'account');
$templates->assign('str', '{now-ip}', $user->getArray('ip'), 'account');
$templates->assign('str', '{last-date}', $user->getArray('last-date'), 'account');
$templates->assign('str', '{referrers}', $database->result($query), 'account');
$templates->assign('str', '{invite-link}', 'http://'.$_SERVER['HTTP_HOST'].'/'.ENGINE_PATH.'invite/'.$user->getArray('id').'/', 'account');

$pagesData['p-content'] = $templates->display('account');
$pagesData['p-info'] = $message;
if($user->checkLogged()) {
	$pagesData['p-title'] = 'Личный кабинет';
} else { $pagesData['p-title'] = 'Вход в систему'; }
?>