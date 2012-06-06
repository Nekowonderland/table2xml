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
    /**
     * ToDo
     * @param type $strBuffer
     * @param DC_Table $table 
     */
    public function replaceInsertTags($strBuffer, DC_Table $table)
    {
        $tags = preg_split('/\{\{([^\}]+)\}\}/', $strBuffer, -1, PREG_SPLIT_DELIM_CAPTURE);

        $strBuffer = '';
        $arrCache = array();

        for ($_rit = 0; $_rit < count($tags); $_rit = $_rit + 2)
        {
            $strBuffer .= $tags[$_rit];
            $strTag = $tags[$_rit + 1];

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
            
            switch ($elements[0])
            {
                case "time":
                    break;
                
                case "field":
                    break;
            }
        
        }
    }

   
}

?>