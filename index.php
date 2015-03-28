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

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

session_start();

define('USER_TIMEOUT', 60); // тайм-аут пользователя, по истечению которого он считается неактивным (в секундах)
define('ENGINE_PATH', ''); // папка с движком, в конце
// обязательно должен быть слеш | пример: "path/to/site/",
// то-же самое проделайте в файле .htaccess

define('INC_CHECK', true);
define('BASE', str_replace('\\', '/', dirname(__FILE__)).'/');
define('CAPTCHA_LINK', '/'.ENGINE_PATH.'engine/sys-modules/captcha.php?'.session_name().'='.session_id());
define('SYS_MODULES_BASE', BASE.'engine/sys-modules/');
define('VERSION', '1.0');

$pagesData = array('p-login' => '', 'p-suffix' => '', 'p-title' => '', 'p-info' => '', 'p-content' => '', 'p-robots' => 'index,follow');
$db_inc = true;
$message = '';

$action = isset($_GET['action'])?$_GET['action']:'';
$section = isset($_GET['section'])?$_GET['section']:'';
$module = isset($_GET['module'])?$_GET['module']:'';

if(file_exists(BASE.'engine/data/db-config.php')) {
	require_once(BASE.'engine/data/db-config.php');
	define('DB_PREFIX', $db_config['db-prefix']);
} else { $db_inc = false; }

require_once(BASE.'engine/application.php');

if(!$db_inc) {
	if(file_exists(BASE.'install/install.php')) {
		$ALL_FIELDS_REQUIRED = 'Не все поля заполнены.'; $step = 0; $time_zone->set('Europe/Moscow'); require_once(BASE.'install/install.php'); die();
	} else { $functions->mistake('Ошибка! Файл "<b>/'.ENGINE_PATH.'install/install.php</b>" не найден!'); }
}

$api->loadModulesFrom(BASE.'engine/res-modules/');

require_once(BASE.'engine/core.php');

$assign_arr = array(
	'links' => array(
		'{main-link}' => '/'.ENGINE_PATH,
		'{admin-link}' => '/'.ENGINE_PATH.'admin/',
		'{registration-link}' => '/'.ENGINE_PATH.'registration/',
		'{forgot-link}' => '/'.ENGINE_PATH.'forgot-password/',
		'{terms-link}' => '/'.ENGINE_PATH.'terms/',
		'{cabinet-link}' => '/'.ENGINE_PATH.'account/',
		'{statistics-link}' => '/'.ENGINE_PATH.'statistics/',
		'{feed-back-link}' => '/'.ENGINE_PATH.'feed-back/',
		'{logout-link}' => '/'.ENGINE_PATH.'logout/index/',
		'{profile-link}' => '/'.ENGINE_PATH.'user/'.$user->getArray('username').'/'
	),
	'main' => array(
		'{p-content}' => $pagesData['p-content'],
		'{p-info}' => $pagesData['p-info'],
		'{login}' => $pagesData['p-login'],
		'{p-title}' => $pagesData['p-title'],
		'{site-name}' => $database->getParam('title').$pagesData['p-suffix'],
		'{p-description}' => $database->getParam('description'),
		'{p-keywords}' => $database->getParam('keywords'),
		'{THEME}' => '/'.ENGINE_PATH.'themes/'.$database->getParam('theme'),
		'{version}' => VERSION,
		
		'{p-headers}' => '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="author" content="Accami (Andrey Popov)">
		<meta name="description" content="'.$database->getParam('description').'">
		<meta name="keywords" content="'.$database->getParam('keywords').'">
		<meta name="generator" content="Bravel Web Engine ('.VERSION.')">
		<meta name="robots" content="'.$pagesData['p-robots'].'">
		<script type="text/javascript" src="/'.ENGINE_PATH.'engine/include/js/jQuery-library.js"></script>'
	)
);

$templates->load('main.tpl', 'index');

$templates->assign('callback', '/\{include-file="(.*?)"\}/', array($templates, 'includeFile'), 'index');
$templates->assign('str', array_keys($assign_arr['main']), array_values($assign_arr['main']), 'index');
$templates->assign('str', array_keys($assign_arr['links']), array_values($assign_arr['links']), 'index');

$templates->assign('callback', '/\{config="(.*?)"\}/', 'getParam', 'index');
$templates->assign('callback', '~\[info="(.*?)"](.*?)\[\/info]~is', array($templates, 'infoTag'), 'index');
$templates->assign('callback', '~\[available="(.*?)"](.*?)\[\/available]~is', array($functions, 'available'), 'index');

$templates->assign('preg', '/\{static-page="(.*?)"\}/', '/'.ENGINE_PATH.'do/$1/', 'index');
$templates->assign('preg', '/\{\* (.*?) \*}/', '', 'index');

if($user->userAdmin() || $user->getPermission('allow-admin') == '1') {
	$templates->assign('str', array('[admin]','[/admin]'), '', 'index');
} else {
	$templates->assign('preg', '~\[admin\](.*?)\[/admin\]~is', '', 'index');
}

if($user->checkLogged()) {
	$templates->assign('str', array('[logged]', '[/logged]'), '', 'index');
	$templates->assign('preg', '~\[!logged\](.*?)\[/!logged\]~is', '', 'index');
} else {
	$templates->assign('str', array('[!logged]', '[/!logged]'), '', 'index');
	$templates->assign('preg', '~\[logged\](.*?)\[/logged\]~is', '', 'index');
}

foreach($api->replaceList as $data) {
	$templates->assign($data['type'], $data['search'], $data['replace'], 'index');
}

echo $templates->display('index', true);

$database->close();
?>