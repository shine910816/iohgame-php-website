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
        $period_option_list = array(
            "daily" => "每日",
            "season" => "赛季"
        );
        $daily_option_list = array(
            "pts" => "得分",
            "reb" => "篮板",
            "ast" => "助攻",
            "stl" => "抢断",
            "blk" => "盖帽"
        );
        $season_option_list = array(
            "ppg" => "得分",
            "rpg" => "篮板",
            "apg" => "助攻",
            "spg" => "抢断",
            "bpg" => "盖帽",
            "fgp" => "投篮%",
            "tpp" => "三分%",
            "ftp" => "罚球%"
        );
        $period = "daily";
        if ($request->hasParameter("period")) {
            if (!Validate::checkAcceptParam($request->getParameter("period"), array_keys($period_option_list))) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $period = $request->getParameter("period");
        }
        $option = "";
        if ($period == "season") {
            $option = "ppg";
            if ($request->hasParameter("option")) {
                if (!Validate::checkAcceptParam($request->getParameter("option"), array_keys($season_option_list))) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                $option = $request->getParameter("option");
            }
        } else {
            $option = "pts";
            if ($request->hasParameter("option")) {
                if (!Validate::checkAcceptParam($request->getParameter("option"), array_keys($daily_option_list))) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                $option = $request->getParameter("option");
            }
        }
        $latest_game_info = IohNbaStatsDBI::selectLatestGameDate();
        if ($controller->isError($latest_game_info)) {
            $latest_game_info->setPos(__FILE__, __LINE__);
            return $latest_game_info;
        }
        $request->setAttribute("period", $period);
        $request->setAttribute("option", $option);
        $request->setAttribute("period_option_list", $period_option_list);
        $request->setAttribute("daily_option_list", $daily_option_list);
        $request->setAttribute("season_option_list", $season_option_list);
        $request->setAttribute("game_season", $latest_game_info["game_season"]);
        $request->setAttribute("game_season_stage", $latest_game_info["game_season_stage"]);
        $request->setAttribute("game_date", $latest_game_info["game_date"]);
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
        $game_date = $request->getAttribute("game_date");
        $option = $request->getAttribute("option");
        $json_array = Utility::transJson(SYSTEM_API_HOST . "nba/leader/player/daily/?date=" . $game_date . "&opt=" . $option);
        if ($controller->isError($json_array)) {
            $json_array->setPos(__FILE__, __LINE__);
            return $json_array;
        }
        if ($json_array["error"]) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, $json_array["err_msg"]);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $leader_player_list = $json_array["data"];
        $request->setAttribute("leader_player_list", $leader_player_list);
        return VIEW_DONE;
    }

    private function _doSeasonExecute(Controller $controller, User $user, Request $request)
    {
        $game_season = $request->getAttribute("game_season");
        $game_season_stage = $request->getAttribute("game_season_stage");
        $option = $request->getAttribute("option");
        $json_array = Utility::transJson(SYSTEM_API_HOST . "nba/leader/player/season/?year=" . $game_season . "&stage=" . $game_season_stage . "&opt=" . $option);
        if ($controller->isError($json_array)) {
            $json_array->setPos(__FILE__, __LINE__);
            return $json_array;
        }
        if ($json_array["error"]) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, $json_array["err_msg"]);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $leader_player_list = $json_array["data"];
        $request->setAttribute("leader_player_list", $leader_player_list);
        return VIEW_DONE;
    }
}
?>