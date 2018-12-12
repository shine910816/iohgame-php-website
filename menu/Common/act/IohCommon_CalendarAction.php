<?php

/**
 * 日历画面
 * @author Kinsama
 * @version 2017-10-24
 */
class IohCommon_CalendarAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        $date_list = $request->getAttribute("date_list");
        $disp_date = $date_list["default_date"];
        $default_date_view_arr = $this->_chunkDate($disp_date);
        $default_date_view = sprintf("%d年%d月%d日", $default_date_view_arr[0], $default_date_view_arr[1], $default_date_view_arr[2]);
        if (isset($date_list["adjust_date"])) {
            $disp_date = $date_list["adjust_date"];
        }
        $disp_date = $this->_chunkDate($disp_date);
        $disp_year = $disp_date[0];
        $disp_month = $disp_date[1];
        $disp_max_day = date("t", mktime(0, 0, 0, $disp_month, 1, $disp_year));
        $calendar_rows = 0;
        $calendar_result = array();
        for ($disp_day = 1; $disp_day <= $disp_max_day; $disp_day++) {
            $day_week = date("w", mktime(0, 0, 0, $disp_month, $disp_day, $disp_year));
            if ($disp_day == 1) {
                if ($day_week != "0") {
                    $prev_month_to_day = date("t", mktime(0, 0, 0, $disp_month - 1, 1, $disp_year));
                    $prev_month_from_day = $prev_month_to_day - $day_week + 1;
                    for ($prev_day = $prev_month_from_day; $prev_day <= $prev_month_to_day; $prev_day++) {
                        $day_result = array();
                        $day_result["day"] = $prev_day;
                        $day_result["able"] = 0;
                        $day_result["value"] = "";
                        $day_result["rest"] = 0;
                        $day_result["view"] = "";
                        $calendar_result[$calendar_rows][] = $day_result;
                    }
                }
            }
            $day_result = array();
            $day_result["day"] = $disp_day;
            $day_result["able"] = 0;
            $day_result["value"] = "";
            $day_result["rest"] = 0;
            $day_result["view"] = "";
            $day_date = sprintf("%04d%02d%02d", $disp_year, $disp_month, $disp_day);
            if ($day_date >= $date_list["selec_sta_date"] && $day_date <= $date_list["selec_end_date"]) {
                $day_result["able"] = 1;
            }
            if ($day_result["able"]) {
                $day_result["value"] = $day_date;
                $day_result["view"] = sprintf("%d年%d月%d日", $disp_year, $disp_month, $disp_day);
                if ($day_week == "0" || $day_week == "6") {
                    $day_result["rest"] = 1;
                }
            }
            $calendar_result[$calendar_rows][] = $day_result;
            if ($disp_day == $disp_max_day) {
                if ($day_week != "6") {
                    $next_month_to_day = 6 - $day_week;
                    for ($next_day = 1; $next_day <= $next_month_to_day; $next_day++) {
                        $day_result = array();
                        $day_result["day"] = $next_day;
                        $day_result["able"] = 0;
                        $day_result["value"] = "";
                        $day_result["rest"] = 0;
                        $day_result["view"] = "";
                        $calendar_result[$calendar_rows][] = $day_result;
                    }
                }
            }
            if ($day_week == "6" && $disp_day != $disp_max_day) {
                $calendar_rows++;
            }
        }
        $limit_sta_date_ym = substr($date_list["limit_sta_date"], 0, 6);
        $limit_end_date_ym = substr($date_list["limit_end_date"], 0, 6);
        $adjust_date = sprintf("%04d%02d", $disp_year, $disp_month);
        $prev_year_date = $this->_changeDate($adjust_date, -1);
        $next_year_date = $this->_changeDate($adjust_date, 1);
        $prev_month_date = $this->_changeDate($adjust_date, 0, -1);
        $next_month_date = $this->_changeDate($adjust_date, 0, 1);
        if ($prev_year_date < $limit_sta_date_ym) {
            $prev_year_date = "";
        }
        if ($next_year_date > $limit_end_date_ym) {
            $next_year_date = "";
        }
        if ($prev_month_date < $limit_sta_date_ym) {
            $prev_month_date = "";
        }
        if ($next_month_date > $limit_end_date_ym) {
            $next_month_date = "";
        }
        $request->setAttribute("calendar_result", $calendar_result);
        $request->setAttribute("calendar_box_height", count($calendar_result));
        $request->setAttribute("disp_year", $disp_year);
        $request->setAttribute("disp_month", $disp_month);
        $request->setAttribute("prev_year_date", $prev_year_date);
        $request->setAttribute("next_year_date", $next_year_date);
        $request->setAttribute("prev_month_date", $prev_month_date);
        $request->setAttribute("next_month_date", $next_month_date);
        $request->setAttribute("default_date_view", $default_date_view);
        return VIEW_DONE;
    }

    /**
     * 执行参数检测
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainValidate(Controller $controller, User $user, Request $request)
    {
        $limit_sta_date = "19710101";
        $limit_end_date = "20371231";
        if ($request->hasParameter("limit_sta_date") && $this->_checkDate($request->getParameter("limit_sta_date"))) {
            if ($request->getParameter("limit_sta_date") >= $limit_sta_date && $request->getParameter("limit_sta_date") < $limit_end_date) {
                $limit_sta_date = $request->getParameter("limit_sta_date");
            }
        }
        if ($request->hasParameter("limit_end_date") && $this->_checkDate($request->getParameter("limit_end_date"))) {
            if ($request->getParameter("limit_end_date") > $limit_sta_date && $request->getParameter("limit_end_date") <= $limit_end_date) {
                $limit_end_date = $request->getParameter("limit_end_date");
            }
        }
        $limit_sta_date = date("Ym01", strtotime($limit_sta_date));
        $limit_end_date = date("Ymt", strtotime($limit_end_date));
        $selec_sta_date = $limit_sta_date;
        $selec_end_date = $limit_end_date;
        if ($request->hasParameter("selec_sta_date") && $this->_checkDate($request->getParameter("selec_sta_date"))) {
            if ($request->getParameter("selec_sta_date") >= $limit_sta_date && $request->getParameter("selec_sta_date") < $limit_end_date) {
                $selec_sta_date = $request->getParameter("selec_sta_date");
            }
        }
        if ($request->hasParameter("selec_end_date") && $this->_checkDate($request->getParameter("selec_end_date"))) {
            if ($request->getParameter("selec_end_date") >= $limit_sta_date && $request->getParameter("selec_end_date") < $limit_end_date) {
                $selec_end_date = $request->getParameter("selec_end_date");
            }
        }
        $default_date = date("Ymd");
        if ($request->hasParameter("default_date") && $this->_checkDate($request->getParameter("default_date"))) {
            $default_date = $request->getParameter("default_date");
        }
        $date_list = array(
            "limit_sta_date" => $limit_sta_date,
            "limit_end_date" => $limit_end_date,
            "selec_sta_date" => $selec_sta_date,
            "selec_end_date" => $selec_end_date,
            "default_date" => $default_date
        );
        if ($request->hasParameter("adjust_date") && $this->_checkDate($request->getParameter("adjust_date"))) {
            $date_list["adjust_date"] = $request->getParameter("adjust_date");
        }
        $request->setAttribute("date_list", $date_list);
        return VIEW_DONE;
    }

    /**
     * 检查日期字符串
     * @param string $date_str 日期字符串
     * @return boolean
     */
    private function _checkDate($date_str)
    {
        $date_str_len = strlen($date_str);
        $result = array();
        if ($date_str_len == 8) {
            $result[] = substr($date_str, 0, 4);
            $result[] = substr($date_str, 4, 2);
            $result[] = substr($date_str, 6, 2);
        } else {
            $result[] = substr($date_str, 0, 4);
            $result[] = substr($date_str, 4, 2);
            $result[] = "01";
        }
        return Validate::checkDate($result[0], $result[1], $result[2]);
    }

    /**
     * 分割日期字符串
     * @param string $date_str 日期字符串
     * @return array
     */
    private function _chunkDate($date_str)
    {
        $date_str_len = strlen($date_str);
        $result = array();
        if ($date_str_len == 8) {
            $result[] = intval(substr($date_str, 0, 4));
            $result[] = intval(substr($date_str, 4, 2));
            $result[] = intval(substr($date_str, 6, 2));
        } else {
            $result[] = intval(substr($date_str, 0, 4));
            $result[] = intval(substr($date_str, 4, 2));
        }
        return $result;
    }

    /**
     * 年月变更
     * @param string $adjust_date 日期字符串
     * @param int $year_change 年变更值
     * @param int $month_change 月变更值
     * @return string
     */
    private function _changeDate($adjust_date, $year_change = 0, $month_change = 0)
    {
        $date_arr = $this->_chunkDate($adjust_date);
        $year_value = $date_arr[0];
        $month_value = $date_arr[1];
        if ($year_change > 0) {
            $year_value++;
        }
        if ($year_change < 0) {
            $year_value--;
        }
        if ($month_change > 0) {
            $month_value++;
        }
        if ($month_change < 0) {
            $month_value--;
        }
        if ($month_value > 12) {
            $month_value -= 12;
            $year_value++;
        }
        if ($month_value < 1) {
            $month_value = 12;
            $year_value--;
        }
        return sprintf("%04d%02d", $year_value, $month_value);
    }
}
?>