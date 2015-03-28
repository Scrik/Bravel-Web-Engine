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

include(BASE.'engine/classes/admin.class.php');

$pagesData['p-robots'] = 'noindex,nofollow';
$templates->setPath(BASE.'engine/include/admin/');
$checkVersion = getVersionData('http://core.bravel.ru/update/update.php?version='.VERSION);

if($user->checkLogged() && $user->userAdmin() || $user->getPermission('allow-admin') == '1') {
	
	switch($section) {
		
		default:
			$pagesData['p-title'] = 'Главная';
			
			$templates->load('index.tpl', 'index');
			
			$templates->assign('str', '{version}', VERSION, 'index');
			if($checkVersion == 'Error!' || $checkVersion == 'Scat!') {
				$templates->assign('preg', '~\[version-oldest\](.*?)\[/version-oldest\]~is', '', 'index');
				$templates->assign('preg', '~\[version-normal\](.*?)\[/version-normal\]~is', '', 'index');
				$templates->assign('str', array('[version-error]', '[/version-error]'), '', 'index');
			} elseif($checkVersion == 'true') {
				$templates->assign('preg', '~\[version-oldest\](.*?)\[/version-oldest\]~is', '', 'index');
				$templates->assign('preg', '~\[version-error\](.*?)\[/version-error\]~is', '', 'index');
				$templates->assign('str', array('[version-normal]', '[/version-normal]'), '', 'index');
			} else {
				$checkVersion = explode('~', $checkVersion);
				if($checkVersion[0] == 'false') {
					$templates->assign('preg', '~\[version-normal\](.*?)\[/version-normal\]~is', '', 'index');
					$templates->assign('preg', '~\[version-error\](.*?)\[/version-error\]~is', '', 'index');
					$templates->assign('str', array('[version-oldest]', '[/version-oldest]'), '', 'index');
					$templates->assign('str', '{new-version}', $checkVersion[1], 'index');
				}
			}
			$templates->assign('str', '{add-static-link}', '/'.ENGINE_PATH.'admin/static/add/', 'index');
			$templates->assign('str', '{configuration-link}', '/'.ENGINE_PATH.'admin/configuration/', 'index');
			$templates->assign('str', '{optimizer-link}', '/'.ENGINE_PATH.'admin/optimizer/', 'index');
			$templates->assign('str', '{news-link}', '/'.ENGINE_PATH.'admin/news/', 'index');
			$templates->assign('str', '{add-news-link}', '/'.ENGINE_PATH.'admin/news/add/', 'index');
			$templates->assign('str', '{categories-link}', '/'.ENGINE_PATH.'admin/categories/', 'index');
			$templates->assign('str', '{add-category-link}', '/'.ENGINE_PATH.'admin/category/add/', 'index');
			$templates->assign('str', '{static-link}', '/'.ENGINE_PATH.'admin/static/', 'index');
			$templates->assign('str', '{add-static-link}', '/'.ENGINE_PATH.'admin/static/add/', 'index');
			
			$templates->assign('str', '{all-news}', $database->countFrom('news'), 'index');
			$templates->assign('str', '{all-comments}', $database->countFrom('comments'), 'index');
			$templates->assign('str', '{all-users}', $database->countFrom('users'), 'index');
			$templates->assign('str', '{online-users}', $database->getOnlineUsers(), 'index');
			// $templates->assign('str', '{all-bans}', $database->countFrom('bans'), 'index');
			
			$templates->assign('str', '{first-user}', $database->forStatistics('first', 'users'), 'index');
			$templates->assign('str', '{last-user}', $database->forStatistics('last', 'users'), 'index');
			
			$templates->assign('str', '{db-size}', $functions->formatFileSize($database->getDatabaseSize()), 'index');
			
			$pagesData['p-content'] = $templates->display('index');
		break;
		
		case 'optimizer':
			$pagesData['p-title'] = 'Мастер оптимизации';
			
			$templates->load('optimizer.tpl', 'optimizer');
			
			if(isset($_POST['optimize'])) {
				if(empty($_POST['non-activated']) && empty($_POST['clear-comments']) && empty($_POST['clear-users']) && empty($_POST['clear-news']) && empty($_POST['clear-static']) && empty($_POST['clear-passwords']) && empty($_POST['clear-categories'])) {
					$message = LANG('NOTHING_SELECTED');
				} else {
					$message = LANG('OPTIMIZATION_COMPLETED');
					if(isset($_POST['non-activated'])) {
						$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_users` WHERE `checked`=\'0\'');
						$count = $database->num_rows($query);
						if($count > 0) {
							$database->query('DELETE FROM `'.DB_PREFIX.'_users` WHERE `checked`=\'0\'');
							$message .= str_replace('{count}', $count, LANG('DELETE_NON_ACTIVATED'));
						} else { $message .= LANG('NON_ACTIVATED_EMPTY'); }
					}
					if(isset($_POST['clear-comments']) || isset($_POST['clear-users']) || isset($_POST['clear-news']) || isset($_POST['clear-static']) || isset($_POST['clear-passwords']) || isset($_POST['clear-categories'])) {
						if(isset($_POST['clear-comments'])) { $database->query('DELETE FROM `'.DB_PREFIX.'_comments`'); }
						if(isset($_POST['clear-users'])) { $database->query('DELETE FROM `'.DB_PREFIX.'_users`'); }
						if(isset($_POST['clear-news'])) { $database->query('DELETE FROM `'.DB_PREFIX.'_news`'); }
						if(isset($_POST['clear-static'])) { $database->query('DELETE FROM `'.DB_PREFIX.'_static`'); }
						if(isset($_POST['clear-passwords'])) { $database->query('DELETE FROM `'.DB_PREFIX.'_passwords`'); }
						if(isset($_POST['clear-categories'])) { $database->query('DELETE FROM `'.DB_PREFIX.'_categories`'); }
						$message .= LANG('BASE_CLEANED');
					}
				}
			}
			
			$templates->assign('str', '{non-activated-status}', isset($_POST['non-activated'])?' checked':'', 'optimizer');
			$templates->assign('str', '{clear-comments-status}', isset($_POST['clear-comments'])?' checked':'', 'optimizer');
			$templates->assign('str', '{clear-users-status}', isset($_POST['clear-users'])?' checked':'', 'optimizer');
			$templates->assign('str', '{clear-news-status}', isset($_POST['news-news'])?' checked':'', 'optimizer');
			$templates->assign('str', '{clear-static-status}', isset($_POST['clear-static'])?' checked':'', 'optimizer');
			$templates->assign('str', '{clear-passwords-status}', isset($_POST['clear-passwords'])?' checked':'', 'optimizer');
			$templates->assign('str', '{clear-categories-status}', isset($_POST['clear-categories'])?' checked':'', 'optimizer');
			
			$pagesData['p-content'] = $templates->display('optimizer');
		break;
		
		case 'configuration':
			$pagesData['p-title'] = 'Редактирование конфигурции';
			
			$templates->load('edit-configuration.tpl', 'edit-configuration');
			
			$nop = isset($_POST['news-on-page'])?$_POST['news-on-page']:$database->getParam('news-on-page');
			$cop = isset($_POST['comments-on-page'])?$_POST['comments-on-page']:$database->getParam('comments-on-page');
			
			if(isset($_POST['edit-configuration'])) {
				if($_POST['comments-on-page'] == '0' || $_POST['news-on-page'] == '0') {
					$message = LANG('DIVISION_BY_ZERO');
					$nop = $database->getParam('news-on-page');
					$cop = $database->getParam('comments-on-page');
				} else {
					$database->query('UPDATE `'.DB_PREFIX.'_config` SET `value`=\''.$_POST['title'].'\' WHERE `setting`=\'title\'');
					$database->query('UPDATE `'.DB_PREFIX.'_config` SET `value`=\''.$_POST['description'].'\' WHERE `setting`=\'description\'');
					$database->query('UPDATE `'.DB_PREFIX.'_config` SET `value`=\''.$_POST['keywords'].'\' WHERE `setting`=\'keywords\'');
					$database->query('UPDATE `'.DB_PREFIX.'_config` SET `value`=\''.$_POST['off-reason'].'\' WHERE `setting`=\'off-reason\'');
					$database->query('UPDATE `'.DB_PREFIX.'_config` SET `value`=\''.$_POST['admin-mail'].'\' WHERE `setting`=\'admin-mail\'');
					$database->query('UPDATE `'.DB_PREFIX.'_config` SET `value`=\''.$_POST['theme'].'\' WHERE `setting`=\'theme\'');
					$database->query('UPDATE `'.DB_PREFIX.'_config` SET `value`=\''.$_POST['time-zone'].'\' WHERE `setting`=\'time-zone\'');
					$database->query('UPDATE `'.DB_PREFIX.'_config` SET `value`=\''.$_POST['x-img-width'].'\' WHERE `setting`=\'x-img-width\'');
					$database->query('UPDATE `'.DB_PREFIX.'_config` SET `value`=\''.$_POST['x-img-height'].'\' WHERE `setting`=\'x-img-height\'');
					$database->query('UPDATE `'.DB_PREFIX.'_config` SET `value`=\''.$_POST['news-on-page'].'\' WHERE `setting`=\'news-on-page\'');
					$database->query('UPDATE `'.DB_PREFIX.'_config` SET `value`=\''.$_POST['comments-on-page'].'\' WHERE `setting`=\'comments-on-page\'');
					$database->query('UPDATE `'.DB_PREFIX.'_config` SET `value`=\''.$_POST['admin-group'].'\' WHERE `setting`=\'admin-group\'');
					$database->query('UPDATE `'.DB_PREFIX.'_config` SET `value`=\''.$_POST['comment-max-sym'].'\' WHERE `setting`=\'comment-max-sym\'');
					$admin->updateBoolean('off-site');
					$admin->updateBoolean('reg-one-ip');
					$admin->updateBoolean('write-user-passwords');
					$admin->updateBoolean('reg-mail-accept');
					$admin->updateBoolean('send-mail-oncomment');
					$message = LANG('CONFIGURATION_WERE_CHANGED');
				}
			}
			
			$templates->assign('str', '{title}', isset($_POST['title'])?$_POST['title']:$database->getParam('title'), 'edit-configuration');
			$templates->assign('str', '{description}', isset($_POST['description'])?$_POST['description']:$database->getParam('description'), 'edit-configuration');
			$templates->assign('str', '{keywords}', isset($_POST['keywords'])?$_POST['keywords']:$database->getParam('keywords'), 'edit-configuration');
			$templates->assign('str', '{off-reason}', isset($_POST['off-reason'])?$_POST['off-reason']:$database->getParam('off-reason'), 'edit-configuration');

			$templates->assign('str', '{admin-mail}', isset($_POST['admin-mail'])?$_POST['admin-mail']:$database->getParam('admin-mail'), 'edit-configuration');
			$templates->assign('str', '{admin-group}', isset($_POST['admin-group'])?$_POST['admin-group']:$database->getParam('admin-group'), 'edit-configuration');
			$templates->assign('str', '{news-on-page}', $nop, 'edit-configuration');
			$templates->assign('str', '{comments-on-page}', $cop, 'edit-configuration');
			$templates->assign('str', '{x-img-height}', isset($_POST['x-img-height'])?$_POST['x-img-height']:$database->getParam('x-img-height'), 'edit-configuration');
			$templates->assign('str', '{x-img-width}', isset($_POST['x-img-width'])?$_POST['x-img-width']:$database->getParam('x-img-width'), 'edit-configuration');
			$templates->assign('str', '{comment-max-sym}', isset($_POST['comment-max-sym'])?$_POST['comment-max-sym']:$database->getParam('comment-max-sym'), 'edit-configuration');
			
			$templates->assign('str', '{time-zone-selector}', $time_zone->zones_list($database->getParam('time-zone')), 'edit-configuration');
			$templates->assign('str', '{theme-selector}', $admin->getSelectBox('theme'), 'edit-configuration');
			$templates->assign('str', '{off-site-selector}', $admin->getSelectBox('off-site'), 'edit-configuration');
			$templates->assign('str', '{send-mail-oncomment-selector}', $admin->getSelectBox('send-mail-oncomment'), 'edit-configuration');
			$templates->assign('str', '{reg-mail-accept-selector}', $admin->getSelectBox('reg-mail-accept'), 'edit-configuration');
			$templates->assign('str', '{reg-one-ip-selector}', $admin->getSelectBox('reg-one-ip'), 'edit-configuration');
			$templates->assign('str', '{write-user-passwords-selector}', $admin->getSelectBox('write-user-passwords'), 'edit-configuration');
			
			$pagesData['p-content'] = $templates->display('edit-configuration');
		break;
		
		case 'categories':
			$pagesData['p-title'] = 'Управление категориями';
			
			$templates->load('categories.tpl', 'categories');
			
			ob_start();
				$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_categories` ORDER BY `id` DESC');
				if($database->num_rows($query) > 0) {
					$numb = 0;
					while($myrow = $database->fetch_array($query)) {
						$numb += 1;
						$news = $database->query('SELECT COUNT(*) FROM `'.DB_PREFIX.'_news` WHERE `category`=\''.$myrow['name'].'\'');
						$news = $database->fetch_row($news);
						$news = $news[0];
						
						$templates->load('category-item.tpl', 'category-items');
						
						$templates->assign('str', '{news}', $news, 'category-items');
						$templates->assign('str', '{category}', $myrow['title'], 'category-items');
						$templates->assign('str', '{delete-link}', '/'.ENGINE_PATH.'admin/category/delete/'.$myrow['id'].'/', 'category-items');
						$templates->assign('str', '{category-link}', '/'.ENGINE_PATH.'category/'.$myrow['name'].'/', 'category-items');
						
						if($database->num_rows($query) != $numb) {
							$templates->assign('str', array('[no-last]', '[/no-last]'), '', 'category-items');
						} else { $templates->assign('preg', '~\[no-last\](.*?)\[/no-last\]~is', '', 'category-items'); }
						
						echo $templates->display('category-items');
					}
				} else { echo LANG('NO_PAGES'); }
			$templates->assign('str', '{category-items}', ob_get_clean(), 'categories');
			
			$pagesData['p-content'] = $templates->display('categories');
		break;
		
		case 'news':
			$pagesData['p-title'] = 'Управление новостями';
			
			$templates->load('news.tpl', 'news');
			
			ob_start();
				$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_news` ORDER BY `id` DESC');
				if($database->num_rows($query) > 0) {
					$numb = 0;
					while($myrow = $database->fetch_array($query)) {
						$numb += 1;
						$comments_query = $database->query('SELECT COUNT(*) FROM `'.DB_PREFIX.'_comments` WHERE `news-id`=\''.$myrow['id'].'\'');
						$category_query = $database->query('SELECT * FROM `'.DB_PREFIX.'_categories` WHERE `name`=\''.$myrow['category'].'\'');
						$category_resource = $database->fetch_array($category_query);
						$comments_resource = $database->fetch_array($comments_query);
						$comments = $comments_resource[0];
						if($category_resource['name'] != '') {
							$category_title = $category_resource['title'];
							$category_name = $category_resource['name'];
						} else {
							$category_title = 'Error!';
							$category_name = $myrow['category'];
						}
						
						$templates->load('news-item.tpl', 'news-items');
						
						$templates->assign('str', '{title}', $myrow['title'], 'news-items');
						$templates->assign('str', '{date}', $myrow['date'], 'news-items');
						$templates->assign('str', '{author}', $myrow['author'], 'news-items');
						$templates->assign('str', '{views}', $myrow['views'], 'news-items');
						$templates->assign('str', '{category}', $category_title, 'news-items');
						$templates->assign('str', '{comments}', $comments, 'news-items');
						$templates->assign('str', '{category-link}', '/'.ENGINE_PATH.'category/'.$category_name.'/', 'news-items');
						$templates->assign('str', '{author-link}', '/'.ENGINE_PATH.'user/'.$myrow['author'].'/', 'news-items');
						$templates->assign('str', '{edit-link}', '/'.ENGINE_PATH.'admin/news/edit/'.$myrow['id'].'/', 'news-items');
						$templates->assign('str', '{delete-link}', '/'.ENGINE_PATH.'admin/news/delete/'.$myrow['id'].'/', 'news-items');
						$templates->assign('str', '{nullify-link}', '/'.ENGINE_PATH.'admin/news/nullify/'.$myrow['id'].'/', 'news-items');
						$templates->assign('str', '{item-link}', '/'.ENGINE_PATH.'news/'.$myrow['id'].'/', 'news-items');
						
						if($database->num_rows($query) != $numb) {
							$templates->assign('str', array('[no-last]', '[/no-last]'), '', 'news-items');
						} else { $templates->assign('preg', '~\[no-last\](.*?)\[/no-last\]~is', '', 'news-items'); }
						
						echo $templates->display('news-items');
					}
				} else { echo LANG('NO_NEWS'); }
			$templates->assign('str', '{news-items}', ob_get_clean(), 'news');
			
			$pagesData['p-content'] = $templates->display('news');
		break;
		
		case 'static':
			$pagesData['p-title'] = 'Управление статическими страницами';
			
			$templates->load('static.tpl', 'static');
			
			ob_start();
				$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_static` ORDER BY `id` DESC');
				if($database->num_rows($query) > 0) {
					$numb = 0;
					while($myrow = $database->fetch_array($query)) {
						$numb += 1;
						
						$templates->load('static-item.tpl', 'static-items');
						
						$templates->assign('str', '{title}', $myrow['title'], 'static-items');
						$templates->assign('str', '{url}', $myrow['url'], 'static-items');
						$templates->assign('str', '{edit-link}', '/'.ENGINE_PATH.'admin/static/edit/'.$myrow['id'].'/', 'static-items');
						$templates->assign('str', '{delete-link}', '/'.ENGINE_PATH.'admin/static/delete/'.$myrow['id'].'/', 'static-items');
						$templates->assign('str', '{item-link}', '/'.ENGINE_PATH.'do/'.$myrow['url'].'/', 'static-items');
						
						if($database->num_rows($query) != $numb) {
							$templates->assign('str', array('[no-last]', '[/no-last]'), '', 'static-items');
						} else { $templates->assign('preg', '~\[no-last\](.*?)\[/no-last\]~is', '', 'static-items'); }
						
						echo $templates->display('static-items');
					}
				} else { echo LANG('NO_PAGES'); }
			$templates->assign('str', '{static-items}', ob_get_clean(), 'static');
			
			$pagesData['p-content'] = $templates->display('static');
		break;
		
		case 'edit-news':
			$pagesData['p-title'] = 'Изменение новости';
			$id = isset($_GET['id'])?$_GET['id']:'';
			
			$templates->load('edit-news.tpl', 'edit-news');
			
			if($id != '') {
				$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_news` WHERE `id`=\''.$id.'\'');
				$resource = $database->fetch_array($query);
				if($database->num_rows($query) > 0) {
					if(isset($_POST['edit-news'])) {
						if(empty($_POST['title']) or empty($_POST['short-story'])) {
							$message = LANG('ALL_FIELDS_REQUIRED');
						} else {
							$full_story = ($_POST['full-story'] != '')?$_POST['full-story']:$_POST['short-story'];
							$database->query('UPDATE `'.DB_PREFIX.'_news` SET `title`=\''.$_POST['title'].'\', `short-story`=\''.$_POST['short-story'].'\', `full-story`=\''.$full_story.'\', `x-image`=\''.$_POST['x-image'].'\', `category`=\''.$_POST['category'].'\' WHERE `id`=\''.$id.'\'');
							$message = str_replace('{id}', $id, LANG('NEWS_WERE_CHANGED'));
						}
					}
 					$templates->assign('str', array('[form]', '[/form]'), '', 'edit-news');
				} else { $templates->assign('preg', '~\[form\](.*?)\[/form\]~is', str_replace('{id}', $id, LANG('INVALID_NEWS_ID')), 'edit-news'); }
				$templates->assign('str', '{title}', isset($_POST['title'])?htmlspecialchars($_POST['title']):htmlspecialchars($resource['title']), 'edit-news');
				$templates->assign('str', '{category-selector}', $admin->getSelectBox('category', isset($_POST['category'])?$_POST['category']:$resource['category']), 'edit-news');
				$templates->assign('str', '{short-story}', isset($_POST['short-story'])?stripslashes($_POST['short-story']):$resource['short-story'], 'edit-news');
				$templates->assign('str', '{full-story}', isset($_POST['full-story'])?stripslashes(($_POST['full-story'] != '')?$_POST['full-story']:$_POST['short-story']):$resource['full-story'], 'edit-news');
				$templates->assign('str', '{x-image}', isset($_POST['x-image'])?$_POST['x-image']:$resource['x-image'], 'edit-news');
				$templates->assign('str', '{x-width}', $database->getParam('x-img-width'), 'edit-news');
				$templates->assign('str', '{x-height}', $database->getParam('x-img-height'), 'edit-news');
			} else { $templates->assign('preg', '~\[form\](.*?)\[/form\]~is', LANG('EMPTY_NEWS_ID'), 'edit-news'); }
			
			$pagesData['p-content'] = $templates->display('edit-news');
		break;
		
		case 'edit-static':
			$pagesData['p-title'] = 'Изменение статической страницы';
			$id = isset($_GET['id'])?$_GET['id']:'';
			
			$templates->load('edit-static.tpl', 'edit-static');
			
			if($id != '') {
				$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_static` WHERE `id`=\''.$id.'\'');
				$resource = $database->fetch_array($query);
				if($database->num_rows($query) > 0) {
					if(isset($_POST['edit-static'])) {
						if(empty($_POST['url']) or empty($_POST['title']) or empty($_POST['content'])) {
							$message = LANG('ALL_FIELDS_REQUIRED');
						} else {
							$url_query = $database->query('SELECT * FROM `'.DB_PREFIX.'_static` WHERE `url`=\''.$_POST['url'].'\'');
							$id_query = $database->query('SELECT * FROM `'.DB_PREFIX.'_static` WHERE `id`=\''.$id.'\'');
							$resource = $database->fetch_array($id_query);
							if($resource['url'] == $_POST['url']) {
								$database->query('UPDATE `'.DB_PREFIX.'_static` SET `url`=\''.$_POST['url'].'\', `content`=\''.$_POST['content'].'\', `title`=\''.$_POST['title'].'\' WHERE `id`=\''.$id.'\'');
								$message = str_replace('{id}', $id, LANG('PAGE_WERE_CHANGED'));
							} else {
								if($database->num_rows($url_query) == 0) {
									$database->query('UPDATE `'.DB_PREFIX.'_static` SET `url`=\''.$_POST['url'].'\', `content`=\''.$_POST['content'].'\', `title`=\''.$_POST['title'].'\' WHERE `id`=\''.$id.'\'');
									$message = str_replace('{id}',$id,LANG('PAGE_WERE_CHANGED'));
								} else { $message = str_replace('{url}', $_POST['url'], LANG('PAGE_ALREADY_EXISTS')); }
							}
						}
					}
 					$templates->assign('str', array('[form]', '[/form]'), '', 'edit-static');
				} else { $templates->assign('preg', '~\[form\](.*?)\[/form\]~is', str_replace('{id}', $id, LANG('INVALID_PAGE_ID')), 'edit-static'); }
				$templates->assign('str', '{title}', isset($_POST['title'])?htmlspecialchars($_POST['title']):htmlspecialchars($resource['title']), 'edit-static');
				$templates->assign('str', '{content}', isset($_POST['content'])?stripslashes($_POST['content']):$resource['content'], 'edit-static');
				$templates->assign('str', '{url}', isset($_POST['url'])?$_POST['url']:$resource['url'], 'edit-static');
			} else { $templates->assign('preg', '~\[form\](.*?)\[/form\]~is', LANG('EMPTY_PAGE_ID'), 'edit-static'); }
			
			$templates->assign('str', '{site-link}', $_SERVER['HTTP_HOST'], 'edit-static');
			$templates->assign('str', '{path}', ENGINE_PATH, 'edit-static');
			
			$pagesData['p-content'] = $templates->display('edit-static');
		break;
		
		case 'add-category':
			$pagesData['p-title'] = 'Добавление категории';
			
			$templates->load('add-category.tpl', 'add-category');
			if(isset($_POST['add-category'])) {
				if(empty($_POST['name']) || empty($_POST['title'])) {
					$message = LANG('ALL_FIELDS_REQUIRED');
				} else {
					$database->query('INSERT INTO `'.DB_PREFIX.'_categories` (`name`, `title`) VALUES (\''.$_POST['name'].'\', \''.$_POST['title'].'\')') or $functions->mistake(mysql_error());
					$message = LANG('CAT_WERE_ADDED');
				}
			}
			
			$templates->assign('str', '{name}', isset($_POST['name'])?$_POST['name']:'', 'add-category');
			$templates->assign('str', '{title}', isset($_POST['title'])?htmlspecialchars($_POST['title']):'', 'add-category');
			$templates->assign('str', '{site-link}', $_SERVER['HTTP_HOST'], 'add-category');
			$templates->assign('str', '{path}', ENGINE_PATH, 'add-category');
			
			$pagesData['p-content'] = $templates->display('add-category');
		break;
		
		case 'add-news':
			$pagesData['p-title'] = 'Добавление новостей';
			
			$templates->load('add-news.tpl', 'add-news');
			if(isset($_POST['add-news'])) {
				if(empty($_POST['title']) || empty($_POST['short-story'])) {
					$message = LANG('ALL_FIELDS_REQUIRED');
				} else {
					$full_story = ($_POST['full-story'] != '')?$_POST['full-story']:$_POST['short-story'];
					$database->query('INSERT INTO `'.DB_PREFIX.'_news` (`title`, `short-story`, `full-story`, `x-image`, `date`, `author`, `category`) VALUES (\''.$_POST['title'].'\', \''.$_POST['short-story'].'\', \''.$full_story.'\', \''.$_POST['x-image'].'\', \''.$functions->curDate().'\', \''.$user->getArray('username').'\', \''.$_POST['category'].'\')') or $functions->mistake(mysql_error());
					$message = LANG('NEWS_WERE_ADDED');
				}
			}
			
			$templates->assign('str', '{title}', isset($_POST['title'])?htmlspecialchars($_POST['title']):'', 'add-news');
			$templates->assign('str', '{category-selector}', $admin->getSelectBox('category', isset($_POST['category'])?$_POST['category']:''), 'add-news');
			$templates->assign('str', '{short-story}', isset($_POST['short-story'])?stripslashes($_POST['short-story']):'', 'add-news');
			$templates->assign('str', '{full-story}', isset($_POST['full-story'])?stripslashes($_POST['full-story']):'', 'add-news');
			$templates->assign('str', '{x-image}', isset($_POST['x-image'])?$_POST['x-image']:'', 'add-news');
			$templates->assign('str', '{x-width}', $database->getParam('x-img-width'), 'add-news');
			$templates->assign('str', '{x-height}', $database->getParam('x-img-height'), 'add-news');
			
			$pagesData['p-content'] = $templates->display('add-news');
		break;
		
		case 'add-static':
			$pagesData['p-title'] = 'Добавление статических страниц';
			
			$templates->load('add-static.tpl', 'add-static');
			
			if(isset($_POST['add-static'])) {
				$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_static` WHERE `url`=\''.$_POST['url'].'\'');
				if(empty($_POST['title']) || empty($_POST['content']) || empty($_POST['url'])) {
					$message = LANG('ALL_FIELDS_REQUIRED');
				} elseif(!preg_match("/^[a-zA-Z0-9-_]+$/", $_POST['url'])) {
					$message = LANG('URL_IS_INVALID');
				} elseif($database->num_rows($query) == 0) {
					$database->query('INSERT INTO `'.DB_PREFIX.'_static` (`title`, `content`, `url`) VALUES (\''.$_POST['title'].'\', \''.$_POST['content'].'\', \''.$_POST['url'].'\')');
					$message = str_replace('{page-url}', '/'.ENGINE_PATH.'do/'.$_POST['url'].'/', LANG('PAGE_WERE_ADDED'));
				} else { $message = str_replace('{url}', $_POST['url'], LANG('PAGE_ALREADY_EXISTS')); }
			}
			
			$templates->assign('str', '{title}', isset($_POST['title'])?htmlspecialchars($_POST['title']):'', 'add-static');
			$templates->assign('str', '{content}', isset($_POST['content'])?stripslashes($_POST['content']):'', 'add-static');
			$templates->assign('str', '{url}', isset($_POST['url'])?$_POST['url']:'', 'add-static');
			$templates->assign('str', '{site-link}', $_SERVER['HTTP_HOST'], 'add-static');
			$templates->assign('str', '{path}', ENGINE_PATH, 'add-static');
			
			$pagesData['p-content'] = $templates->display('add-static');
		break;
		
		case 'delete-category':
			$pagesData['p-title'] = 'Удаление категории';
			$id = isset($_GET['id'])?$_GET['id']:'';
			
			$templates->load('admin-page.tpl', 'admin');
			
			if($id != '') {
				$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_categories` WHERE `id`=\''.$id.'\'');
				$resource = $database->fetch_array($query);
				if($database->num_rows($query) > 0) {
					if(isset($_POST['submit'])) {
						if(isset($_POST['delete-news'])) { $database->query('DELETE FROM `'.DB_PREFIX.'_news` WHERE `category`=\''.$resource['name'].'\''); }
						$database->query('DELETE FROM `'.DB_PREFIX.'_categories` WHERE `id`=\''.$id.'\'');
						$message = str_replace('{id}', $id, LANG('CAT_WERE_DELETED'));
					} else { $message = str_replace('{id}', $id, LANG('TRUE_DELETE_CAT')); }
				} else { $message = str_replace('{id}', $id, LANG('INVALID_CAT_ID')); }
			} else { $message = LANG('EMPTY_CAT_ID'); }
			
			$pagesData['p-content'] = $templates->display('admin');
			$templates->clear('admin');
		break;
		
		case 'delete-news':
			$pagesData['p-title'] = 'Удаление новости';
			$id = isset($_GET['id'])?$_GET['id']:'';
			
			$templates->load('admin-page.tpl', 'admin');
			
			if($id != '') {
				$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_news` WHERE `id`=\''.$id.'\'');
				if($database->num_rows($query) > 0) {
					if(isset($_POST['submit'])) {
						$database->query('DELETE FROM `'.DB_PREFIX.'_news` WHERE `id`=\''.$id.'\'');
						if(isset($_POST['delete-comments'])) { $database->query('DELETE FROM `'.DB_PREFIX.'_comments` WHERE `news-id`=\''.$id.'\''); }
						$message = str_replace('{id}', $id, LANG('NEWS_WERE_DELETED'));
					} else { $message = str_replace('{id}', $id, LANG('TRUE_DELETE_NEWS')); }
				} else { $message = str_replace('{id}', $id, LANG('INVALID_NEWS_ID')); }
			} else { $message = LANG('EMPTY_NEWS_ID'); }
			
			$pagesData['p-content'] = $templates->display('admin');
			$templates->clear('admin');
		break;
		
		case 'delete-static': 
			$pagesData['p-title'] = 'Удаление статической страницы';
			$id = isset($_GET['id'])?$_GET['id']:'';
			$delete = isset($_GET['delete'])?$_GET['delete']:'';
			
			$templates->load('admin-page.tpl', 'admin');
			
			if($id != '') {
				$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_static` WHERE `id`=\''.$id.'\'');
				if($database->num_rows($query) > 0) {
					if($delete == 'yes') {
						$database->query('DELETE FROM `'.DB_PREFIX.'_static` WHERE `id`=\''.$id.'\'');
						$message = str_replace('{id}', $id, LANG('PAGE_WERE_DELETED'));
					} else { $message = str_replace(array('{id}', '{accept-link}'), array($id, '/'.ENGINE_PATH.'admin/static/delete/'.$id.'/yes/'), LANG('TRUE_DELETE_PAGE')); }
				} else { $message = str_replace('{id}', $id, LANG('INVALID_PAGE_ID')); }
			} else { $message = LANG('EMPTY_PAGE_ID'); }
			
			$pagesData['p-content'] = $templates->display('admin');
			$templates->clear('admin');
		break;
		
		case 'delete-comments':
			$pagesData['p-title'] = 'Удаление комментария';
			$id = isset($_GET['id'])?$_GET['id']:'';
			$delete = isset($_GET['delete'])?$_GET['delete']:'';
			
			$templates->load('admin-page.tpl', 'admin');
			
			if($id != '') {
				$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_comments` WHERE `id`=\''.$id.'\'');
				if($database->num_rows($query) > 0) {
					if($delete == 'yes') {
						$database->query('DELETE FROM `'.DB_PREFIX.'_comments` WHERE `id`=\''.$id.'\'');
						$message = str_replace('{id}', $id, LANG('COMMENT_WERE_DELETED'));
					} else { $message = str_replace(array('{id}', '{accept-link}'), array($id, '/'.ENGINE_PATH.'admin/comments/delete/'.$id.'/yes/'), LANG('TRUE_DELETE_COMMENT')); }
				} else { $message = str_replace('{id}', $id, LANG('INVALID_COMMENT_ID')); }
			} else { $message = LANG('EMPTY_COMMENT_ID'); }
			
			$pagesData['p-content'] = $templates->display('admin');
			$templates->clear('admin');
		break;
		
		case 'nullify-news':
			$pagesData['p-title'] = 'Обнуление просмотров';
			$id = isset($_GET['id'])?$_GET['id']:'';
			
			$templates->load('admin-page.tpl', 'admin');
			
			if($id != '') {
				$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_news` WHERE `id`=\''.$id.'\'');
				if($database->num_rows($query) > 0) {
					$database->query('UPDATE `'.DB_PREFIX.'_news` SET `views`=\'0\' WHERE `id`=\''.$id.'\'');
					$message = str_replace('{id}', $id, LANG('NEWS_WERE_NULLED'));
				} else { $message = str_replace('{id}', $id, LANG('INVALID_NEWS_ID')); }
			} else { $message = LANG('EMPTY_NEWS_ID'); }
			
			$pagesData['p-content'] = $templates->display('admin');
			$templates->clear('admin');
		break;
		
	}
	
	$templates->load('admin.tpl', 'admin');
	
	$templates->assign('str', '{p-headers}', '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="Author" content="RevenHell">
		<meta name="Generator" content="Bravel Web Engine ('.VERSION.')">
		<meta name="Robots" content="'.$pagesData['p-robots'].'">
		<script type="text/javascript" src="/'.ENGINE_PATH.'engine/include/js/jQuery-library.js"></script>', 'admin');
	$templates->assign('str', '{p-title}', $pagesData['p-title'], 'admin');
	$templates->assign('str', '{p-content}', $pagesData['p-content'], 'admin');
	$templates->assign('str', '{THEME}', '/'.ENGINE_PATH.'engine/include', 'admin');
	$templates->assign('str', '{username}', $user->getArray('username'), 'admin');
	$templates->assign('str', '{engine-name}', 'Bravel Web Engine', 'admin');
	$templates->assign('str', '{admin-link}', '/'.ENGINE_PATH.'admin/', 'admin');
	$templates->assign('str', '{logout-link}', '/'.ENGINE_PATH.'logout/admin/', 'admin');
	$templates->assign('str', '{main-link}', '/'.ENGINE_PATH, 'admin');
	
	if($message != '') {
		$templates->assign('str', array('[message]', '[/message]'), '', 'admin');
		$templates->assign('str', '{message}', $message, 'admin');
	} else { $templates->assign('preg', '~\[message\](.*?)\[/message\]~is', '', 'admin'); }
	
	echo $templates->display('admin', true);
	
} else {
	
	$templates->load('login.tpl', 'admin');
	
	if(isset($_POST['admin-send'])) {
		switch($user->checkAuth($functions->strip($_POST['username']), $functions->strip($_POST['password']), true)) {
			case 1: $message = LANG('ALL_FIELDS_REQUIRED'); break;
			case 2: $message = LANG('AUTHORIZATION_ERROR'); break;
			case 3: $message = LANG('ACCOUNT_IS_BANNED'); break;
			case 4: $message = LANG('ACCOUNT_IS_NOT_CONFIRM'); break;
			case 41: $message = LANG('ACCESS_DENIED'); break;
			case 5:
				$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_users` WHERE `username`=\''.$functions->strip($_POST['username']).'\' AND `password`=\''.$functions->strip($functions->crypt($_POST['password'])).'\'');
				$resource = $database->fetch_array($query);
				if(isset($_POST['remember'])) {
					$token = $functions->generateToken($functions->strip($_POST['username']));
					$functions->setcookie('token', $token);
					$database->query('UPDATE `'.DB_PREFIX.'_users` SET `token`=\''.$token.'\' WHERE `username`=\''.$functions->strip($_POST['username']).'\'');
				}
				$_SESSION['username'] = $resource['username'];
				$functions->spaceTo('/'.ENGINE_PATH.'admin/');
			break;
		}
	}
	
	if($message != '') {
		$templates->assign('str', array('[message]', '[/message]'), '', 'admin');
	} else { $templates->assign('preg', '~\[message\](.*?)\[/message\]~is', '', 'admin'); }
	$templates->assign('str', '{message}', $message, 'admin');
	$templates->assign('str', '{p-title}', 'Авторизация', 'admin');
	$templates->assign('str', '{engine-name}', 'Bravel Web Engine', 'admin');
	$templates->assign('str', '{p-headers}', '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="Author" content="RevenHell">
		<meta name="Generator" content="Bravel Web Engine ('.VERSION.')">
		<meta name="Robots" content="'.$pagesData['p-robots'].'">
		<script type="text/javascript" src="/'.ENGINE_PATH.'engine/include/js/jQuery-library.js"></script>', 'admin');
	$templates->assign('str', '{THEME}', '/'.ENGINE_PATH.'engine/include', 'admin');
	
	echo $templates->display('admin', true);
	
}

$database->close();
die();
?>