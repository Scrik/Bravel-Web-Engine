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
	if(isset($_POST['comment-send'])) {
		switch($user->checkComment($functions->strip($_POST['comment']))) {
			case 1: $message = $templates->info('error', LANG('COMMENT_REQUIRED')); break;
			case 2: $message = $templates->info('error', LANG('COMMENT_BIG_LENGTH'), array('{max-sym}' => $database->getParam('comment-max-sym'))); break;
			case 3:
				$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_comments` WHERE `comment`=\''.$functions->strip($_POST['comment']).'\'');
				if($database->num_rows($query) == 0) {
					if($database->getParam('send-mail-oncomment') == 'true') {
						$mail->setTo($database->getParam('admin-mail'));
						$mail->setSubject(MAIL_MSG('NEW-COMMENT_T'));
						$mail->setMessage(str_replace(
							array('{name}', '{mail}', '{username}', '{comment}', '{site-name}', '{news-link}'),
							array($user->getArray('name'), $user->getArray('mail'), $user->getArray('username'), $functions->strip($_POST['comment'], true), $database->getParam('title'), 'http://'.$_SERVER['HTTP_HOST'].'/'.ENGINE_PATH.'news/'.$functions->strip($id).'/'),
							MAIL_MSG('NEW-COMMENT')
						));
						$mail->send();
					}
					$database->query('INSERT INTO `'.DB_PREFIX.'_comments` (`author`, `comment`, `news-id`, `date`) VALUES (\''.$user->getArray('username').'\', \''.$functions->strip($_POST['comment'], true).'\', \''.$functions->strip($id).'\', \''.$functions->curDate().'\')');
					$functions->spaceTo('/'.ENGINE_PATH.'news/'.$functions->strip($id).'/');
				} else { $message = $templates->info('error', LANG('COMMENT_ALREADY_ADDED')); }
			break;
		}
	}
	$templates->load('comments-add.tpl', 'comments-add');
	$templates->assign('str', '{message}', $message, 'comments-add');
	echo $templates->display('comments-add');
} else { echo $templates->info('error', LANG('LOGIN_REQUIRED')); }
?>