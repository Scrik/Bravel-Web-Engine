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

include(BASE.'engine/classes/user-methods.class.php');
include(BASE.'engine/classes/registration.class.php');

class user {
	
	public $avatarSize = 768; // максимальный размер аватарки (в килобайтах)
	public $avatarHeight = 150; // высота аватарки (в пикселях)
	public $avatarWidth = 150; // ширина аватарки (в пикселях)
	
	public $userMethods = '';
	public $registration = '';
	public $rand_pass = '';
	
	public function __construct() {
		$this->userMethods = new userMethods();
		$this->registration = new registration();
	}
	
	public function invitedBy($by_id) {
		if(!$this->checkLogged()) {
			if(empty($_COOKIE['referral'])) {
				global $database;
				$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_users` WHERE `id`=\''.$by_id.'\'');
				if($database->num_rows($query) == 1) {
					$resource = $database->fetch_array($query);
					$functions->setcookie('referral', $resource['username']);
				}
			}
		}
	}
	
	public function getUserIp() {
		if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else { $ip = $_SERVER['REMOTE_ADDR']; }
		return $ip;
	}
	
	public function checkOnline($username) {
		global $database, $functions;
		$time = $this->getArray('time', $username);
		if($time != 0) {
			if($time > $functions->getTime()-USER_TIMEOUT) {
				return true;
			} else { return false; }
		} else { return false; }
	}
	
	public function userAdmin() {
		global $database;
		if($this->checkLogged()) {
			$groups = $database->getParam('admin-group');
			if(stripos($groups, ', ') === false) {
				$array = array($groups);
			} else { $array = explode(', ', $groups); }
			if(in_array($this->getArray('group'), $array)) {
				return true;
			} else { return false; }
		} else { return false; }
	}
	
	public function getAvatar($username, $type = 'normal') {
		global $database;
		if(file_exists(BASE.'uploads/avatars/'.$username.'.png')) {
			if($type == 'normal') {
				return getResizeLink('/'.ENGINE_PATH.'uploads/avatars/'.$username.'.png', $this->avatarWidth, $this->avatarHeight);
			} elseif($type == 'full') { return '/'.ENGINE_PATH.'uploads/avatars/'.$username.'.png'; }
		} else { return getResizeLink('/'.ENGINE_PATH.'themes/'.$database->getParam('theme').'/images/no-avatar.png', $this->avatarWidth, $this->avatarHeight); }
	}
	
	public function update() {
		global $database, $functions;
		if($this->checkLogged()) {
			$database->query('UPDATE `'.DB_PREFIX.'_users` SET `last-date`=\''.$functions->curDate().'\', `ip`=\''.$this->getUserIp().'\' WHERE `username`=\''.$this->getArray('username').'\'');
			$database->query('UPDATE `'.DB_PREFIX.'_users` SET `time`=\''.$functions->getTime().'\' WHERE `username`=\''.$this->getArray('username').'\'');
		}
		if(!$this->checkLogged() && $this->checkCookie()) {
			$token = $functions->strip($_COOKIE['token']);
			$query = $database->query('SELECT `username` FROM `'.DB_PREFIX.'_users` WHERE `token`=\''.$token.'\'');
			$username = @$database->result($query);
			if($username == '') {
				$functions->deletecookie('token');
			} else { $_SESSION['username'] = $username; }
		}
	}
	
	public function getArray($string, $username = '') {
		global $database, $functions;
		if($username != '') {
			$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_users` WHERE `username`=\''.$username.'\'');
			$resource = $database->fetch_array($query);
			return $resource[$string];
		} else {
			if($this->checkLogged()) {
				$username = $functions->strip($_SESSION['username']);
				$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_users` WHERE `username`=\''.$username.'\'');
				$resource = $database->fetch_array($query);
				return $resource[$string];
			} else { return false; }
		}
	}
	
	public function getPermission($section) {
	global $database;
		if($this->checkLogged()) {
			$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_users` WHERE `username`=\''.$this->getArray('username').'\'');
			$resource = $database->fetch_array($query);
			$permissions = explode(';', $resource['permissions']);
			if($section == 'allow-admin') {
				return $permissions[0];
			} elseif($section == 'allow-offline') { return $permissions[1]; }
		} else { return false; }
	}
	
	public function getGroup($username) {
		$do = true;
		if($this->getArray('checked', $username) == '0') {
			return LANG('GROUP_NOT_ACTIVATED');
			$do = false;
		}
		if($do) {
			switch($this->getArray('group', $username)) {
				case '0': return LANG('GROUP_0'); break;
				case '1': return LANG('GROUP_1'); break;
				case '2': return LANG('GROUP_2'); break;
				case '3': return LANG('GROUP_3'); break;
				case '4': return LANG('GROUP_4'); break;
				case '5': return LANG('GROUP_5'); break;
				case '6': return LANG('GROUP_6'); break;
			}
		}
	}
	
	public function checkLogged() {
		if(isset($_SESSION['username'])) {
			return true;
		} else { return false; }
	}
	
