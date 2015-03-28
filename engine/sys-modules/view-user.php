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

$username = isset($_GET['username'])?$_GET['username']:'';
$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_users` WHERE `username`=\''.$functions->strip($username).'\'');
$resource = $database->fetch_array($query);

if(empty($username) || $username != $resource['username']) {
	$pagesData['p-content'] = $templates->info('error', LANG('USER_NOT_FOUND'));
	$pagesData['p-title'] = 'Ошибка';
} else {
	$referrers_query = $database->query('SELECT COUNT(*) FROM `'.DB_PREFIX.'_users` WHERE `referral`=\''.$username.'\'');
	if($resource['group'] == '0' || $resource['checked'] == '0') {
		$pagesData['p-content'] = $templates->info('info', LANG('USER_BANNED'));
		$pagesData['p-title'] = 'Информация';
	} else {
		$templates->load('view-user.tpl', 'view-user');
		if($resource['referral'] != '') {
			$templates->assign('str', array('[referral]', '[/referral]'), '', 'view-user');
			$templates->assign('str', '{referral}', $resource['referral'], 'view-user');
			$templates->assign('str', '{referral-link}', '/user/'.$resource['referral'].'/', 'view-user');
		} else { $templates->assign('preg', '~\[referral\](.*?)\[/referral\]~is', '', 'view-user'); }
		if($user->checkOnline($resource['username'])) {
			$templates->assign('str', array('[online]', '[/online]'), '', 'view-user');
			$templates->assign('preg', '~\[offline\](.*?)\[/offline\]~is', '', 'view-user');
		} else {
			$templates->assign('str', array('[offline]', '[/offline]'), '', 'view-user');
			$templates->assign('preg', '~\[online\](.*?)\[/online\]~is', '', 'view-user');
		}
		$templates->assign('str', '{name}', $resource['name'], 'view-user');
		$templates->assign('str', '{username}', $resource['username'], 'view-user');
		$templates->assign('str', '{group}', $user->getGroup($resource['username']), 'view-user');
		$templates->assign('str', '{reg-date}', $resource['reg-date'], 'view-user');
		$templates->assign('str', '{avatar}', $user->getAvatar($resource['username']), 'view-user');
		$templates->assign('str', '{avatar-link}', $user->getAvatar($resource['username'], 'full'), 'view-user');
		$templates->assign('str', '{last-date}', ($resource['last-date'] != '')?$resource['last-date']:'---', 'view-user');
		$templates->assign('str', '{referrers}', $database->result($referrers_query), 'view-user');
		$pagesData['p-content'] = $templates->display('view-user');
		$pagesData['p-title'] = $resource['username'];
	}
}
?>