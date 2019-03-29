<?php
require_once SRC_PATH . "/menu/Nba/lib/IohNba_Common.php";

/**
 * Object NBA数据王
 * @author Kinsama
 * @version 2019-03-14
 */
class IohNba_LeagueLeaderAction extends ActionBase
{
    private $_common;

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
//$game_period_list = IohNbaDBI::selectGamePeriodGroupByDate(2018);
//Utility::testVariable($game_period_list);
        $this->_common = new IohNba_Common();
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
            $request->setAttribute("season_info", array());
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
            if (!$user->hasVariable("DAILY_LEAGUE_LEADER")) {
                $sess_res = $this->_sessLoadDailyPlayer($controller, $user);
                if ($controller->isError($sess_res)) {
                    $sess_res->setPos(__FILE__, __LINE__);
                    return $sess_res;
                }
            }
            $sess_daily_info = $user->getVariable("DAILY_LEAGUE_LEADER");
            if (time() - $sess_daily_info["time"] > 3600) {
                $sess_res = $this->_sessLoadDailyPlayer($controller, $user);
                if ($controller->isError($sess_res)) {
                    $sess_res->setPos(__FILE__, __LINE__);
                    return $sess_res;
                }
            }
            $sess_daily_info = $user->getVariable("DAILY_LEAGUE_LEADER");
            $request->setAttribute("daily_info", $sess_daily_info["data"]);
        }
        $request->setAttribute("period", $period);
        $request->setAttribute("option", $option);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $period = $request->getAttribute("period");
        $option = $request->getAttribute("option");
        if ($request->hasParameter("refresh")) {
            $sess_res = $this->_sessLoadDailyPlayer($controller, $user);
            if ($controller->isError($sess_res)) {
                $sess_res->setPos(__FILE__, __LINE__);
                return $sess_res;
            }
            $controller->redirect("./?menu=nba&act=league_leader&period=" . $period . "&option=" . $option);
            return VIEW_DONE;
        }
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
        $daily_info = $request->getAttribute("daily_info");
        $option_array = array();
        $sort_array = array();
        foreach ($daily_info as $p_id => $player_info) {
            $option_array[$p_id] = $player_info[$option];
            $sort_array[$p_id] = $player_info["sort"];
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
        return VIEW_DONE;
    }

    private function _doSeasonExecute(Controller $controller, User $user, Request $request)
    {
        $option = $request->getAttribute("option");
        return VIEW_DONE;
    }

    private function _sessLoadDailyPlayer(Controller $controller, User $user)
    {
        $league_leader = $this->_common->getDailyActivePlayersInfo();
        if ($controller->isError($league_leader)) {
            $league_leader->setPos(__FILE__, __LINE__);
            return $league_leader;
        }
        $result = array();
        foreach ($league_leader as $player_id => $player_info) {
            $player_item = array();
            $player_item["p_id"] = $player_id;
            $player_item["pts"] = $player_info["points"];
            $player_item["reb"] = $player_info["totReb"];
            $player_item["ast"] = $player_info["assists"];
            $player_item["blk"] = $player_info["blocks"];
            $player_item["stl"] = $player_info["steals"];
            $player_item["sort"] = $player_info["points"] + $player_info["totReb"] + $player_info["assists"]
                + 1.4 * ($player_info["steals"] + $player_info["blocks"])
                + 1.5 * $player_info["fgm"] + 0.25 * $player_info["ftm"]
                - 0.7 * $player_info["turnovers"]
                - 0.8 * ($player_info["fga"] + $player_info["fta"] - $player_info["fgm"] - $player_info["ftm"]);
            if ($player_item["sort"] > 0) {
                $result[$player_id] = $player_item;
            }
        }
        $user->setVariable("DAILY_LEAGUE_LEADER", array(
            "time" => time(),
            "data" => $result
        ));
        return true;
    }
}
?>