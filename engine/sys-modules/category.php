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

$category = isset($_GET['name'])?$_GET['name']:'';
$navigation_data = '';
$news_data = '';

if($category != '') {
	$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_categories` WHERE `name`=\''.$category.'\'');
	$resource = $database->fetch_array($query);
	if($resource['name'] != '') {
		$nop = $database->getParam('news-on-page');
		$query = $database->query('SELECT COUNT(*) FROM `'.DB_PREFIX.'_news` WHERE `category`=\''.$category.'\'');
		$count_records = $database->fetch_row($query);
		$count_records = $count_records[0];
		$num_pages = ceil($count_records / $nop);
		$curpage = isset($_GET['page'])?$_GET['page']:1;
		if($curpage < 1) {
			$curpage = 1;
		} elseif($curpage > $num_pages) {
			$curpage = $num_pages;
		}
		$start_from = ($curpage - 1) * $nop;
		$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_news` WHERE `category`=\''.$category.'\' ORDER BY `id` DESC LIMIT '.$functions->strip($start_from).', '.$nop);
		if($count_records != 0) {
			while($myrow = $database->fetch_array($query)) {
				$comments_query = $database->query('SELECT COUNT(*) FROM `'.DB_PREFIX.'_comments` WHERE `news-id`=\''.$myrow['id'].'\'');
				$comments_resource = $database->fetch_array($comments_query);
				$comments = $comments_resource[0];
				$templates->load('news-short.tpl', 'category-item');
				$templates->assign('str', '{id}', $myrow['id'], 'category-item');
				$templates->assign('str', '{title}', $myrow['title'], 'category-item');
				$templates->assign('str', '{date}', $myrow['date'], 'category-item');
				$templates->assign('str', '{short-story}', bbcode_formatting($myrow['short-story']), 'category-item');
				$templates->assign('str', '{full-story}', bbcode_formatting($myrow['full-story']), 'category-item');
				$templates->assign('str', '{author}', $myrow['author'], 'category-item');
				$templates->assign('str', '{views}', $myrow['views'], 'category-item');
				$templates->assign('str', '{category}', $myrow['category'], 'category-item');
				$templates->assign('str', '{comments}', $comments, 'category-item');
				$templates->assign('str', '{category-link}', '/'.ENGINE_PATH.'category/'.$myrow['category'].'/', 'category-item');
				$templates->assign('str', '{author-link}', '/'.ENGINE_PATH.'user/'.$myrow['author'].'/', 'category-item');
				$templates->assign('str', '{full-link}', '/'.ENGINE_PATH.'news/'.$myrow['id'].'/', 'category-item');
				$templates->assign('str', '{delete-link}', '/'.ENGINE_PATH.'admin/news/delete/'.$myrow['id'].'/', 'category-item');
				$templates->assign('str', '{nullify-link}', '/'.ENGINE_PATH.'admin/news/nullify/'.$myrow['id'].'/', 'category-item');
				$templates->assign('str', '{edit-link}', '/'.ENGINE_PATH.'admin/news/edit/'.$myrow['id'].'/', 'category-item');
				$templates->assign('preg', '~(\[category\].+\[/category\])~is', '', 'category-item');
				if($myrow['x-image'] != '') {
					$templates->assign('preg', '~(\[without-x-image\].+\[/without\])~is', '', 'category-item');
					$templates->assign('str', array('[with-x-image]', '[/with]'), '', 'category-item');
					$templates->assign('str', '{x-image}', '/'.ENGINE_PATH.'engine/sys-modules/resize.php?width='.$database->getParam('x-img-width').'&height='.$database->getParam('x-img-height').'&source='.$myrow['x-image'], 'category-item');
				} else {
					$templates->assign('str', array('[without-x-image]', '[/without]'), '', 'category-item');
					$templates->assign('preg', '~(\[with-x-image\].+\[/with\])~is', '', 'category-item');
				}
				$news_data .= $templates->display('category-item');
			}
			if($count_records > $nop) {
				$templates->load('navigation.tpl', 'category-navigation');
				$templates->assign('preg', '~\[news\](.*?)\[/news\]~is', '', 'category-navigation');
				$templates->assign('preg', '~\[comments\](.*?)\[/comments\]~is', '', 'category-navigation');
				$templates->assign('str', array('[categories]', '[/categories]'), '', 'category-navigation');
				for($page = 1; $page <= $num_pages; $page++) {
					$templates->load('navigation-items.tpl','category-navigation-items');
					$templates->assign('preg', '~\[news\](.*?)\[/news\]~is', '', 'category-navigation-items');
					$templates->assign('preg', '~\[comments\](.*?)\[/comments\]~is', '', 'category-navigation-items');
					$templates->assign('str', array('[categories]', '[/categories]'), '', 'category-navigation-items');
					if($page == $curpage) {
						$templates->assign('str', array('[active]', '[/active]'), '', 'category-navigation-items');
						$templates->assign('preg', '~(\[item\].+\[/item\])~is', '', 'category-navigation-items');
					} else {
						$templates->assign('str', array('[item]', '[/item]'), '', 'category-navigation-items');
						$templates->assign('preg', '~(\[active\].+\[/active\])~is', '', 'category-navigation-items');
					}
					$templates->assign('str',array('{page-link}', '{page}'), array('/'.ENGINE_PATH.'category/'.$category.'/page/'.$page.'/', $page), 'category-navigation-items');
					$navigation_data .= $templates->display('category-navigation-items');
				}
				$templates->assign('str', '{navigation-items}', $navigation_data, 'category-navigation');
				$navigation_data = $templates->display('category-navigation');
			}
			$pagesData['p-content'] = $news_data.$navigation_data;
			$pagesData['p-title'] = $resource['title'];
		} else {
			$templates->load('empty-news.tpl', 'empty-news');
			$pagesData['p-content'] = $templates->display('empty-news');
			$pagesData['p-title'] = 'Новостей нет';
		}
	} else {
		$pagesData['p-content'] = $templates->info('info', LANG('CAT_NOT_FOUND'));;
		$pagesData['p-title'] = 'Категории не существует';
	}
} else {
	$pagesData['p-content'] = $templates->info('error', LANG('EMPTY_CAT_NAME'));;
	$pagesData['p-title'] = 'Категория не указана';
}
?>