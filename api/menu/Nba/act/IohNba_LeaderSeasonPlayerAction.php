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
Utility::testVariable($season_player_stats);
        }
        //$daily_player_leader = IohNbaStatsDBI::selectDailyPlayerLeader($game_date, $stats_option);
        //if ($controller->isError($daily_player_leader)) {
        //    $daily_player_leader->setPos(__FILE__, __LINE__);
        //    return $daily_player_leader;
        //}
        //if (empty($daily_player_leader)) {
        //    return array();
        //}
        //$daily_player_leader = array_chunk($daily_player_leader, 20, true);
        //$daily_player_leader = $daily_player_leader[0];
        //$team_info_list = IohNbaDBI::getTeamList();
        //if ($controller->isError($team_info_list)) {
        //    $team_info_list->setPos(__FILE__, __LINE__);
        //    return $team_info_list;
        //}
        //$player_info_list = IohNbaDBI::selectPlayer(array_keys($daily_player_leader));
        //if ($controller->isError($player_info_list)) {
        //    $player_info_list->setPos(__FILE__, __LINE__);
        //    return $player_info_list;
        //}
        //$rank = 1;
        //foreach ($daily_player_leader as $p_id => $player_info) {
        //    $daily_player_leader[$p_id]["rank"] = $rank;
        //    $daily_player_leader[$p_id]["player_name"] = "Undefine";
        //    $daily_player_leader[$p_id]["team_name"] = "Undefine";
        //    $daily_player_leader[$p_id]["team_color"] = "000000";
        //    if (isset($player_info_list[$p_id])) {
        //        if (empty($player_info_list[$p_id]["p_name"])) {
        //            $daily_player_leader[$p_id]["player_name"] = $player_info_list[$p_id]["p_first_name"] . " " . $player_info_list[$p_id]["p_last_name"];
        //        } else {
        //            $daily_player_leader[$p_id]["player_name"] = $player_info_list[$p_id]["p_name"];
        //        }
        //    }
        //    $t_id = $player_info["t_id"];
        //    if (isset($team_info_list[$t_id])) {
        //        $daily_player_leader[$p_id]["team_name"] = $team_info_list[$t_id]["t_name_cn"];
        //        $daily_player_leader[$p_id]["team_color"] = $team_info_list[$t_id]["t_color"];
        //    }
        //    $rank++;
        //}
        //return $daily_player_leader;
    }
}
?>