<?php

/**
 * Object NBA比赛详细
 * @author Kinsama
 * @version 2019-04-29
 */
class IohNba_GameDetailAction extends ActionBase
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
        if (!$request->hasParameter("game_id")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $game_id = $request->getParameter("game_id");
        $request->setAttribute("game_id", $game_id);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $game_id = $request->getAttribute("game_id");
        $json_array = Utility::transJson(SYSTEM_API_HOST . "nba/game/?id=" . $game_id);
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
        $request->setAttribute("game_info", $json_data["base"]);
        $request->setAttribute("team_info", $json_data["team"]);
        $request->setAttribute("boxscore_info", $json_data["box_score"]);
        $request->setAttribute("pbp_info", $json_data["play_by_play"]);
        return VIEW_DONE;
    }
}
?>