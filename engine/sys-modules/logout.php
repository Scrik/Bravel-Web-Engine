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

$pagesData['p-robots'] = 'noindex,nofollow';

if(isset($_GET['url'])) {
	$user->logout();
	if($_GET['url'] == 'admin') {
		$functions->spaceTo('/'.ENGINE_PATH.'admin/');
	} elseif($_GET['url'] == 'index') { $functions->spaceTo('/'.ENGINE_PATH); }
} else { $functions->spaceTo('/'.ENGINE_PATH); }
?>