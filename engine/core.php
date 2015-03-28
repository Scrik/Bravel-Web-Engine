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

if($action != 'admin') { $templates->setPath(BASE.'themes/'.$database->getParam('theme').'/'); }

if($action == 'error-404') {
	$pagesData['robots'] = 'noindex,nofollow';
	$templates->load('error-404.tpl', 'index');
	$templates->assign('str', '{url}', 'http://'.$_SERVER['HTTP_HOST'].'/'.ENGINE_PATH.substr($functions->crop($_SERVER['REQUEST_URI'], 31), 1), 'index');
	$templates->assign('str', '{url-full}', 'http://'.$_SERVER['HTTP_HOST'].'/'.ENGINE_PATH.substr($_SERVER['REQUEST_URI'], 1), 'index');
	$templates->clear('index');
}

if($action != 'admin') {
	$templates->load('login.tpl', 'login');
	$templates->assign('str', '{username}', $functions->crop($user->getArray('username'), 10), 'login');
	$templates->assign('str', '{username-full}', $user->getArray('username'), 'login');
	$pagesData['p-login'] = $templates->display('login');
	if($database->getParam('off-site') == 'true') {
		if($user->userAdmin() || $user->getPermission('allow-offline') == '1' || $user->getPermission('allow-admin') == '1') {
			$pagesData['p-suffix'] = ' [offline]';
		} else {
			$templates->load('off-line.tpl', 'index');
			$templates->assign('str', '{off-reason}', $database->getParam('off-reason'), 'index');
			$templates->clear('index');
		}
	}
}

switch($action) {
	
	case 'news':            include(SYS_MODULES_BASE.'news-full.php');       break;
	case 'view-user':       include(SYS_MODULES_BASE.'view-user.php');       break;
 	case 'statistics':      include(SYS_MODULES_BASE.'statistics.php');      break;
 	case 'registration':    include(SYS_MODULES_BASE.'registration.php');    break;
 	case 'account':         include(SYS_MODULES_BASE.'account.php');         break;
 	case 'static':          include(SYS_MODULES_BASE.'static.php');          break;
 	case 'forgot-password': include(SYS_MODULES_BASE.'forgot-password.php'); break;
 	case 'feed-back':       include(SYS_MODULES_BASE.'feed-back.php');       break;
	case 'activation':      include(SYS_MODULES_BASE.'activation.php');      break;
 	case 'terms':           include(SYS_MODULES_BASE.'terms.php');           break;
	case 'logout':          include(SYS_MODULES_BASE.'logout.php');          break;
	case 'invite':          include(SYS_MODULES_BASE.'invite.php');          break;
	case 'nope-right':      include(SYS_MODULES_BASE.'nope-right.php');      break;
	case 'category':        include(SYS_MODULES_BASE.'category.php');        break;
	
 	case 'admin':           include(SYS_MODULES_BASE.'admin.php');           break;
	case 'api':             include(SYS_MODULES_BASE.'api.php');             break;
	
	default:                include(SYS_MODULES_BASE.'news-short.php');      break;
	
}
?>