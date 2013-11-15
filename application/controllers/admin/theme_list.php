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
 * @package   admin
 * @copyright (C) OXID eSales AG 2003-2013
 * @version OXID eShop CE
 * @version   SVN: $Id: actions_list.php 28470 2010-06-19 12:49:59Z arvydas $
 */

/**
 * Admin actionss manager.
 * Sets list template, list object class ('oxactions') and default sorting
 * field ('oxactions.oxtitle').
 * Admin Menu: Manage Products -> Actions.
 * @package admin
 */
class Theme_List extends oxAdminList
{
    /**
     * Calls parent::render() and returns name of template to render
     *
     * @return string
     */
    public function render()
    {
        $oTheme = oxNew('oxtheme');

        parent::render();

        // assign our list
        $this->_aViewData['mylist'] = $oTheme->getList();

        return 'theme_list.tpl';
    }
}
