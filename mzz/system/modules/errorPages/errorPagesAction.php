<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/errorPages/errorPagesAction.php $
 *
 * MZZ Content Management System (c) 2010
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: errorPagesAction.php 4415 2011-07-12 05:50:34Z striker $
 */

/**
 * errorPagesAction
 *
 * @package modules
 * @subpackage errorPages
 * @version 0.0.1
 */
class errorPagesAction extends simpleAction
{
	/**
     * Run action
     *
     * @return string
     */
    public function run(simpleAction $forAction = null)
    {
        $controller = $this->getController();
        return $controller->run($forAction);
    }
}
?>