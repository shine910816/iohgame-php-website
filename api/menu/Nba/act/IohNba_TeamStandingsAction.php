<?php

/**
 * NBA球队排位
 * @author Kinsama
 * @version 2019-04-23
 */
class IohNba_TeamStandingsAction
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
        $standings_group = "1";
        if ($request->hasParameter("group")) {
            $standings_group = $request->getParameter("group");
            if (!Validate::checkAcceptParam($standings_group, array("1", "2"))) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Group is invalid.");
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
        }
        $standings_info = IohNbaDBI::selectStandings($standings_group);
        if ($controller->isError($standings_info)) {
            $standings_info->setPos(__FILE__, __LINE__);
            return $standings_info;
        }
        $team_info_list = IohNbaDBI::getTeamList();
        if ($controller->isError($team_info_list)) {
            $team_info_list->setPos(__FILE__, __LINE__);
            return $team_info_list;
        }
        $conference_list = IohNbaEntity::getConferenceList();
        $division_list = IohNbaEntity::getDivisionList();
        $result = array();
        foreach ($standings_info as $group_id => $group_info) {
            foreach ($group_info as $rank_id => $team_info) {
                $result[$group_id][$rank_id] = array(
                    "id" => $team_info["t_id"],
                    "name" => $team_info_list[$team_info["t_id"]]["t_name_cn"],
                    "name_short" => strtolower($team_info_list[$team_info["t_id"]]["t_name_short"]),
                    "win_loss" => $team_info["t_win"] . "-" . $team_info["t_loss"],
                    "win_pct" => sprintf("%.1f", $team_info["t_win_percent"]) . "%",
                    "conference" => $conference_list["cn"][$team_info["t_conference"]],
                    "conf_rank" => $team_info["t_conf_rank"],
                    "conf_win_loss" => $team_info["t_conf_win"] . "-" . $team_info["t_conf_loss"],
                    "conf_gb" => sprintf("%.1f", $team_info["t_game_behind"]),
                    "division" => $division_list["cn"][$team_info["t_division"]],
                    "div_rank" => $team_info["t_div_rank"],
                    "div_win_loss" => $team_info["t_div_win"] . "-" . $team_info["t_div_loss"],
                    "div_gb" => sprintf("%.1f", $team_info["t_game_behind_div"]),
                    "home_win_loss" => $team_info["t_home_win"] . "-" . $team_info["t_home_loss"],
                    "away_win_loss" => $team_info["t_away_win"] . "-" . $team_info["t_away_loss"],
                    "last_ten_win_loss" => $team_info["t_last_ten_win"] . "-" . $team_info["t_last_ten_loss"],
                    "streak" => ($team_info["t_win_streak_flg"] ? "胜" : "负") . $team_info["t_streak"]
                );
            }
        }
        return array(
            "standings_info" => $result,
            "conference_list" => $conference_list["cn"],
            "division_list" => $division_list["cn"]
        );
    }
}
?>