<?php

/**
 * Object NBA首页
 * @author Kinsama
 * @version 2019-03-14
 */
class IohNba_TopAction extends ActionBase
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
        $target_date = date("Ymd");
        if ($request->hasParameter("date")) {
            $target_date = $request->getParameter("date");
            if (!Validate::checkDate(substr($target_date, 0, 4), substr($target_date, 4, 2), substr($target_date, 6, 2))) {
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
        $schedule_calendar = IohNbaDBI::selectScheduleGamePlayed($latest_game_info["game_season"]);
        if ($controller->isError($schedule_calendar)) {
            $schedule_calendar->setPos(__FILE__, __LINE__);
            return $schedule_calendar;
        }
        $today_info = array();
        if (isset($schedule_calendar[$target_date])) {
            $today_info = $schedule_calendar[$target_date];
            $request->setAttribute("target_date", $target_date);
        } else {
            $tmp_date = date("Ymd", mktime(0, 0, 0, substr($target_date, 4, 2), substr($target_date, 6, 2) - 1, substr($target_date, 0, 4)));
            $adjust_date = IohNbaDBI::selectLatestScheduleGameDate($tmp_date);
            if ($controller->isError($adjust_date)) {
                $adjust_date->setPos(__FILE__, __LINE__);
                return $adjust_date;
            }
            $today_info = $schedule_calendar[$adjust_date];
            $request->setAttribute("target_date", $adjust_date);
        }
        $request->setAttribute("today_info", $today_info);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $today_info = $request->getAttribute("today_info");
        $game_date = $today_info["game_date"];
        $game_date_time = mktime(0, 0, 0, substr($game_date, 4, 2), substr($game_date, 6, 2), substr($game_date, 0, 4));
        $game_number = $today_info["game_number"];
        $disp_cal = date("n", $game_date_time) . "月" . date("j", $game_date_time) . "日(" . $game_number . "场)";
        $request->setAttribute("disp_cal", $disp_cal);
        return VIEW_DONE;
    }
}
?>