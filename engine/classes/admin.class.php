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

class admin {
	
	public function updateBoolean($settingName) {
		global $database;
		if($_POST[$settingName] == LANG('YES')) {
			$bool = 'true';
		} elseif($_POST[$settingName] == LANG('NO')) { $bool = 'false'; }
		$database->query('UPDATE `'.DB_PREFIX.'_config` SET `value`=\''.$bool.'\' WHERE `setting`=\''.$settingName.'\'');
	}
	
	public function getSelectBox($paramName, $category = '') {
		global $database;
		ob_start();
			if($paramName == 'category') {
				$i = 0;
				echo '<select id="cs-categories-box" name="category">'.PHP_EOL;
				$query = $database->query('SELECT * FROM `'.DB_PREFIX.'_categories`');
				while($myrow = $database->fetch_array($query)) {
					$i += 1;
					if($myrow['name'] == $category) {
						$selected[$i] = 'selected ';
						$active[$i] = 'active-';
					}
					echo '<option id="cs-category-'.$active[$i].'option" '.$selected[$i].'value="'.$myrow['name'].'">'.$myrow['title'].'</option>'.PHP_EOL;
				}
				echo '</select>'.PHP_EOL;
			} elseif($paramName == 'theme') {
				echo '<select id="cs-theme-box" name="theme">'.PHP_EOL;
				if(is_dir(BASE.'/themes/')) {
					$files = scandir(BASE.'/themes/');
					array_shift($files);
					array_shift($files);
					for($i = 0; $i < sizeof($files); $i++) {
						if($files[$i] != '.htaccess') {
							if($database->getParam('theme') == $files[$i]) {
								$selected[$i] = 'selected ';
								$active[$i] = 'active-';
							}
							echo '<option id="cs-theme-'.$active[$i].'option" '.$selected[$i].'value="'.$files[$i].'">'.$files[$i].'</option>'.PHP_EOL;
						}
					}
				}
				echo '</select>'.PHP_EOL;
			} else {
				$selectBox = array(LANG('YES'), LANG('NO'));
				echo '<select id="cs-'.$paramName.'-box" name="'.$paramName.'">'.PHP_EOL;
				for($i = 0; $i < sizeof($selectBox); $i++) {
					if($selectBox[$i] == LANG('NO')) {
						if($database->getParam($paramName) == 'false') {
							echo '<option id="cs-'.$paramName.'-active-option" selected value="'.$selectBox[$i].'">'.$selectBox[$i].'</option>'.PHP_EOL;
						} else { echo '<option id="cs-'.$paramName.'-option" value="'.$selectBox[$i].'">'.$selectBox[$i].'</option>'.PHP_EOL; }
					} elseif($selectBox[$i] == LANG('YES')) {
						if($database->getParam($paramName) == 'true') {
							echo '<option id="cs-'.$paramName.'-active-option" selected value="'.$selectBox[$i].'">'.$selectBox[$i].'</option>'.PHP_EOL;
						} else { echo '<option id="cs-'.$paramName.'-option" value="'.$selectBox[$i].'">'.$selectBox[$i].'</option>'.PHP_EOL; }
					}
				}
				echo '</select>'.PHP_EOL;
			}
		return ob_get_clean();
	}
	
}

$admin = new admin();
?>