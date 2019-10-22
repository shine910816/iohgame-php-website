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
        $request->setAttribute("calendar_date", date("Ym"));
        $request->setAttribute("game_season", $latest_game_info["game_season"]);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $t_id = $request->getAttribute("t_id");
        $calendar_date = $request->getAttribute("calendar_date");
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
        $team_base_info = $json_data["base"];
        if (empty($team_base_info)) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $team_standings_info = $json_data["ranking"];
        $team_playoffs_info = $json_data["playoff"];
        $team_stats_info = array();
        $game_season_stage = "0";
        if (isset($json_data["stats"]["final"]["average"])) {
            $team_stats_info = $json_data["stats"]["final"]["average"];
            $game_season_stage = "5";
        } elseif (isset($json_data["stats"]["playoffs"]["average"])) {
            $team_stats_info = $json_data["stats"]["playoffs"]["average"];
            $game_season_stage = "4";
        } elseif (isset($json_data["stats"]["regular"]["average"])) {
            $team_stats_info = $json_data["stats"]["regular"]["average"];
            $game_season_stage = "2";
        } elseif (isset($json_data["stats"]["preseason"]["average"])) {
            $team_stats_info = $json_data["stats"]["preseason"]["average"];
            $game_season_stage = "1";
        }
        $team_roster_info = $json_data["roster"];
        $team_schedule_info = array();
        $calendar_list = array();
        if (!empty($json_data["schedule"])) {
            foreach ($json_data["schedule"] as $cal_month_day => $cal_tmp) {
                $cal_date_ts = mktime(0, 0, 0, substr($cal_month_day, 4, 2), 1, substr($cal_month_day, 0, 4));
                $cal_date_title = date("Y", $cal_date_ts) . "年" . date("n", $cal_date_ts) . "月(" . count($cal_tmp) . "场)";
                $calendar_list[$cal_month_day] = $cal_date_title;
            }
            $team_schedule_info = $json_data["schedule"];
        }
        $chart_send_text = "";
        if (!empty($team_stats_info)) {
            $leader_stats_info = IohNbaStatsDBI::selectLeaderStats($game_season, $game_season_stage, true);
            if ($controller->isError($leader_stats_info)) {
                $leader_stats_info->setPos(__FILE__, __LINE__);
                return $leader_stats_info;
            }
            $stats_tmp = array(
                $team_stats_info["ppg"],
                $team_stats_info["rpg"],
                $team_stats_info["apg"],
                $team_stats_info["spg"],
                $team_stats_info["bpg"],
                str_replace("%", "", $team_stats_info["fgp"]),
                str_replace("%", "", $team_stats_info["tpp"]),
                str_replace("%", "", $team_stats_info["ftp"])
            );
            $chart_send_info = array(
                "stats" => implode(",", $stats_tmp),
                "maximum" => str_replace("000", "", implode(",", $leader_stats_info)),
                "color" => $team_base_info["color"]
            );
            $chart_send_text = Utility::encodeCookieInfo($chart_send_info);
        }
        $stage_list = array(
            "0" => "",
            "1" => "季前赛",
            "2" => "常规赛",
            "4" => "季后赛"
        );
        $stats_title = sprintf("%s-%s赛季%s", $game_season, $game_season + 1, $stage_list[$game_season_stage]);
        $team_past_info = $json_data["past"];
        $request->setAttribute("team_base_info", $team_base_info);
        $request->setAttribute("team_standings_info", $team_standings_info);
        $request->setAttribute("team_playoffs_info", $team_playoffs_info);
        $request->setAttribute("team_stats_info", $team_stats_info);
        $request->setAttribute("stats_title", $stats_title);
        $request->setAttribute("team_schedule_info", $team_schedule_info);
        $request->setAttribute("team_roster_info", $team_roster_info);
        $request->setAttribute("calendar_list", $calendar_list);
        $request->setAttribute("chart_send_text", $chart_send_text);
        $request->setAttribute("stage_list", $stage_list);
        $request->setAttribute("team_past_info", $team_past_info);
        return VIEW_DONE;
    }
}
?>