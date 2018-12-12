<?php

/**
 * 用户登录记录一览画面
 * @author Kinsama
 * @version 2017-01-13
 */
class IohUser_LoginHistoryAction extends ActionBase
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
     * 执行默认命令
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $cus_id = $user->getVariable("cus_id");
        $login_his_info = IohCLoginHistoryDBI::getLoginHistoryByCusId($cus_id);
        if ($controller->isError($login_his_info)) {
            $login_his_info->setPos(__FILE__, __LINE__);
            return $login_his_info;
        }
        if (!empty($login_his_info)) {
            $login_his_info = Utility::getPaginationData($request, $login_his_info, "./?menu=user&act=login_history&");
            if ($controller->isError($login_his_info)) {
                $login_his_info->setPos(__FILE__, __LINE__);
                return $login_his_info;
            }
        }
        $request->setAttribute("login_his_info", $login_his_info);
        return VIEW_DONE;
    }
}
?>