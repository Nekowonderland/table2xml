<?php

if (!defined('TL_ROOT'))
    die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
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
$GLOBALS['TL_DCA']['tl_tabletoxml_export'] = array(
    // Config
    'config' => array(
        'dataContainer' => 'Table',
        'enableVersioning' => true
    ),
    // List
    'list' => array(
        'sorting' => array(
            'mode' => 1,
            'fields' => array('id', 'title'),
            'flag' => 2,
            'panelLayout' => 'filter;search,limit',
        ),
        'label' => array(
            'fields' => array('title'),
            'format' => '%s ',
        ),
        'global_operations' => array(
            'all' => array(
                'label' => &$GLOBALS['TL_LANG']['tl_syncCto_clients']['all'],
                'href' => 'act=select',
                'class' => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset();"'
            )
        ),
        'operations' => array(
            'edit' => array(
                'label' => &$GLOBALS['TL_LANG']['tl_syncCto_clients']['edit'],
                'href' => 'act=edit',
                'icon' => 'edit.gif',
            ),
            'copy' => array(
                'label' => &$GLOBALS['TL_LANG']['tl_syncCto_clients']['copy'],
                'href' => 'act=copy',
                'icon' => 'copy.gif',
            ),
            'delete' => array(
                'label' => &$GLOBALS['TL_LANG']['tl_syncCto_clients']['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.gif',
                'attributes' => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
            ),
            'show' => array(
                'label' => &$GLOBALS['TL_LANG']['tl_syncCto_clients']['show'],
                'href' => 'act=show',
                'icon' => 'show.gif',
            ),
        )
    ),
    // Palettes
    'palettes' => array(
        '__selector__' => array(),
        'default' => '{title_legend},title,description;{table_legend},tables,fields;{expot_legend},exportMode,xmlTemplate;{save_legend},xmlSaveField,xmlSaveName,xmlSavePath;',
    ),
    'subpalettes' => array(
    ),
    // Fields
    'fields' => array(
        // Title
        'title' => array(
            'label' => &$GLOBALS['TL_LANG']['tl_tabletoxml_export']['title'],
            'inputType' => 'text',
            'search' => true,
            'exclude' => true,
            'eval' => array('mandatory' => true, 'maxlength' => '64', 'tl_class' => 'long')
        ),
        'description' => array(
            'label' => &$GLOBALS['TL_LANG']['tl_tabletoxml_export']['description'],
            'inputType' => 'textarea',
            'search' => true,
            'exclude' => true
        ),
        // Table
        'tables' => array(
            'label' => &$GLOBALS['TL_LANG']['tl_tabletoxml_export']['tables'],
            'inputType' => 'select',
            'search' => true,
            'exclude' => true,
            'options_callback' => array('tl_tabletoxml_export', 'getAllTables'),
            'eval' => array('includeBlankOption' => true)
        ),
        'fields' => array(
            'label' => &$GLOBALS['TL_LANG']['tl_tabletoxml_export']['fields'],
            'exclude' => true,
            'inputType' => 'multiColumnWizard',
            'eval' => array(
                'columnFields' => array(
                    'fieldname' => array(
                        'label' => &$GLOBALS['TL_LANG']['tl_tabletoxml_export']['fieldname'],
                        'inputType' => 'select',
                        'options_callback' => array('tl_tabletoxml_export', 'getAllFields'),
                        'eval' => array('includeBlankOption' => true)
                    ),
                    'mapping' => array(
                        'label' => &$GLOBALS['TL_LANG']['tl_tabletoxml_export']['mapping'],
                        'inputType' => 'text'
                    ),
                    'unserialize' => array(
                        'label' => &$GLOBALS['TL_LANG']['tl_tabletoxml_export']['unserialize'],
                        'inputType' => 'checkbox'
                    ),
                ),
            )
        ),
        // Export 
        'exportMode' => array(
            'label' => &$GLOBALS['TL_LANG']['tl_tabletoxml_export']['exportMode'],
            'inputType' => 'checkbox',
            'search' => true,
            'exclude' => true
        ),
        'xmlTemplate' => array(
            'label' => &$GLOBALS['TL_LANG']['tl_tabletoxml_export']['xmlTemplate'],
            'inputType' => 'textarea',
            'search' => true,
            'exclude' => true,
            'eval' => array('preserveTags' => true, 'decodeEntities' => false)
        ),
        // Save
        'xmlSaveField' => array(
            'label' => &$GLOBALS['TL_LANG']['tl_tabletoxml_export']['xmlSaveField'],
            'inputType' => 'select',
            'search' => true,
            'exclude' => true,
            'options_callback' => array('tl_tabletoxml_export', 'getAllFields'),
            'eval' => array('includeBlankOption' => true)
        ),
        'xmlSaveName' => array(
            'label' => &$GLOBALS['TL_LANG']['tl_tabletoxml_export']['xmlSaveName'],
            'inputType' => 'text',
            'search' => true,
            'exclude' => true,
        ),
        'xmlSavePath' => array(
            'label' => &$GLOBALS['TL_LANG']['tl_tabletoxml_export']['xmlSavePath'],
            'inputType' => 'fileTree',
            'search' => true,
            'exclude' => true,
            'eval' => array('files' => false, 'fieldType' => 'radio')
        ),
    )
);

class tl_tabletoxml_export extends Backend
{

    public function getAllTables(DC_Table $table)
    {
        $arrTables = $this->Database->listTables();
        $arrReturn = array();

        foreach ($arrTables as $value)
        {
            $mixGroup = explode("_", $value);
            $mixGroup = $mixGroup[0];

            $arrReturn[$mixGroup][$value] = $value;
        }

        return $arrReturn;
    }

    public function getAllFields($table)
    {
        $arrReturn = array();

        $intID = $this->Input->get("id");

        if ($intID == "")
        {
            return $arrReturn;
        }

        $arrCurrentRow = $this->Database
                ->prepare("SELECT * FROM tl_tabletoxml_export WHERE id=?")
                ->executeUncached($intID)
                ->fetchAllAssoc();

        if (count($arrCurrentRow) == 0 || $arrCurrentRow[0]['tables'] == "")
        {
            return $arrReturn;
        }

        $arrFields = $this->Database->getFieldNames($arrCurrentRow[0]['tables']);

        foreach ($arrFields as $value)
        {
            if ($value == "PRIMARY")
            {
                continue;
            }

            $arrReturn[$value] = $value;
        }

        return array_unique($arrReturn);
    }

}

?>