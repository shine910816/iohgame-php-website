<?php

/**
 * Object NBA球员
 * @author Kinsama
 * @version 2019-03-14
 */
class IohNba_PlayerListAction extends ActionBase
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
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $json_player_list = Utility::transJson(SYSTEM_API_HOST . "nba/player/");
        if ($json_player_list["error"]) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, $json_player_list["err_msg"]);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $request->setAttribute("player_list", $json_player_list["data"]);
        return VIEW_DONE;
    }
}
?>