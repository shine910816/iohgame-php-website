<?php

/**
 * 修改密码画面
 * @author Kinsama
 * @version 2019-01-02
 */
class IohUser_ChangePasswordAction extends ActionBase
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
        if ($request->hasParameter("do_change")) {
            if (!$request->hasParameter("custom_password") ||
                !$request->hasParameter("custom_password_new") ||
                !$request->hasParameter("custom_password_confirm")) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $custom_password = $request->getParameter("custom_password");
            $custom_password_new = $request->getParameter("custom_password_new");
            $custom_password_confirm = $request->getParameter("custom_password_confirm");
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
            $password_info = IohCustomDBI::selectCustomPasswordById($custom_id);
            if ($controller->isError($password_info)) {
                $password_info->setPos(__FILE__, __LINE__);
                return $password_info;
            }
            if (!isset($password_info[$custom_id])) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $custom_salt_arr = Utility::transSalt($custom_login_info[$custom_id]["custom_salt"]);
            if ($password_info[$custom_id]["custom_password"] != md5($custom_salt_arr["salt1"] . $custom_password . $custom_salt_arr["salt2"])) {
                $request->setError("custom_password", "旧登录密码不正确");
                return VIEW_NONE;
            }
            if (!Validate::checkNotEmpty($custom_password_new)) {
                $request->setError("custom_password", "请输入新登录密码");
                return VIEW_NONE;
            } elseif (Utility::getPasswordSecurityLevel($custom_password_new) < 1) {
                $request->setError("custom_password", "新登录密码不符合规范");
                return VIEW_NONE;
            } elseif (!Validate::checkNotEmpty($custom_password_confirm)) {
                $request->setError("custom_password", "请确认新登录密码");
                return VIEW_NONE;
            } elseif (md5($custom_password_new) !== md5($custom_password_confirm)) {
                $request->setError("custom_password", "两次输入的登录密码不一致");
                return VIEW_NONE;
            }
            $request->setAttribute("custom_id", $custom_id);
            $request->setAttribute("custom_password", $custom_password_new);
        }
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
        $custom_id = $request->getAttribute("custom_id");
        $custom_password = $request->getAttribute("custom_password");
        $salt = Utility::transSalt();
        $login_update = array(
            "custom_salt" => $salt["code"]
        );
        $password_update = array(
            "custom_password" => md5($salt["salt1"] . $custom_password . $salt["salt2"])
        );
        $where = "custom_id = " . $custom_id;
        $dbi = Database::getInstance();
        $begin_res = $dbi->begin();
        if ($dbi->isError($begin_res)) {
            $dbi->rollback();
            $begin_res->setPos(__FILE__, __LINE__);
            return $begin_res;
        }
        $login_res = IohCustomDBI::updateLogin($login_update, $where);
        if ($dbi->isError($login_res)) {
            $dbi->rollback();
            $login_res->setPos(__FILE__, __LINE__);
            return $login_res;
        }
        $pass_res = IohCustomDBI::updatePassword($password_update, $where);
        if ($dbi->isError($pass_res)) {
            $dbi->rollback();
            $pass_res->setPos(__FILE__, __LINE__);
            return $pass_res;
        }
        $commit_res = $dbi->commit();
        if ($dbi->isError($commit_res)) {
            $dbi->rollback();
            $commit_res->setPos(__FILE__, __LINE__);
            return $commit_res;
        }
        $controller->redirect("./?menu=user&act=login&do_logout=1");
        return VIEW_NONE;
    }
}
?>