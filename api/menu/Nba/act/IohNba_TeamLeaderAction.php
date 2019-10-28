<?php

/**
 * NBA球队数据王
 * @author Kinsama
 * @version 2019-010-29
 */
class IohNba_TeamLeaderAction
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
                $error_message = "Database error";
            } else {
                $error_message = $exec_result->getMessage();
            }
            $result["error"] = 1;
            $result["err_msg"] = $error_message;
            $exec_result->writeLog();
        } else {
            $result["data"] = $exec_result;
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
        if (!$request->hasParameter("year")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Game season is invalid.");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        if (!$request->hasParameter("id")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Team ID is invalid.");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        if (!$request->hasParameter("stage")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Season stage is invalid.");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $t_id = $request->getParameter("id");
        $game_season = $request->getParameter("year");
        $game_season_stage = $request->getParameter("stage");
        $team_game_played_info = IohNbaStatsDBI::selectTeamGamePlayed($game_season, $game_season_stage);
        if ($controller->isError($team_game_played_info)) {
            $team_game_played_info->setPos(__FILE__, __LINE__);
            return $team_game_played_info;
        }
        $game_played = 0;
        if (isset($team_game_played_info[$t_id])) {
            $game_played = count($team_game_played_info[$t_id]);
        }
        $team_leader_info = array();
        if ($game_played > 0) {
            $team_leader_list = IohNbaStatsDBI::selectTeamLeader($t_id, $game_season, $game_season_stage);
            if ($controller->isError($team_leader_list)) {
                $team_leader_list->setPos(__FILE__, __LINE__);
                return $team_leader_list;
            }
Utility::testVariable($team_leader_list);
        }
        return array(
            "leader" => $team_leader_info
        );
    }
}
?>