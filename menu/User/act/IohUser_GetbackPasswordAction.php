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
        } elseif ($request->getAttribute("progress_step") == 5) {
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
        if ($request->hasParameter("do_confirm")) {
            $progress_step = 2;
        } elseif ($request->hasParameter("do_select")) {
            $progress_step = 3;
        } elseif ($request->hasParameter("do_verify")) {
            $progress_step = 4;
        } elseif ($request->hasParameter("do_complete")) {
            $progress_step = 5;
        }
        $request->setAttribute("progress_step", $progress_step);
        $session_data = array();
        if ($progress_step == 1) {
            if (!$user->hasVariable(USER_GETBACK_PASSWORD)) {
                $session_data = array(
                    "custom_account" => "",
                    "custom_id" => "0",
                    "custom_security_type" => "1"
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
            $custom_id = "0";
            if ($request->getParameter("do_confirm") == "next") {
                if (!$request->hasParameter("custom_account")) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                $custom_account = $request->getParameter("custom_account");
                $session_data["custom_account"] = $custom_account;
                $user->setVariable(USER_GETBACK_PASSWORD, $session_data);
                if (strlen($custom_account) == 0) {
                    $request->setError("custom_account", "请输入用户名");
                    return VIEW_NONE;
                }
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
                    return VIEW_NONE;
                }
                $custom_id = $login_info["custom_id"];
                $session_data["custom_id"] = $custom_id;
                $user->setVariable(USER_GETBACK_PASSWORD, $session_data);
            } else {
                $custom_id = $session_data["custom_id"];
            }
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
            $request->setAttribute("security_able_tele", $custom_login_info[$custom_id]["custom_tele_flg"] == IohCustomEntity::TELE_CONFIRM_YES);
            $request->setAttribute("security_able_mail", $custom_login_info[$custom_id]["custom_mail_flg"] == IohCustomEntity::MAIL_CONFIRM_YES);
            return VIEW_DONE;
        }
        if ($progress_step == 3) {
            if (!$user->hasVariable(USER_GETBACK_PASSWORD)) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $session_data = $user->getVariable(USER_GETBACK_PASSWORD);
            if (!($request->hasParameter("security_type") && Validate::checkAcceptParam($request->getParameter("security_type"), array("1", "2", "3")))) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $custom_security_type = $request->getParameter("security_type");
            $session_data["custom_security_type"] = $custom_security_type;
            $user->setVariable(USER_GETBACK_PASSWORD, $session_data);
            $custom_id = $session_data["custom_id"];
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
            if ($custom_security_type == "2") {
                if (strlen($custom_login_info[$custom_id]["custom_tele_number"]) == 0 ||
                    $custom_login_info[$custom_id]["custom_tele_flg"] == IohCustomEntity::TELE_CONFIRM_NO) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                $custom_tele_number = $custom_login_info[$custom_id]["custom_tele_number"];
                $request->setAttribute("saved_tele_number", substr($custom_tele_number, 0, 2) . str_repeat("*", 7) . substr($custom_tele_number, -2));
            } elseif ($custom_security_type == "3") {
                if (strlen($custom_login_info[$custom_id]["custom_mail_address"]) == 0 ||
                    $custom_login_info[$custom_id]["custom_mail_flg"] == IohCustomEntity::MAIL_CONFIRM_NO) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                $custom_mail_address = $custom_login_info[$custom_id]["custom_mail_address"];
                $mail_arr = explode("@", $custom_mail_address);
                $request->setAttribute("saved_mail_address", substr($mail_arr[0], 0, 1) . str_repeat("*", strlen($mail_arr[0]) - 1) . "@" . $mail_arr[1]);
            } else {
                
            }
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