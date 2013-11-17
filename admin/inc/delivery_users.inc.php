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
 * @link http://www.oxid-esales.com
 * @package inc
 * @copyright (C) OXID eSales AG 2003-2009
 * @version OXID eShop CE
 * $Id: delivery_users.inc.php 16302 2009-02-05 10:18:49Z rimvydas.paskevicius $
 */

$aColumns = array( 'container1' => array(    // field , table,  visible, multilanguage, ident
                                        array( 'oxusername',  'oxuser', 1, 0, 0 ),
                                        array( 'oxlname',     'oxuser', 0, 0, 0 ),
                                        array( 'oxfname',     'oxuser', 0, 0, 0 ),
                                        array( 'oxstreet',    'oxuser', 0, 0, 0 ),
                                        array( 'oxstreetnr',  'oxuser', 0, 0, 0 ),
                                        array( 'oxcity',      'oxuser', 0, 0, 0 ),
                                        array( 'oxzip',       'oxuser', 0, 0, 0 ),
                                        array( 'oxfon',       'oxuser', 0, 0, 0 ),
                                        array( 'oxbirthdate', 'oxuser', 0, 0, 0 ),
                                        array( 'oxid',        'oxuser', 0, 0, 1 ),
                                        ),
                     'container2' => array(
                                        array( 'oxusername',  'oxuser', 1, 0, 0 ),
                                        array( 'oxlname',     'oxuser', 0, 0, 0 ),
                                        array( 'oxfname',     'oxuser', 0, 0, 0 ),
                                        array( 'oxstreet',    'oxuser', 0, 0, 0 ),
                                        array( 'oxstreetnr',  'oxuser', 0, 0, 0 ),
                                        array( 'oxcity',      'oxuser', 0, 0, 0 ),
                                        array( 'oxzip',       'oxuser', 0, 0, 0 ),
                                        array( 'oxfon',       'oxuser', 0, 0, 0 ),
                                        array( 'oxbirthdate', 'oxuser', 0, 0, 0 ),
                                        array( 'oxid',     'oxobject2delivery', 0, 0, 1 ),
                                        )
                    );
/**
 * Class manages delivery users
 */
class ajaxComponent extends ajaxListComponent
{
    /**
     * Returns SQL query for data to fetc
     *
     * @return string
     */
    protected function _getQuery()
    {
        $myConfig = $this->getConfig();

        $sUserTable = getViewName('oxuser');

        $sId      = oxConfig::getParameter( 'oxid' );
        $sSynchId = oxConfig::getParameter( 'synchoxid' );

        // category selected or not ?
        if ( !$sId) {
            $sQAdd  = " from $sUserTable where 1 ";
            if (!$myConfig->getConfigParam( 'blMallUsers' ) )
                $sQAdd .= " and $sUserTable.oxshopid = '".$myConfig->getShopId()."' ";
        } else {
            // selected group ?
            if ( $sSynchId && $sSynchId != $sId ) {
                $sQAdd  = " from oxobject2group left join $sUserTable on $sUserTable.oxid = oxobject2group.oxobjectid ";
                $sQAdd .= " where oxobject2group.oxgroupsid = '$sId' ";
                if (!$myConfig->getConfigParam( 'blMallUsers' ) )
                    $sQAdd .= " and $sUserTable.oxshopid = '".$myConfig->getShopId()."' ";
            } else {
                $sQAdd  = " from oxobject2delivery left join $sUserTable on $sUserTable.oxid=oxobject2delivery.oxobjectid ";
                $sQAdd .= " where oxobject2delivery.oxdeliveryid = '$sId' and oxobject2delivery.oxtype = 'oxuser' ";
            }
        }

        if ( $sSynchId && $sSynchId != $sId) {
            $sQAdd .= " and $sUserTable.oxid not in ( select $sUserTable.oxid from oxobject2delivery left join $sUserTable on $sUserTable.oxid=oxobject2delivery.oxobjectid ";
            $sQAdd .= " where oxobject2delivery.oxdeliveryid = '$sSynchId' and oxobject2delivery.oxtype = 'oxuser' ) ";
        }

        return $sQAdd;
    }

    /**
     * Removes user from delivery configuration
     *
     * @return null
     */
    public function removeuserfromdel()
    {
        $aRemoveGroups = $this->_getActionIds( 'oxobject2delivery.oxid' );
        if ( oxConfig::getParameter( 'all' ) ) {

            $sQ = $this->_addFilter( "delete oxobject2delivery.* ".$this->_getQuery() );
            oxDb::getDb()->Execute( $sQ );

        } elseif ( $aRemoveGroups && is_array( $aRemoveGroups ) ) {
            $sQ = "delete from oxobject2delivery where oxobject2delivery.oxid in ('" . implode( "', '", $aRemoveGroups ) . "') ";
            oxDb::getDb()->Execute( $sQ );
        }
    }

    /**
     * Adds user from delivery configuration
     *
     * @return null
     */
    public function addusertodel()
    {
        $aChosenUsr = $this->_getActionIds( 'oxuser.oxid' );
        $soxId      = oxConfig::getParameter( 'synchoxid' );

        // adding
        if ( oxConfig::getParameter( 'all' ) ) {
            $sUserTable = getViewName('oxuser');
            $aChosenUsr = $this->_getAll( $this->_addFilter( "select $sUserTable.oxid ".$this->_getQuery() ) );
        }

        if ( $soxId && $soxId != "-1" && is_array( $aChosenUsr ) ) {
            foreach ( $aChosenUsr as $sChosenUsr) {
                $oObject2Delivery = oxNew( 'oxbase' );
                $oObject2Delivery->init( 'oxobject2delivery' );
                $oObject2Delivery->oxobject2delivery__oxdeliveryid = new oxField($soxId);
                $oObject2Delivery->oxobject2delivery__oxobjectid   = new oxField($sChosenUsr);
                $oObject2Delivery->oxobject2delivery__oxtype       = new oxField('oxuser');
                $oObject2Delivery->save();
            }
        }
    }
}
