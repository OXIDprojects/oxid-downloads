<?php
/**
 *    This file is part of OXID eShop Community Edition.
 *
 *    OXID eShop Community Edition is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    OXID eShop Community Edition is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with OXID eShop Community Edition.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://www.oxid-esales.com
 * @package   smarty_plugins
 * @copyright (C) OXID eSales AG 2003-2010
 * @version OXID eShop CE
 * @version   SVN: $Id: modifier.oxformattime.php 25466 2010-02-01 14:12:07Z sarunas $
 */

/**
 * Smarty modifier
 * -------------------------------------------------------------
 * Name:     smarty_modifier_oxformattime<br>
 * Purpose:  Converts integer (seconds) type value to time (hh:mm:ss) format
 * Example:  {$seconds|oxformattime}
 * -------------------------------------------------------------
 *
 * @param int $iSeconds timespan in seconds
 *
 * @return string
 */
function smarty_modifier_oxformattime( $iSeconds )
{
        $iHours = floor($iSeconds / 3600);
        $iMins  = floor($iSeconds % 3600 / 60);
        $iSecs  = $iSeconds % 60;

        return sprintf("%02d:%02d:%02d", $iHours, $iMins, $iSecs);
}

/* vim: set expandtab: */
