<?php

/**
 * 绑定手机号码画面
 * @author Kinsama
 * @version 2018-12-19
 */
class IohUser_BindTeleAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->isError()) {
            $ret = $this->_doErrorExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("do_change")) {
            $ret = $this->_doChangeExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } else {
            $ret = $this->_doDefaultExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
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
        $custom_id = $user->getVariable("custom_id");
        $custom_login_info = IohCustomDBI::selectCustomById($custom_id);
        if ($controller->isError($custom_login_info)) {
            $custom_login_info->setPos(__FILE__, __LINE__);
            return $custom_login_info;
        }
        if (!isset($custom_login_info[$custom_id])) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $custom_login_info = $custom_login_info[$custom_id];
        $bound_flg = false;
        if ($custom_login_info["custom_tele_flg"] == "1") {
            $bound_flg = true;
        }
        $mode = "2";
        $saved_tele_number = "";
$custom_login_info["custom_tele_number"] = "13821247400";
        if (strlen($custom_login_info["custom_tele_number"]) > 0) {
            $mode = "1";
            $saved_tele_number = substr($custom_login_info["custom_tele_number"], 0, 2) . str_repeat("*", 7) . substr($custom_login_info["custom_tele_number"], -2);
        }
        $custom_login_info["saved_tele_number"] = $saved_tele_number;
        //Utility::testVariable($custom_login_info);
        if ($request->hasParameter("do_change")) {
            
        }
        $request->setAttribute("custom_id", $custom_id);
        $request->setAttribute("custom_login_info", $custom_login_info);
        $request->setAttribute("bound_flg", $bound_flg);
        $request->setAttribute("mode", $mode);
        $request->setAttribute("count_down_start", 60);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }

    private function _doErrorExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }

    private function _doChangeExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }
}
?>