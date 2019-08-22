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
        $request->setAttribute("custom_info", $custom_info[$custom_id]);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $custom_id = $request->getAttribute("custom_id");
        $custom_info = $request->getAttribute("custom_info");
        $open_flg = false;
        if ($custom_info["open_level"] == IohCustomEntity::CUSTOM_OPEN_LEVEL_TOTAL) {
            $open_flg = true;
        } elseif ($custom_info["open_level"] == IohCustomEntity::CUSTOM_OPEN_LEVEL_FRIEND) {
            if ($user->isLogin()) {
                $json_array = Utility::transJson(SYSTEM_API_HOST . "?act=friend_list");
                if ($controller->isError($json_array)) {
                    $json_array->setPos(__FILE__, __LINE__);
                    return $json_array;
                }
                if ($json_array["error"]) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, $json_array["err_msg"]);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                $json_data = $json_array["data"];
                if ($json_data["login"]) {
                    if (in_array($user->getCustomId(), $json_data["list"][0])) {
                        $open_flg = true;
                    }
                }
            }
        }
        
//Utility::testVariable($custom_info);
        $request->setAttribute("open_flg", $open_flg);
        return VIEW_DONE;
    }
}
?>