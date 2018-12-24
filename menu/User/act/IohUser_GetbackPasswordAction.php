<?php

/**
 * 用户登录登出画面
 * @author Kinsama
 * @version 2017-01-09
 */
class IohUser_GetbackPasswordAction
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
        } elseif ($request->getAttribute("progress_step") == 4) {
            $ret = $this->_doConfirmExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->getAttribute("progress_step") == 3) {
            $ret = $this->_doChangeExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->getAttribute("progress_step") == 2) {
            $ret = $this->_doVerifyExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->getAttribute("progress_step") == 1) {
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
        $progress_step = 1;
        if ($request->hasParameter("do_verify")) {
            $progress_step = 2;
        } elseif ($request->hasParameter("do_change")) {
            $progress_step = 3;
        } elseif ($request->hasParameter("do_confirm")) {
            $progress_step = 4;
        }
        $session_data = array(
            "custom_account" => "",
            "custom_login_info" => array(),
            "custom_verify_type" => "1",
            "custom_verify_question_id" => "0",
            "custom_verify_question_answer" => ""
        );
        if ($user->hasVariable(USER_GETBACK_PASSWORD)) {
            $session_data = $user->getVariable(USER_GETBACK_PASSWORD);
        }
        if ($progress_step == 2) {
            if (!$request->hasParameter("custom_account")) {
                $request->setError("custom_account", "请输入用户名");
                $progress_step = 1;
                return VIEW_DONE;
            }
            $session_data["custom_account"] = $request->getParameter("custom_account");
            $login_info = array();
            if (Validate::checkMailAddress($custom_account)) {
                $login_info = IohCustomDBI::selectCustomByMail($custom_account);
                if ($controller->isError($login_info)) {
                    $login_info->setPos(__FILE__, __LINE__);
                    return $login_info;
                }
            } elseif (Validate::checkMobileNumber($custom_account)) {
                $login_info = IohCustomDBI::selectCustomByTel($custom_account);
                if ($controller->isError($login_info)) {
                    $login_info->setPos(__FILE__, __LINE__);
                    return $login_info;
                }
            }
            if (empty($login_info)) {
                $login_info = IohCustomDBI::selectCustomByName($custom_account);
                if ($controller->isError($login_info)) {
                    $login_info->setPos(__FILE__, __LINE__);
                    return $login_info;
                }
            }
            if (empty($login_info)) {
                $request->setError("custom_account", "用户名不存在");
                $progress_step = 1;
                return VIEW_DONE;
            }
            $session_data["custom_login_info"] = $login_info;
            $user->setVariable(USER_GETBACK_PASSWORD, $session_data);
        }
        if ($progress_step == 3) {
            
        }
        if ($progress_step == 4) {
            
        }
        $request->setAttribute("progress_step", $progress_step);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
//Utility::testVariable("asdasd");
        return VIEW_DONE;
    }

    private function _doVerifyExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_NONE;
    }

    private function _doChangeExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_NONE;
    }

    private function _doConfirmExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_NONE;
    }
}
?>