<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/admin/mappers/adminMapper.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: adminMapper.php 4267 2010-07-09 14:34:11Z desperado $
 */

fileLoader::load('admin/models/admin');

/**
 * adminMapper: маппер
 *
 * @package modules
 * @subpackage admin
 * @version 0.2
 */
class adminMapper extends mapper
{

    public function getModules()
    {
        $toolkit = systemToolkit::getInstance();

        $allModules = glob(systemConfig::$pathToSystem . '/modules/*', GLOB_ONLYDIR);
        $appModules = glob(systemConfig::$pathToApplication . '/modules/*', GLOB_ONLYDIR);

        if (is_array($appModules)) {
            $allModules = array_merge($allModules, $appModules);
        }

        $modules = array();
        foreach ($allModules as $module) {
            $module = substr(strrchr($module, '/'), 1);
            // @todo: remove it and make specified modules as regular (with foobarModule class)
            if (!in_array($module, array(
                        'i18n',
                        'jip',
                        'pager',
                        'simple',
                        'timer'))) {
                $modules[$module] = $toolkit->getModule($module);
            }
        }

        return $modules;
    }

}
?>