<?php

/**
 * NBA球队信息
 * @author Kinsama
 * @version 2019-04-29
 */
class IohNba_TeamInfoAction
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
        $game_season = $request->getParameter("year");
        $t_id = $request->getParameter("id");
        $team_list = IohNbaDBI::getTeamList();
        if ($controller->isError($team_list)) {
            $team_list->setPos(__FILE__, __LINE__);
            return $team_list;
        }
        $team_base_info = array();
        if (isset($team_list[$t_id])) {
            $team_base_info["id"] = $t_id;
            $team_base_info["name"] = $team_list[$t_id]["t_name"];
            $team_base_info["name_cn"] = $team_list[$t_id]["t_city_cn"] . $team_list[$t_id]["t_name_cn"];
            $team_base_info["name_short"] = $team_list[$t_id]["t_name_short"];
            $team_base_info["color"] = $team_list[$t_id]["t_color"];
        }
        $standings_info = IohNbaDBI::selectStandings("0");
        if ($controller->isError($standings_info)) {
            $standings_info->setPos(__FILE__, __LINE__);
            return $standings_info;
        }
        $team_standings_info = array();
        $team_biography_info = array();
        if (isset($standings_info[$t_id])) {
            $conf_list = IohNbaEntity::getConferenceList();
            $div_list = IohNbaEntity::getDivisionList();
            $team_standings_info["win_loss"] = $standings_info[$t_id]["t_win"] . "-" . $standings_info[$t_id]["t_loss"];
            $team_standings_info["win_pct"] = sprintf("%.1f", $standings_info[$t_id]["t_win_percent"]) . "%";
            $team_standings_info["conf_gb"] = sprintf("%.1f", $standings_info[$t_id]["t_game_behind"]);
            $team_standings_info["conference"] = $conf_list["cn"][$standings_info[$t_id]["t_conference"]];
            $team_standings_info["conf_win_loss"] = $standings_info[$t_id]["t_conf_win"] . "-" . $standings_info[$t_id]["t_conf_loss"];
            $team_standings_info["conf_rank"] = $standings_info[$t_id]["t_conf_rank"];
            $team_standings_info["division"] = $div_list["cn"][$standings_info[$t_id]["t_division"]];
            $team_standings_info["div_win_loss"] = $standings_info[$t_id]["t_div_win"] . "-" . $standings_info[$t_id]["t_div_loss"];
            $team_standings_info["div_rank"] = $standings_info[$t_id]["t_div_rank"];
            $team_standings_info["home_win_loss"] = $standings_info[$t_id]["t_home_win"] . "-" . $standings_info[$t_id]["t_home_loss"];
            $team_standings_info["away_win_loss"] = $standings_info[$t_id]["t_away_win"] . "-" . $standings_info[$t_id]["t_away_loss"];
            $team_standings_info["last_win_loss"] = $standings_info[$t_id]["t_last_ten_win"] . "-" . $standings_info[$t_id]["t_last_ten_loss"];
            $team_standings_info["streak_flg"] = $standings_info[$t_id]["t_win_streak_flg"] ? "1" : "0";
            $team_standings_info["streak"] = $standings_info[$t_id]["t_streak"];
            $arena_coach_list = IohNbaEntity::getArenaCoachName();
            $coach_list = IohNbaEntity::getCoachName();
            $arena_list = IohNbaEntity::getArenaList();
            if (isset($arena_coach_list[$t_id])) {
                $arena_coach_info = $arena_coach_list[$t_id];
                if (isset($arena_list[$arena_coach_info["arena"]])) {
                    $team_biography_info["arena"] = $arena_list[$arena_coach_info["arena"]];
                } else {
                    $team_biography_info["arena"] = $arena_coach_info["arena"];
                }
                if (isset($coach_list[$arena_coach_info["coach"]])) {
                    $team_biography_info["coach"] = $coach_list[$arena_coach_info["coach"]];
                } else {
                    $team_biography_info["coach"] = $arena_coach_info["coach"];
                }
                $team_biography_info["conf"] = $conf_list["cn"][$standings_info[$t_id]["t_conference"]];
                $team_biography_info["div"] = $div_list["cn"][$standings_info[$t_id]["t_division"]];
            }
        }
        $playoffs_info = IohNbaDBI::selectTeamSchedule($game_season, $t_id, "4");
        if ($controller->isError($playoffs_info)) {
            $playoffs_info->setPos(__FILE__, __LINE__);
            return $playoffs_info;
        }
        $team_playoffs_info = array();
        if (!empty($playoffs_info)) {
            foreach ($playoffs_info as $game_id => $game_info) {
                $series_num = substr($game_id, 5, 1);
                $games_num = substr($game_id, 7, 1);
                if (!isset($team_playoffs_info[$series_num])) {
                    $oppo_team_id = $game_info["game_away_team"];
                    if ($t_id == $game_info["game_away_team"]) {
                        $oppo_team_id = $game_info["game_home_team"];
                    }
                    $team_playoffs_info[$series_num] = array(
                        "series" => $series_num,
                        "oppo_team_id" => $oppo_team_id,
                        "opponent_name" => $team_list[$oppo_team_id]["t_city_cn"] . $team_list[$oppo_team_id]["t_name_cn"],
                        "self" => $team_list[$t_id]["t_name_cn"],
                        "self_wins" => 0,
                        "oppo" => $team_list[$oppo_team_id]["t_name_cn"],
                        "oppo_wins" => 0,
                        "games" => array()
                    );
                }
                if ($game_info["game_home_team"] == $t_id) {
                    $team_playoffs_info[$series_num]["games"][$games_num] = array(
                        "self" => $game_info["game_home_team"],
                        "self_color" => $team_list[$game_info["game_home_team"]]["t_color"],
                        "self_score" => $game_info["game_home_score"],
                        "oppo" => $game_info["game_away_team"],
                        "oppo_color" => $team_list[$game_info["game_away_team"]]["t_color"],
                        "oppo_score" => $game_info["game_away_score"],
                        "is_home" => "1"
                    );
                } else {
                    $team_playoffs_info[$series_num]["games"][$games_num] = array(
                        "self" => $game_info["game_away_team"],
                        "self_color" => $team_list[$game_info["game_away_team"]]["t_color"],
                        "self_score" => $game_info["game_away_score"],
                        "oppo" => $game_info["game_home_team"],
                        "oppo_color" => $team_list[$game_info["game_home_team"]]["t_color"],
                        "oppo_score" => $game_info["game_home_score"],
                        "is_home" => "0"
                    );
                }
                if ($game_info["game_away_team"] == $team_playoffs_info[$series_num]["oppo_team_id"]) {
                    if ($game_info["game_away_score"] > $game_info["game_home_score"]) {
                        $team_playoffs_info[$series_num]["oppo_wins"] += 1;
                    } else {
                        $team_playoffs_info[$series_num]["self_wins"] += 1;
                    }
                } else {
                    if ($game_info["game_away_score"] > $game_info["game_home_score"]) {
                        $team_playoffs_info[$series_num]["self_wins"] += 1;
                    } else {
                        $team_playoffs_info[$series_num]["oppo_wins"] += 1;
                    }
                }
            }
        }
        $stage_list = array(
            "1" => "preseason",
            "2" => "regular",
            "4" => "playoffs"
        );
        $team_stats_info = array();
        foreach ($stage_list as $game_season_stage => $stage_name) {
            $game_played_info = IohNbaStatsDBI::selectTeamGamePlayed($game_season, $game_season_stage);
            if ($controller->isError($game_played_info)) {
                $game_played_info->setPos(__FILE__, __LINE__);
                return $game_played_info;
            }
            $team_season_stats_info = IohNbaStatsDBI::selectTeamSeasonStats($game_season, $game_season_stage);
            if ($controller->isError($team_season_stats_info)) {
                $team_season_stats_info->setPos(__FILE__, __LINE__);
                return $team_season_stats_info;
            }
            $team_stats_info_tmp = array(
                "average" => array(),
                "total" => array()
            );
            if (isset($game_played_info[$t_id]) && $game_played_info[$t_id] > 0 && isset($team_season_stats_info[$t_id])) {
                $team_stats_info_tmp["total"]["gp"] = $game_played_info[$t_id];
                $team_stats_info_tmp["total"]["pts"] = $team_season_stats_info[$t_id]["pts"];
                $team_stats_info_tmp["total"]["fgm"] = $team_season_stats_info[$t_id]["fgm"];
                $team_stats_info_tmp["total"]["fga"] = $team_season_stats_info[$t_id]["fga"];
                $team_stats_info_tmp["total"]["tpm"] = $team_season_stats_info[$t_id]["tpm"];
                $team_stats_info_tmp["total"]["tpa"] = $team_season_stats_info[$t_id]["tpa"];
                $team_stats_info_tmp["total"]["ftm"] = $team_season_stats_info[$t_id]["ftm"];
                $team_stats_info_tmp["total"]["fta"] = $team_season_stats_info[$t_id]["fta"];
                $team_stats_info_tmp["total"]["reb"] = $team_season_stats_info[$t_id]["reb"];
                $team_stats_info_tmp["total"]["off"] = $team_season_stats_info[$t_id]["off"];
                $team_stats_info_tmp["total"]["def"] = $team_season_stats_info[$t_id]["def"];
                $team_stats_info_tmp["total"]["ast"] = $team_season_stats_info[$t_id]["ast"];
                $team_stats_info_tmp["total"]["stl"] = $team_season_stats_info[$t_id]["stl"];
                $team_stats_info_tmp["total"]["blk"] = $team_season_stats_info[$t_id]["blk"];
                $team_stats_info_tmp["total"]["to"] = $team_season_stats_info[$t_id]["to"];
                $team_stats_info_tmp["total"]["pf"] = $team_season_stats_info[$t_id]["pf"];
                $team_stats_info_tmp["average"]["gp"] = $game_played_info[$t_id];
                $team_stats_info_tmp["average"]["ppg"] = sprintf("%.1f", $team_season_stats_info[$t_id]["pts"] / $game_played_info[$t_id]);
                $team_stats_info_tmp["average"]["fgp"] = "-";
                $team_stats_info_tmp["average"]["tpp"] = "-";
                $team_stats_info_tmp["average"]["ftp"] = "-";
                $team_stats_info_tmp["average"]["rpg"] = sprintf("%.1f", $team_season_stats_info[$t_id]["reb"] / $game_played_info[$t_id]);
                $team_stats_info_tmp["average"]["offpg"] = sprintf("%.1f", $team_season_stats_info[$t_id]["off"] / $game_played_info[$t_id]);
                $team_stats_info_tmp["average"]["defpg"] = sprintf("%.1f", $team_season_stats_info[$t_id]["def"] / $game_played_info[$t_id]);
                $team_stats_info_tmp["average"]["apg"] = sprintf("%.1f", $team_season_stats_info[$t_id]["ast"] / $game_played_info[$t_id]);
                $team_stats_info_tmp["average"]["spg"] = sprintf("%.1f", $team_season_stats_info[$t_id]["stl"] / $game_played_info[$t_id]);
                $team_stats_info_tmp["average"]["bpg"] = sprintf("%.1f", $team_season_stats_info[$t_id]["blk"] / $game_played_info[$t_id]);
                $team_stats_info_tmp["average"]["topg"] = sprintf("%.1f", $team_season_stats_info[$t_id]["to"] / $game_played_info[$t_id]);
                $team_stats_info_tmp["average"]["pfpg"] = sprintf("%.1f", $team_season_stats_info[$t_id]["pf"] / $game_played_info[$t_id]);
                if ($team_season_stats_info[$t_id]["fga"] > 0) {
                    $team_stats_info_tmp["average"]["fgp"] = sprintf("%.1f", $team_season_stats_info[$t_id]["fgm"] * 100 / $team_season_stats_info[$t_id]["fga"]) . "%";
                }
                if ($team_season_stats_info[$t_id]["tpa"] > 0) {
                    $team_stats_info_tmp["average"]["tpp"] = sprintf("%.1f", $team_season_stats_info[$t_id]["tpm"] * 100 / $team_season_stats_info[$t_id]["tpa"]) . "%";
                }
                if ($team_season_stats_info[$t_id]["fta"] > 0) {
                    $team_stats_info_tmp["average"]["ftp"] = sprintf("%.1f", $team_season_stats_info[$t_id]["ftm"] * 100 / $team_season_stats_info[$t_id]["fta"]) . "%";
                }
                $team_stats_info[$stage_name] = $team_stats_info_tmp;
            }
        }
        $standard_player_info = IohNbaDBI::selectStandardPlayerGroupByTeam();
        if ($controller->isError($standard_player_info)) {
            $standard_player_info->setPos(__FILE__, __LINE__);
            return $standard_player_info;
        }
        $team_player_info = array();
        if (isset($standard_player_info[$t_id]) && !empty($standard_player_info[$t_id])) {
            $position_list = array(
                "1" => "中锋",
                "2" => "前锋",
                "3" => "后卫"
            );
            $country_list = IohNbaEntity::getCountryList();
            foreach ($standard_player_info[$t_id] as $p_id => $player_info) {
                $player_item = array(
                    "id" => $p_id,
                    "name" => "",
                    "position" => "",
                    "jersey" => "",
                    "height" => "",
                    "weight" => "",
                    "birth" => "",
                    "country" => ""
                );
                if ($player_info["p_name_cnf_flg"]) {
                    $player_item["name"] = $player_info["p_name"];
                } else {
                    $player_item["name"] = $player_info["p_first_name"] . " " . $player_info["p_last_name"];
                }
                if ($player_info["p_position"] != "0") {
                    $player_item["position"] = $position_list[$player_info["p_position"]];
                    if ($player_info["p_position_2"] != "0") {
                        $player_item["position"] .= "-" . $position_list[$player_info["p_position_2"]];
                    }
                }
                if ($player_info["p_jersey"] != "-1") {
                    $player_item["jersey"] = $player_info["p_jersey"];
                }
                if ($player_info["p_height"] != "0") {
                    $player_item["height"] = sprintf("%.2f", $player_info["p_height"]) . "m";
                }
                if ($player_info["p_weight"] != "0") {
                    $player_item["weight"] = sprintf("%.1f", $player_info["p_weight"]) . "kg";
                }
                if ($player_info["p_birth_date"] != "1900-01-01") {
                    $birth_arr = explode("-", $player_info["p_birth_date"]);
                    $player_item["birth"] = sprintf("%d年%d月%d日", $birth_arr[0], $birth_arr[1], $birth_arr[2]);
                }
                if ($player_info["p_country"] != "" && isset($country_list[$player_info["p_country"]])) {
                    $player_item["country"] = $country_list[$player_info["p_country"]];
                }
                $team_player_info[$p_id]["info"] = $player_item;
            }
            $team_player_id_list = array_keys($team_player_info);
            if (!empty($team_player_id_list)) {
                $judge_num = 0;
                foreach ($team_player_info as $p_id => $tmp) {
                    if ($judge_num % 2 != 0) {
                        $team_player_info[$p_id]["info"]["is_even"] = "1";
                    } else {
                        $team_player_info[$p_id]["info"]["is_even"] = "0";
                    }
                    $judge_num++;
                }
            }
        }
        $team_schedule_list = IohNbaDBI::selectTeamSchedule($game_season, $t_id);
        if ($controller->isError($team_schedule_list)) {
            $team_schedule_list->setPos(__FILE__, __LINE__);
            return $team_schedule_list;
        }
        $team_schedule_info = array();
        if (!empty($team_schedule_list)) {
            foreach ($team_schedule_list as $game_id => $schedule_info) {
                $date_key = date("Ym", strtotime($schedule_info["game_start_date"]));
                if (!isset($team_schedule_info[$date_key])) {
                    $team_schedule_info[$date_key] = array();
                }
                $team_schedule_info[$date_key][$game_id] = $this->_getFormatSchedule($t_id, $schedule_info, $team_list);
            }
        }
        $team_past_played = IohNbaStatsDBI::selectTeamPastPlayed($t_id, $game_season);
        if ($controller->isError($team_past_played)) {
            $team_past_played->setPos(__FILE__, __LINE__);
            return $team_past_played;
        }
        $team_past_stats = IohNbaStatsDBI::selectTeamPastStats($t_id, $game_season);
        if ($controller->isError($team_past_stats)) {
            $team_past_stats->setPos(__FILE__, __LINE__);
            return $team_past_stats;
        }
        $team_past_info = array();
        foreach ($team_past_stats as $game_season_stage => $stage_info) {
            foreach ($stage_info as $game_season => $stats_info) {
                if (isset($team_past_played[$game_season_stage][$game_season])) {
                    $stats_result = array();
                    $stats_result["s"] = $game_season . "-" . substr($game_season + 1, -2);
                    $stats_result["gp"] = $team_past_played[$game_season_stage][$game_season];
                    $stats_result["ppg"] = sprintf("%.1f", $stats_info["pts"] / $stats_result["gp"]);
                    $stats_result["fgp"] = "-";
                    $stats_result["tpp"] = "-";
                    $stats_result["ftp"] = "-";
                    $stats_result["rpg"] = sprintf("%.1f", $stats_info["reb"] / $stats_result["gp"]);
                    $stats_result["offpg"] = sprintf("%.1f", $stats_info["off"] / $stats_result["gp"]);
                    $stats_result["defpg"] = sprintf("%.1f", $stats_info["def"] / $stats_result["gp"]);
                    $stats_result["apg"] = sprintf("%.1f", $stats_info["ast"] / $stats_result["gp"]);
                    $stats_result["spg"] = sprintf("%.1f", $stats_info["stl"] / $stats_result["gp"]);
                    $stats_result["bpg"] = sprintf("%.1f", $stats_info["blk"] / $stats_result["gp"]);
                    $stats_result["topg"] = sprintf("%.1f", $stats_info["to"] / $stats_result["gp"]);
                    $stats_result["pfpg"] = sprintf("%.1f", $stats_info["pf"] / $stats_result["gp"]);
                    if ($stats_info["fga"] > 0) {
                        $stats_result["fgp"] = sprintf("%.1f", $stats_info["fgm"] * 100 / $stats_info["fga"]) . "%";
                    }
                    if ($stats_info["tpa"] > 0) {
                        $stats_result["tpp"] = sprintf("%.1f", $stats_info["tpm"] * 100 / $stats_info["tpa"]) . "%";
                    }
                    if ($stats_info["fta"] > 0) {
                        $stats_result["ftp"] = sprintf("%.1f", $stats_info["ftm"] * 100 / $stats_info["fta"]) . "%";
                    }
                    $team_past_info[$game_season_stage][$game_season] = $stats_result;
                }
            }
        }
        return array(
            "base" => $team_base_info,
            "bio" => $team_biography_info,
            "ranking" => $team_standings_info,
            "playoff" => $team_playoffs_info,
            "stats" => $team_stats_info,
            "schedule" => $team_schedule_info,
            "roster" => $team_player_info,
            "past" => $team_past_info
        );
    }

    private function _getFormatSchedule($t_id, $schedule_info, $team_list)
    {
        $stage_list = array(
            "1" => "季前赛",
            "2" => "常规赛",
            "3" => "全明星赛",
            "4" => "季后赛",
            "5" => "总决赛"
        );
        $result = array(
            "game_date" => "",
            "is_home" => "",
            "oppo_team_id" => "",
            "oppo_team_name" => "",
            "is_started" => "0",
            "score" => "0:0",
            "review_text" => "",
            "is_win" => "0",
            "stage" => "",
            "stage_name" => ""
        );
        $game_start_ts = strtotime($schedule_info["game_start_date"]);
        $result["game_date"] = date("n月j日", $game_start_ts);
        if ($schedule_info["game_away_team"] == $t_id) {
            $result["is_home"] = "0";
            $result["oppo_team_id"] = $schedule_info["game_home_team"];
        } else {
            $result["is_home"] = "1";
            $result["oppo_team_id"] = $schedule_info["game_away_team"];
        }
        $result["oppo_team_name"] = $team_list[$result["oppo_team_id"]]["t_name_cn"];
        if ($schedule_info["game_status"] == "2") {
            $result["score"] = $schedule_info["game_away_score"] . ":" . $schedule_info["game_home_score"];
            if ($result["is_home"]) {
                $result["review_text"] = $schedule_info["game_away_score"] . ":<b>" . $schedule_info["game_home_score"] . "</b>";
            } else {
                $result["review_text"] = "<b>" . $schedule_info["game_away_score"] . "</b>:" . $schedule_info["game_home_score"];
            }
            $result["is_started"] = "1";
        } elseif ($schedule_info["game_status"] == "3") {
            if ($result["is_home"]) {
                if ($schedule_info["game_away_score"] > $schedule_info["game_home_score"]) {
                    $result["is_win"] = "2";
                } else {
                    $result["is_win"] = "1";
                }
            } else {
                if ($schedule_info["game_away_score"] > $schedule_info["game_home_score"]) {
                    $result["is_win"] = "1";
                } else {
                    $result["is_win"] = "2";
                }
            }
            $result["score"] = $schedule_info["game_away_score"] . ":" . $schedule_info["game_home_score"];
            if ($result["is_home"]) {
                $result["review_text"] = $schedule_info["game_away_score"] . ":<b>" . $schedule_info["game_home_score"] . "</b>";
            } else {
                $result["review_text"] = "<b>" . $schedule_info["game_away_score"] . "</b>:" . $schedule_info["game_home_score"];
            }
            $result["is_started"] = "1";
        } else {
            $result["review_text"] = date("H:i", $game_start_ts);
        }
        $result["stage"] = $schedule_info["game_season_stage"];
        $result["stage_name"] = $stage_list[$schedule_info["game_season_stage"]];
        return $result;
    }
}
?>