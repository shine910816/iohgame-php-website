<?php

/**
 * 修改个人信息画面
 * @author Kinsama
 * @version 2018-12-13
 */
class IohUser_ChangeInfoAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("do_change")) {
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
        $custom_id = $user->getVariable("custom_id");
        $custom_info = IohCustomDBI::selectCustomInfo($custom_id);
        if ($controller->isError($custom_info)) {
            $custom_info->setPos(__FILE__, __LINE__);
            return $custom_info;
        }
        if (empty($custom_info)) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $confirm_flg = false;
        if ($custom_info["confirm_flg"] == IohCustomEntity::CUSTON_INFO_CONFIRM_YES) {
            $confirm_flg = true;
        }
        $open_level_list = IohCustomEntity::getOpenLevelList();
        $update_info = array();
        if ($request->hasParameter("do_change")) {
            if (!$request->hasParameter("custom_info")) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $got_custom_info = $request->getParameter("custom_info");
            if (!(isset($got_custom_info["open_level"]) && Validate::checkAcceptParam($got_custom_info["open_level"], array_keys($open_level_list)))) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $update_info["open_level"] = $got_custom_info["open_level"];
            if (!$confirm_flg) {
                $gender_opt = array(
                    IohCustomEntity::CUSTOM_GENDER_FEMALE,
                    IohCustomEntity::CUSTOM_GENDER_MALE
                );
                if (!(isset($got_custom_info["custom_gender"]) && Validate::checkAcceptParam($got_custom_info["custom_gender"], $gender_opt))) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                $update_info["custom_gender"] = $got_custom_info["custom_gender"];
                if (!isset($got_custom_info["custom_birth"])) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                $got_custom_birth = new DateTime($got_custom_info["custom_birth"]);
                if (!Validate::checkDate($got_custom_birth->format("Y"), $got_custom_birth->format("n"), $got_custom_birth->format("j"))) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                $update_info["custom_birth"] = $got_custom_birth->format("Y-m-d");
            }
        }
        $request->setAttribute("custom_gender", $custom_info["custom_gender"]);
        $request->setAttribute("custom_birth", $custom_info["custom_birth"]);
        $request->setAttribute("open_level", $custom_info["open_level"]);
        $request->setAttribute("confirm_flg", $confirm_flg);
        $request->setAttribute("open_level_list", $open_level_list);
        $request->setAttribute("update_info", $update_info);
        return VIEW_NONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }

    private function _doChangeExecute(Controller $controller, User $user, Request $request)
    {
        $update_info = $request->getAttribute("update_info");
        $update_data = array();
        $update_data["open_level"] = $update_info["open_level"];
        if (!$request->getAttribute("confirm_flg")) {
            $update_data["confirm_flg"] = IohCustomEntity::CUSTON_INFO_CONFIRM_YES;
            $update_data["custom_gender"] = $update_info["custom_gender"];
            $update_data["custom_birth"] = $update_info["custom_birth"];
        }
        $update_res = IohCustomDBI::updateInfo($update_data, "custom_id = " . $user->getVariable("custom_id"));
        if ($controller->isError($update_res)) {
            $update_res->setPos(__FILE__, __LINE__);
            return $update_res;
        }
        $controller->redirect("./?menu=user&act=disp");
        return VIEW_NONE;
    }
}
?>