<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/menu/mappers/menuMapper.php $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: menuMapper.php 4267 2010-07-09 14:34:11Z desperado $
 */

fileLoader::load('menu/models/menu');
fileLoader::load('modules/jip/plugins/jipPlugin');

/**
 * menuMapper: маппер
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menuMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'menu';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'menu_menu';

    /**
     * Map
     *
     * @var array
     */
    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'once', 'pk'
            ),
        ),
        'name' => array(
            'accessor' => 'getName',
            'mutator' => 'setName',
        ),
        'items' => array(
            'accessor' => 'getItems',
            'mutator' => 'setItems',
            'relation' => 'many',
            'mapper' => 'menu/menuItem',
            'foreign_key' => 'menu_id',
            'local_key' => 'id'
        )
    );

    public function __construct($module)
    {
        parent::__construct($module);
        $this->plugins('jip');
    }

    public function searchById($id)
    {
        return $this->searchByKey($id);
    }

    public function searchByName($name)
    {
        return $this->searchOneByField('name', $name);
    }

    public function delete(menu $menu)
    {
        $itemMapper = systemToolkit::getInstance()->getMapper('menu', 'menuItem');
        foreach ($menu->getItems() as $item) {
            $itemMapper->delete($item);
        }

        parent::delete($menu);
    }
}

?>