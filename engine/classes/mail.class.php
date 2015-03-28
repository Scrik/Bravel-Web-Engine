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

class mail {
	
	protected $data_charset = 'UTF-8';
	protected $send_charset = 'KOI8-R';
	
	protected $to = '';
	protected $subject = '';
	protected $message = '';
	protected $from = 'noreply@{host}';
	
	protected $headers = '';
	
	public function setTo($string) {
		$this->to = $string;
	}
	
	public function setSubject($string) {
		if($this->data_charset != $this->send_charset) { $string = iconv($this->data_charset, $this->send_charset, $string); }
		$this->subject = '=?'.$this->send_charset.'?B?'.base64_encode($string).'?=';
	}
	
	public function setMessage($message) {
		if($this->data_charset != $this->send_charset) { $message = iconv($this->data_charset, $this->send_charset, $message); }
		$this->message = $message;
	}
	
	public function setFrom($string) {
		$this->from = $string;
	}
	
	public function send() {
		$this->from = str_replace('{host}', $_SERVER['HTTP_HOST'], $this->from);
		$this->headers .= 'From: '.$this->from."\r\n";
		
		$this->headers .= 'Content-type: text/html; charset='.$this->send_charset."\r\n";
		$this->headers .= 'X-Mailer: PHP/'.phpversion()."\r\n";
		$this->headers .= 'Mime-Version: 1.0';
		mail($this->to, $this->subject, $this->message, $this->headers);
	}
	
}

$mail = new mail();
?>