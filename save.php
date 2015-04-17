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

require('../../config.php');
$update_when_modified = true;
require(WB_PATH.'/modules/admin.php');

/**
 * Ausgewählte Sprache des Codes in Kleinbuchstaben
 */
$c4clang = $admin->get_post('lang');
/**
 * Zeile mit der die Nummerierung startet
 */
$c4clinestartat = $admin->get_post('linestartat');
/**
 * HTML-Element, dass den fertigen Code umgibt
 */
$c4ccodewrapper = $admin->get_post('codewrapper');
/*
 * Soll der Code in Klein/Großbuchstaben umgewandelt werden
 */
$c4ctextconvert = $admin->get_post('textconvert');
/*
 * Höhe der Textarea (Feature noch nicht integriert)
 */
$c4ctextareaheight = $admin->get_post('textareaheight');
/*
 * Der eigentliche Code
 */
$c4ctext = $admin->get_post('text');

/* * * * * * * *
 * Checkboxes  *
 *	       *
 * * * * * * * */

/*
 * Soll die Sprache des Codes im Frontend angezeigt werden ? (Ja = 1 - Nein = 0)
 */
$c4cfrontendlang = (isset($_POST['frontendlang']) ? 1 : 0);
/*
 * Ist der Codes bereits mit HTML-Entities escpaed ? (Ja = 1 - Nein = 0)
 */
$c4cescaped = (isset($_POST['escaped']) ? 1 : 0);
/*
 * Soll die Zeilennummerierung angezeigt werden ? (Ja = 1 - Nein = 0)
 */
$c4clinenumbers = (isset($_POST['linenumbers']) ? 1 : 0);
/*
 * Aktuellen Timestamp in der Variablen $timestamp speichern
 */
$timestamp = time();

/*
 * SQL-Query in der Variablen $sql_query zusammensetzen
 */
$sql_query = "UPDATE " .TABLE_PREFIX ."mod_color4code SET
	lang = '$c4clang',
	frontendlang = '$c4cfrontendlang',
	codeescaped = '$c4cescaped',
	linenumbers = '$c4clinenumbers',
	linesstartat = '$c4clinestartat',
	textareaheight = '$c4ctextareaheight',
	codewrapper = '$c4ccodewrapper',
	textconvert = '$c4ctextconvert',
	text = '". mysql_real_escape_string( $c4ctext ) ."',
	last_modified = '$timestamp' WHERE section_id = $section_id";
$database->query($sql_query);

/*
 * Fehler abfangen
 */
if($database->is_error()) {
	$admin->print_error($database->get_error(), $js_back);
} else {
	$admin->print_success($MESSAGE['PAGES']['SAVED'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);}

$admin->print_footer();

?>