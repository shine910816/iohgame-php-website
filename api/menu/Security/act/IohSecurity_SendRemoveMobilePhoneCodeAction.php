<?php

/**
 * 发送手机验证码
 * @author Kinsama
 * @version 2018-12-18
 */
class IohSecurity_SendRemoveMobilePhoneCodeAction
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
        $custom_login_info = $custom_login_info[$custom_id];
        $target_number = $custom_login_info["custom_tele_number"];
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
        $update_where = "custom_id = " . $custom_id . " AND code_type = " . IohSecurityVerifycodeEntity::CODE_TYPE_TELEPHONE;
        $update_res = IohSecurityVerifycodeDBI::updateVerifyCode($update_data, $update_where);
        if ($controller->isError($update_res)) {
            $dbi->rollback();
            $result["error"] = 1;
            $result["err_msg"] = "数据库错误";
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
        require_once SRC_PATH . "/library/security/Message.php";
        Message::sendSms($target_number, $code_value, MSG_TPL_REMOVE_PHONE);
        return $result;
    }
}
?>