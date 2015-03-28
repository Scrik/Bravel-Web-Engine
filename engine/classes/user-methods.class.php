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

class userMethods {
	
	public function birthday($username) {
		// $username - ник именинника
		// Здесь можно прописать какой нибудь бонус для именинника, а затем написать про него в "account.tpl" между тегами "[birthday]" :)
		// Учтите, что данный метод вызывается при каждом открытии страницы в день рождения, так-что придется сделать так, что-бы он мог быть вызван лишь один раз.
		// Ps. Можно еще написать систему, что-бы если именинника не было на сайте в день его рождения, то бонус зачислился бы позже...
	}
	
	public function invitationBonus($username) {
		// $username - ник пригласившего
		// Здесь можно написать какой нибудь бонус для пригласившего человека
	}
	
}
?>