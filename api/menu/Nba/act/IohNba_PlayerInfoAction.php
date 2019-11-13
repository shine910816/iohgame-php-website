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
        $player_lastfive_info = array();
        $player_last_five_list = IohNbaStatsDBI::selectPlayerLastFiveStats($p_id, $game_season, $game_season_stage);
        if ($controller->isError($player_last_five_list)) {
            $player_last_five_list->setPos(__FILE__, __LINE__);
            return $player_last_five_list;
        }
        if (!empty($player_last_five_list)) {
            $position_list = array(
                "1" => "C",
                "2" => "PF",
                "3" => "SF",
                "4" => "SG",
                "5" => "PG"
            );
            $player_total_stats = array(
                "min" => 0,
                "sec" => 0,
                "pts" => 0,
                "reb" => 0,
                "ast" => 0,
                "stl" => 0,
                "blk" => 0,
                "fgm" => 0,
                "fga" => 0,
                "fgp" => 0,
                "tpm" => 0,
                "tpa" => 0,
                "tpp" => 0,
                "ftm" => 0,
                "fta" => 0,
                "ftp" => 0,
                "off" => 0,
                "def" => 0,
                "pf" => 0,
                "to" => 0
            );
            foreach ($player_last_five_list as $game_id => $game_info) {
                $game_result = array();
                $game_result["date"] = date("n月j日", strtotime($game_info["game_start_date"]));
                $game_result["is_home"] = "1";
                $game_result["oppo_team"] = "Undefine";
                if ($game_info["t_id"] == $game_info["game_home_team"]) {
                    if (isset($team_list[$game_info["game_away_team"]])) {
                        $game_result["oppo_team"] = $team_list[$game_info["game_away_team"]]["t_name_cn"];
                    }
                } else {
                    $game_result["is_home"] = "0";
                    if (isset($team_list[$game_info["game_home_team"]])) {
                        $game_result["oppo_team"] = $team_list[$game_info["game_home_team"]]["t_name_cn"];
                    }
                }
                $game_result["score"] = "";
                if ($game_result["is_home"]) {
                    $game_result["score"] = $game_info["game_away_score"] . ":<b>" . $game_info["game_home_score"] . "</b>";
                    if ($game_info["game_away_score"] > $game_info["game_home_score"]) {
                        $game_result["score"] .= " 负";
                    } else {
                        $game_result["score"] .= " 胜";
                    }
                } else {
                    $game_result["score"] = "<b>" . $game_info["game_away_score"] . "</b>:" . $game_info["game_home_score"];
                    if ($game_info["game_away_score"] > $game_info["game_home_score"]) {
                        $game_result["score"] .= " 胜";
                    } else {
                        $game_result["score"] .= " 负";
                    }
                }
                $game_result["pos"] = "";
                if ($game_info["g_position"] > 0) {
                    $game_result["pos"] = $position_list[$game_info["g_position"]];
                }
                $game_result["min"] = sprintf("%02d:%02d", $game_info["g_minutes"], $game_info["g_minutes_sec"]);
                $game_result["pts"] = $game_info["g_points"];
                $game_result["reb"] = $game_info["g_rebounds"];
                $game_result["ast"] = $game_info["g_assists"];
                $game_result["stl"] = $game_info["g_steals"];
                $game_result["blk"] = $game_info["g_blocks"];
                $game_result["fgm"] = $game_info["g_field_goals_made"];
                $game_result["fga"] = $game_info["g_field_goals_attempted"];
                if ($game_result["fga"] > 0) {
                    $game_result["fgp"] = sprintf("%.1f", $game_result["fgm"] / $game_result["fga"] * 100);
                } else {
                    $game_result["fgp"] = 0;
                }
                $game_result["tpm"] = $game_info["g_three_points_made"];
                $game_result["tpa"] = $game_info["g_three_points_attempted"];
                if ($game_result["tpa"] > 0) {
                    $game_result["tpp"] = sprintf("%.1f", $game_result["tpm"] / $game_result["tpa"] * 100);
                } else {
                    $game_result["tpp"] = 0;
                }
                $game_result["ftm"] = $game_info["g_free_throw_made"];
                $game_result["fta"] = $game_info["g_free_throw_attempted"];
                if ($game_result["fta"] > 0) {
                    $game_result["ftp"] = sprintf("%.1f", $game_result["ftm"] / $game_result["fta"] * 100);
                } else {
                    $game_result["ftp"] = 0;
                }
                $game_result["off"] = $game_info["g_offensive_rebounds"];
                $game_result["def"] = $game_info["g_defensive_rebounds"];
                $game_result["pf"] = $game_info["g_personal_fouls"];
                $game_result["to"] = $game_info["g_turnovers"];
                $player_lastfive_info[$game_id] = $game_result;
                $player_total_stats["min"] += $game_info["g_minutes"];
                $player_total_stats["sec"] += $game_info["g_minutes_sec"];
                $player_total_stats["pts"] += $game_result["pts"];
                $player_total_stats["reb"] += $game_result["reb"];
                $player_total_stats["ast"] += $game_result["ast"];
                $player_total_stats["stl"] += $game_result["stl"];
                $player_total_stats["blk"] += $game_result["blk"];
                $player_total_stats["fgm"] += $game_result["fgm"];
                $player_total_stats["fga"] += $game_result["fga"];
                $player_total_stats["tpm"] += $game_result["tpm"];
                $player_total_stats["tpa"] += $game_result["tpa"];
                $player_total_stats["ftm"] += $game_result["ftm"];
                $player_total_stats["fta"] += $game_result["fta"];
                $player_total_stats["off"] += $game_result["off"];
                $player_total_stats["def"] += $game_result["def"];
                $player_total_stats["pf"] += $game_result["pf"];
                $player_total_stats["to"] += $game_result["to"];
            }
            $game_played = count($player_last_five_list);
            if ($player_total_stats["sec"] >= 60) {
                $player_total_stats["min"] += ceil($player_total_stats["sec"] / 60);
                $player_total_stats["sec"] = $player_total_stats["sec"] % 60;
            }
            $average_min = sprintf("%.1f", ($player_total_stats["min"] * 60 + $player_total_stats["sec"]) / $game_played / 60);
            $player_total_stats["min"] = sprintf("%02d:%02d", $player_total_stats["min"], $player_total_stats["sec"]);
            unset($player_total_stats["sec"]);
            if ($player_total_stats["fga"] > 0) {
                $player_total_stats["fgp"] = sprintf("%.1f", $player_total_stats["fgm"] / $player_total_stats["fga"] * 100);
            }
            if ($player_total_stats["tpa"] > 0) {
                $player_total_stats["tpp"] = sprintf("%.1f", $player_total_stats["tpm"] / $player_total_stats["tpa"] * 100);
            }
            if ($player_total_stats["fta"] > 0) {
                $player_total_stats["ftp"] = sprintf("%.1f", $player_total_stats["ftm"] / $player_total_stats["fta"] * 100);
            }
            $player_average_stats = array(
                "min" => $average_min,
                "pts" => sprintf("%.1f", $player_total_stats["pts"] / $game_played),
                "reb" => sprintf("%.1f", $player_total_stats["reb"] / $game_played),
                "ast" => sprintf("%.1f", $player_total_stats["ast"] / $game_played),
                "stl" => sprintf("%.1f", $player_total_stats["stl"] / $game_played),
                "blk" => sprintf("%.1f", $player_total_stats["blk"] / $game_played),
                "fgm" => sprintf("%.1f", $player_total_stats["fgm"] / $game_played),
                "fga" => sprintf("%.1f", $player_total_stats["fga"] / $game_played),
                "fgp" => $player_total_stats["fgp"],
                "tpm" => sprintf("%.1f", $player_total_stats["tpm"] / $game_played),
                "tpa" => sprintf("%.1f", $player_total_stats["tpa"] / $game_played),
                "tpp" => $player_total_stats["tpp"],
                "ftm" => sprintf("%.1f", $player_total_stats["ftm"] / $game_played),
                "fta" => sprintf("%.1f", $player_total_stats["fta"] / $game_played),
                "ftp" => $player_total_stats["ftp"],
                "off" => sprintf("%.1f", $player_total_stats["off"] / $game_played),
                "def" => sprintf("%.1f", $player_total_stats["def"] / $game_played),
                "pf" => sprintf("%.1f", $player_total_stats["pf"] / $game_played),
                "to" => sprintf("%.1f", $player_total_stats["to"] / $game_played)
            );
            $player_lastfive_info["average"] = $player_average_stats;
            $player_lastfive_info["total"] = $player_total_stats;
        }
//Utility::testVariable($player_lastfive_info);
        return array(
            "base" => $player_base_info,
            "stats" => $player_stats_info,
            "last5" => $player_lastfive_info
        );
    }
}
?>