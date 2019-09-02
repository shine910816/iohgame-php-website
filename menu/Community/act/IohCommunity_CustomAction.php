<?php

/**
 * 社区用户画面
 * @author Kinsama
 * @version 2019-08-06
 */
class IohCommunity_CustomAction extends ActionBase
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
        $custom_id = "0";
        $self_flg = false;
        if ($request->hasParameter("custom_id")) {
            $custom_id = $request->getParameter("custom_id");
        } elseif ($request->hasParameter("self")) {
            if ($user->isLogin()) {
                $self_flg = true;
                $custom_id = $user->getCustomId();
            }
        }
        if (!$custom_id) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $custom_info = IohCustomDBI::selectCustomInfoById($custom_id, true);
        if ($controller->isError($custom_info)) {
            $custom_info->setPos(__FILE__, __LINE__);
            return $custom_info;
        }
        if (!isset($custom_info[$custom_id])) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $request->setAttribute("custom_id", $custom_id);
        $request->setAttribute("self_flg", $self_flg);
        $request->setAttribute("custom_info", $custom_info[$custom_id]);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $custom_id = $request->getAttribute("custom_id");
        $self_flg = $request->getAttribute("self_flg");
        $custom_info = $request->getAttribute("custom_info");
        $open_flg = false;


        $json_array = Utility::transJson(SYSTEM_API_HOST . "?act=friend_list&id=" . $custom_id);
        if ($controller->isError($json_array)) {
            $json_array->setPos(__FILE__, __LINE__);
            return $json_array;
        }
        if ($json_array["error"]) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, $json_array["err_msg"]);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $friend_list = $json_array["data"];


        if ($self_flg) {
            $open_flg = true;
        } else {
            if ($custom_info["open_level"] == IohCustomEntity::CUSTOM_OPEN_LEVEL_TOTAL) {
                $open_flg = true;
            } elseif ($custom_info["open_level"] == IohCustomEntity::CUSTOM_OPEN_LEVEL_FRIEND) {
                if ($user->isLogin() && in_array($user->getCustomId(), $friend_list["friend"])) {
                    $open_flg = true;
                }
            }
        }
//Utility::testVariable($open_flg ? "1" : "0");
Utility::testVariable($custom_id);
        $request->setAttribute("open_flg", $open_flg);
        return VIEW_DONE;
    }
}
?>