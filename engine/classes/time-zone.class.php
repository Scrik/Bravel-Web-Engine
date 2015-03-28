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

class time_zone {
	
	public function zones_list($selectedZone = false) {
		include(BASE.'engine/data/time-zones.php');
		ob_start();
			echo '<select id="cs-time-zone-box" name="time-zone">'.PHP_EOL;
			foreach($time_zones as $key => $value) {
				echo '<option id="cs-time-zone-'.(($value == $selectedZone)?'active-':'').'option" value="'.$value.'"'.(($value == $selectedZone)?' selected':'').'>'.$key.'</option>'.PHP_EOL;
			}
			echo '</select>';
		return ob_get_clean();
	}
	
	public function get() {
		return date_default_timezone_get();
	}
	
	public function set($timeZone) {
		date_default_timezone_set($timeZone);
	}
	
}

$time_zone = new time_zone();
?>