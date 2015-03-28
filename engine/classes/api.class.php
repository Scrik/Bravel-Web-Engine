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

class api {
	
	public $replaceList = array();
	public $library = array();
	
	public function loadModulesFrom($modulesDir) {
		$skip = array('.', '..');
		$modules = scandir($modulesDir);
		foreach($modules as $module) {
			if(!in_array($module, $skip)) {
				$this->load($modulesDir.$module.'/controller.class.php', $module);
			}
		}
	}
	
	public function load($fileName, $moduleName) {
		global $functions;
		if(file_exists($fileName)) {
			include($fileName);
			$className = $moduleName.'_Controller';
			$controller = new $className();
			$controller->run();
			$version = $controller->version;
			$this->library[$moduleName] = $controller;
			$this->replaceList = $controller->cacheReplaceList;
			if(isset($version)) {
				if($functions->contains($version, '+')) {
					$version = str_replace('+', '', $version);
					if(VERSION > $version || VERSION == $version) {
						// ok...
					} else { return $functions->mistake('Ошибка! Модуль "<b>'.$moduleName.'</b>" требует версию <b>'.$version.'</b> и выше, у вас <b>'.VERSION.'</b>!', false); }
				} else {
					if($version == VERSION) {
						// ok...
					} else { return $functions->mistake('Ошибка! Модуль "<b>'.$moduleName.'</b>" требует версию <b>'.$version.'</b>, у вас <b>'.VERSION.'</b>!', false); }
				}
			} else { return $functions->mistake('Ошибка! Версия модуля "<b>'.$moduleName.'</b>" не указана!', false); }
		} else { return $functions->mistake('Ошибка! Модуль "<b>'.$moduleName.'</b>" не найден!', false); }
	}
	
}

$api = new api();
?>