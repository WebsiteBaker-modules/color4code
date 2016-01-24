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

$backlink = ADMIN_URL.'/pages/modify.php?page_id='.(int)$page_id.'#wb_'.$section_id;
// Validate all fields
if($admin->get_post('text') == '') {
    $admin->print_error($MESSAGE['GENERIC_FILL_IN_ALL'], $backlink);
} else {

//Ausgewählte Sprache des Codes in Kleinbuchstaben
$c4clang = (isset($_POST['lang']) ? ($admin->get_post('lang')) : 'php');

//Zeile mit der die Nummerierung startet
$c4clinestartat = (isset($_POST['linestartat']) ? (intval($_POST['linestartat'])) : '1');

//HTML-Element, dass den fertigen Code umgibt - pre, div, kein
$c4ccodewrapper = (isset($_POST['codewrapper']) ? (intval($_POST['codewrapper'])) : '3');

//Soll der Code in Klein/Großbuchstaben umgewandelt werden
$c4ctextconvert = (isset($_POST['textconvert']) ? (intval($_POST['textconvert'])) : '1');

//Höhe der Textarea (Feature noch nicht integriert)
$c4ctextareaheight = (isset($_POST['textareaheight']) ? (intval($_POST['textareaheight'])) : '300');

//Der eigentliche Code
$tags = array('<?php', '?>' , '<?', '<?=');
$c4ctext = (isset($_POST['text']) ? ($admin->add_slashes(str_replace($tags, '', $_POST['text']))) : '');

//Soll die Sprache des Codes im Frontend angezeigt werden ? (Ja = 1 - Nein = 0)
$c4cfrontendlang = (isset($_POST['frontendlang']) ? 1 : 0);

//Ist der Codes bereits mit HTML-Entities escpaed ? (Ja = 1 - Nein = 0)
$c4cescaped = (isset($_POST['escaped']) ? 1 : 0);

//Soll die Zeilennummerierung angezeigt werden ? (Ja = 1 - Nein = 0)
$c4clinenumbers = (isset($_POST['linenumbers']) ? 1 : 0);

//Aktuellen Timestamp in der Variablen $timestamp speichern
$timestamp = time();


$sql = 'UPDATE `'.TABLE_PREFIX .'mod_color4code` SET '
      .'`lang` = \''.$c4clang.'\', '
      .'`frontendlang` = \''.$c4cfrontendlang.'\', '
      .'`codeescaped` = \''.$c4cescaped.'\', '
      .'`linenumbers` = \''.$c4clinenumbers.'\', '
      .'`linesstartat` = '.$c4clinestartat.', '
      .'`textareaheight` = \''.$c4ctextareaheight.'\', '
      .'`codewrapper` = '.$c4ccodewrapper.', '
      .'`textconvert` = '.$c4ctextconvert.', '
      .'`text` = \''.$c4ctext.'\', '
      .'`last_modified` = \''.$timestamp.'\' '
      .'WHERE `section_id` = '.$section_id.' ';
$database->query($sql);

if($database->is_error()) {
    $admin->print_error($database->get_error(), $js_back);
} else {
    $admin->print_success($MESSAGE['PAGES_SAVED'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);}

$admin->print_footer();

}

// end of file