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

$navigation_data = '';
$id = isset($_GET['id'])?$_GET['id']:'';
$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_news` WHERE `id`=\''.$functions->strip($id).'\'');
$resource = $database->fetch_array($query);
$query = $database->query('SELECT COUNT(*) FROM `'.DB_PREFIX.'_comments` WHERE `news-id`=\''.$resource['id'].'\'');
$comments_resource = $database->fetch_array($query);
$comments = $comments_resource[0];

if(empty($id) || $id != $resource['id']) {
	$pagesData['p-content'] = $templates->info('error', LANG('NEWS_NOT_FOUND'));
	$pagesData['p-title'] = 'Ошибка';
} else {
	$database->query('UPDATE `'.DB_PREFIX.'_news` SET `views`=\''.($resource['views']+1).'\' WHERE `id`=\''.$resource['id'].'\'');
	$category_query = $database->query('SELECT * FROM `'.DB_PREFIX.'_categories` WHERE `name`=\''.$resource['category'].'\'');
	$category_resource = $database->fetch_array($category_query);
	if($category_resource['name'] != '') {
		$category_title = $category_resource['title'];
		$category_name = $category_resource['name'];
	} else {
		$category_title = 'Error!';;
		$category_name = $resource['category'];
	}
	$templates->load('news-full.tpl', 'full-news');
	$templates->assign('str', '{id}', $resource['id'], 'full-news');
	$templates->assign('str', '{title}', $resource['title'], 'full-news');
	$templates->assign('str', '{date}', $resource['date'], 'full-news');
	$templates->assign('str', '{short-story}', bbcode_formatting($resource['short-story']), 'full-news');
	$templates->assign('str', '{full-story}', bbcode_formatting($resource['full-story']), 'full-news');
	$templates->assign('str', '{author}', $resource['author'], 'full-news');
	$templates->assign('str', '{views}', $resource['views'], 'full-news');
	$templates->assign('str', '{category}', $category_title, 'full-news');
	$templates->assign('str', '{comments}', $comments, 'full-news');
	$templates->assign('str', '{category-link}', '/'.ENGINE_PATH.'category/'.$category_name.'/', 'full-news');
	$templates->assign('str', '{author-link}', '/'.ENGINE_PATH.'user/'.$resource['author'].'/', 'full-news');
	$templates->assign('str', '{delete-link}', '/'.ENGINE_PATH.'admin/news/delete/'.$resource['id'].'/', 'full-news');
	$templates->assign('str', '{nullify-link}', '/'.ENGINE_PATH.'admin/news/nullify/'.$resource['id'].'/', 'full-news');
	$templates->assign('str', '{edit-link}', '/'.ENGINE_PATH.'admin/news/edit/'.$resource['id'].'/', 'full-news');
	if($resource['x-image'] != '') {
		$templates->assign('preg', '~(\[without-x-image\].+\[/without\])~is', '', 'full-news');
		$templates->assign('str', array('[with-x-image]', '[/with]'), '', 'full-news');
		$templates->assign('str', '{x-image}', '/'.ENGINE_PATH.'engine/sys-modules/resize.php?width='.$database->getParam('x-img-width').'&height='.$database->getParam('x-img-height').'&source='.$resource['x-image'], 'full-news');
	} else {
		$templates->assign('str', array('[without-x-image]', '[/without]'), '', 'full-news');
		$templates->assign('preg', '~(\[with-x-image\].+\[/with\])~is', '', 'full-news');
	}
	ob_start();
		require(SYS_MODULES_BASE.'comments-add.php');
	$templates->assign('str', '{comments-add}', ob_get_clean(), 'full-news');
	ob_start();
		require(SYS_MODULES_BASE.'comments-show.php');
	$templates->assign('str', '{comments-show}', ob_get_clean(), 'full-news');
	if($count_records > $com) {
		$templates->load('navigation.tpl', 'comments-navigation');
		$templates->assign('preg', '~\[categories\](.*?)\[/categories\]~is', '', 'comments-navigation');
		$templates->assign('preg', '~\[news\](.*?)\[/news\]~is', '', 'comments-navigation');
		$templates->assign('str', array('[comments]', '[/comments]'), '', 'comments-navigation');
		for($page = 1; $page <= $num_pages; $page++) {
			$templates->load('navigation-items.tpl', 'comments-navigation-items');
			$templates->assign('preg', '~\[categories\](.*?)\[/categories\]~is', '', 'comments-navigation-items');
			$templates->assign('preg', '~\[news\](.*?)\[/news\]~is', '', 'comments-navigation-items');
			$templates->assign('str', array('[comments]', '[/comments]'), '', 'comments-navigation-items');
			if($page == $curpage) {
				$templates->assign('str', array('[active]', '[/active]'), '', 'comments-navigation-items');
				$templates->assign('preg', '~(\[item\].+\[/item\])~is', '', 'comments-navigation-items');
			} else {
				$templates->assign('str', array('[item]', '[/item]'), '', 'comments-navigation-items');
				$templates->assign('preg', '~(\[active\].+\[/active\])~is', '', 'comments-navigation-items');
			}
			$templates->assign('str', array('{page-link}', '{page}'), array(($page == '1')?'/'.ENGINE_PATH.'news/'.$id.'/':'/'.ENGINE_PATH.'news/'.$id.'/page/'.$page.'/', $page), 'comments-navigation-items');
			$navigation_data .= $templates->display('comments-navigation-items');
		}
		$templates->assign('str', '{navigation-items}', $navigation_data, 'comments-navigation');
		$navigation_data = $templates->display('comments-navigation');
	}
	$templates->assign('str', '{comments-navigation}', $navigation_data, 'full-news');
	$pagesData['p-content'] = $templates->display('full-news');
	$pagesData['p-title'] = $resource['title'];
}
?>