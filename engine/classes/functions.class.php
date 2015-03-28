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

if(!defined('INC_CHECK')) die('Scat!');

class functions {
	
	public function mistake($string, $dieMode = true) {
		if($dieMode) {
			echo '<style type="text/css">body { padding: 20px; background: #F7F7F8; margin: 0; font-family: Verdana; font-size: 12px; font-weight: normal; font-style: normal; line-height: 20px; color: #333333; }</style>'.PHP_EOL;
			die($string);
		} else { return $string; }
	}
	
	public function strip($string, $textMode = false, $saveSpaces = false) {
		if(!$saveSpaces) {
			if($textMode) {
				return str_replace('[br]', '<br>', escape(htmlspecialchars(str_replace(PHP_EOL, '[br]', $string), ENT_QUOTES)));
			} else { return escape(htmlspecialchars(strip_tags(str_replace(' ', '', $string)), ENT_QUOTES)); }
		} else { return escape(htmlspecialchars(strip_tags($string), ENT_QUOTES)); }
	}
	
	public function setcookie($name, $value, $time = 2592000) {
		setcookie($name, $value, time()+$time, '/', $_SERVER['HTTP_HOST']);
	}
	
	public function deletecookie($name, $time = 2592000) {
		setcookie($name, null, time()-$time, '/', $_SERVER['HTTP_HOST']);
	}
	
	public function contains($haystack, $needle) {
		if(stripos($haystack, $needle) === false) {
			return false;
		} else { return true; }
	}
	
	public function crop($string, $length) {
		if($this->length($string) > $length) {
			$data = substr($string, $length);
			$data = $this->length($string)-$this->length($data);
			$data = substr($string, 0, $data-3).'...';
			return $data;
		} else { return $string; }
	}
	
	public function length($string) {
		return iconv_strlen($string, 'UTF-8');
	}
	
	function formatFileSize($data) {
		if($data < 1024) {
			return $data.' Bytes';
		} elseif($data < 1024000) {
			return round(($data / 1024 ), 1).'KB';
		} else { return round(($data / 1024000), 1).'MB'; }
	}
	
	public function generateToken($username) {
		return md5(time().$username);
	}
	
	public function generatePassword($lenght) {
		$password = '';
		$full_array = array_merge(range('a', 'z'), range('A', 'Z'), range('1', '9'));
		for($i = '0'; $i < $lenght; $i++){
			$entrie = array_rand($full_array);
			$password .= $full_array[$entrie];
		}
		return $password;
	}
	
	public function available($data) {
		global $action;
		switch($data[1]) {
			case 'full-news':       if($action == 'news')            { return $data[2]; }   break;
			case 'view-user':       if($action == 'view-user')       { return $data[2]; }   break;
			case 'statistics':      if($action == 'statistics')      { return $data[2]; }   break;
			case 'registration':    if($action == 'registration')    { return $data[2]; }   break;
			case 'account':         if($action == 'account')         { return $data[2]; }   break;
			case 'static':          if($action == 'static')          { return $data[2]; }   break;
			case 'forgot-password': if($action == 'forgot-password') { return $data[2]; }   break;
			case 'feed-back':       if($action == 'feed-back')       { return $data[2]; }   break;
			case 'activation':      if($action == 'activation')      { return $data[2]; }   break;
			case 'terms':           if($action == 'terms')           { return $data[2]; }   break;
			case 'main':            if($action == '')                { return $data[2]; }   break;
			
			default:                return 'Страницы "<b>'.$data[1].'</b>" не существует!'; break;
		}
	}
	
	public function refreshPage() {
		$this->spaceTo($_SERVER['PHP_SELF']);
	}
	
	public function spaceTo($url) {
		Header('Location: '.$url);
	}
	
	public function getTime() {
		return time();
	}
	
	public function curDate() {
		return date('d.m.Y, в H:i');
	}
	
	public function curDay() {
		return date('d');
	}
	
	public function curYear() {
		return date('Y');
	}
	
	public function curMonth() {
		return date('m');
	}
	
	public function crypt($string) {
		return md5(md5('~@!s*)!'.$string.'!:W#!x~'));
	}
	
}

$functions = new functions();
?>