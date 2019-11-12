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
        $t_id_list = explode(",", $request->getParameter("id"));
        $game_season = $request->getParameter("year");
        $game_season_stage = $request->getParameter("stage");
        $team_game_played_info = IohNbaStatsDBI::selectTeamGamePlayed($game_season, $game_season_stage);
        if ($controller->isError($team_game_played_info)) {
            $team_game_played_info->setPos(__FILE__, __LINE__);
            return $team_game_played_info;
        }
        $game_played_arr = array();
        foreach ($t_id_list as $t_id) {
            if (isset($team_game_played_info[$t_id]) && $team_game_played_info[$t_id] > 0) {
                $game_played_arr[$t_id] = $team_game_played_info[$t_id];
            }
        }
        $team_leader_info = array();
        if (count($game_played_arr) > 0) {
            $team_leader_list = IohNbaStatsDBI::selectTeamLeader(array_keys($game_played_arr), $game_season, $game_season_stage);
            if ($controller->isError($team_leader_list)) {
                $team_leader_list->setPos(__FILE__, __LINE__);
                return $team_leader_list;
            }
            if (!empty($team_leader_list)) {
                foreach ($team_leader_list as $t_id => $team_leader_player_info) {
                    if (!isset($team_leader_info[$t_id])) {
                        $team_leader_info[$t_id] = array(
                            "ppg" => array(
                                "p_id" => "0",
                                "value" => 0
                            ),
                            "rpg" => array(
                                "p_id" => "0",
                                "value" => 0
                            ),
                            "apg" => array(
                                "p_id" => "0",
                                "value" => 0
                            )
                        );
                    }
                    foreach ($team_leader_player_info as $p_id => $player_info) {
                        if ($player_info["pg"] >= $game_played_arr[$t_id] * 0.7) {
                            $ppg_value = sprintf("%.1f", $player_info["pts"] / $player_info["pg"]);
                            $rpg_value = sprintf("%.1f", $player_info["reb"] / $player_info["pg"]);
                            $apg_value = sprintf("%.1f", $player_info["ast"] / $player_info["pg"]);
                            if ($ppg_value > $team_leader_info[$t_id]["ppg"]["value"]) {
                                $team_leader_info[$t_id]["ppg"]["value"] = $ppg_value;
                                $team_leader_info[$t_id]["ppg"]["p_id"] = $p_id;
                            }
                            if ($rpg_value > $team_leader_info[$t_id]["rpg"]["value"]) {
                                $team_leader_info[$t_id]["rpg"]["value"] = $rpg_value;
                                $team_leader_info[$t_id]["rpg"]["p_id"] = $p_id;
                            }
                            if ($apg_value > $team_leader_info[$t_id]["apg"]["value"]) {
                                $team_leader_info[$t_id]["apg"]["value"] = $apg_value;
                                $team_leader_info[$t_id]["apg"]["p_id"] = $p_id;
                            }
                        }
                    }
                }
            }
        }
        return array(
            "leader" => $team_leader_info
        );
    }
}
?>