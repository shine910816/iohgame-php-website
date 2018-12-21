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
        header("Content-type:text/plain; charset=utf-8");
        $result = array(
            "error" => 0,
            "err_msg" => ""
        );
        $exec_result = $this->_doDefaultExecute($controller, $user, $request);
        if ($controller->isError($exec_result)) {
            $exec_result->setPos(__FILE__, __LINE__);
            $error_message = "";
            if ($exec_result->err_code == ERROR_CODE_DATABASE_RESULT) {
                $error_message = "数据库发生错误";
            } else {
                $error_message = $exec_result->getMessage();
            }
            $result["error"] = 1;
            $result["err_msg"] = $error_message;
        }
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
        require_once SRC_PATH . "/api/menu/Security/lib/IohSecurity_Common.php";
        $common = IohSecurity_Common::getInstance();
        $custom_login_info = $common->getCustomLoginInfo($controller, $user);
        if ($controller->isError($custom_login_info)) {
            $custom_login_info->setPos(__FILE__, __LINE__);
            return $custom_login_info;
        }
        $custom_id = $custom_login_info["custom_id"];
        $code_type = IohSecurityVerifycodeEntity::CODE_TYPE_MAILADDRESS;
        $is_remove = false;
        $target_number = $common->getTargetNumber($controller, $request, $custom_login_info, $code_type, $is_remove);
        if ($controller->isError($target_number)) {
            $target_number->setPos(__FILE__, __LINE__);
            return $target_number;
        }
        $send_result = $common->sendCodeAndRecord($custom_id, $code_type, $target_number, $is_remove);
        if ($controller->isError($send_result)) {
            $send_result->setPos(__FILE__, __LINE__);
            return $send_result;
        }
        return true;
    }
}
?>