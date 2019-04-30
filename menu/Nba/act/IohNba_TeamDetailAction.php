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
        $calendar_date = date("Ym");
        if ($request->hasParameter("cal_date")) {
            $calendar_date = $request->getParameter("cal_date");
            if (!Validate::checkDate(substr($calendar_date, 0, 4), substr($calendar_date, 4, 2), 1)) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
        }
        $roster_option = "1";
        if ($request->hasParameter("roster")) {
            $roster_option = $request->getParameter("roster");
            if (!Validate::checkAcceptParam($roster_option, array("1", "2"))) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
        }
        $latest_game_info = IohNbaStatsDBI::selectLatestGameDate();
        if ($controller->isError($latest_game_info)) {
            $latest_game_info->setPos(__FILE__, __LINE__);
            return $latest_game_info;
        }
        $request->setAttribute("t_id", $t_id);
        $request->setAttribute("calendar_date", $calendar_date);
        $request->setAttribute("roster_option", $roster_option);
        $request->setAttribute("game_season", $latest_game_info["game_season"]);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $t_id = $request->getAttribute("t_id");
        $calendar_date = $request->getAttribute("calendar_date");
        $roster_option = $request->getAttribute("roster_option");
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
        $team_stats_info = $json_data["stats"]["average"];
        $team_roster_info = $json_data["roster"];
        $team_schedule_info = array();
        $calendar_list = array();
        if (!empty($json_data["schedule"])) {
            foreach ($json_data["schedule"] as $cal_month_day => $cal_tmp) {
                $cal_date_ts = mktime(0, 0, 0, substr($cal_month_day, 4, 2), 1, substr($cal_month_day, 0, 4));
                $cal_date_title = date("Y", $cal_date_ts) . "年" . date("n", $cal_date_ts) . "月(" . count($cal_tmp) . "场)";
                $calendar_list[$cal_month_day] = $cal_date_title;
            }
            if (isset($json_data["schedule"][$calendar_date])) {
                $team_schedule_info = $json_data["schedule"][$calendar_date];
            }
        }
        $request->setAttribute("team_base_info", $team_base_info);
        $request->setAttribute("team_standings_info", $team_standings_info);
        $request->setAttribute("team_stats_info", $team_stats_info);
        $request->setAttribute("team_schedule_info", $team_schedule_info);
        $request->setAttribute("team_roster_info", $team_roster_info);
        $request->setAttribute("calendar_list", $calendar_list);
//Utility::testVariable($request->getAttributes());
        return VIEW_DONE;
    }
}
?>