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

class database {
	
	protected $db = null;
	
	public function connect($db_host, $db_user, $db_pass, $db_base) {
		global $functions;
		$this->db = mysql_connect($db_host, $db_user, $db_pass) or $functions->mistake('Ошибка соединения с Базой Данных: <b>'.mysql_error().'</b>');
		mysql_select_db($db_base, $this->db) or $functions->mistake('Ошибка соединения с Базой Данных: <b>'.mysql_error().'</b>');
		
		$this->query('SET `character_set_client`=\'utf8\'');
		$this->query('SET `character_set_results`=\'utf8\'');
		$this->query('SET `collation_connection`=\'utf8_unicode_ci\'');
		$this->query('SET `time_zone`=\''.date('P').'\'');
		
	}
	
	public function getParam($paramName) {
		$query = $this->query('SELECT * FROM `'.DB_PREFIX.'_config` WHERE `setting`=\''.$paramName.'\'');
		$resource = $this->fetch_array($query);
		if(isset($resource['value'])) {
			return $resource['value'];
		} else { return ''; }
	}
	
	public function getDatabaseSize() {
		$db_size = 0;
		$query = $this->query('SHOW TABLE STATUS');
		while($myrow = $this->fetch_array($query)) {
			$db_size += $myrow['Data_length']+$myrow['Index_length'];
		}
		return $db_size;
	}
	
	public function forStatistics($mode, $type) {
		switch($mode) {
			case 'first': $query = $this->query('SELECT * FROM `'.DB_PREFIX.'_'.$type.'`'); break;
			case 'last': $query = $this->query('SELECT * FROM `'.DB_PREFIX.'_'.$type.'` ORDER BY `id` DESC'); break;
		}
		$resource = $this->fetch_array($query);
		if($resource == '') {
			return '---';
		} else {
			switch($type) {
				case 'users': $type = 'user'; $text = $resource['username']; $url = $resource['username']; break;
				case 'news': $type = 'news'; $text = $resource['title']; $url = $resource['id']; break;
			}
			return '<a target="_blank" href="/'.ENGINE_PATH.$type.'/'.$url.'/">'.$text.'</a>';
		}
	}
	
	public function countFrom($table) {
		$query = $this->query('SELECT COUNT(*) FROM `'.DB_PREFIX.'_'.$table.'`');
		return $this->result($query);
	}
	
	public function getOnlineUsers() {
		global $functions;
		$count = 0;
		$query = $this->query('SELECT * FROM `'.DB_PREFIX.'_users`');
		while($myrow = $this->fetch_array($query)) {
			if($myrow['time'] > $functions->getTime()-60) { $count++; }
		}
		return $count;
	}
	
	public function query($string) { return mysql_query($string, $this->db); }
	
	public function result($string) { return mysql_result($string, 0); }
	
	public function num_rows($string) { return mysql_num_rows($string); }
	
	public function fetch_array($string) { return mysql_fetch_array($string); }
	
	public function fetch_row($string) { return mysql_fetch_row($string); }
	
	public function close() { return mysql_close($this->db); }
	
}

$database = new database();
?>