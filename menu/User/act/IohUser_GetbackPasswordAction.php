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
        $progress_step = 1;
        if ($request->hasParameter("do_verify")) {
            $progress_step = 2;
        } elseif ($request->hasParameter("do_change")) {
            $progress_step = 3;
        } elseif ($request->hasParameter("do_confirm")) {
            $progress_step = 4;
        }
        $request->setAttribute("progress_step", $progress_step);
        $session_data = array();
        if ($progress_step == 1) {
            if (!$user->hasVariable(USER_GETBACK_PASSWORD)) {
                $session_data = array(
                    "custom_account" => "",
                    "custom_login_info" => array(),
                    "custom_verify_type" => "1",
                    "custom_verify_question_id" => "0",
                    "custom_verify_question_answer" => ""
                );
                $user->setVariable(USER_GETBACK_PASSWORD, $session_data);
            }
            return VIEW_DONE;
        }
        if ($progress_step == 2) {
            if (!$user->hasVariable(USER_GETBACK_PASSWORD)) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $session_data = $user->getVariable(USER_GETBACK_PASSWORD);
            if (!$request->hasParameter("custom_account") || strlen($request->getParameter("custom_account")) == 0) {
                $request->setError("custom_account", "请输入用户名");
                return VIEW_NONE;
            }
            $session_data["custom_account"] = $request->getParameter("custom_account");
            $user->setVariable(USER_GETBACK_PASSWORD, $session_data);
            $login_info = array();
            if (Validate::checkMailAddress($session_data["custom_account"])) {
                $login_info = IohCustomDBI::selectCustomByMail($session_data["custom_account"]);
                if ($controller->isError($login_info)) {
                    $login_info->setPos(__FILE__, __LINE__);
                    return $login_info;
                }
            } elseif (Validate::checkMobileNumber($session_data["custom_account"])) {
                $login_info = IohCustomDBI::selectCustomByTel($session_data["custom_account"]);
                if ($controller->isError($login_info)) {
                    $login_info->setPos(__FILE__, __LINE__);
                    return $login_info;
                }
            }
            if (empty($login_info)) {
                $login_info = IohCustomDBI::selectCustomByName($session_data["custom_account"]);
                if ($controller->isError($login_info)) {
                    $login_info->setPos(__FILE__, __LINE__);
                    return $login_info;
                }
            }
            if (empty($login_info)) {
                $request->setError("custom_account", "用户名不存在");
                return VIEW_NONE;
            }
            $session_data["custom_login_info"] = $login_info;
            $user->setVariable(USER_GETBACK_PASSWORD, $session_data);
            return VIEW_DONE;
        }
        if ($progress_step == 3) {
            if (!$user->hasVariable(USER_GETBACK_PASSWORD)) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $session_data = $user->getVariable(USER_GETBACK_PASSWORD);
        }
        if ($progress_step == 4) {
            if (!$user->hasVariable(USER_GETBACK_PASSWORD)) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $session_data = $user->getVariable(USER_GETBACK_PASSWORD);
        }
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $session_data = $user->getVariable(USER_GETBACK_PASSWORD);
        $request->setAttribute("session_data", $session_data);
        return VIEW_DONE;
    }

    private function _doChangeExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_NONE;
    }

    private function _doErrorExecute(Controller $controller, User $user, Request $request)
    {
        $progress_step = $request->getAttribute("progress_step");
        $session_data = $user->getVariable(USER_GETBACK_PASSWORD);
        $request->setAttribute("progress_step", $progress_step - 1);
        $request->setAttribute("session_data", $session_data);
        return VIEW_DONE;
    }
}
?>