-- phpMyAdmin SQL Dump
-- Erstellungszeit: 18. Januar 2016 um 12:49
-- Server Version: 5.1.41
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
-- --------------------------------------------------------
-- Database structure for module 'color4code'
--
-- Replacements: {TABLE_PREFIX}, {TABLE_ENGINE}, {TABLE_COLLATION}
--
-- --------------------------------------------------------
--
-- Tabellenstruktur fuer Tabelle `mod_color4code`
--
DROP TABLE IF EXISTS `{TABLE_PREFIX}mod_color4code`;
CREATE TABLE IF NOT EXISTS `{TABLE_PREFIX}mod_color4code` (
  `section_id` INT NOT NULL DEFAULT '0',
  `page_id` INT NOT NULL DEFAULT '0',
  `lang` VARCHAR(32){TABLE_COLLATION} NOT NULL DEFAULT 'php',
  `frontendlang` TINYINT NOT NULL,
  `codeescaped` TINYINT NOT NULL,
  `linenumbers` TINYINT NOT NULL,
  `linesstartat` INT NOT NULL DEFAULT '1',
  `textareaheight` INT NOT NULL DEFAULT '1',
  `codewrapper` TINYINT NOT NULL DEFAULT '1',
  `textconvert` TINYINT NOT NULL DEFAULT '1',
  `text` TEXT NOT NULL ,
  `last_modified` INT NOT NULL DEFAULT '0',
  PRIMARY KEY ( `section_id` )
){TABLE_ENGINE};