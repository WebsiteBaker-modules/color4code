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

@include_once(WB_PATH .'/framework/module.functions.php');

if(!file_exists(WB_PATH .'/modules/color4code/languages/' .LANGUAGE .'.php')) {
    require_once(WB_PATH .'/modules/color4code/languages/EN.php');
} else {
        require_once(WB_PATH .'/modules/color4code/languages/' .LANGUAGE .'.php');
}
if(!method_exists($admin, 'register_backend_modfiles') && file_exists(WB_PATH .'/modules/color4code/backend.css')) {
    echo '<style type="text/css">';
        include(WB_PATH .'/modules/color4code/backend.css'); // Inhalt der backend.css in den Style-Bereich einbinden
    echo "\n</style>\n";
}

/*
 * Verfügbare Sprachen laden
 *
 */
require(WB_PATH .'/modules/color4code/available-langs.php');
/*
 * Daten aus der Tabelle TABLE_PREFIXmodcolor4code abrufen und in der Variablen $sql_res speichern
 *
 */
$sql_res = $database->query("SELECT * FROM `" .TABLE_PREFIX ."mod_color4code` WHERE `section_id` = '$section_id'");

$sql = 'SELECT * FROM `'.TABLE_PREFIX .'mod_color4code` '
          .'WHERE `section_id` = '.$section_id;
$oRes = $database->query($sql);
$sql_row = $oRes->fetchRow(MYSQLI_ASSOC);
?>

<p class="c4ctitle">Color4Code</p>
<?php
/*
 * 'CSS bearbeiten'-Button einbinden
 *
 */
if(function_exists('edit_module_css')) {
    edit_module_css('color4code');
}
?>
   <form name="edit" action="<?php echo WB_URL; ?>/modules/color4code/save.php" method="post">
       <input type="hidden" name="page_id" value="<?php echo $page_id; ?>">
    <input type="hidden" name="section_id" value="<?php echo $section_id; ?>">
    <fieldset class="c4cfieldset">
        <legend><?php echo $mod_color4code['BACKEND_SETTINGS'] ?></legend>
        <div style="display:inline;">
            <span class="c4clabel">Sprache:</span><br />
            <select name="lang" class="c4cselect" size="10">
                <optgroup label="<?php echo $mod_color4code['BACKEND_LANGSELECT_1'] ?>">
<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Abkürzungen der Sprachen in den *_short-Array mit den langen Namen in einer Auswahlliste ausgeben *
 * Bei schon gewählter Sprache wird zusätzlich das selected-Attribut gesetzt                 *
 * Standard-Sprache: php                                         *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */
                for($i = 0; $i < count($web_short); $i++) {
                    if($sql_row['lang'] == "$web_short[$i]") {
                        $sel = " selected=\"selected\"";
                    } else {
                        $sel = "";
                    }
                    echo "<option value=\"". $web_short[$i] ."\"". $sel .">". $web_long[$i] . "</option>\n";
                }
?>
                </optgroup>
                <optgroup label="<?php echo $mod_color4code['BACKEND_LANGSELECT_2'] ?>">
<?php
                for($i = 0; $i < count($comp_short); $i++) {
                    if($sql_row['lang'] == "$comp_short[$i]") {
                        $sel = " selected=\"selected\"";
                    } else {
                        $sel = "";
                    }
                    echo "<option value=\"". $comp_short[$i] ."\"". $sel .">". $comp_long[$i] . "</option>\n";
                }
?>
                </optgroup>
                <optgroup label="<?php echo $mod_color4code['BACKEND_LANGSELECT_3'] ?>">
<?php
                for($i = 0; $i < count($script_short); $i++) {
                    if($sql_row['lang'] == "$script_short[$i]") {
                        $sel = " selected=\"selected\"";
                    } else {
                        $sel = "";
                    }
                    echo "<option value=\"". $script_short[$i] ."\"". $sel .">". $script_long[$i] . "</option>\n";
                }
?>
                </optgroup>
            </select>
        </div>
        <div style="display:inline;float:right;">
            <input type="checkbox" name="frontendlang" <?php if($sql_row['frontendlang']){ echo "checked=\"checked\""; } ?>/><span class="c4clabel"><?php echo $mod_color4code['BACKEND_SHOWINFRONTEND'] ?></span><br />
            <input type="checkbox" name="escaped" <?php if($sql_row['codeescaped']){ echo "checked=\"checked\""; } ?>/><span class="c4clabel"><?php echo $mod_color4code['BACKEND_ESCAPED'] ?></span>
        </div>

    </fieldset>
    <fieldset class="c4cfieldset">
        <legend><?php echo $mod_color4code['BACKEND_OUTPUTSETTINGS'] ?></legend>
        <input type="checkbox" name="linenumbers" <?php if($sql_row['linenumbers']){ echo "checked=\"checked\""; } ?> onclick="checkboxcheck(this, 'linestart_<?php echo $section_id; ?>');"/>
    <span class="c4clabel"><?php echo $mod_color4code['BACKEND_LINENUMBERS'] ?></span><br />
        <p class="linestart" id="linestart_<?php echo $section_id; ?>" style="visibility: <?php echo ($sql_row['linenumbers'] == 1) ? "visible" : "hidden"; ?>;">
    <span class="c4clabel" ><?php echo $mod_color4code['BACKEND_STARTATLINE'] ?></span>&nbsp;<input type="text" name="linestartat" style="max-width:50px;" value="<?php echo $sql_row['linesstartat']; ?>"/></p><br />
                    <div class="c4coutputcontainer">
                        <span class="c4clabel"><?php echo $mod_color4code['BACKEND_CODEWRAP'] ?></span><br />
                        <select name="codewrapper" class="c4cselect" size="3" >
                            <option value="1" <?php if($sql_row['codewrapper'] == 1){ echo "selected=\"selected\""; } ?>>pre</option>
                            <option value="2" <?php if($sql_row['codewrapper'] == 2){ echo "selected=\"selected\""; } ?>>div</option>
                            <option value="3" <?php if($sql_row['codewrapper'] == 3){ echo "selected=\"selected\""; } ?>>kein</option>
                        </select>
                    </div>
                    <div class="c4coutputcontainer" style="margin-left:10px;">
                        <span class="c4clabel"><?php echo $mod_color4code['BACKEND_OUTPUTTRANSFORM'] ?></span><br />
                        <input type="radio" name="textconvert" value="1" <?php if($sql_row['textconvert'] == 1){ echo "checked=\"checked\""; } ?>/><span class="c4clabel"><?php echo $mod_color4code['BACKEND_TRANSFORM1'] ?></span><br />
                        <input type="radio" name="textconvert" value="2" <?php if($sql_row['textconvert'] == 2){ echo "checked=\"checked\""; } ?>/><span class="c4clabel"><?php echo $mod_color4code['BACKEND_TRANSFORM2'] ?></span><br />
                        <input type="radio" name="textconvert" value="3" <?php if($sql_row['textconvert'] == 3){ echo "checked=\"checked\""; } ?>/><span class="c4clabel"><?php echo $mod_color4code['BACKEND_TRANSFORM3'] ?></span><br />
                    </div>
    </fieldset>
        <hr />
        <div>
            <input type="hidden" name="textarea-height" value="300" />
            <textarea name="text" class="c4ctextarea"><?php echo stripslashes($sql_row['text']); ?></textarea><br />
            <input type="submit" value="<?php echo $mod_color4code['BACKEND_SAVE'] ?>" style="width:101%;height: 50px;"/>
        </div>
    </form>
