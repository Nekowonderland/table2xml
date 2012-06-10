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
class Table2XmlHelper extends Backend
{

    protected $strTable;

    public function createXML($intExportID)
    {
        $arrExportRow = $this->Database
                ->prepare("SELECT * FROM tl_tabletoxml_export WHERE id=?")
                ->execute($intExportID)
                ->fetchAllAssoc();

        // Check if this id exist
        if (count($arrExportRow) == 0)
        {
            throw new Exception("Could not find row in database");
        }

        // Load min vars
        $this->strTable = $arrExportRow[0]['tables'];
        $arrFieldMapping = deserialize($arrExportRow[0]['fields']);
        $strXMLTemplate = $arrExportRow[0]['xmlTemplate'];

        // Save vars
        $strSaveFolder = $arrExportRow[0]['xmlSavePath'];
        $strSaveFileName = $arrExportRow[0]['xmlSaveName'];

        // Check vars
        if (strlen($this->strTable) == 0)
        {
            throw new Exception("Missing table.");
        }

        if (!is_array($arrFieldMapping) || count($arrFieldMapping) == 0)
        {
            throw new Exception("Missing field mappings.");
        }

        if (strlen($strXMLTemplate) == 0)
        {
            throw new Exception("Missing xml template.");
        }

        if (strlen($strSaveFolder) == 0)
        {
            throw new Exception("Missing save folder.");
        }

        if (strlen($strSaveFileName) == 0)
        {
            throw new Exception("Missing file name.");
        }

        // Get data from table
        $arrData = $this->Database
                ->prepare("SELECT * FROM $this->strTable")
                ->execute();

        while ($arrData->next())
        {
            // Reset values
            $arrFieldData = array();

            // Load field values
            foreach ($arrFieldMapping as $valueField)
            {
                $arrFieldData[$valueField['mapping']] = $arrData->$valueField['fieldname'];
            }

            // Set time
            $strTime = time();

            // Replace insert tgas
            $strContext = $this->xmlReplaceInsertTags($strTime, $arrFieldData, $strXMLTemplate);
            $strFilename = $this->xmlReplaceInsertTags($strTime, $arrFieldData, $strSaveFileName);

            // Write Data
            $objFile = new File($strSaveFolder . "/" . $strFilename);
            $objFile->write($strContext);
            $objFile->close();
        }

        $this->redirect("contao/main.php?do=tl_tabletoxml_export");
    }

    /**
     * ToDo
     * @param type $strBuffer
     * @param DC_Table $table 
     */
    public function xmlReplaceInsertTags($intTime, $arrFieldData, $strXMLTemplate)
    {
        $arrTags = preg_split('/\{\{([^\}]+)\}\}/', $strXMLTemplate, -1, PREG_SPLIT_DELIM_CAPTURE);
        return $this->parseXML($arrTags, $intTime, $arrFieldData);
    }

    protected function parseXML($arrTags, $intTime, $arrFieldData)
    {
        $strBuffer = '';
        $arrCache = array();

        for ($_rit = 0; $_rit < count($arrTags); $_rit = $_rit + 2)
        {
            $strBuffer .= $arrTags[$_rit];
            $strTag = $arrTags[$_rit + 1];

            // Skip empty tags
            if ($strTag == '')
            {
                continue;
            }

            // Load value from cache array
            if (isset($arrCache[$strTag]))
            {
                $strBuffer .= $arrCache[$strTag];
                continue;
            }

            $elements = explode('::', $strTag);

            $arrCache[$strTag] = '';

            switch ($elements[0])
            {
                case "time":
                    switch ($elements[1])
                    {
                        case "unix":
                        case "time":
                            $arrCache[$strTag] = $intTime;
                            break;
                    }
                    break;

                case "date":
                    $arrCache[$strTag] = date($elements[1], $intTime);
                    break;

                case "field":
                    if (key_exists($elements[1], $arrFieldData))
                    {
                        $arrCache[$strTag] = $arrFieldData[$elements[1]];
                    }
                    break;

                case "foreach":
                    $intEndForeach = $this->searchEndForeach($arrTags, $_rit);
                    $arrForeachTags = array_splice($arrTags, $_rit + 2, ($intEndForeach - ($_rit + 1)));
                    $arrForeachTags = array_slice($arrForeachTags, 0, count($arrForeachTags) - 1);

                    switch ($elements[1])
                    {
                        case "unserialize":
                            $arrForeachValue = deserialize($arrFieldData[$elements[2]]);
                            $arrCache[$strTag] = $this->parseForeach($arrForeachTags, $arrForeachValue);

                            break;
                    }
                    break;
            }

            $strBuffer .= $arrCache[$strTag];
        }

        return $strBuffer;
    }

    protected function parseForeach($arrTags, $arrData)
    {
        if (!is_array($arrData))
        {
            return "";
        }

        $strBuffer = "";
        $booFirstRun = true;

        foreach ($arrData as $key => $value)
        {
            for ($_rit = 0; $_rit < count($arrTags); $_rit = $_rit + 2)
            {
                $strBuffer .= $arrTags[$_rit];
                $strTag = $arrTags[$_rit + 1];

                // Skip empty tags
                if ($strTag == '')
                {
                    continue;
                }

                $elements = explode('::', $strTag);

                $arrCache[$strTag] = '';

                switch ($elements[0])
                {
                    case "field":
                        switch ($elements[1])
                        {
                            case "key":
                                $arrCache[$strTag] = $key;
                                break;

                            case "value":
                                $arrCache[$strTag] = $value;
                                break;
                        }
                        break;

                    default:
                        break;
                }

                $strBuffer .= $arrCache[$strTag];
            }
        }

        return $strBuffer;
    }

    protected function searchEndForeach($arrTags, $intStartKey)
    {
        $intInnerForeach = 0;

        for ($_rit = $intStartKey; $_rit < count($arrTags); $_rit = $_rit + 2)
        {
            $strTag = $arrTags[$_rit + 1];

            // Skip empty tags
            if ($strTag == '')
            {
                continue;
            }

            $elements = explode('::', $strTag);

            switch ($elements[0])
            {
                case "foreach":
                    if ($_rit != $intStartKey)
                    {
                        $intInnerForeach++;
                    }
                    break;

                case "endforeach":
                    if ($intInnerForeach != 0)
                    {
                        $intInnerForeach--;
                    }
                    else if ($intInnerForeach == 0)
                    {
                        return $_rit + 1;
                    }
                    break;

                default:
                    break;
            }
        }

        throw new Exception("Syntax error, missing endforeach.");
    }

}

?>