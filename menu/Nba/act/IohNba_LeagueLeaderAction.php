<?php
require_once SRC_PATH . "/menu/Nba/lib/IohNba_Common.php";

/**
 * Object NBA数据王
 * @author Kinsama
 * @version 2019-03-14
 */
class IohNba_LeagueLeaderAction extends ActionBase
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
        $period_opt = array(
            "daily",
            "season"
        );
        $daily_opt = array(
            "pts",
            "reb",
            "ast",
            "blk",
            "stl"
        );
        $season_opt = array(
            "ppg",
            "rpg",
            "apg",
            "bpg",
            "spg",
            "fgp",
            "tpp",
            "ftp"
        );
        $period = $period_opt[0];
        if ($request->hasParameter("period")) {
            if (!Validate::checkAcceptParam($request->getParameter("period"), $period_opt)) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $period = $request->getParameter("period");
        }
        $option = "";
        if ($period == "season") {
            $option = $season_opt[0];
            if ($request->hasParameter("option")) {
                if (!Validate::checkAcceptParam($request->getParameter("option"), $season_opt)) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                $option = $request->getParameter("option");
            }
        } else {
            $option = $daily_opt[0];
            if ($request->hasParameter("option")) {
                if (!Validate::checkAcceptParam($request->getParameter("option"), $daily_opt)) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                $option = $request->getParameter("option");
            }
        }
        $request->setAttribute("period", $period);
        $request->setAttribute("option", $option);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $period = $request->getAttribute("period");
        $option = $request->getAttribute("option");
        if ($period == "season") {
            $ret = $this->_doSeasonExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } else {
            $ret = $this->_doDailyExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        }
        return $ret;
    }

    private function _doDailyExecute(Controller $controller, User $user, Request $request)
    {
        $option = $request->getAttribute("option");
        $game_date_info = IohNbaStatsDBI::selectLatestGameDate(NBA_GAME_SEASON);
        if (empty($game_date_info)) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $game_date = $game_date_info[0]["game_date"];
        $daily_stats_info = IohNbaStatsDBI::selectDailyStatsByGameData($game_date_info[0]["game_date"]);
        if ($controller->isError($daily_stats_info)) {
            $daily_stats_info->setPos(__FILE__, __LINE__);
            return $daily_stats_info;
        }
        $daily_info = array();
        $option_array = array();
        $sort_array = array();
        foreach ($daily_stats_info as $p_id => $player_info) {
            $daily_player_info = array();
            $daily_player_info["p_id"] = $player_info["p_id"];
            $daily_player_info["t_id"] = $player_info["t_id"];
            $daily_player_info["pts"] = $player_info["g_points"];
            $daily_player_info["reb"] = $player_info["g_offensive_rebounds"] + $player_info["g_defensive_rebounds"];
            $daily_player_info["ast"] = $player_info["g_assists"];
            $daily_player_info["stl"] = $player_info["g_steals"];
            $daily_player_info["blk"] = $player_info["g_blocks"];
            $daily_player_info["sort"] = $player_info["g_points"] + $player_info["g_offensive_rebounds"]
                + $player_info["g_defensive_rebounds"] + $player_info["g_assists"]
                + 1.4 * ($player_info["g_steals"] + $player_info["g_blocks"])
                + 1.5 * $player_info["g_field_goals_made"] + 0.25 * $player_info["g_free_throw_made"]
                - 0.7 * $player_info["g_turnovers"]
                - 0.8 * ($player_info["g_field_goals_attempted"] + $player_info["g_free_throw_attempted"]
                - $player_info["g_field_goals_made"] - $player_info["g_free_throw_made"]);
            if ($daily_player_info["sort"] > 0) {
                $daily_info[$p_id] = $daily_player_info;
                $option_array[$p_id] = $daily_player_info[$option];
                $sort_array[$p_id] = $daily_player_info["sort"];
            }
        }
        array_multisort(
            $option_array, SORT_DESC,
            $sort_array, SORT_DESC,
            $daily_info
        );
        $daily_info = array_chunk($daily_info, 20);
        $daily_info = $daily_info[0];
        $player_id_list = array();
        foreach ($daily_info as $player_info) {
            $player_id_list[] = $player_info["p_id"];
        }
        $player_info_list = IohNbaDBI::selectPlayer($player_id_list);
        if ($controller->isError($player_info_list)) {
            $player_info_list->setPos(__FILE__, __LINE__);
            return $player_info_list;
        }
        $team_info_list = IohNbaDBI::getTeamGroupList();
        if ($controller->isError($team_info_list)) {
            $team_info_list->setPos(__FILE__, __LINE__);
            return $team_info_list;
        }
        $request->setAttribute("daily_info", $daily_info);
        $request->setAttribute("player_info_list", $player_info_list);
        $request->setAttribute("team_info_list", $team_info_list);
        $request->setAttribute("daily_option_list", array(
            "pts" => "得分",
            "reb" => "篮板",
            "ast" => "助攻",
            "blk" => "盖帽",
            "stl" => "抢断"
        ));
        return VIEW_DONE;
    }

    private function _doSeasonExecute(Controller $controller, User $user, Request $request)
    {
        $option = $request->getAttribute("option");
        return VIEW_DONE;
    }
}
?>