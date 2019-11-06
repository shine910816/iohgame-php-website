<?php

/**
 * NBA赛季数据王
 * @author Kinsama
 * @version 2019-04-21
 */
class IohNba_LeaderSeasonPlayerAction
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
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Play season is invalid.");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        if (!$request->hasParameter("stage")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Play season stage is invalid.");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        if (!$request->hasParameter("opt")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Stats option is invalid.");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $game_season = $request->getParameter("year");
        $game_season_stage = $request->getParameter("stage");
        $stats_option = $request->getParameter("opt");
        if (!Validate::checkDate(substr($game_season, 0, 4), 1, 1)) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Game date is invalid.");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $option_list = array(
            "ppg",
            "rpg",
            "apg",
            "spg",
            "bpg",
            "fgp",
            "tpp",
            "ftp"
        );
        if (!Validate::checkAcceptParam($stats_option, $option_list)) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Stats option is invalid.");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $season_player_leader = array();
        $value_list = array();
        $sort_list = array();
        if ($stats_option == "fgp") {
            return array();
        } elseif ($stats_option == "tpp") {
            return array();
        } elseif ($stats_option == "ftp") {
            return array();
        } else {
            $season_player_stats = IohNbaStatsDBI::selectSeasonStats($game_season, $game_season_stage);
            if ($controller->isError($season_player_stats)) {
                $season_player_stats->setPos(__FILE__, __LINE__);
                return $season_player_stats;
            }
            $team_played_info = IohNbaStatsDBI::selectTeamGamePlayed($game_season, $game_season_stage);
            if ($controller->isError($team_played_info)) {
                $team_played_info->setPos(__FILE__, __LINE__);
                return $team_played_info;
            }
            foreach ($season_player_stats as $p_id => $player_info) {
                if ($player_info["game_played"] >= $team_played_info[$player_info["t_id"]] * 0.7) {
                    $stats_value = 0;
                    if ($stats_option == "bpg" || $stats_option == "spg") {
                        $stats_value = sprintf("%.2f", $player_info[$stats_option] / $player_info["game_played"]);
                    } else {
                        $stats_value = sprintf("%.1f", $player_info[$stats_option] / $player_info["game_played"]);
                    }
                    $sort_value = sprintf("%.2f", $player_info["sort"] / $player_info["game_played"]);
                    $season_player_leader[$p_id] = array(
                        "p_id" => $p_id,
                        "t_id" => $player_info["t_id"],
                        "value" => $stats_value
                    );
                    $value_list[$p_id] = $stats_value;
                    $sort_list[$p_id] = $sort_value;
                }
            }
        }
        array_multisort(
            $value_list, SORT_DESC,
            $sort_list, SORT_DESC,
            $season_player_leader
        );
        $season_player_leader = array_chunk($season_player_leader, 20, true);
        $season_player_leader = $season_player_leader[0];
        $result = array();
        foreach ($season_player_leader as $player_info) {
            $result[$player_info["p_id"]] = $player_info;
        }
        $team_info_list = IohNbaDBI::getTeamList();
        if ($controller->isError($team_info_list)) {
            $team_info_list->setPos(__FILE__, __LINE__);
            return $team_info_list;
        }
        $player_info_list = IohNbaDBI::selectPlayer(array_keys($result));
        if ($controller->isError($player_info_list)) {
            $player_info_list->setPos(__FILE__, __LINE__);
            return $player_info_list;
        }
        $rank = 1;
        foreach ($result as $p_id => $player_info) {
            $result[$p_id]["rank"] = $rank;
            $result[$p_id]["player_name"] = "Undefine";
            $result[$p_id]["team_name"] = "Undefine";
            $result[$p_id]["team_color"] = "000000";
            if (isset($player_info_list[$p_id])) {
                if ($player_info_list[$p_id]["p_name_cnf_flg"]) {
                    $result[$p_id]["player_name"] = $player_info_list[$p_id]["p_name"];
                } else {
                    $result[$p_id]["player_name"] = $player_info_list[$p_id]["p_first_name"] . " " . $player_info_list[$p_id]["p_last_name"];
                }
            }
            $t_id = $player_info["t_id"];
            if (isset($team_info_list[$t_id])) {
                $result[$p_id]["team_name"] = $team_info_list[$t_id]["t_name_cn"];
                $result[$p_id]["team_color"] = $team_info_list[$t_id]["t_color"];
            }
            $rank++;
        }
        return $result;
    }
}
?>