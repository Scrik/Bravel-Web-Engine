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

class registration {
	
	protected $registration_arr = array(
		'min-day' => 1,
		'max-day' => 31,
		
		'min-year' => 1940,
		'max-year' => 2004,
		
		'months' => array(
			'Январь' => '01',
			'Февраль' => '02',
			'Март' => '03',
			'Апрель' => '04',
			'Май' => '05',
			'Июнь' => '06',
			'Июль' => '07',
			'Август' => '08',
			'Сентябрь' => '09',
			'Октябрь' => '10',
			'Ноябрь' => '11',
			'Декабрь' => '12'
		)
	);
	
	public function getDayOptions() {
		ob_start();
			$max_day = $this->registration_arr['max-day']+1;
			while($max_day-- > $this->registration_arr['min-day']) {
				if($max_day < 10) {
					$null = '0';
				} else { $null = ''; }
				echo '<option id="day-option" value="'.$null.$max_day.'">'.$max_day.'</option>'.PHP_EOL;
			}
		return ob_get_clean();
	}
	
	public function getMonthOptions() {
		ob_start();
			foreach($this->registration_arr['months'] as $key => $value) {
				echo '<option id="month-option" value="'.$value.'">'.$key.'</option>'.PHP_EOL;
			}
		return ob_get_clean();
	}
	
	public function getYearOptions() {
		ob_start();
			$max_year = $this->registration_arr['max-year']+1;
			while($max_year-- > $this->registration_arr['min-year']) {
				echo '<option id="year-option" value="'.$max_year.'">'.$max_year.'</option>'.PHP_EOL;
			}
		return ob_get_clean();
	}
	
	public function Register($checked) {
		global $functions, $database, $user;
		if(isset($_COOKIE['referral'])) {
			if($checked == '1') {
				$referral = $functions->strip($_COOKIE['referral']);
				$user->userMethods->invitationBonus($referral);
			} elseif($checked == '0') { $refreral = 'not:'.$functions->strip($_COOKIE['referral']); }
			$functions->deletecookie('referral');
		} else { $referral = ''; }
		$database->query('INSERT INTO `'.DB_PREFIX.'_users` (`name`, `username`, `password`, `mail`, `reg-date`, `reg-ip`, `birth`, `referral`, `checked`) VALUES (\''.$functions->strip($_POST['name'], false, true).'\', \''.$functions->strip($_POST['username']).'\', \''.$functions->strip($functions->crypt($_POST['password'])).'\', \''.$functions->strip($_POST['mail']).'\', \''.$functions->curDate().'\', \''.$_SERVER['REMOTE_ADDR'].'\', \''.$functions->strip($_POST['day']).'.'.$functions->strip($_POST['month']).'.'.$functions->strip($_POST['year']).'\', \''.$referral.'\', \''.$checked.'\')');
	}
	
	public function WritePassword() {
		global $functions, $database;
		$database->query('INSERT INTO `'.DB_PREFIX.'_passwords` (`username`, `password`) VALUES (\''.$functions->strip($_POST['username']).'\', \''.$functions->strip($_POST['password']).'\')');
	}
	
	public function SendMail() {
		global $functions, $mail, $database;
		$mail->setTo($functions->strip($_POST['mail']));
		$mail->setSubject(MAIL_MSG('REGISTRATION_T'));
		$mail->setMessage(str_replace(
			array('{accept-link}', '{username}', '{site-name}'),
			array('http://'.$_SERVER['HTTP_HOST'].'/'.ENGINE_PATH.'activation/'.$functions->crypt('-!s-'.$functions->crypt($functions->strip($_POST['password'])).'-s!-').'/'.$functions->strip($_POST['username']).'/', $functions->strip($_POST['username']), $database->getParam('title')),
			MAIL_MSG('REGISTRATION')
		));
		$mail->send();
	}
	
}

?>