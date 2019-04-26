<?php

/**
 * NBA赛程日历
 * @author Kinsama
 * @version 2019-04-26
 */
class IohNba_ScheduleCalendarAction
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
        if (!$request->hasParameter("date")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Game date is invalid.");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $game_date = $request->getParameter("date");
        if (!Validate::checkDate(substr($game_date, 0, 4), substr($game_date, 4, 2), substr($game_date, 6, 2))) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $schedule_calendar = IohNbaDBI::selectScheduleGamePlayed($game_date);
        if ($controller->isError($schedule_calendar)) {
            $schedule_calendar->setPos(__FILE__, __LINE__);
            return $schedule_calendar;
        }
        $game_number = count($schedule_calendar);
        $result = array();
        if ($game_number > 0) {
            $team_info_list = IohNbaDBI::getTeamList();
            if ($controller->isError($team_info_list)) {
                $team_info_list->setPos(__FILE__, __LINE__);
                return $team_info_list;
            }
            $arena_list = IohNbaEntity::getArenaList();
            foreach ($schedule_calendar as $game_id => $game_info) {
                $game_item = array(
                    "game_id" => $game_info["game_id"],
                    "game_season" => $game_info["game_season"],
                    "game_season_stage" => $game_info["game_season_stage"],
                    "game_start_date" => $game_info["game_start_date"],
                    "game_arena" => $game_info["game_arena"],
                    "game_status" => $game_info["game_status"]
                );
                $game_title = date("n月j日 H:i ", strtotime($game_item["game_start_date"]));
                if (isset($arena_list[$game_item["game_arena"]])) {
                    $game_title .= $arena_list[$game_item["game_arena"]];
                } else {
                    $game_title .= $game_item["game_arena"];
                }
                $game_item["game_title"] = $game_title;
                $game_item["away_team"] = array(
                    "t_id" => $game_info["game_away_team"],
                    "t_name" => "Undefined",
                    "t_name_short" => "",
                    "score" => $game_info["game_away_score"],
                    "is_win" => "0"
                );
                $game_item["home_team"] = array(
                    "t_id" => $game_info["game_home_team"],
                    "t_name" => "Undefined",
                    "t_name_short" => "",
                    "score" => $game_info["game_home_score"],
                    "is_win" => "0"
                );
                if (isset($team_info_list[$game_item["away_team"]["t_id"]])) {
                    $game_item["away_team"]["t_name"] = $team_info_list[$game_item["away_team"]["t_id"]]["t_name_cn"];
                    $game_item["away_team"]["t_name_short"] = strtolower($team_info_list[$game_item["away_team"]["t_id"]]["t_name_short"]);
                }
                if (isset($team_info_list[$game_item["home_team"]["t_id"]])) {
                    $game_item["home_team"]["t_name"] = $team_info_list[$game_item["home_team"]["t_id"]]["t_name_cn"];
                    $game_item["home_team"]["t_name_short"] = strtolower($team_info_list[$game_item["home_team"]["t_id"]]["t_name_short"]);
                }
                if ($game_item["game_status"] == "3") {
                    if ($game_item["away_team"]["score"] > $game_item["home_team"]["score"]) {
                        $game_item["away_team"]["is_win"] = "1";
                    }
                    if ($game_item["home_team"]["score"] > $game_item["away_team"]["score"]) {
                        $game_item["home_team"]["is_win"] = "1";
                    }
                }
                $result[$game_id] = $game_item;
            }
        }
        return array(
            "game_date" => $game_date,
            "game_number" => $game_number,
            "game_info" => $result
        );
    }
}
?>