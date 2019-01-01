<?php
require_once SRC_PATH . "/library/security/IohSecurityCommon.php";

/**
 * 用户登录登出画面
 * @author Kinsama
 * @version 2017-01-09
 */
class IohUser_GetbackPasswordAction
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
        } elseif ($request->getAttribute("progress_step") == 5) {
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
        $progress_step = 1;
        if ($request->hasParameter("do_confirm")) {
            $progress_step = 2;
        } elseif ($request->hasParameter("do_select")) {
            $progress_step = 3;
        } elseif ($request->hasParameter("do_verify")) {
            $progress_step = 4;
        } elseif ($request->hasParameter("do_complete")) {
            $progress_step = 5;
        }
        $request->setAttribute("progress_step", $progress_step);
        $session_data = array();
        if ($progress_step == 1) {
            if (!$user->hasVariable(USER_GETBACK_PASSWORD)) {
                $session_data = array(
                    "custom_account" => "",
                    "custom_id" => "0",
                    "custom_security_type" => "1",
                    "custom_selected_question_id" => "0",
                    "custom_verify_passed" => false
                );
                $user->setVariable(USER_GETBACK_PASSWORD, $session_data);
            }
            return VIEW_DONE;
        }
        if ($progress_step == 2) {
            if (!$user->hasVariable(USER_GETBACK_PASSWORD)) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $session_data = $user->getVariable(USER_GETBACK_PASSWORD);
            $custom_id = "0";
            if ($request->getParameter("do_confirm") == "next") {
                if (!$request->hasParameter("custom_account")) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                $custom_account = $request->getParameter("custom_account");
                $session_data["custom_account"] = $custom_account;
                $user->setVariable(USER_GETBACK_PASSWORD, $session_data);
                if (strlen($custom_account) == 0) {
                    $request->setError("custom_account", "请输入用户名");
                    return VIEW_NONE;
                }
                $login_info = IohCustomDBI::selectCustomByName($custom_account);
                if ($controller->isError($login_info)) {
                    $login_info->setPos(__FILE__, __LINE__);
                    return $login_info;
                }
                if (empty($login_info)) {
                    $request->setError("custom_account", "用户名不存在");
                    return VIEW_NONE;
                }
                $custom_id = $login_info["custom_id"];
                $session_data["custom_id"] = $custom_id;
                $user->setVariable(USER_GETBACK_PASSWORD, $session_data);
            } else {
                $custom_id = $session_data["custom_id"];
                $session_data["custom_selected_question_id"] = "0";
                $user->setVariable(USER_GETBACK_PASSWORD, $session_data);
            }
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
            $request->setAttribute("security_able_tele", $custom_login_info[$custom_id]["custom_tele_flg"] == IohCustomEntity::TELE_CONFIRM_YES);
            $request->setAttribute("security_able_mail", $custom_login_info[$custom_id]["custom_mail_flg"] == IohCustomEntity::MAIL_CONFIRM_YES);
            return VIEW_DONE;
        }
        if ($progress_step == 3) {
            if (!$user->hasVariable(USER_GETBACK_PASSWORD)) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $session_data = $user->getVariable(USER_GETBACK_PASSWORD);
            if (!($request->hasParameter("security_type") && Validate::checkAcceptParam($request->getParameter("security_type"), array("1", "2", "3")))) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $custom_security_type = $request->getParameter("security_type");
            $session_data["custom_security_type"] = $custom_security_type;
            $user->setVariable(USER_GETBACK_PASSWORD, $session_data);
            $custom_id = $session_data["custom_id"];
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
            $count_down_start = 60;
            if ($custom_security_type == "2") {
                if (strlen($custom_login_info[$custom_id]["custom_tele_number"]) == 0 ||
                    $custom_login_info[$custom_id]["custom_tele_flg"] == IohCustomEntity::TELE_CONFIRM_NO) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                $custom_tele_number = $custom_login_info[$custom_id]["custom_tele_number"];
                $request->setAttribute("saved_tele_number", substr($custom_tele_number, 0, 2) . str_repeat("*", 7) . substr($custom_tele_number, -2));
                $this->_common = IohSecurityCommon::getInstance(IohSecurityCommon::GETBACK_TELE);
                $count_down_start = $this->_common->getCountDownStart();
                if ($controller->isError($count_down_start)) {
                    $count_down_start->setPos(__FILE__, __LINE__);
                    return $count_down_start;
                }
            } elseif ($custom_security_type == "3") {
                if (strlen($custom_login_info[$custom_id]["custom_mail_address"]) == 0 ||
                    $custom_login_info[$custom_id]["custom_mail_flg"] == IohCustomEntity::MAIL_CONFIRM_NO) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                $custom_mail_address = $custom_login_info[$custom_id]["custom_mail_address"];
                $mail_arr = explode("@", $custom_mail_address);
                $request->setAttribute("saved_mail_address", substr($mail_arr[0], 0, 1) . str_repeat("*", strlen($mail_arr[0]) - 1) . "@" . $mail_arr[1]);
                $this->_common = IohSecurityCommon::getInstance(IohSecurityCommon::GETBACK_MAIL);
                $count_down_start = $this->_common->getCountDownStart();
                if ($controller->isError($count_down_start)) {
                    $count_down_start->setPos(__FILE__, __LINE__);
                    return $count_down_start;
                }
            } else {
                $question_info = IohSecurityQuestionDBI::selectByCustomId($custom_id);
                if ($controller->isError($question_info)) {
                    $question_info->setPos(__FILE__, __LINE__);
                    return $question_info;
                }
                $request->setAttribute("custom_question", array_keys($question_info));
            }
            $request->setAttribute("count_down_start", $count_down_start);
        }
        if ($progress_step == 4) {
            if (!$user->hasVariable(USER_GETBACK_PASSWORD)) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $session_data = $user->getVariable(USER_GETBACK_PASSWORD);
            $custom_id = $session_data["custom_id"];
            $custom_security_type = $session_data["custom_security_type"];
            $code_type = IohSecurityVerifycodeEntity::CODE_TYPE_MAILADDRESS;
            if ($custom_security_type == "1") {
                $code_type = IohSecurityVerifycodeEntity::CODE_TYPE_TELEPHONE;
                $question_info = IohSecurityQuestionDBI::selectByCustomId($custom_id);
                if ($controller->isError($question_info)) {
                    $question_info->setPos(__FILE__, __LINE__);
                    return $question_info;
                }
                if (!$request->hasParameter("select_safety_question")) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                if ($request->getParameter("select_safety_question") == "0") {
                    $request->setError("select_safety_question", "请选择一个安全问题");
                    return VIEW_NONE;
                }
                if (!Validate::checkAcceptParam($request->getParameter("select_safety_question"), array_keys($question_info))) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                $custom_question_id = $request->getParameter("select_safety_question");
                $session_data["custom_selected_question_id"] = $custom_question_id;
                $user->setVariable(USER_GETBACK_PASSWORD, $session_data);
                if (!$request->hasParameter("select_safety_answer")) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                if ($question_info[$custom_question_id]["answer"] != md5($request->getParameter("select_safety_answer"))) {
                    $request->setError("select_safety_answer", "安全问题的答案不正确");
                    return VIEW_NONE;
                }
            } else {
                if (!$request->hasParameter("verify_code")) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                $custom_login_info = IohCustomDBI::selectCustomById($custom_id);
                if ($controller->isError($custom_login_info)) {
                    $custom_login_info->setPos(__FILE__, __LINE__);
                    return $custom_login_info;
                }
                $target_number = "";
                if ($custom_security_type == "2") {
                    $this->_common = IohSecurityCommon::getInstance(IohSecurityCommon::GETBACK_TELE);
                    $target_number = $custom_login_info[$custom_id]["custom_tele_number"];
                } else {
                    $this->_common = IohSecurityCommon::getInstance(IohSecurityCommon::GETBACK_MAIL);
                    $target_number = $custom_login_info[$custom_id]["custom_mail_address"];
                }
                $this->_common->setCustomId($custom_id);
                $check_res = $this->_common->doCheckExecute($controller, $user, $request, $target_number);
                if ($controller->isError($check_res)) {
                    $check_res->setPos(__FILE__, __LINE__);
                    return $check_res;
                }
                if (!$check_res) {
                    return VIEW_NONE;
                }
            }
            $session_data["custom_verify_passed"] = true;
            $user->setVariable(USER_GETBACK_PASSWORD, $session_data);
            $free_res = IohSecurityCommon::freeVerifyCode($custom_id, $code_type);
            if ($controller->isError($free_res)) {
                $free_res->setPos(__FILE__, __LINE__);
                return $free_res;
            }
        }
        if ($progress_step == 5) {
            if (!$user->hasVariable(USER_GETBACK_PASSWORD)) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $session_data = $user->getVariable(USER_GETBACK_PASSWORD);
            if (!$session_data["custom_verify_passed"]) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            if (!$request->hasParameter("custom_password") || !$request->hasParameter("custom_password_confirm")) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $custom_password = $request->getParameter("custom_password");
            $custom_password_confirm = $request->getParameter("custom_password_confirm");
            if (!Validate::checkNotEmpty($custom_password)) {
                $request->setError("custom_password", "请输入新密码");
                return VIEW_NONE;
            } elseif (Utility::getPasswordSecurityLevel($custom_password) < 1) {
                $request->setError("custom_password", "登录密码不符合规范");
                return VIEW_NONE;
            } elseif (!Validate::checkNotEmpty($custom_password_confirm)) {
                $request->setError("custom_password", "请确认新密码");
                return VIEW_NONE;
            } elseif (md5($custom_password) !== md5($custom_password_confirm)) {
                $request->setError("custom_password", "两次输入的密码不一致");
                return VIEW_NONE;
            }
            $request->setAttribute("custom_password", $custom_password);
        }
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $session_data = $user->getVariable(USER_GETBACK_PASSWORD);
        $request->setAttribute("session_data", $session_data);
        $request->setAttribute("question_list", IohSecurityQuestionEntity::getQuestions());
        $request->setAttribute("selected_question_id", $session_data["custom_selected_question_id"]);
        return VIEW_DONE;
    }

    private function _doChangeExecute(Controller $controller, User $user, Request $request)
    {
        $custom_password = $request->getAttribute("custom_password");
        $session_data = $user->getVariable(USER_GETBACK_PASSWORD);
        $custom_id = $session_data["custom_id"];
        $salt = Utility::transSalt();
        $login_update = array(
            "custom_salt" => $salt["code"]
        );
        $password_update = array(
            "custom_password" => md5($salt["salt1"] . $custom_password . $salt["salt2"])
        );
        $where = "custom_id = " . $custom_id;
        $dbi = Database::getInstance();
        $begin_res = $dbi->begin();
        if ($dbi->isError($begin_res)) {
            $dbi->rollback();
            $begin_res->setPos(__FILE__, __LINE__);
            return $begin_res;
        }
        $login_res = IohCustomDBI::updateLogin($login_update, $where);
        if ($dbi->isError($login_res)) {
            $dbi->rollback();
            $login_res->setPos(__FILE__, __LINE__);
            return $login_res;
        }
        $pass_res = IohCustomDBI::updatePassword($password_update, $where);
        if ($dbi->isError($pass_res)) {
            $dbi->rollback();
            $pass_res->setPos(__FILE__, __LINE__);
            return $pass_res;
        }
        $commit_res = $dbi->commit();
        if ($dbi->isError($commit_res)) {
            $dbi->rollback();
            $commit_res->setPos(__FILE__, __LINE__);
            return $commit_res;
        }
        return VIEW_DONE;
    }

    private function _doErrorExecute(Controller $controller, User $user, Request $request)
    {
        $progress_step = $request->getAttribute("progress_step");
        $progress_step--;
        $session_data = $user->getVariable(USER_GETBACK_PASSWORD);
        $request->setAttribute("progress_step", $progress_step);
        $request->setAttribute("session_data", $session_data);
        $request->setAttribute("question_list", IohSecurityQuestionEntity::getQuestions());
        if ($progress_step == 3) {
            $custom_id = $session_data["custom_id"];
            if ($session_data["custom_security_type"] == "1") {
                $question_info = IohSecurityQuestionDBI::selectByCustomId($custom_id);
                if ($controller->isError($question_info)) {
                    $question_info->setPos(__FILE__, __LINE__);
                    return $question_info;
                }
                $request->setAttribute("custom_question", array_keys($question_info));
                $request->setAttribute("selected_question_id", $session_data["custom_selected_question_id"]);
            } else {
                $custom_login_info = IohCustomDBI::selectCustomById($custom_id);
                if ($controller->isError($custom_login_info)) {
                    $custom_login_info->setPos(__FILE__, __LINE__);
                    return $custom_login_info;
                }
                if ($session_data["custom_security_type"] == "2") {
                    if (strlen($custom_login_info[$custom_id]["custom_tele_number"]) == 0 ||
                        $custom_login_info[$custom_id]["custom_tele_flg"] == IohCustomEntity::TELE_CONFIRM_NO) {
                        $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                        $err->setPos(__FILE__, __LINE__);
                        return $err;
                    }
                    $custom_tele_number = $custom_login_info[$custom_id]["custom_tele_number"];
                    $request->setAttribute("saved_tele_number", substr($custom_tele_number, 0, 2) . str_repeat("*", 7) . substr($custom_tele_number, -2));
                } else {
                    if (strlen($custom_login_info[$custom_id]["custom_mail_address"]) == 0 ||
                        $custom_login_info[$custom_id]["custom_mail_flg"] == IohCustomEntity::MAIL_CONFIRM_NO) {
                        $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                        $err->setPos(__FILE__, __LINE__);
                        return $err;
                    }
                    $custom_mail_address = $custom_login_info[$custom_id]["custom_mail_address"];
                    $mail_arr = explode("@", $custom_mail_address);
                    $request->setAttribute("saved_mail_address", substr($mail_arr[0], 0, 1) . str_repeat("*", strlen($mail_arr[0]) - 1) . "@" . $mail_arr[1]);
                }
                $count_down_start = $this->_common->getCountDownStart();
                if ($controller->isError($count_down_start)) {
                    $count_down_start->setPos(__FILE__, __LINE__);
                    return $count_down_start;
                }
                $request->setAttribute("count_down_start", $count_down_start);
            }
        }
        return VIEW_DONE;
    }
}
?>