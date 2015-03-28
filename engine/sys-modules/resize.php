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

Header('Content-type: image/png');
Header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
Header('Cache-Control: no-store, no-cache, must-revalidate');
Header('Cache-Control: post-check=0, pre-check=0', FALSE);
Header('Pragma: no-cache');

$needle_width = addslashes($_GET['width']);
$needle_height = addslashes($_GET['height']);
$source_file = addslashes(str_replace('https://', 'http://', $_GET['source']));

list($width, $height) = getimagesize($source_file);
$image = imagecreatefromstring(file_get_contents($source_file));

if(empty($needle_height)) {
	$needle_height = ($height/$width)*$needle_width;
}

$temp = imagecreatetruecolor($needle_width, $needle_height);
imagecopyresampled($temp, $image, 0, 0, 0, 0, $needle_width, $needle_height, $width, $height);

imagepng($temp);
imagedestroy($image);
imagedestroy($temp);
?>