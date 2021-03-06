<?php

/**
 * Object NBA球员详细
 * @author Kinsama
 * @version 2019-03-14
 */
class IohNba_PlayerDetailAction extends ActionBase
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
        $p_id = 0;
        if (!$request->hasParameter("p_id")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $p_id = $request->getParameter("p_id");
        $json_player_list = Utility::transJson(SYSTEM_API_HOST . "nba/player/?only=1");
        if ($json_player_list["error"]) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, $json_player_list["err_msg"]);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $display_flg = true;
        if (!in_array($p_id, $json_player_list["data"])) {
            $display_flg = false;
        }
        $latest_game_info = IohNbaStatsDBI::selectLatestGameDate();
        if ($controller->isError($latest_game_info)) {
            $latest_game_info->setPos(__FILE__, __LINE__);
            return $latest_game_info;
        }
        $request->setAttribute("p_id", $p_id);
        $request->setAttribute("game_season", $latest_game_info["game_season"]);
        $request->setAttribute("game_season_stage", $latest_game_info["game_season_stage"]);
        $request->setAttribute("player_display_flg", $display_flg);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $p_id = $request->getAttribute("p_id");
        $game_season = $request->getAttribute("game_season");
        $game_season_stage = $request->getAttribute("game_season_stage");
        $player_display_flg = $request->getAttribute("player_display_flg");
        if ($player_display_flg) {
            $json_array = Utility::transJson(SYSTEM_API_HOST . "nba/player/info/?year=" . $game_season . "&stage=" . $game_season_stage . "&id=" . $p_id);
            if ($json_array["error"]) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, $json_array["err_msg"]);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $player_base_info = $json_array["data"]["base"];
            $player_stats_info = $json_array["data"]["stats"];
            $player_last5_info = $json_array["data"]["last5"];
            // Getting leader info
            $player_leader_info = array(
                "ppg" => 0,
                "rpg" => 0,
                "apg" => 0
            );
            $json_leader_ppg_array = Utility::transJson(SYSTEM_API_HOST . "nba/leader/player/season/?year=" . $game_season . "&stage=" . $game_season_stage . "&opt=ppg&only=1");
            if ($json_leader_ppg_array["error"]) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, $json_leader_ppg_array["err_msg"]);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            if (isset($json_leader_ppg_array["data"][$p_id])) {
                $player_leader_info["ppg"] = $json_leader_ppg_array["data"][$p_id]["rank"];
            }
            $json_leader_rpg_array = Utility::transJson(SYSTEM_API_HOST . "nba/leader/player/season/?year=" . $game_season . "&stage=" . $game_season_stage . "&opt=rpg&only=1");
            if ($json_leader_rpg_array["error"]) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, $json_leader_rpg_array["err_msg"]);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            if (isset($json_leader_rpg_array["data"][$p_id])) {
                $player_leader_info["rpg"] = $json_leader_rpg_array["data"][$p_id]["rank"];
            }
            $json_leader_apg_array = Utility::transJson(SYSTEM_API_HOST . "nba/leader/player/season/?year=" . $game_season . "&stage=" . $game_season_stage . "&opt=apg&only=1");
            if ($json_leader_apg_array["error"]) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, $json_leader_apg_array["err_msg"]);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            if (isset($json_leader_apg_array["data"][$p_id])) {
                $player_leader_info["apg"] = $json_leader_apg_array["data"][$p_id]["rank"];
            }
            $stage_list = array(
                "0" => "",
                "1" => "季前赛",
                "2" => "常规赛",
                "4" => "季后赛"
            );
            $stats_title = sprintf("%s-%s%s", $game_season, $game_season - 1999, $stage_list[$game_season_stage]);
            $leader_stats_info = IohNbaStatsDBI::selectLeaderStats($game_season, $game_season_stage);
            if ($controller->isError($leader_stats_info)) {
                $leader_stats_info->setPos(__FILE__, __LINE__);
                return $leader_stats_info;
            }
            $stats_tmp = array(
                $player_stats_info["ppg"],
                $player_stats_info["rpg"],
                $player_stats_info["apg"],
                $player_stats_info["spg"],
                $player_stats_info["bpg"]
            );
            $chart_send_info = array(
                "stats" => implode(",", $stats_tmp),
                "maximum" => str_replace("00", "", implode(",", $leader_stats_info)),
                "color" => $player_base_info["color"]
            );
            $chart_send_text = Utility::encodeCookieInfo($chart_send_info);
            $request->setAttribute("player_base_info", $player_base_info);
            $request->setAttribute("stats_title", $stats_title);
            $request->setAttribute("chart_send_text", $chart_send_text);
            $request->setAttribute("player_stats_info", $player_stats_info);
            $request->setAttribute("player_last5_info", $player_last5_info);
            $request->setAttribute("player_leader_info", $player_leader_info);
        }
        return VIEW_DONE;
    }
}
?>