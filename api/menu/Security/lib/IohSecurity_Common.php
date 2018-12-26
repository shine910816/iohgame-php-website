<?php
class IohSecurity_Common
{
    const BIND_TELE = "1";
    const BIND_MAIL = "2";
    const RESET_TELE = "3";
    const RESET_MAIL = "4";
    const GETBACK_TELE = "5";
    const GETBACK_MAIL = "6";
    const REMOVE_TELE = "7";
    const REMOVE_MAIL = "8";

    private $_must_login_flg = true;
    private $_code_type = IohSecurityVerifycodeEntity::CODE_TYPE_MAILADDRESS;
    private $_is_mail_flg = true;
    private $_type_keyword = "邮箱地址";
    private $_parameterized_flg = false;
    private $_mail_title = "";
    private $_mail_context_format = "";
    private $_message_template = "";
    private $_must_check_flg = false;

    public function __construct($exec_code)
    {
        if ($exec_code == "1" || $exec_code == "2") {
            $this->_parameterized_flg = true;
        }
        if ($exec_code == "5" || $exec_code == "6") {
            $this->_must_login_flg = false;
            $this->_must_check_flg = true;
        }
        if ($exec_code == "7" || $exec_code == "8") {
            $this->_must_check_flg = true;
        }
        if ($exec_code == "1" || $exec_code == "3" || $exec_code == "5" || $exec_code == "7") {
            $this->_code_type = IohSecurityVerifycodeEntity::CODE_TYPE_TELEPHONE;
            $this->_is_mail_flg = false;
            $this->_type_keyword = "手机号码";
        }
        if ($exec_code == "1") {
            $this->_message_template = MSG_TPL_BIND_PHONE;
        }
        if ($exec_code == "2") {
            $this->_mail_title = "邮箱绑定验证";
            $this->_mail_context_format = MAIL_TPL_BIND_PHONE;
        }
        if ($exec_code == "3") {
            $this->_message_template = MSG_TPL_RESET_PASSWORD;
        }
        if ($exec_code == "4") {
            $this->_mail_title = "重置密码邮箱验证";
            $this->_mail_context_format = MAIL_TPL_RESET_PASSWORD;
        }
        if ($exec_code == "5") {
            $this->_message_template = MSG_TPL_GETBACK_PASSWORD;
        }
        if ($exec_code == "6") {
            $this->_mail_title = "找回密码邮箱验证";
            $this->_mail_context_format = MAIL_TPL_GETBACK_PASSWORD;
        }
        if ($exec_code == "7") {
            $this->_message_template = MSG_TPL_REMOVE_PHONE;
        }
        if ($exec_code == "8") {
            $this->_mail_title = "解除邮箱绑定验证";
            $this->_mail_context_format = MAIL_TPL_REMOVE_PHONE;
        }
    }

    public function doSendExecute(Controller $controller, User $user, Request $request)
    {
        $custom_id = "0";
        if ($this->_must_login_flg) {
            if (!$user->isLogin()) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "用户尚未登录");
                $err->setPos(__FILE__, __LINE__); 
                return $err; 
            } 
            $custom_id = $user->getVariable("custom_id");
        } else {
            if ($user->hasVariable(USER_GETBACK_PASSWORD)) {
                $session_data = $user->getVariable(USER_GETBACK_PASSWORD);
                $custom_id = $session_data["custom_id"];
            }
        }
        if ($custom_id == "0") {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "用户不存在");
            $err->setPos(__FILE__, __LINE__);
            return $err; 
        }
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
        $custom_login_info = $custom_login_info[$custom_id];
        $target_number = "";
        $number_from_parameter = "";
        $mode = "1";
        // mode参数认证
        if ($this->_parameterized_flg) {
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
                if ($this->_is_mail_flg) {
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
                $not_provide_error_text = "请输入" . $this->_type_keyword;
                $invalidate_error_text = "您输入的" . $this->_type_keyword . "不合法";
                $occupied_error_text = "您输入的" . $this->_type_keyword . "已被占用";
                if (strlen($number_from_parameter) == 0) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, $not_provide_error_text);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                $registered_info = array();
                if ($this->_is_mail_flg) {
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
        // target_number赋值
        if ($mode == "2") {
            $target_number = $number_from_parameter;
        } else {
            if ($this->_is_mail_flg) {
                if ($this->_must_check_flg && $custom_login_info["custom_mail_flg"] == IohCustomEntity::MAIL_CONFIRM_NO) {
                    $err = $controller->raiseError(ERROR_CODE_DATABASE_DISACCEPT, "用户尚未绑定" . $this->_type_keyword);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                $target_number = $custom_login_info["custom_mail_address"];
            } else {
                if ($this->_must_check_flg && $custom_login_info["custom_tele_flg"] == IohCustomEntity::TELE_CONFIRM_NO) {
                    $err = $controller->raiseError(ERROR_CODE_DATABASE_DISACCEPT, "用户尚未绑定" . $this->_type_keyword);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                $target_number = $custom_login_info["custom_tele_number"];
            }
            if (strlen($target_number) == 0) {
                $err = $controller->raiseError(ERROR_CODE_DATABASE_DISACCEPT, "用户没有预存的" . $this->_type_keyword);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
        }
        $dbi = Database::getInstance();
        // SQL BEGIN
        $begin_res = $dbi->begin();
        if ($dbi->isError($begin_res)) {
            $dbi->rollback();
            $begin_res->setPos(__FILE__, __LINE__);
            return $begin_res;
        }
        // 检索最后一条验证码
        $last_code_info = IohSecurityVerifycodeDBI::selectLastCode($custom_id, $this->_code_type);
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
        $update_where = "custom_id = " . $custom_id . " AND code_type = " . $this->_code_type;
        $update_res = IohSecurityVerifycodeDBI::updateVerifyCode($update_data, $update_where);
        if ($dbi->isError($update_res)) {
            $dbi->rollback();
            $update_res->setPos(__FILE__, __LINE__);
            return $update_res;
        }
        // 发送验证码
        $code_value = "";
        $send_error_text = "验证码发送失败";
        if ($this->_is_mail_flg) {
            $code_value = strtoupper(Utility::getRandomString(8));
            if (!Utility::sendToMail($target_number, $this->_mail_title, sprintf($this->_mail_context_format, $code_value))) {
                $dbi->rollback();
                $err = Error::getInstance();
                $err->raiseError(ERROR_CODE_THIRD_ERROR_FALSIFY, $send_error_text);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
        } else {
            $code_value = Utility::getNumberCode();
            if (!Utility::sendToPhone($target_number, $code_value, $this->_message_template)) {
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
            "code_type" => $this->_code_type,
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

    public static function getInstance($exec_code)
    {
        return new IohSecurity_Common($exec_code);
    }
}
?>