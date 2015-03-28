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

class templates {
	
	protected $template = array();
	protected $blacklist = array();
	protected $info = '';
	
	protected $path = '';
	
	public function setPath($path) {
		$this->path = $path;
	}
	
	public function clear($i) {
		$this->blacklist[$i] = true;
	}
	
	public function load($fileName, $i) {
		global $database, $functions;
		if($this->path != '') {
			if(empty($this->blacklist[$i])) {
				if(is_dir($this->path)) {
					if(file_exists($this->path.$fileName)) {
						$this->template[$i] = file_get_contents($this->path.$fileName);
					} else { $functions->mistake('Ошибка! Файл "'.$fileName.'" не найден!'); }
				} else { $functions->mistake('Ошибка! Путь "<b>'.$this->path.'</b>" неверен!'); }
			}
		} else { $functions->mistake('Ошибка! Не указан путь!'); }
	}
	
	public function assign($action, $search, $replace, $i) {
		global $functions;
		if(isset($this->template[$i])) {
			switch($action) {
				case 'str'; $this->template[$i] = str_replace($search, $replace, $this->template[$i]); break;
				case 'preg'; $this->template[$i] = preg_replace($search, $replace, $this->template[$i]); break;
				case 'callback'; $this->template[$i] = preg_replace_callback($search, $replace, $this->template[$i]); break;
			}
		} else { $functions->mistake('Ошибка! Функция "<b>load()</b>" не определена!'); }
	}
	
	public function info($action, $string, $replace = array()) {
		global $database, $functions;
		$path = BASE.'themes/'.$database->getParam('theme').'/info.tpl';
		if(file_exists($path)) {
			$this->info = file_get_contents($path);
		} else { $functions->mistake('Ошибка! Файл "<b>/'.ENGINE_PATH.'themes/'.$database->getParam('theme').'/info.tpl</b>" не найден!'); }
		switch($action) {
			case 'info':
				$this->info = str_replace(array('[info]', '[/info]'), '', $this->info);
				$this->info = preg_replace('~(\[error\].+\[/error\])~is', '', $this->info);
				$this->info = preg_replace('~(\[success\].+\[/success\])~is', '', $this->info);
			break;
			case 'success':
				$this->info = str_replace(array('[success]', '[/success]'), '', $this->info);
				$this->info = preg_replace('~(\[error\].+\[/error\])~is', '', $this->info);
				$this->info = preg_replace('~(\[info\].+\[/info\])~is', '', $this->info);
			break;
			case 'error':
				$this->info = str_replace(array('[error]', '[/error]'), '', $this->info);
				$this->info = preg_replace('~(\[success\].+\[/success\])~is', '', $this->info);
				$this->info = preg_replace('~(\[info\].+\[/info\])~is', '', $this->info);
			break;
		}
		$this->info = str_replace('{information}', $string, $this->info);
		$this->info = str_replace(array_keys($replace), array_values($replace), $this->info);
		return $this->info;
	}
	
	public function infoTag($data) {
		return $this->info($data[1], $data[2]);
	}
	
	public function includeFile($fileName) {
		global $database, $functions, $user;
		$fileName[1] = str_replace('{THEME}', ENGINE_PATH.'themes/'.$database->getParam('theme'), $fileName[1]);
		if(file_exists(BASE.$fileName[1])) {
			if($fileName[1] == ENGINE_PATH.'themes/'.$database->getParam('theme').'/login.tpl') {
				return str_replace('{username}', $user->getArray('username'), file_get_contents(BASE.$fileName[1]));
			} else { return file_get_contents(BASE.$fileName[1]); }
		} else { return $functions->mistake('Ошибка! Файл "<b>/'.ENGINE_PATH.$fileName[1].'</b>" не найден!',false); }
	}
	
	public function display($i, $showCopy = false) {
		global $functions;
		$copyright = base64_decode('PCEtLSBCcmF2ZWwgV2ViIEVuZ2luZSAo').VERSION.base64_decode('KSDCqSAyMDE0LTIwMTUgfCBjb3JlLmJyYXZlbC5ydSAtLT4=');
		if(isset($this->template[$i])) {
			return $showCopy?$copyright.PHP_EOL.$this->template[$i].PHP_EOL.$copyright:$this->template[$i];
		} else { $functions->mistake('Ошибка! Функция "<b>load()</b>" не определена!'); }
	}
	
}

$templates = new templates();
?>