<?php
class IohSecurity_Common
{
    public function getCustomLoginInfo(Controller $controller, User $user)
    {
        if (!$user->isLogin()) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "用户尚未登录");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $custom_id = $user->getVariable("custom_id");
        $custom_login_info = IohCustomDBI::selectCustomById($custom_id);
        if ($controller->isError($custom_login_info)) {
            $custom_login_info->setPos(__FILE__, __LINE__);
            return $custom_login_info;
        }
        if (!isset($custom_login_info[$custom_id])) {
            $err = $controller->raiseError(ERROR_CODE_DATABASE_DISACCEPT, "用户登录信息不存在");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        return $custom_login_info[$custom_id];
    }

    public function getTargetNumber(Controller $controller, Request $request, $custom_login_info, $code_type, $is_remove_flg = false)
    {
        $error_keyword = "手机号码";
        $is_mail_flg = false;
        if ($code_type == IohSecurityVerifycodeEntity::CODE_TYPE_MAILADDRESS) {
            $error_keyword = "邮箱地址";
            $is_mail_flg = true;
        }
        $target_number = "";
        $number_from_parameter = "";
        $mode = "1";
        if (!$is_remove_flg) {
            if (!$request->hasParameter("mode")) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "用户擅自修改地址栏信息");
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            if (!Validate::checkAcceptParam($request->getParameter("mode"), array("1", "2"))) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "用户擅自修改地址栏信息");
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $mode = $request->getParameter("mode");
            if ($mode == "2") {
                if ($is_mail_flg) {
                    if (!$request->hasParameter("address")) {
                        $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "用户擅自修改地址栏信息");
                        $err->setPos(__FILE__, __LINE__);
                        return $err;
                    }
                    $number_from_parameter = $request->getParameter("address");
                } else {
                    if (!$request->hasParameter("number")) {
                        $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "用户擅自修改地址栏信息");
                        $err->setPos(__FILE__, __LINE__);
                        return $err;
                    }
                    $number_from_parameter = $request->getParameter("number");
                }
                $not_provide_error_text = "请输入" . $error_keyword;
                $invalidate_error_text = "您输入的" . $error_keyword . "不合法";
                $occupied_error_text = "您输入的" . $error_keyword . "已被占用";
                if (strlen($number_from_parameter) == 0) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, $not_provide_error_text);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                $registered_info = array();
                if ($is_mail_flg) {
                    if (!Validate::checkMailAddress($number_from_parameter)) {
                        $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, $invalidate_error_text);
                        $err->setPos(__FILE__, __LINE__);
                        return $err;
                    }
                    $registered_info = IohCustomDBI::selectCustomByMail($number_from_parameter);
                    if ($controller->isError($registered_info)) {
                        $registered_info->setPos(__FILE__, __LINE__);
                        return $registered_info;
                    }
                } else {
                    if (!Validate::checkMobileNumber($number_from_parameter)) {
                        $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, $invalidate_error_text);
                        $err->setPos(__FILE__, __LINE__);
                        return $err;
                    }
                    $registered_info = IohCustomDBI::selectCustomByTel($number_from_parameter);
                    if ($controller->isError($registered_info)) {
                        $registered_info->setPos(__FILE__, __LINE__);
                        return $registered_info;
                    }
                }
                if (count($registered_info) > 0) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, $occupied_error_text);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
            }
        }
        if ($mode == "2") {
            $target_number = $number_from_parameter;
        } else {
            if ($is_mail_flg) {
                $target_number = $custom_login_info["custom_mail_address"];
            } else {
                $target_number = $custom_login_info["custom_tele_number"];
            }
            if (strlen($target_number) == 0) {
                $err = $controller->raiseError(ERROR_CODE_DATABASE_DISACCEPT, "用户没有预存的" . $error_keyword);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
        }
        return $target_number;
    }

    public function sendCodeAndRecord($custom_id, $code_type, $target_number, $is_remove_flg)
    {
        $dbi = Database::getInstance();
        // SQL BEGIN
        $begin_res = $dbi->begin();
        if ($dbi->isError($begin_res)) {
            $dbi->rollback();
            $begin_res->setPos(__FILE__, __LINE__);
            return $begin_res;
        }
        // 检索最后一条验证码
        $last_code_info = IohSecurityVerifycodeDBI::selectLastCode($custom_id, $code_type);
        if ($dbi->isError($last_code_info)) {
            $dbi->rollback();
            $last_code_info->setPos(__FILE__, __LINE__);
            return $last_code_info;
        }
        // 频繁请求
        if (isset($last_code_info[$custom_id]) && time() - strtotime($last_code_info[$custom_id]["send_time"]) < 60) {
            $dbi->rollback();
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "请勿频繁请求发送验证码");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        // 逻辑删除之前的验证码
        $update_data = array(
            "del_flg" => "1"
        );
        $update_where = "custom_id = " . $custom_id . " AND code_type = " . $code_type;
        $update_res = IohSecurityVerifycodeDBI::updateVerifyCode($update_data, $update_where);
        if ($dbi->isError($update_res)) {
            $dbi->rollback();
            $update_res->setPos(__FILE__, __LINE__);
            return $update_res;
        }
        // 发送验证码
        $code_value = "";
        $send_error_text = "验证码发送失败";
        if ($code_type == IohSecurityVerifycodeEntity::CODE_TYPE_TELEPHONE) {
            $code_value = Utility::getNumberCode();
            if (!Utility::sendToPhone($target_number, $code_value, $is_remove_flg ? MSG_TPL_REMOVE_PHONE : MSG_TPL_BIND_PHONE)) {
                $dbi->rollback();
                $err = Error::getInstance();
                $err->raiseError(ERROR_CODE_THIRD_ERROR_FALSIFY, $send_error_text);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
        } else {
            $code_value = strtoupper(Utility::getRandomString(8));
            $mail_title = "电子邮箱绑定验证码";
            $template = MAIL_TPL_BIND_PHONE;
            if ($is_remove_flg) {
                $mail_title = "解除" . $mail_title;
                $template = MAIL_TPL_REMOVE_PHONE;
            }
            $context = sprintf($template, $code_value);
            if (!Utility::sendToMail($target_number, $mail_title, $context)) {
                $dbi->rollback();
                $err = Error::getInstance();
                $err->raiseError(ERROR_CODE_THIRD_ERROR_FALSIFY, $send_error_text);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
        }
        // 记录验证码
        $insert_data = array(
            "custom_id" => $custom_id,
            "code_type" => $code_type,
            "target_number" => $target_number,
            "code_value" => $code_value,
            "send_time" => date("Y-m-d H:i:s")
        );
        $insert_res = IohSecurityVerifycodeDBI::insertVerifyCode($insert_data);
        if ($dbi->isError($insert_res)) {
            $dbi->rollback();
            $insert_res->setPos(__FILE__, __LINE__);
            return $insert_res;
        }
        // SQL COMMIT
        $commit_res = $dbi->commit();
        if ($dbi->isError($commit_res)) {
            $dbi->rollback();
            $commit_res->setPos(__FILE__, __LINE__);
            return $commit_res;
        }
        return true;
    }

    public static function getInstance()
    {
        return new IohSecurity_Common();
    }
}
?>