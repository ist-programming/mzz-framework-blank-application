<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/user/controllers/userAddToGroupController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: userAddToGroupController.php 4197 2010-04-12 06:22:25Z desperado $
 */

/**
 * userAddToGroupController: контроллер для метода addToGroup модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */
class userAddToGroupController extends simpleController
{
    protected function getView()
    {
        $filter = $this->request->getString('filter', SC_POST);
        $id = $this->request->getInteger('id');

        $groupMapper = $this->toolkit->getMapper('user', 'group');
        $userMapper = $this->toolkit->getMapper('user', 'user');

        $group = $groupMapper->searchByKey($id);

        // проверяем что найдена нужная группа
        if (is_null($group)) {
            return $groupMapper->get404()->run();
        }

        $validator = new formValidator();

        if ($validator->validate()) {
            $users = $this->request->getArray('users', SC_POST);

            if (is_null($users)) {
                $users = array();
            }

            $added_users = $group->getUsers();

            foreach (array_keys($users) as $user_id) {
                $user = $userMapper->searchByKey($user_id);

                if (!is_null($user)) {
                    $added_users->add($user);
                }
            }

            $groupMapper->save($group);

            return jipTools::closeWindow();
        }

        $users = array();

        if (!is_null($filter)) {
            $userGroupMapper = $this->toolkit->getMapper('user', 'userGroup');

            $criterion = new criterion('r.user_id', $userMapper->table() . '.' . $userMapper->pk(), criteria::EQUAL, true);
            $criterion->addAnd(new criterion('r.group_id', $id));

            $criteria = new criteria();
            $criteria->join($userGroupMapper->table(), $criterion, 'r');
            $criteria->where('login', '%' . $filter . '%', criteria::LIKE)->where('r.id', null, criteria::IS_NULL);

            $limit = 25;
            $criteria->limit($limit + 1);

            // выбираем всех пользователей, которые ещё не добавлены в эту группу и удовлетворяют маске
            $users = $userMapper->searchAllByCriteria($criteria);

            if (sizeof($users) > $limit) {
                $this->view->assign('too_much', true);
            }

            $this->view->assign('filter', $filter);
        }

        $url = new url('withId');
        $url->add('id', $this->request->getInteger('id'));
        $url->setAction('addToGroupList');

        $this->view->assign('users', $users);
        $this->view->assign('group', $group);

        return $this->render('user/addToGroup.tpl');
    }
}

?>