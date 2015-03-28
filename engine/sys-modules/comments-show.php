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

$com = $database->getParam('comments-on-page');
$query = $database->query('SELECT COUNT(*) FROM `'.DB_PREFIX.'_comments` WHERE `news-id`=\''.$functions->strip($id).'\'');
$count_records = $database->fetch_row($query);
$count_records = $count_records[0];
$num_pages = ceil($count_records / $com);
$curpage = isset($_GET['page'])?$_GET['page']:1;
if($curpage < 1) {
	$curpage = 1;
} elseif($curpage > $num_pages) {
	$curpage = $num_pages;
}
$start_from = ($curpage - 1) * $com;
$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_comments` WHERE `news-id`=\''.$functions->strip($id).'\' ORDER BY `id` DESC LIMIT '.$functions->strip($start_from).', '.$com);

if($count_records != 0) {
	while($myrow = $database->fetch_array($query)) {
		$templates->load('comments-show.tpl', 'comments-show');
		$templates->assign('str', '{id}', $myrow['id'], 'comments-show');
		$templates->assign('str', '{author}', $myrow['author'], 'comments-show');
		$templates->assign('str', '{comment}', $myrow['comment'], 'comments-show');
		$templates->assign('str', '{date}', $myrow['date'], 'comments-show');
		$templates->assign('str', '{author-link}', '/'.ENGINE_PATH.'user/'.$myrow['author'].'/', 'comments-show');
		$templates->assign('str', '{delete-link}', '/'.ENGINE_PATH.'admin/comments/delete/'.$myrow['id'].'/', 'comments-show');
		echo $templates->display('comments-show');
	}
} else { echo $templates->info('info', LANG('NO_COMMENTS')); }
?>