<?php

/**
 * 用户注册画面
 * @author Kinsama
 * @version 2018-09-18
 */
class IohUser_RegisterAction extends ActionBase
{

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
        } elseif ($request->hasParameter("go_to_next")) {
            $ret = $this->_doRegisterExecute($controller, $user, $request);
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
        $custom_login_name = "";
        $custom_password = "";
        $custom_tele_number = "";
        $custom_mail_address = "";
        if ($request->hasParameter("go_to_next")) {
            $custom_login_name = $request->getParameter("custom_login_name");
            $custom_password = $request->getParameter("custom_password");
            $custom_password_confirm = $request->getParameter("custom_password_confirm");
            $custom_tele_number = $request->getParameter("custom_tele_number");
            $custom_mail_address = $request->getParameter("custom_mail_address");
            $login_name_res = IohCustomDBI::selectCustomByName($custom_login_name);
            if ($controller->isError($login_name_res)) {
                $login_name_res->setPos(__FILE__, __LINE__);
                return $login_name_res;
            }
            if (!Validate::checkNotEmpty($custom_login_name)) {
                $request->setError("custom_login_name", "请填写登录名");
            } elseif (!preg_match("/^[\w\d_]{4,50}$/i", $custom_login_name)) {
                $request->setError("custom_login_name", "登录名不符合规范");
            } elseif (!empty($login_name_res)) {
                $request->setError("custom_login_name", "登录名已经被注册");
            }
            if (!Validate::checkNotEmpty($custom_password)) {
                $request->setError("custom_password", "请填写密码");
            } elseif (Utility::getPasswordSecurityLevel($custom_password) < 1) {
                $request->setError("custom_password", "登录密码不符合规范");
            } elseif (!Validate::checkNotEmpty($custom_password_confirm)) {
                $request->setError("custom_password", "请确认密码");
            } elseif (md5($custom_password) !== md5($custom_password_confirm)) {
                $request->setError("custom_password", "两次输入的密码不一致");
            }
            if (!empty($custom_tele_number)) {
                $tel_res = IohCustomDBI::selectCustomByTel($custom_tele_number);
                if ($controller->isError($tel_res)) {
                    $tel_res->setPos(__FILE__, __LINE__);
                    return $tel_res;
                }
                if (!Validate::checkMobileNumber($custom_tele_number)) {
                    $request->setError("custom_tele_number", "请填写有效的手机号码");
                } elseif (!empty($tel_res)) {
                    $request->setError("custom_tele_number", "手机号码已经被注册");
                }
            }
            if (!empty($custom_mail_address)) {
                $mail_res = IohCustomDBI::selectCustomByMail($custom_mail_address);
                if ($controller->isError($mail_res)) {
                    $mail_res->setPos(__FILE__, __LINE__);
                    return $mail_res;
                }
                if (!Validate::checkMailAddress($custom_mail_address)) {
                    $request->setError("custom_mail_address", "请填写有效的邮箱地址");
                } elseif (!empty($mail_res)) {
                    $request->setError("custom_mail_address", "邮箱地址已经被注册");
                }
            }
        }
        $request->setAttribute("custom_login_name", $custom_login_name);
        $request->setAttribute("custom_password", $custom_password);
        $request->setAttribute("custom_tele_number", $custom_tele_number);
        $request->setAttribute("custom_mail_address", $custom_mail_address);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }

    private function _doRegisterExecute(Controller $controller, User $user, Request $request)
    {
        $custom_login_name = $request->getAttribute("custom_login_name");
        $custom_password = $request->getAttribute("custom_password");
        $custom_tele_number = $request->getAttribute("custom_tele_number");
        $custom_mail_address = $request->getAttribute("custom_mail_address");
        $salt = Utility::transSalt();
        $login_insert = array(
            "custom_login_name" => $custom_login_name,
            "custom_tele_number" => $custom_tele_number,
            "custom_mail_address" => $custom_mail_address,
            "custom_salt" => $salt["code"],
            "custom_tele_flg" => IohCustomEntity::TELE_CONFIRM_NO,
            "custom_mail_flg" => IohCustomEntity::MAIL_CONFIRM_NO
        );
        $password_insert = array(
            "custom_password" => md5($salt["salt1"] . $custom_password . $salt["salt2"])
        );
        $info_insert = array(
            "custom_nick" => $custom_login_name,
            "custom_gender" => IohCustomEntity::CUSTOM_GENDER_FEMALE,
            "custom_birth" => "1990-01-01",
            "confirm_flg" => IohCustomEntity::CUSTON_INFO_CONFIRM_NO,
            "open_level" => IohCustomEntity::CUSTOM_OPEN_LEVEL_TOTAL
        );
        $point_insert = array(
            "custom_point" => "0"
        );
        $dbi = Database::getInstance();
        $begin_res = $dbi->begin();
        if ($dbi->isError($begin_res)) {
            $dbi->rollback();
            $begin_res->setPos(__FILE__, __LINE__);
            return $begin_res;
        }
        $custom_id = IohCustomDBI::insertLogin($login_insert);
        if ($dbi->isError($custom_id)) {
            $dbi->rollback();
            $custom_id->setPos(__FILE__, __LINE__);
            return $custom_id;
        }
        $password_insert["custom_id"] = $custom_id;
        $password_res = IohCustomDBI::insertPassword($password_insert);
        if ($dbi->isError($password_res)) {
            $dbi->rollback();
            $password_res->setPos(__FILE__, __LINE__);
            return $password_res;
        }
        $info_insert["custom_id"] = $custom_id;
        $info_res = IohCustomDBI::insertInfo($info_insert);
        if ($dbi->isError($info_res)) {
            $dbi->rollback();
            $info_res->setPos(__FILE__, __LINE__);
            return $info_res;
        }
        $point_insert["custom_id"] = $custom_id;
        $point_res = IohPointDBI::insertPoint($point_insert);
        if ($dbi->isError($point_res)) {
            $dbi->rollback();
            $point_res->setPos(__FILE__, __LINE__);
            return $point_res;
        }
        $commit_res = $dbi->commit();
        if ($dbi->isError($commit_res)) {
            $dbi->rollback();
            $commit_res->setPos(__FILE__, __LINE__);
            return $commit_res;
        }
        $user->setVariable("custom_id", $custom_id);
        $user->setVariable("custom_nick", $custom_login_name);
        $user->setVariable("admin_lvl", "0");
        $event_info = IohEventDBI::selectPassiveEvent(date("Y-m-d H:i:s"));
        if ($controller->isError($event_info)) {
            $event_info->setPos(__FILE__, __LINE__);
            return $event_info;
        }
        if (!empty($event_info)) {
            foreach ($event_info as $event_number => $event_item_info) {
                if ($event_number == "2AC08D0A-9154-0D21-BA12-299FA6E7A78A") {
                    $xml_trans_obj = Translate::getInstance();
                    $register_present_xml = SYSTEM_API_HOST . "event/2AC08D0A-9154-0D21-BA12-299FA6E7A78A/?k=" . $custom_id;
                    $register_present = $xml_trans_obj->transXMLToArray($register_present_xml);
                }
            }
        }
        $controller->redirect("./?menu=user&act=disp");
        return VIEW_NONE;
    }

    private function _doErrorExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }
}
?>