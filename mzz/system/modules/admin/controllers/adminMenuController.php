<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/admin/controllers/adminMenuController.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: adminMenuController.php 4197 2010-04-12 06:22:25Z desperado $
 */

/**
 * adminMenuController: контроллер для метода menu модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

class adminMenuController extends simpleController
{
    protected function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin');

        $menu = array();

        foreach ($adminMapper->getModules() as $moduleName => $module) {
            if ($module->isEnabled()) {
                foreach ($module->getActions() as $action) {
                    if ($action && $action->isAdmin() && $action->canRun()) {
                        if (!isset($menu[$action->getModuleName()])) {
                            $menu[$action->getModuleName()]['info'] = $module;
                        }

                        $menu[$action->getModuleName()]['icon'] = $module->getIcon();
                        $menu[$action->getModuleName()]['actions'][$action->getName()] = $action;
                    }
                }
            }
        }

        $module = $this->request->getString('module_name');
        $action = $this->request->getString('action_name');

        if (is_null($action) && is_null($module)) {
            $module = 'admin';
            $action = $this->request->getRequestedAction();
        }

        $this->view->assign('current_module', $module);
        $this->view->assign('current_action', $action);
        $this->view->assign('menu', $menu);
        return $this->render('admin/menu.tpl');
    }
}

?>