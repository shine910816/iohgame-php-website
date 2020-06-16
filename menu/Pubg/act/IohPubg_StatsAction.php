<?php

/**
 *
 * @author Kinsama
 * @version 2020-06-16
 */
class IohPubg_StatsAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        $ret = $this->_doDefaultExecute($controller, $user, $request);
        if ($controller->isError($ret)) {
            $ret->setPos(__FILE__, __LINE__);
            return $ret;
        }
        return $ret;
    }

    /**
     * 执行参数检测
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainValidate(Controller $controller, User $user, Request $request)
    {
        $custom_id = $user->getCustomId();
        $account_list = IohPubgRequestDBI::getAccountId($custom_id);
        if ($controller->isError($account_list)) {
            $account_list->setPos(__FILE__, __LINE__);
            return $account_list;
        }
        if (!isset($account_list[$custom_id])) {
            $controller->redirect("./?menu=pubg&act=bind_account");
            return VIEW_DONE;
        }
        return VIEW_DONE;
    }

    /**
     * 执行默认程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        // Utility::testVariable($weapon_list);
        return VIEW_DONE;
    }
}
?>