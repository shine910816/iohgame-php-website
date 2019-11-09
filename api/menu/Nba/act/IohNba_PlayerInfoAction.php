<?php

/**
 * NBA球员列表
 * @author Kinsama
 * @version 2019-11-07
 */
class IohNba_PlayerInfoAction
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
        if (!$request->hasParameter("id")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Player ID is invalid.");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        if (!$request->hasParameter("year")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Game season is invalid.");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        if (!$request->hasParameter("stage")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Game season stage is invalid.");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $p_id = $request->getParameter("id");
        $game_season = $request->getParameter("year");
        $game_season_stage = $request->getParameter("stage");
        $player_info = IohNbaDBI::selectPlayer($p_id);
        if ($controller->isError($player_info)) {
            $player_info->setPos(__FILE__, __LINE__);
            return $player_info;
        }
        if (!isset($player_info[$p_id])) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Player ID is invalid.");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $team_list = IohNbaDBI::getTeamList();
        if ($controller->isError($team_list)) {
            $team_list->setPos(__FILE__, __LINE__);
            return $team_list;
        }
        $player_base_info = array();
        if ($player_info[$p_id]["p_name_cnf_flg"]) {
            $player_base_info["name"] = $player_info[$p_id]["p_name"];
        } else {
            $player_base_info["name"] = $player_info[$p_id]["p_first_name"] . " " . $player_info[$p_id]["p_last_name"];
        }
        $player_base_info["name_en"] = $player_info[$p_id]["p_first_name"] . " " . $player_info[$p_id]["p_last_name"];
        $position_list = array(
            "1" => "中锋",
            "2" => "前锋",
            "3" => "后卫"
        );
        $player_base_info["pos"] = $position_list[$player_info[$p_id]["p_position"]];
        if ($player_info[$p_id]["p_position_2"]) {
            $player_base_info["pos"] .= "-" . $position_list[$player_info[$p_id]["p_position_2"]];
        }
        $player_base_info["jersey"] = $player_info[$p_id]["p_jersey"];
        $player_base_info["t_id"] = $player_info[$p_id]["t_id"];
        $player_base_info["team"] = "Undefined";
        $player_base_info["color"] = "000000";
        if (isset($team_list[$player_info[$p_id]["t_id"]])) {
            $player_base_info["team"] = $team_list[$player_info[$p_id]["t_id"]]["t_city_cn"] . $team_list[$player_info[$p_id]["t_id"]]["t_name_cn"];
            $player_base_info["color"] = $team_list[$player_info[$p_id]["t_id"]]["t_color"];
        }
        $player_stats_info = array(
            "gp" => 0,
            "gs" => 0,
            "mpg" => 0,
            "ppg" => 0,
            "rpg" => 0,
            "apg" => 0,
            "spg" => 0,
            "bpg" => 0,
            "fgp" => "-",
            "tpp" => "-",
            "ftp" => "-",
            "opg" => 0,
            "dpg" => 0,
            "pfpg" => 0,
            "topg" => 0,
            "pmpg" => "-",
            "dd2" => 0,
            "td3" => 0
        );
        $player_stats_list = IohNbaStatsDBI::selectPlayerSeasonStats($p_id, $game_season, $game_season_stage);
        if ($controller->isError($player_stats_list)) {
            $player_stats_list->setPos(__FILE__, __LINE__);
            return $player_stats_list;
        }
        $player_gs_list = IohNbaStatsDBI::selectPlayerGameStart($p_id, $game_season, $game_season_stage);
        if ($controller->isError($player_gs_list)) {
            $player_gs_list->setPos(__FILE__, __LINE__);
            return $player_gs_list;
        }
        $player_dd2_list = IohNbaStatsDBI::selectPlayerDoubleDouble($p_id, $game_season, $game_season_stage);
        if ($controller->isError($player_dd2_list)) {
            $player_dd2_list->setPos(__FILE__, __LINE__);
            return $player_dd2_list;
        }
        $player_td3_list = IohNbaStatsDBI::selectPlayerTribleDouble($p_id, $game_season, $game_season_stage);
        if ($controller->isError($player_td3_list)) {
            $player_td3_list->setPos(__FILE__, __LINE__);
            return $player_td3_list;
        }
//Utility::testVariable($player_gs_list);
        if (isset($player_stats_list[$p_id])) {
            $game_played = $player_stats_list[$p_id]["gp"];
            $player_stats_info["gp"] = $game_played;
            $total_minutes = $player_stats_list[$p_id]["min"] * 60 + $player_stats_list[$p_id]["sec"];
            $player_stats_info["mpg"] = sprintf("%.1f", $total_minutes / 60 / $game_played);
            $player_stats_info["ppg"] = sprintf("%.1f", $player_stats_list[$p_id]["pts"] / $game_played);
            $player_stats_info["rpg"] = sprintf("%.1f", $player_stats_list[$p_id]["reb"] / $game_played);
            $player_stats_info["apg"] = sprintf("%.1f", $player_stats_list[$p_id]["ast"] / $game_played);
            $player_stats_info["spg"] = sprintf("%.2f", $player_stats_list[$p_id]["stl"] / $game_played);
            $player_stats_info["bpg"] = sprintf("%.2f", $player_stats_list[$p_id]["blk"] / $game_played);
            $player_stats_info["opg"] = sprintf("%.1f", $player_stats_list[$p_id]["off"] / $game_played);
            $player_stats_info["dpg"] = sprintf("%.1f", $player_stats_list[$p_id]["def"] / $game_played);
            $player_stats_info["pfpg"] = sprintf("%.1f", $player_stats_list[$p_id]["pf"] / $game_played);
            $player_stats_info["topg"] = sprintf("%.1f", $player_stats_list[$p_id]["to"] / $game_played);
            $player_stats_info["pmpg"] = sprintf("%.1f", $player_stats_list[$p_id]["pm"] / $game_played);
            if ($player_stats_list[$p_id]["fga"] > 0) {
                $player_stats_info["fgp"] = sprintf("%.1f", $player_stats_list[$p_id]["fgm"] / $player_stats_list[$p_id]["fga"] * 100) . "%";
            }
            if ($player_stats_list[$p_id]["tpa"] > 0) {
                $player_stats_info["tpp"] = sprintf("%.1f", $player_stats_list[$p_id]["tpm"] / $player_stats_list[$p_id]["tpa"] * 100) . "%";
            }
            if ($player_stats_list[$p_id]["fta"] > 0) {
                $player_stats_info["ftp"] = sprintf("%.1f", $player_stats_list[$p_id]["ftm"] / $player_stats_list[$p_id]["fta"] * 100) . "%";
            }
        }
        if (isset($player_gs_list[$p_id])) {
            $player_stats_info["gs"] = $player_gs_list[$p_id];
        }
        if (isset($player_dd2_list[$p_id])) {
            $player_stats_info["dd2"] = $player_dd2_list[$p_id];
        }
        if (isset($player_td3_list[$p_id])) {
            $player_stats_info["td3"] = $player_td3_list[$p_id];
        }
        return array(
            "base" => $player_base_info,
            "stats" => $player_stats_info
        );
    }
}
?>