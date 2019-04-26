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
        $request->setAttribute("calendar_title", $calendar_title);
        $request->setAttribute("calendar_prev", $calendar_prev);
        $request->setAttribute("calendar_next", $calendar_next);
        $request->setAttribute("game_info", $json_data["game_info"]);
//Utility::testVariable($request->getAttributes());
        return VIEW_DONE;
    }
}
?>