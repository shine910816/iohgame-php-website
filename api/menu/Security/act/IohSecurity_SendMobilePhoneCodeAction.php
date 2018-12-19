<?php

/**
 * 发送手机验证码
 * @author Kinsama
 * @version 2018-12-18
 */
class IohSecurity_SendMobilePhoneCodeAction
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        $result = $this->_doDefaultExecute($controller, $user, $request);
        header("Content-type:text/plain; charset=utf-8");
        echo json_encode($result);
        exit;
    }

    /**
     * 执行参数检测
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainValidate(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $result = array(
            "error" => 0,
            "err_msg" => ""
        );
        if (!$user->isLogin()) {
            $result["error"] = 1;
            $result["err_msg"] = "用户尚未登录";
            return $result;
        }
        $custom_id = $user->getVariable("custom_id");
        $custom_login_info = IohCustomDBI::selectCustomById($custom_id);
        if ($controller->isError($custom_login_info)) {
            $result["error"] = 1;
            $result["err_msg"] = "数据库错误";
            return $result;
        }
        if (!isset($custom_login_info[$custom_id])) {
            $result["error"] = 1;
            $result["err_msg"] = "用户登录信息不存在";
            return $result;
        }
        $mode_opt = array(
            "1",
            "2"
        );
        if (!$request->hasParameter("mode")) {
            $result["error"] = 1;
            $result["err_msg"] = "用户篡改地址栏信息";
            return $result;
        }
        if (!Validate::checkAcceptParam($request->getParameter("mode"), $mode_opt)) {
            $result["error"] = 1;
            $result["err_msg"] = "用户篡改地址栏信息";
            return $result;
        }
        $custom_login_info = $custom_login_info[$custom_id];
        $mode = $request->getParameter("mode");
        $target_number = "";
        if ($mode == "1") {
            $target_number = $custom_login_info["custom_tele_number"];
        } else {
            if (!$request->hasParameter("number")) {
                $result["error"] = 1;
                $result["err_msg"] = "用户篡改地址栏信息";
                return $result;
            }
            $target_number = $request->getParameter("number");
        }
        if (strlen($target_number) == 0) {
            $result["error"] = 1;
            $result["err_msg"] = "请输入手机号码";
            return $result;
        }
        if (!Validate::checkMobileNumber($target_number)) {
            $result["error"] = 1;
            $result["err_msg"] = "手机号码不合法";
            return $result;
        }
        $tel_res = IohCustomDBI::selectCustomByTel($target_number);
        if ($controller->isError($tel_res)) {
            $result["error"] = 1;
            $result["err_msg"] = "数据库错误";
            return $result;
        }
        if (!empty($tel_res)) {
            $result["error"] = 1;
            $result["err_msg"] = "手机号码已被占用";
            return $result;
        }
        $last_code_info = IohSecurityVerifycodeDBI::selectLastCode($custom_id, IohSecurityVerifycodeEntity::CODE_TYPE_TELEPHONE);
        if ($controller->isError($last_code_info)) {
            $result["error"] = 1;
            $result["err_msg"] = "数据库错误";
            return $result;
        }
        if (isset($last_code_info[$custom_id]) && time() - strtotime($last_code_info[$custom_id]["send_time"]) < 60) {
            $result["error"] = 1;
            $result["err_msg"] = "重复请求";
            return $result;
        }
        $code_value = Utility::getNumberCode();
        $insert_data = array(
            "custom_id" => $custom_id,
            "code_type" => IohSecurityVerifycodeEntity::CODE_TYPE_TELEPHONE,
            "target_number" => $target_number,
            "code_value" => $code_value,
            "send_time" => date("Y-m-d H:i:s")
        );
        $insert_res = IohSecurityVerifycodeDBI::insertVerifyCode($insert_data);
        if ($controller->isError($insert_res)) {
            $result["error"] = 1;
            $result["err_msg"] = "数据库错误";
            return $result;
        }
        //require_once SRC_PATH . "/library/security/Message.php";
        //Message::sendSms($target_number, $code_value, MSG_TPL_BINDING_PHONE);
        return $result;
    }
}
?>