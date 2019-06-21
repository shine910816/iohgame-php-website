<?php

/**
 * NBA比赛详情
 * @author Kinsama
 * @version 2019-04-23
 */
class IohNba_GameDetailAction
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
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Game ID is invalid.");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $game_id = $request->getParameter("id");
        $game_base_info = IohNbaDBI::selectGameBaseInfo($game_id);
        if ($controller->isError($game_base_info)) {
            $game_base_info->setPos(__FILE__, __LINE__);
            return $game_base_info;
        }
        if (!isset($game_base_info[$game_id])) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Game ID is invalid.");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $game_base_info = $game_base_info[$game_id];
        $game_date = $game_base_info["game_date"];
        $game_season = $game_base_info["game_season"];
        $game_season_stage = $game_base_info["game_season_stage"];
        $game_start = date("n月j日 H:i ", strtotime($game_base_info["game_start_date"]));
        $arena_list = IohNbaEntity::getArenaList();
        $game_arena = $game_base_info["game_arena"];
        if (isset($arena_list[$game_base_info["game_arena"]])) {
            $game_arena = $arena_list[$game_base_info["game_arena"]];
        }
        $result = array(
            "base" => array(
                "id" => $game_id,
                "season" => $game_season,
                "season_stage" => $game_season_stage,
                "start" => $game_start,
                "arena" => $game_arena,
                "home" => $game_base_info["game_home_team"],
                "away" => $game_base_info["game_away_team"],
                "status" => $game_base_info["game_status"],
                "score" => array()
            ),
            "team" => array(),
            "box_score" => array(),
            "play_by_play" => array()
        );
        $away_linescore = explode(",", $game_base_info["game_away_line_score"]);
        $home_linescore = explode(",", $game_base_info["game_home_line_score"]);
        if (count($away_linescore) != count($home_linescore)) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Data error.");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $game_current = count($away_linescore);
        $game_current_name = array();
        for ($c_name = 1; $c_name <= $game_current; $c_name++) {
            if ($c_name > 4) {
                $game_current_name[] = "OT" . ($c_name - 4);
            } else {
                $game_current_name[] = "Q" . $c_name;
            }
        }
        foreach ($game_current_name as $c_idx => $current_name) {
            $result["base"]["score"][$current_name] = array($away_linescore[$c_idx], $home_linescore[$c_idx]);
        }
        $result["base"]["score"]["TO"] = array($game_base_info["game_away_score"], $game_base_info["game_home_score"]);
        $team_info = array(
            "name" => "",
            "name_full" => "",
            "name_cn" => "",
            "name_short" => "",
            "color" => "",
            "win" => "",
            "loss" => "",
            "conf" => "",
            "rank" => ""
        );
        $result["team"][$game_base_info["game_home_team"]] = $team_info;
        $result["team"][$game_base_info["game_away_team"]] = $team_info;
        $team_list = IohNbaDBI::getTeamList();
        if ($controller->isError($team_list)) {
            $team_list->setPos(__FILE__, __LINE__);
            return $team_list;
        }
        $standings_info = IohNbaDBI::selectStandings("0");
        if ($controller->isError($standings_info)) {
            $standings_info->setPos(__FILE__, __LINE__);
            return $standings_info;
        }
        $conf_list = IohNbaEntity::getConferenceList();
        foreach ($result["team"] as $t_id => $team_info) {
            if (isset($team_list[$t_id])) {
                $result["team"][$t_id]["name"] = $team_list[$t_id]["t_name"];
                $result["team"][$t_id]["name_full"] = $team_list[$t_id]["t_city_cn"] . $team_list[$t_id]["t_name_cn"];
                $result["team"][$t_id]["name_cn"] = $team_list[$t_id]["t_name_cn"];
                $result["team"][$t_id]["name_short"] = $team_list[$t_id]["t_name_short"];
                $result["team"][$t_id]["color"] = $team_list[$t_id]["t_color"];
            }
            if (isset($standings_info[$t_id])) {
                $result["team"][$t_id]["win"] = $standings_info[$t_id]["t_win"];
                $result["team"][$t_id]["loss"] = $standings_info[$t_id]["t_loss"];
                $result["team"][$t_id]["conf"] = $conf_list["cn"][$standings_info[$t_id]["t_conference"]];
                $result["team"][$t_id]["rank"] = $standings_info[$t_id]["t_conf_rank"];
            }
        }
        $position_list = array(
            "0" => "",
            "1" => "C",
            "2" => "PF",
            "3" => "SF",
            "4" => "SG",
            "5" => "PG"
        );
        if ($game_base_info["game_synch_flg"]) {
            $detail_boxscore = IohNbaStatsDBI::selectGameDetailBoxscore($game_id);
            if ($controller->isError($detail_boxscore)) {
                $detail_boxscore->setPos(__FILE__, __LINE__);
                return $detail_boxscore;
            }
            if (!empty($detail_boxscore)) {
                $player_list = array();
                foreach (array_keys($detail_boxscore[$result["base"]["home"]]) as $p_id) {
                    $player_list[] = $p_id;
                }
                foreach (array_keys($detail_boxscore[$result["base"]["away"]]) as $p_id) {
                    $player_list[] = $p_id;
                }
                $player_info = IohNbaDBI::selectPlayer($player_list);
                if ($controller->isError($player_info)) {
                    $player_info->setPos(__FILE__, __LINE__);
                    return $player_info;
                }
                $team_total_boxscore = array();
                foreach ($detail_boxscore as $t_id => $team_boxscore) {
                    if (!isset($team_total_boxscore[$t_id])) {
                        $team_total_boxscore[$t_id] = array(
                            "min" => 0,
                            "sec" => 0,
                            "pts" => 0,
                            "reb" => 0,
                            "ast" => 0,
                            "stl" => 0,
                            "blk" => 0,
                            "fgm" => 0,
                            "fga" => 0,
                            "tpm" => 0,
                            "tpa" => 0,
                            "ftm" => 0,
                            "fta" => 0,
                            "off" => 0,
                            "def" => 0,
                            "pf" => 0,
                            "to" => 0
                        );
                    }
                    foreach ($team_boxscore as $p_id => $player_boxscore) {
                        $player_name = "Undefined";
                        if (isset($player_info[$p_id])) {
                            if ($player_info[$p_id]["p_name"] != "") {
                                $player_name = $player_info[$p_id]["p_name"];
                            } else {
                                $player_name = $player_info[$p_id]["p_first_name"] . " " . $player_info[$p_id]["p_last_name"];
                            }
                        }
                        $result["box_score"][$t_id][$p_id] = array(
                            "name" => $player_name,
                            "p" => $position_list[$player_boxscore["g_position"]],
                            "min" => sprintf("%02d:%02d", $player_boxscore["g_minutes"], $player_boxscore["g_minutes_sec"]),
                            "pts" => $player_boxscore["g_points"],
                            "reb" => $player_boxscore["g_rebounds"],
                            "ast" => $player_boxscore["g_assists"],
                            "stl" => $player_boxscore["g_steals"],
                            "blk" => $player_boxscore["g_blocks"],
                            "fg" => $player_boxscore["g_field_goals_made"] . "/" . $player_boxscore["g_field_goals_attempted"],
                            "tp" => $player_boxscore["g_three_points_made"] . "/" . $player_boxscore["g_three_points_attempted"],
                            "ft" => $player_boxscore["g_free_throw_made"] . "/" . $player_boxscore["g_free_throw_attempted"],
                            "off" => $player_boxscore["g_offensive_rebounds"],
                            "def" => $player_boxscore["g_defensive_rebounds"],
                            "pf" => $player_boxscore["g_personal_fouls"],
                            "to" => $player_boxscore["g_turnovers"]
                        );
                        $team_total_boxscore[$t_id]["min"] += $player_boxscore["g_minutes"];
                        $team_total_boxscore[$t_id]["sec"] += $player_boxscore["g_minutes_sec"];
                        $team_total_boxscore[$t_id]["pts"] += $player_boxscore["g_points"];
                        $team_total_boxscore[$t_id]["reb"] += $player_boxscore["g_rebounds"];
                        $team_total_boxscore[$t_id]["ast"] += $player_boxscore["g_assists"];
                        $team_total_boxscore[$t_id]["stl"] += $player_boxscore["g_steals"];
                        $team_total_boxscore[$t_id]["blk"] += $player_boxscore["g_blocks"];
                        $team_total_boxscore[$t_id]["fgm"] += $player_boxscore["g_field_goals_made"];
                        $team_total_boxscore[$t_id]["fga"] += $player_boxscore["g_field_goals_attempted"];
                        $team_total_boxscore[$t_id]["tpm"] += $player_boxscore["g_three_points_made"];
                        $team_total_boxscore[$t_id]["tpa"] += $player_boxscore["g_three_points_attempted"];
                        $team_total_boxscore[$t_id]["ftm"] += $player_boxscore["g_free_throw_made"];
                        $team_total_boxscore[$t_id]["fta"] += $player_boxscore["g_free_throw_attempted"];
                        $team_total_boxscore[$t_id]["off"] += $player_boxscore["g_offensive_rebounds"];
                        $team_total_boxscore[$t_id]["def"] += $player_boxscore["g_defensive_rebounds"];
                        $team_total_boxscore[$t_id]["pf"]  += $player_boxscore["g_personal_fouls"];
                        $team_total_boxscore[$t_id]["to"]  += $player_boxscore["g_turnovers"];
                    }
                }
                foreach ($team_total_boxscore as $t_id => $team_boxscore) {
                    $team_total_min = "240";
                    if ($game_current > 4) {
                        $team_total_min += ($game_current - 4) * 25;
                    }
                    $result["box_score"][$t_id]["total"] = array(
                        "name" => "",
                        "p" => "",
                        "min" => $team_total_min . ":00",
                        "pts" => $team_boxscore["pts"],
                        "reb" => $team_boxscore["reb"],
                        "ast" => $team_boxscore["ast"],
                        "stl" => $team_boxscore["stl"],
                        "blk" => $team_boxscore["blk"],
                        "fg" => $team_boxscore["fgm"] . "/" . $team_boxscore["fga"],
                        "tp" => $team_boxscore["tpm"] . "/" . $team_boxscore["tpa"],
                        "ft" => $team_boxscore["ftm"] . "/" . $team_boxscore["fta"],
                        "off" => $team_boxscore["off"],
                        "def" => $team_boxscore["def"],
                        "pf" => $team_boxscore["pf"],
                        "to" => $team_boxscore["to"]
                    );
                }
            }
        }
        if ($game_current > 0) {
            for ($i = 0; $i < $game_current; $i++) {
                $pbp_json = Utility::transJson("http://data.nba.net/10s/prod/v1/" . $game_date . "/00" . $game_id . "_pbp_" . ($i + 1) . ".json");
                if ($controller->isError($pbp_json)) {
                    continue;
                }
                $pbp_item = array(
                    "current_name" => $game_current_name[$i],
                    "plays" => array()
                );
                foreach ($pbp_json["plays"] as $play_by_play_item) {
                    $item = array(
                        "current" => $pbp_item["current_name"],
                        "clock" => $play_by_play_item["clock"],
                        "type" => $play_by_play_item["eventMsgType"],
                        "p_id" => $play_by_play_item["personId"],
                        "t_id" => $play_by_play_item["teamId"],
                        "score" => $play_by_play_item["vTeamScore"] . "-" . $play_by_play_item["hTeamScore"],
                        "change" => $play_by_play_item["isScoreChange"] ? "1" : "0",
                        "desc" => ""
                    );
                    $desc = $play_by_play_item["formatted"]["description"];
                    if (strpos($desc, " - ")) {
                        $desc_arr = explode(" - ", $desc);
                        $item["desc"] = $desc_arr[1];
                    } else {
                        $item["desc"] = $desc;
                    }
                    $pbp_item["plays"][] = $item;
                }
                $result["play_by_play"][$pbp_item["current_name"]] = $pbp_item["plays"];
            }
        }
        return $result;
    }
}
?>