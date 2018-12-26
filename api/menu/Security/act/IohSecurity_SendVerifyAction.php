<?php

/**
 * 发送验证码
 * @author Kinsama
 * @version 2018-12-26
 */
class IohSecurity_SendVerifyAction
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
            $exec_result->writeLog();
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
        $key_option = array(
            IohSecurity_Common::BIND_TELE,
            IohSecurity_Common::BIND_MAIL,
            IohSecurity_Common::RESET_TELE,
            IohSecurity_Common::RESET_MAIL,
            IohSecurity_Common::GETBACK_TELE,
            IohSecurity_Common::GETBACK_MAIL,
            IohSecurity_Common::REMOVE_TELE,
            IohSecurity_Common::REMOVE_MAIL
        );
        if (!$request->hasParameter("k")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "用户擅自修改地址栏信息");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        if (!Validate::checkAcceptParam($request->getParameter("k"), $key_option)) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "用户擅自修改地址栏信息");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $common = IohSecurity_Common::getInstance($request->getParameter("k"));
        $send_result = $common->doSendExecute($controller, $user, $request);
        if ($controller->isError($send_result)) {
            $send_result->setPos(__FILE__, __LINE__);
            return $send_result;
        }
        return true;
    }
}
?>