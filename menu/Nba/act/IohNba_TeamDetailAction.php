<?php

/**
 * Object NBA球队详细
 * @author Kinsama
 * @version 2019-02-18
 */
class IohNba_TeamDetailAction extends ActionBase
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
        if (!$request->hasParameter("t_id")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $t_id = $request->getParameter("t_id");
        $latest_game_info = IohNbaStatsDBI::selectLatestGameDate();
        if ($controller->isError($latest_game_info)) {
            $latest_game_info->setPos(__FILE__, __LINE__);
            return $latest_game_info;
        }
        $request->setAttribute("t_id", $t_id);
        $request->setAttribute("game_season", $latest_game_info["game_season"]);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $t_id = $request->getAttribute("t_id");
        $game_season = $request->getAttribute("game_season");
        $json_array = Utility::transJson(SYSTEM_API_HOST . "nba/team/?year=" . $game_season . "&id=" . $t_id);
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
        Utility::testVariable($json_data);
        return VIEW_DONE;
    }
}
?>