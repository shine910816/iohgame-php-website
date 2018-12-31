<?php
require_once SRC_PATH . "/library/Security/IohSecurityCommon.php";

/**
 * 绑定手机号码画面
 * @author Kinsama
 * @version 2018-12-19
 */
class IohUser_BindTeleAction extends ActionBase
{
    private $_common;

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
        if ($custom_login_info["custom_tele_flg"] == IohCustomEntity::TELE_CONFIRM_YES) {
            $bound_flg = true;
        }
        $mode = "2";
        $saved_tele_number = "";
        if (strlen($custom_login_info["custom_tele_number"]) > 0) {
            $mode = "1";
            $saved_tele_number = substr($custom_login_info["custom_tele_number"], 0, 2) . str_repeat("*", 7) . substr($custom_login_info["custom_tele_number"], -2);
        }
        $custom_login_info["saved_tele_number"] = $saved_tele_number;
        if ($request->hasParameter("selected_mode")) {
            $mode_opt = array(
                "1",
                "2"
            );
            if (!Validate::checkAcceptParam($request->getParameter("selected_mode"), $mode_opt)) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $mode = $request->getParameter("selected_mode");
        }
        $send_code_tele_number = "";
        $count_down_start = 60;
        $verify_info = IohSecurityVerifycodeDBI::selectLastCode($custom_id, IohSecurityVerifycodeEntity::CODE_TYPE_TELEPHONE, IohSecurityVerifycodeEntity::CODE_METHOD_BIND);
        if ($controller->isError($verify_info)) {
            $verify_info->setPos(__FILE__, __LINE__);
            return $verify_info;
        }
        if (isset($verify_info[$custom_id])) {
            $count_down_start = 60 - (time() - strtotime($verify_info[$custom_id]["insert_date"]));
            if ($count_down_start < 1) {
                $count_down_start = 60;
            }
        }
        if ($request->hasParameter("do_change")) {
            if ($mode == "1") {
                $send_code_tele_number = $custom_login_info["custom_tele_number"];
            } else {
                if (!$request->hasParameter("phone_number")) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                $send_code_tele_number = $request->getParameter("phone_number");
                if (strlen($send_code_tele_number) == 0) {
                    $request->setError("send_code_tele_number", "请输入手机号码");
                }
            }
            if (!$request->hasParameter("verify_code")) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            if (!isset($verify_info[$custom_id])) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            if ($verify_info[$custom_id]["target_number"] != $send_code_tele_number) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            if ($verify_info[$custom_id]["code_value"] != $request->getParameter("verify_code")) {
                $request->setError("verify_code", "验证码错误");
            }
            if (time() - strtotime($verify_info[$custom_id]["insert_date"]) > 300) {
                $request->setError("verify_code", "验证码已失效");
            }
            if ($bound_flg) {
                if (!$request->hasParameter("custom_password")) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                $custom_password = $request->getParameter("custom_password");
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
                $salt_arr = Utility::transSalt($custom_login_info["custom_salt"]);
                if ($password_info[$custom_id]["custom_password"] != md5($salt_arr["salt1"] . $custom_password . $salt_arr["salt2"])) {
                    $request->setError("custom_password", "登录密码不正确");
                }
            }
        }
        $request->setAttribute("custom_id", $custom_id);
        $request->setAttribute("custom_login_info", $custom_login_info);
        $request->setAttribute("bound_flg", $bound_flg);
        $request->setAttribute("mode", $mode);
        $request->setAttribute("send_code_tele_number", $send_code_tele_number);
        $request->setAttribute("count_down_start", $count_down_start);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }

    private function _doErrorExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->getAttribute("mode") == "1") {
            $request->setAttribute("send_code_tele_number", "");
        }
        return VIEW_DONE;
    }

    private function _doChangeExecute(Controller $controller, User $user, Request $request)
    {
        $custom_id = $request->getAttribute("custom_id");
        $bound_flg = $request->getAttribute("bound_flg");
        $send_code_tele_number = $request->getAttribute("send_code_tele_number");
        $update_data = array();
        if ($bound_flg) {
            $update_data["custom_tele_flg"] = IohCustomEntity::TELE_CONFIRM_NO;
        } else {
            $update_data["custom_tele_flg"] = IohCustomEntity::TELE_CONFIRM_YES;
            $update_data["custom_tele_number"] = $send_code_tele_number;
        }
        $dbi = Database::getInstance();
        $begin_res = $dbi->begin();
        if ($dbi->isError($begin_res)) {
            $dbi->rollback();
            $begin_res->setPos(__FILE__, __LINE__);
            return $begin_res;
        }
        $reset_data = array(
            "del_flg" => "1"
        );
        $reset_where = "custom_id = " . $custom_id . " AND code_type = " . IohSecurityVerifycodeEntity::CODE_TYPE_TELEPHONE;
        $reset_res = IohSecurityVerifycodeDBI::updateVerifyCode($reset_data, $reset_where);
        if ($controller->isError($reset_res)) {
            $dbi->rollback();
            $reset_res->setPos(__FILE__, __LINE__);
            return $reset_res;
        }
        $update_res = IohCustomDBI::updateLogin($update_data, "custom_id = " . $custom_id);
        if ($controller->isError($update_res)) {
            $dbi->rollback();
            $update_res->setPos(__FILE__, __LINE__);
            return $update_res;
        }
        $commit_res = $dbi->commit();
        if ($dbi->isError($commit_res)) {
            $dbi->rollback();
            $commit_res->setPos(__FILE__, __LINE__);
            return $commit_res;
        }
        $controller->redirect("./?menu=user&act=safety");
        return VIEW_NONE;
    }
}
?>