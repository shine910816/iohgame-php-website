<?php

/**
 * 用户安全设置画面
 * @author Kinsama
 * @version 2018-12-18
 */
class IohUser_SafetyAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        $ret = $this->_doDefaultExecute($controller, $user, $request);
        if ($controller->isError($ret)) {
            $ret->setPos(__FILE__, __LINE__);
            return $ret;
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
        $request->setAttribute("subpanel_file", SRC_PATH . "/menu/User/tpl/IohUser_MobileListView.tpl");
        $request->setAttribute("custom_id", $custom_id);
        $request->setAttribute("custom_login_info", $custom_login_info[$custom_id]);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $custom_id = $request->getAttribute("custom_id");
        $custom_login_info = $request->getAttribute("custom_login_info");
        $safety_question_resetable_flg = false;
        if ($custom_login_info["custom_tele_flg"] == IohCustomEntity::TELE_CONFIRM_YES ||
            $custom_login_info["custom_mail_flg"] == IohCustomEntity::MAIL_CONFIRM_YES) {
            $safety_question_resetable_flg = true;
        }
        $disp_tele_number = "";
        $disp_mail_number = "";
        if (strlen($custom_login_info["custom_tele_number"]) > 0) {
            $disp_tele_number = substr($custom_login_info["custom_tele_number"], 0, 2) . str_repeat("*", 7) . substr($custom_login_info["custom_tele_number"], -2);
        }
        if (strlen($custom_login_info["custom_mail_address"]) > 0) {
            $mail_arr = explode("@", $custom_login_info["custom_mail_address"]);
            $disp_mail_number = substr($mail_arr[0], 0, 1) . str_repeat("*", strlen($mail_arr[0]) - 1) . "@" . $mail_arr[1];
        }
        $custom_login_info["disp_tele_number"] = $disp_tele_number;
        $custom_login_info["disp_mail_number"] = $disp_mail_number;
        $disp_no_change_password_hint = 0;
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
        if (time() - strtotime($password_info[$custom_id]["update_date"]) > CUSTOM_NO_CHANGE_PASSWORD_LIMIT) {
            $disp_no_change_password_hint = ceil((time() - strtotime($password_info[$custom_id]["update_date"])) / 86400);
        }
        $request->setAttribute("custom_login_info", $custom_login_info);
        $request->setAttribute("safety_question_resetable_flg", $safety_question_resetable_flg);
        $request->setAttribute("disp_no_change_password_hint", $disp_no_change_password_hint);
        return VIEW_DONE;
    }
}
?>