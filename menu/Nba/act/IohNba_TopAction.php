<?php

/**
 * Object NBA首页
 * @author Kinsama
 * @version 2019-03-14
 */
class IohNba_TopAction extends ActionBase
{
    private $_year = 2018;

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
        $game_date = date("Ymd");
        if ($request->hasParameter("date")) {
            $game_date = $request->getParameter("date");
            if (!Validate::checkDate(substr($game_date, 0, 4), substr($game_date, 4, 2), substr($game_date, 6, 2))) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
        }
        $request->setAttribute("game_date", $game_date);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $game_date = $request->getAttribute("game_date");
        $json_array = Utility::transJson(SYSTEM_API_HOST . "nba/calendar/?date=" . $game_date);
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
        $game_date = $json_data["game_date"];
        $game_number = $json_data["game_number"];
        $today_time = mktime(0, 0, 0, substr($game_date, 4, 2), substr($game_date, 6, 2), substr($game_date, 0, 4));
        $calendar_title = date("n", $today_time) . "月" . date("j", $today_time) . "日(" . $game_number . "场)";
        $calendar_prev = date("Ymd", $today_time - 24 * 3600);
        $calendar_next = date("Ymd", $today_time + 24 * 3600);
        $calendar_year_month = date("Ym", $today_time);
        // AB Test
        $subpanel_file = SRC_PATH . "/menu/Nba/tpl/IohNba_TopMobileView_Calendar.tpl";
        if (date("i") % 2 == 0) {
            $subpanel_file = SRC_PATH . "/menu/Nba/tpl/IohNba_TopMobileView_Calendar2.tpl";
        }
        $request->setAttribute("calendar_title", $calendar_title);
        $request->setAttribute("calendar_prev", $calendar_prev);
        $request->setAttribute("calendar_next", $calendar_next);
        $request->setAttribute("calendar_year_month", $calendar_year_month);
        $request->setAttribute("calendar_info", $this->_getCalendar());
        $request->setAttribute("subpanel_file", $subpanel_file);
        $request->setAttribute("game_info", $json_data["game_info"]);
        return VIEW_DONE;
    }

    private function _getCalendar()
    {
        $result = array();
        $result[$this->_year] = array(
            9 => array(),
            10 => array(),
            11 => array(),
            12 => array()
        );
        $result[$this->_year + 1] = array(
            1 => array(),
            2 => array(),
            3 => array(),
            4 => array(),
            5 => array(),
            6 => array()
        );
        foreach ($result as $m_year => $year_item) {
            foreach ($year_item as $m_month => $tmp) {
                $first_day_time = mktime(0, 0, 0, $m_month, 1, $m_year);
                $last_day = date("t", $first_day_time);
                $last_day_time = mktime(0, 0, 0, $m_month, $last_day, $m_year);
                $first_day_week = date("w", $first_day_time);
                $last_day_week = date("w", $last_day_time);
                $month_tmp_array = array();
                if ($first_day_week != "0") {
                    for ($blank = 0; $blank < $first_day_week; $blank++) {
                        $month_tmp_array[] = array(
                            "day" => "",
                            "date" => ""
                        );
                    }
                }
                for ($m_day = 1; $m_day <= $last_day; $m_day++) {
                    $month_tmp_array[] = array(
                        "day" => $m_day,
                        "date" => sprintf("%04d%02d%02d", $m_year, $m_month, $m_day)
                    );
                }
                if ($last_day_week != "6") {
                    for ($blank = 0; $blank < 6 - $last_day_week; $blank++) {
                        $month_tmp_array[] = array(
                            "day" => "",
                            "date" => ""
                        );
                    }
                }
                $result[$m_year][$m_month] = array(
                    "key" => sprintf("%04d%02d", $m_year, $m_month),
                    "data" =>array_chunk($month_tmp_array, 7)
                );
            }
        }
        return $result;
    }
}
?>