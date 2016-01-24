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

if (!defined('WB_PATH')) { throw new Exception('Cannot access the addon \"'.basename(__DIR__).'\" directly'); }
/* -------------------------------------------------------- */
    $sSqlDumpFile = dirname(__FILE__).'/install-struct.sql';
    if (is_readable($sSqlDumpFile)) {
        // create needet database tables and set default records
        $database->SqlImport($sSqlDumpFile, TABLE_PREFIX, false);
    }
// end of file