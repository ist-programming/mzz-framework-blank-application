<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/menu/helpers/iMenuItemHelper.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: iMenuItemHelper.php 4171 2010-03-30 10:25:49Z desperado $
 */

/**
 * iMenuItemHelper
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */
interface iMenuItemHelper
{
    public function setArguments($item, array $args);
    public function injectItem($validator, $item = null, $view = null, array $args = null);
}

?>