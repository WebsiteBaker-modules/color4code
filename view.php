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
/*
 * Falls keine entsprechende Sprachdatei existiert, wird die englische eingebunden
 *
 */
if(!file_exists(WB_PATH .'/modules/color4code/languages/' .LANGUAGE .'.php')) {
	require_once(WB_PATH .'/modules/color4code/languages/EN.php');
} else {
		require_once(WB_PATH .'/modules/color4code/languages/' .LANGUAGE .'.php');
}
/*
 * Falls die Funktion register_frontend_modfiles existiert wird der Inhalt der frontend.css des Moduls
 * in einem Style-Element ausgegeben
 */
if((!function_exists('register_frontend_modfiles') || !defined('MOD_FRONTEND_CSS_REGISTERED')) && 
	file_exists(WB_PATH .'/modules/color4code/frontend.css')) {
	echo "\n<style type=\"text/css\">\n";
	include(WB_PATH .'/modules/color4code/frontend.css');
	echo "\n</style>\n";
}
/*
 * Einbinden des Syntax-Highlighters
 *
 */
include_once(WB_PATH .'/modules/color4code/geshi/geshi.php');
/*
 * Verfügbare Sprachen laden
 *
 */
require(WB_PATH .'/modules/color4code/available-langs.php');

/*
 * Daten aus der Tabelle TABLE_PREFIXmodcolor4code abrufen und in der Variablen $sql_res speichern
 *
 */
$sql_res = $database->query("SELECT * FROM ".TABLE_PREFIX."mod_color4code WHERE section_id = $section_id");
/*
 * Daten aus $sql_res in eine assoziatives Array schreiben und in der Variablen $sql_row speichern
 *
 */
$sql_row = $sql_res->fetchRow();
/*
 * Timestamp in lesbares Datum umwandeln
 *
 */
$last_modified = date("d.m.Y",$sql_row['last_modified'] );
/*
 * Wandelt bereits escapten Code in nicht escapten um und speichert diesen in der Variablen $code
 *
 */
if($sql_row['codeescaped'] == 1) {
	$code = htmlspecialchars_decode($sql_row['text']);
} else {
	$code = $sql_row['text'];
}

/*
 * Prüft, ob die Kurzform der Sprachen in den Spracharray vorhanden ist. Wenn ja wird der Index gespeichert und die
 * entsprechende Lanform der Sprache in der Variablen $lang gespeichert
 *
 */
if(in_array($sql_row['lang'], $web_short) || in_array($sql_row['lang'], $comp_short) || in_array($sql_row['lang'], $script_short)) {
	$web_lang = ((array_search($sql_row['lang'], $web_short)) ? (array_search($sql_row['lang'], $web_short)) : false);
	$comp_lang = ((array_search($sql_row['lang'], $comp_short)) ? (array_search($sql_row['lang'], $comp_short)) : false);
	$script_lang = ((array_search($sql_row['lang'], $script_short)) ? (array_search($sql_row['lang'], $script_short)) : false);
	if($web_lang != false) {
		$lang = $web_long[$web_lang];
	} elseif($comp_lang != false) {
		$lang = $comp_long[$comp_lang];
	} elseif($script_lang != false) {
		$lang = $script_long[$script_lang];
	}
}
/*
 * Neue Instanz der GeSHi-Klasse im Objekt $geshi speichern
 * Die escapten Anführungszeichen aus der DB werden mit stripslashes entfernt
 * Die festgelegte Sprache wird dem Highlighter übergeben
 * 
 */
$geshi = new GeSHi(stripslashes($code), $sql_row['lang']);
/*
 * Nimmt Umwandlungen in Groß/Kleinbuchstaben vor
 *
 */
switch($sql_row['textconvert']) {
	case "1" :
		$geshi->set_case_keywords(GESHI_CAPS_NO_CHANGE);
		break;
	case "2" :
		$geshi->set_case_keywords(GESHI_CAPS_LOWER);
		break;
	case "3" :
		$geshi->set_case_keywords(GESHI_CAPS_UPPER);
		break;
}
/*
 * Verändert den Code-Wrapper
 *
 */
switch($sql_row['codewrapper']) {
	case "1" :
		$geshi->set_header_type(GESHI_HEADER_PRE);
		break;
	case "2" :
		$geshi->set_header_type(GESHI_HEADER_DIV);
		break;
	case "3" :
		$geshi->set_header_type(GESHI_HEADER_NONE);
		break;
}		
/*
 * Beheben des Kopier-Bugs
 *
 */
 if(!function_exists("line_numbers")) {
function line_numbers($code, $start)
{
    $line_count = count(explode("\n", $code));
    $output = "<pre>";
    for ($i = 0; $i < $line_count; $i++)
    {
        $output .= ($start + $i) . "\n";
    }
    $output .= "</pre>";
    return $output;
}
}
/*
 * Ausgabe des fertigen Codes mit Zeilennummerierung
 *
 */
if($sql_row['linenumbers'] == 1 && $sql_row['linesstartat'] > 0) { ?>
	<div class="color4code">
		<table>
			<tr>
				<td colspan="2">
				<?php if($sql_row['frontendlang']) { 
					echo "<p class=\"color4codelang\">{$mod_color4code['FRONTEND_LANG']}{$lang}</p>";
				}
				?>
				</td>
			</tr>
				<tr>
				<td class="line_numbers">
					<?php echo line_numbers($code, $sql_row['linesstartat']); ?>
				</td>
				<td class="code">
					<?php echo $geshi->parse_code(); ?>
				</td>
			</tr>
		</table>
	</div>
<?php } else {
/*
 * Ausgabe des fertigen Codes ohne Zeilennummerierung
 *
 */
?>
<div class="color4code">
	<?php if($sql_row['frontendlang']) { 
		echo "<p class=\"color4codelang\">{$mod_color4code['FRONTEND_LANG']}{$lang}</p>";
	}
	?>	
		<?php echo $geshi->parse_code(); ?>
</div>
<?php } ?>
