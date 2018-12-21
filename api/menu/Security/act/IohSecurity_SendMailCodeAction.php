<?php

/**
 * 发送邮箱验证码
 * @author Kinsama
 * @version 2018-12-21
 */
class IohSecurity_SendMailCodeAction
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
        $target_mail = "";
        if ($mode == "1") {
            $target_mail = $custom_login_info["custom_mail_address"];
        } else {
            if (!$request->hasParameter("address")) {
                $result["error"] = 1;
                $result["err_msg"] = "用户篡改地址栏信息";
                return $result;
            }
            $target_mail = $request->getParameter("address");
        }
        if (strlen($target_mail) == 0) {
            $result["error"] = 1;
            $result["err_msg"] = "请输入邮箱地址";
            return $result;
        }
        if (!Validate::checkMailAddress($target_mail)) {
            $result["error"] = 1;
            $result["err_msg"] = "邮箱地址不合法";
            return $result;
        }
        $mail_res = IohCustomDBI::selectCustomByMail($target_mail);
        if ($controller->isError($mail_res)) {
            $result["error"] = 1;
            $result["err_msg"] = "数据库错误";
            return $result;
        }
        if (!empty($mail_res)) {
            $result["error"] = 1;
            $result["err_msg"] = "邮箱地址已被占用";
            return $result;
        }
        $last_code_info = IohSecurityVerifycodeDBI::selectLastCode($custom_id, IohSecurityVerifycodeEntity::CODE_TYPE_MAILADDRESS);
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
        $dbi = Database::getInstance();
        $begin_res = $dbi->begin();
        if ($dbi->isError($begin_res)) {
            $dbi->rollback();
            $result["error"] = 1;
            $result["err_msg"] = "数据库错误";
            return $result;
        }
        $update_data = array(
            "del_flg" => "1"
        );
        $update_where = "custom_id = " . $custom_id . " AND code_type = " . IohSecurityVerifycodeEntity::CODE_TYPE_MAILADDRESS;
        $update_res = IohSecurityVerifycodeDBI::updateVerifyCode($update_data, $update_where);
        if ($controller->isError($update_res)) {
            $dbi->rollback();
            $result["error"] = 1;
            $result["err_msg"] = "数据库错误";
            return $result;
        }
        $code_value = strtoupper(Utility::getRandomString(8));
        $context = '<p>尊敬的用户，您的邮箱地址绑定验证码为</p><h1 style="color:#F06000;">' . $code_value . "</h1><p>请在5分钟内按页面提示提交验证码</p><p>切勿将验证码泄露于他人</p>";
        if (!Utility::sendToMail($target_mail, "电子邮箱绑定验证码", $context)) {
            $dbi->rollback();
            $result["error"] = 1;
            $result["err_msg"] = "验证码发送失败";
            return $result;
        }
        $insert_data = array(
            "custom_id" => $custom_id,
            "code_type" => IohSecurityVerifycodeEntity::CODE_TYPE_MAILADDRESS,
            "target_number" => $target_mail,
            "code_value" => $code_value,
            "send_time" => date("Y-m-d H:i:s")
        );
        $insert_res = IohSecurityVerifycodeDBI::insertVerifyCode($insert_data);
        if ($controller->isError($insert_res)) {
            $dbi->rollback();
            $result["error"] = 1;
            $result["err_msg"] = "数据库错误";
            return $result;
        }
        $commit_res = $dbi->commit();
        if ($dbi->isError($commit_res)) {
            $dbi->rollback();
            $result["error"] = 1;
            $result["err_msg"] = "数据库错误";
            return $result;
        }
        return $result;
    }
}
?>