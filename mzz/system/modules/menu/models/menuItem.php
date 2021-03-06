<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/menu/models/menuItem.php $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: menuItem.php 4012 2009-11-29 01:07:00Z striker $
 */

/**
 * menuItem: класс для работы c данными
 *
 * @package modules
 * @subpackage menu
 * @version 0.2
 */
abstract class menuItem extends entity
{
    protected $isActive = null;
    protected $childrens = array();
    protected $arguments = null;
    protected $urlLang;
    protected $urlLangSpecified;

    protected $module = 'menu';

    public function getArgument($argument, $default = null)
    {
        $arguments = $this->getArguments();
        $value = $arguments->get($argument);

        return is_null($value) ? $default : $value;
    }

    protected function getArguments()
    {
        if (is_null($this->arguments)) {
            $arguments = $this->getArgs();
            try {
                $arguments = unserialize($arguments);
                if (!is_array($arguments)) {
                    $arguments = array();
                }
            } catch (mzzException $e) {
                $arguments = array();
            }

            $this->arguments = new arrayDataspace($arguments);
        }

        return $this->arguments;
    }

    public function setArgument($name, $value)
    {
        $arguments = $this->getArguments();
        $arguments->set($name, $value);
        $this->setArguments($arguments->export());
    }

    public function setArguments(Array $args)
    {
        $this->arguments = new arrayDataspace($args);
        $this->setArgs(serialize($args));
    }

    protected function stripLangFromUrl($url)
    {
        if ($this->urlLangSpecified) {
            $url = preg_replace('!^' . $this->urlLang . '/{0,1}!si', '', $url);
        }

        return $url;
    }

    /**
     * Возвращает JIP-меню
     * Переопределяется если требуется использовать другие данные для построения JIP-меню
     *
     * @param string $tpl шаблон JIP-меню
     * @return string
     */
    public function getJip($tpl = jip::DEFAULT_TEMPLATE)
    {
        return parent::__call('getJip', array(1, $tpl, __CLASS__));
    }

    public function setUrlLang($lang, $specified)
    {
        $this->urlLang = $lang;
        $this->urlLangSpecified = (bool)$specified;
    }

    public function getTypeTitle()
    {
        return $this->getTitleByType($this->getType());
    }

    protected function getTitleByType($type)
    {
        $types = menuItemMapper::getMenuItemsTypes();

        if (!array_key_exists($type, $types)) {
            $type = self::ITEMTYPE_SIMPLE;
        }

        return $types[$type];
    }

    abstract function getUrl();
    abstract function isActive();
}

?>