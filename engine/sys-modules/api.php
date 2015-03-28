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

if(!defined('INC_CHECK')) { echo 'Scat!'; }

$username = isset($_GET['username'])?$_GET['username']:'';
$password = isset($_GET['password'])?$_GET['password']:'';

switch($module) {
	
	case 'crypt':
		if($password != '') {
			echo $functions->crypt($functions->strip($password));
		} else { echo 'Error!'; }
	break;
	case 'userCheck':
		if($username != '') {
			if($password != '') {
				switch($user->checkAuth($functions->strip($username), $functions->strip($password))) {
					case 1: /* ... */ break;
					case 2: echo 'Bad login/password!'; break;
					case 3: echo 'Banned!'; break;
					case 4: echo 'Not confirmed!'; break;
					case 5: echo 'Success!'; break;
				}
			} else {
				if($user->getArray('checked', $username) == '0') {
					echo 'User not confirmed!';
				} elseif($user->getArray('group', $username) == '0') {
					echo 'User banned!';
				} elseif($user->getArray('checked', $username) == '1') {
					echo 'User found!~'.$user->getArray('group', $username);
				} else { echo 'User not found!'; }
			}
		} else { echo 'Error!'; }
	break;
	
	default: echo 'Error!'; break;
	
}

die();
?>