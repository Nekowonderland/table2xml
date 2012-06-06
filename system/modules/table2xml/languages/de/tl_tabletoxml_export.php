<?php

if (!defined('TL_ROOT'))
    die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Stefan Heimes
 * @package    table2xml
 * @license    GNU/LGPL
 * @filesource
 */
/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_tabletoxml_export']['title_legend'] = 'Beschreibung';
$GLOBALS['TL_LANG']['tl_tabletoxml_export']['table_legend'] = 'Tabellen Auswahl';
$GLOBALS['TL_LANG']['tl_tabletoxml_export']['expot_legend'] = 'Export Einstellungen';
$GLOBALS['TL_LANG']['tl_tabletoxml_export']['save_legend'] = 'Speicher Einstellungen';

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_tabletoxml_export']['title'] = array('Titel', 'Titel für diesen Export.');
$GLOBALS['TL_LANG']['tl_tabletoxml_export']['description'] = array('Beschreibung', 'Beschreibung des Exports.');
$GLOBALS['TL_LANG']['tl_tabletoxml_export']['tables'] = array('Tabellen Auswahl', 'Wählen Sie die Tabelle aus die exportiert werden soll.');
$GLOBALS['TL_LANG']['tl_tabletoxml_export']['fields'] = array('Felder Auswahl', 'Hier können sie bestimmen welche Felder exportiert werden soll, sowie welche ein mapping im Template.');
$GLOBALS['TL_LANG']['tl_tabletoxml_export']['exportMode'] = array('Einzel Export', 'Wählen Sie diese Option wenn jeder Datensatz als eigene XML exportiert werden soll.');
$GLOBALS['TL_LANG']['tl_tabletoxml_export']['xmlTemplate'] = array('XML Template', 'Hier können Sie die Form des XML definieren.');
$GLOBALS['TL_LANG']['tl_tabletoxml_export']['xmlSaveField'] = array('XML Tabellen Pfad', 'Wählen Sie die Spalte aus in der der Pfad zu der XL gespeichert werden soll.');
$GLOBALS['TL_LANG']['tl_tabletoxml_export']['xmlSaveName'] = array('XML Datei Name', 'Definieren Sie hier wie der Dateiname aussehen soll.');
$GLOBALS['TL_LANG']['tl_tabletoxml_export']['xmlSavePath'] = array('XML Speicher Pfad', 'Wählen Sie einen Ordner aus, in dem die XML gespeichert werden soll.');
$GLOBALS['TL_LANG']['tl_tabletoxml_export']['fieldname'] = array('Feldname', '');
$GLOBALS['TL_LANG']['tl_tabletoxml_export']['mapping'] = array('Template Name', '');
$GLOBALS['TL_LANG']['tl_tabletoxml_export']['unserialize'] = array('Unserialize', '');

/**
 * List
 */
$GLOBALS['TL_LANG']['tl_tabletoxml_export']['step1'] = 'ZIP-Datei entpacken.';
$GLOBALS['TL_LANG']['tl_tabletoxml_export']['complete'] = 'Das Backup %s wurde erfolgreich um %s am %s eingespielt.';
?>