	public function checkCookie() {
		if(isset($_COOKIE['token'])) {
			return true;
		} else { return false; }
	}
	
	public function checkData($name, $mail) {
		global $functions;
		if(empty($name) || empty($mail)) {
			return 1;
		} elseif($functions->length($name) > 15) {
			return 11;
		} elseif($functions->length($mail) > 26 || !preg_match("/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/", $mail)) {
			return 2;
		} else { return 3; }
	}
	
	public function checkComment($comment) {
		global $database, $functions;
		if(empty($comment)) {
			return 1;
		} elseif($functions->length($comment) > $database->getParam('comment-max-sym')) {
			return 2;
		} else { return 3; }
	}
	
	public function checkForgot_password($username, $mail, $keystring) {
		global $database, $functions;
		$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_users` WHERE `username`=\''.$username.'\' AND `mail`=\''.$mail.'\'');
		$resource = $database->fetch_array($query);
		if(empty($username) || empty($mail) || empty($keystring)) {
			return 1;
		} elseif(empty($resource['id']) || $resource['checked'] == '0' || $resource['group'] == '0') {
			return 2;
		} elseif($keystring || $keystring == '') {
			if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] === $keystring) {
				$this->rand_pass = $functions->generatePassword('8');
				return 3;
			} else { return 4; }
			unset($_SESSION['captcha_keystring']);
		}
	}
	
	public function checkAuth($username, $password, $cpMode = false) {
		global $database, $functions;
		$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_users` WHERE `username`=\''.$username.'\' AND `password`=\''.$functions->crypt($password).'\'');
		$resource = $database->fetch_array($query);
		$permissions = explode(';', $resource['permissions']);
		if(empty($username) || empty($password)) {
			return 1;
		} elseif(empty($resource['id'])) {
			return 2;
		} elseif($resource['group'] == '0') {
			return 3;
		} elseif($resource['checked'] == '0') {
			return 4;
		} elseif($cpMode) {
			if($this->userAdmin($resource['group']) || $permissions[0] == '1') {
				return 5;
			} else { return 41; }
		} else { return 5; }
	}
	
	public function checkChange_password($old_password, $new_password, $re_new_password) {
		global $database, $functions;
		$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_users` WHERE `password`=\''.$functions->crypt($old_password).'\'');
		$resource = $database->fetch_array($query);
		if(empty($old_password) || empty($new_password) || empty($re_new_password)) {
			return 1;
		} elseif(empty($resource['id'])) {
			return 2;
		} elseif(!preg_match("/\A(\w){5,20}\Z/", $new_password)) {
			return 3;
		} elseif($new_password != $re_new_password) {
			return 4;
		} else { return 5; }
	}
	
	public function checkFeed_back($name, $mail, $subject, $message, $keystring) {
		if(empty($name) || empty($mail) || empty($subject) || empty($message) || empty($keystring)) {
			return 1;
		} elseif($keystring || $keystring == '') {
			if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] === $keystring) {
				return 2;
			} else { return 3; }
			unset($_SESSION['captcha_keystring']);
		}
	}
	
	public function checkRegister($name, $username, $password, $repassword, $date, $mail, $keystring) {
		global $database, $functions;
		$date = explode('.', $date);
		if(empty($name)) {
			return 1;
		} elseif($functions->length($name) > 15) {
			return 11;
		} elseif($functions->length($username) < 3 || $functions->length($username) > 15 || !preg_match("/^[a-zA-Z0-9]+$/", $username)) {
			return 2;
		} elseif($functions->length($mail) > 26 || !preg_match("/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/", $mail)) {
			return 3;
		} elseif($functions->length($password) < 6 || $functions->length($password) > 20 || !preg_match("/^[a-zA-Z0-9]+$/", $password)) {
			return 4;
		} elseif($password != $repassword) {
			return 5;
		} elseif(!checkdate($date[1], str_replace('0', '', $date[1]), $date[2])) {
			return 6;
		} elseif($keystring || $keystring == '') {
			if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] === $keystring) {
				$sql = $database->query('SELECT * FROM `'.DB_PREFIX.'_users` WHERE `username`=\''.$username.'\'');
				if($database->num_rows($sql) > 0) {
					return 7;
				} else {
					$sql = $database->query('SELECT * FROM `'.DB_PREFIX.'_users` WHERE `mail`=\''.$mail.'\'');
					if($database->num_rows($sql) > 0) {
						return 8;
					} else {
						$sql = $database->query('SELECT * FROM `'.DB_PREFIX.'_users` WHERE `reg-ip`=\''.$this->getUserIp().'\'');
						if($database->getParam('reg-one-ip') == 'true') {
							if($database->num_rows($sql) > 0) {
								return 9;
							} else { return 10; }
						} else { return 10; }
					}
				}
			} else { return 12; }
			unset($_SESSION['captcha_keystring']);
		}
	}
	
	public function logout() {
		global $functions;
		if($this->checkLogged()) { unset($_SESSION['username']); }
		if($this->checkCookie()) { $functions->deletecookie('token'); }
	}
	
}

$user = new user();
?>