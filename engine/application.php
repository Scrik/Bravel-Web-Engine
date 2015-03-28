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

$phpversion = explode('.', phpversion());
$phpversion = $phpversion[0].'.'.$phpversion[1];
if($phpversion > '5.2' || $phpversion == '5.2') {
	// ok...
} else { die('Ошибка! Версия PHP ниже <b>5.2</b>!'); }

$extensions = array('cURL', 'GD', 'iconv');
foreach($extensions as $extension) { if(!extension_loaded($extension)) { die('Ошибка! Расширение "<b>'.$extension.'</b>" не установлено!'); } }

$filesPart1 = array('engine/data/lang.php', 'engine/data/mail.php', 'engine/classes/functions.class.php', 'engine/classes/time-zone.class.php', 'engine/classes/databases/include.php');
foreach($filesPart1 as $fileName) { include(BASE.$fileName); }

if($db_inc) {
	$database->connect($db_config['db-host'], $db_config['db-user'], $db_config['db-pass'], $db_config['db-base']);
	$time_zone->set($database->getParam('time-zone'));
}

$filesPart2 = array('engine/classes/api.class.php', 'engine/classes/templates.class.php', 'engine/classes/mail.class.php', 'engine/classes/user.class.php');
foreach($filesPart2 as $fileName) { include(BASE.$fileName); }

if($db_inc) { $user->update(); }

function bbcode_formatting($string) {
	$bb_codes = array(
		'/\[b\](.*?)\[\/b\]/' => '<b>$1</b>',
		'/\[i\](.*?)\[\/i\]/' => '<i>$1</i>',
		'/\[u\](.*?)\[\/u\]/' => '<u>$1</u>',
		'/\[s\](.*?)\[\/s\]/' => '<s>$1</s>',
		'/\[img\](.*?)\[\/img\]/' => '<img src="$1" alt="Inserted Image" />',
		'/\[url=(.*?)\](.*?)\[\/url\]/' => '<a target="_blank" href="$1">$2</a>',
		'/\[list\](.*?)\[\/list\]/' => '<ul>$1</ul>',
		'/\[list=1\](.*?)\[\/list\]/' => '<ol>$1</ol>',
		'/\[\*\](.*?)\[\/\*\]/' => '<li>$1</li>',
		'/\[color=(.*?)\](.*?)\[\/color\]/' => '<font color="$1">$2</font>',
		'/\[size=50\](.*?)\[\/size\]/' => '<font size="1">$1</font>',
		'/\[size=85\](.*?)\[\/size\]/' => '<font size="2">$1</font>',
		'/\[size=100\](.*?)\[\/size\]/' => '<font size="3">$1</font>',
		'/\[size=150\](.*?)\[\/size\]/' => '<font size="4">$1</font>',
		'/\[size=185\](.*?)\[\/size\]/' => '<font size="5">$1</font>',
		'/\[size=200\](.*?)\[\/size\]/' => '<font size="6">$1</font>',
		'/\[font=(.*?)\](.*?)\[\/font\]/' => '<font face="$1">$2</font>',
		'/\[left\](.*?)\[\/left\]/' => '<p style="text-align: left;">$1</p>',
		'/\[center\](.*?)\[\/center\]/' => '<p style="text-align: center;">$1</p>',
		'/\[right\](.*?)\[\/right\]/' => '<p style="text-align: right;">$1</p>',
		'/\[justify\](.*?)\[\/justify\]/' => '<p style="text-align: justify;">$1</p>'
	);
	$string = str_replace(PHP_EOL, '<br>', $string);
	$string = preg_replace(array_keys($bb_codes), array_values($bb_codes), $string);
	return $string;
}

function getResizeLink($source, $width, $height) {
	return '/'.ENGINE_PATH.'engine/sys-modules/resize.php?width='.$width.'&height='.$height.'&source=http://'.$_SERVER['HTTP_HOST'].$source;
}

function escape($string) {
	$search = array("\\",  "\x00", "'",  '"', "\x1a");
	$replace = array("\\\\", "\\0", "\'", '\"', "\\Z");
	return str_replace($search, $replace, $string);
}

function getParam($paramName) {
	global $database, $functions;
	if($database->getParam($paramName[1]) != '') {
		return $database->getParam($paramName[1]);
	} else { return $functions->mistake('Ошибка! Параметра "<b>'.$paramName[1].'</b>" не существует!', false); }
}

function getVersionData($link) {
	$data = @file_get_contents($link);
	if(!$data) {
		return 'Error!';
	} else { return $data; }
}
?>