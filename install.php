	<?php
/**
  Module developed for the Open Source Content Management System Website Baker (http://websitebaker.org)
  Copyright (C) 2009, Jan Schwarzkopf
  Contact me: webmaster(at)computerjan.de, http://www.webwork-blog.net

  This module is free software. You can redistribute it and/or modify it 
  under the terms of the GNU General Public License  - version 2 or later, 
  as published by the Free Software Foundation: http://www.gnu.org/licenses/gpl.html.

  This module is distributed in the hope that it will be useful, 
  but WITHOUT ANY WARRANTY; without even the implied warranty of 
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
  GNU General Public License for more details.
*/

if(!defined('WB_PATH')) die(header('Location: index.php'));  
$database->query("DROP TABLE IF EXISTS `" .TABLE_PREFIX ."mod_color4code`");
$mod_create_table = 'CREATE TABLE `' .TABLE_PREFIX .'mod_color4code` ( '
	. '`section_id` INT NOT NULL ,'
	. '`page_id` INT NOT NULL ,'
	. '`lang` VARCHAR( 32 ) NOT NULL DEFAULT \'php\','
	. '`frontendlang` TINYINT NOT NULL ,'
	. '`codeescaped` TINYINT NOT NULL ,'
	. '`linenumbers` TINYINT NOT NULL ,'
	. '`linesstartat` INT NOT NULL DEFAULT \'1\','
	. '`textareaheight` INT NOT NULL ,'
	. '`codewrapper` TINYINT NOT NULL DEFAULT \'1\','
	. '`textconvert` TINYINT NOT NULL DEFAULT \'1\','
	. '`text` TEXT NOT NULL ,'
	. '`last_modified` INT NOT NULL ,'
	. 'PRIMARY KEY ( `section_id` )'
	. ' )'; 
$database->query($mod_create_table) or die(mysql_error());
?>