<?php

/**
 * 用户登录登出画面
 * @author Kinsama
 * @version 2017-01-09
 */
class IohUser_LoginAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter('do_logout')) {
            $ret = $this->_doLogoutExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->isError()) {
            $ret = $this->_doErrorExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter('do_login')) {
            $ret = $this->_doLoginExecute($controller, $user, $request);
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
        $request->setAttribute("custom_account", "");
        if ($request->hasParameter('do_login')) {
            $custom_account = $request->getParameter("custom_account");
            $custom_password = $request->getParameter("custom_password");
            $request->setAttribute("custom_account", $custom_account);
            $login_info = array();
            if (Validate::checkMailAddress($custom_account)) {
                $addr_login = IohCustomDBI::selectCustomByMail($custom_account);
                if ($controller->isError($addr_login)) {
                    $addr_login->setPos(__FILE__, __LINE__);
                    return $addr_login;
                }
                if (empty($addr_login)) {
                    $login_info = IohCustomDBI::selectCustomByName($custom_account);
                    if ($controller->isError($login_info)) {
                        $login_info->setPos(__FILE__, __LINE__);
                        return $login_info;
                    }
                } else {
                    $login_info = $addr_login;
                }
            } elseif (Validate::checkMobileNumber($custom_account)) {
                $tel_login = IohCustomDBI::selectCustomByTel($custom_account);
                if ($controller->isError($tel_login)) {
                    $tel_login->setPos(__FILE__, __LINE__);
                    return $tel_login;
                }
                if (empty($tel_login)) {
                    $login_info = IohCustomDBI::selectCustomByName($custom_account);
                    if ($controller->isError($login_info)) {
                        $login_info->setPos(__FILE__, __LINE__);
                        return $login_info;
                    }
                } else {
                    $login_info = $tel_login;
                }
            } else {
                $login_info = IohCustomDBI::selectCustomByName($custom_account);
                if ($controller->isError($login_info)) {
                    $login_info->setPos(__FILE__, __LINE__);
                    return $login_info;
                }
            }
            if (empty($login_info)) {
                $request->setError("custom_account", "用户名不存在");
                return VIEW_DONE;
            }
            $salt_arr = Utility::transSalt($login_info["custom_salt"]);
            if ($login_info["custom_password"] != md5($salt_arr["salt1"] . $custom_password . $salt_arr["salt2"])) {
                $request->setError("custom_password", "密码不正确");
                return VIEW_DONE;
            }
            $request->setAttribute("custom_id", $login_info["custom_id"]);
        }
        return VIEW_DONE;
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
        return VIEW_DONE;
    }

    /**
     * 执行登录命令
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doLoginExecute(Controller $controller, User $user, Request $request)
    {
        $custom_id = $request->getAttribute("custom_id");
        $custom_nick = IohCustomDBI::selectCustomNickname($custom_id);
        if ($controller->isError($custom_nick)) {
            $custom_nick->setPos(__FILE__, __LINE__);
            return $custom_nick;
        }
        $admin_lvl = IohCustomDBI::selectAdminLevel($custom_id);
        if ($controller->isError($admin_lvl)) {
            $admin_lvl->setPos(__FILE__, __LINE__);
            return $admin_lvl;
        }
        $user->setVariable("custom_id", $custom_id);
        $user->setVariable("custom_nick", $custom_nick);
        $user->setVariable("admin_lvl", $admin_lvl);
        // FIXME Add save cookie judgement in future
        if (true) {
            $cookie_arr = array();
            $cookie_arr["custom_id"] = $custom_id;
            $cookie_arr["custom_nick"] = $custom_nick;
            $user->setParameter(LOGINED_COOKIE_KEY, Utility::encodeCookieInfo($cookie_arr), 3600 * 24 * 15);
        }
        $redirect_url = null;
        if ($user->hasVariable(REDIRECT_URL)) {
            $redirect_url = $user->getVariable(REDIRECT_URL);
        }
        $controller->redirect($redirect_url);
        return VIEW_NONE;
    }

    /**
     * 执行登出命令
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doLogoutExecute(Controller $controller, User $user, Request $request)
    {
        if (!$user->isLogin()) {
            $controller->redirect("?menu=user&act=login");
            return VIEW_NONE;
        }
        $user->setVariable("custom_id", "0");
        $user->setVariable("custom_nick", "");
        $user->setVariable("admin_lvl", "0");
        $user->freeParameter(LOGINED_COOKIE_KEY);
        $controller->redirect();
        return VIEW_NONE;
    }

    /**
     * 执行登录错误命令
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doErrorExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }
}
?>