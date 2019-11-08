<?php

/**
 * NBA球员列表
 * @author Kinsama
 * @version 2019-11-07
 */
class IohNba_PlayerInfoAction
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
        if (!$request->hasParameter("id")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Player ID is invalid.");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        if (!$request->hasParameter("year")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Game season is invalid.");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        if (!$request->hasParameter("stage")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Game season stage is invalid.");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $p_id = $request->getParameter("id");
        $game_season = $request->getParameter("year");
        $game_season_stage = $request->getParameter("stage");
        $player_info = IohNbaDBI::selectPlayer($p_id);
        if ($controller->isError($player_info)) {
            $player_info->setPos(__FILE__, __LINE__);
            return $player_info;
        }
        if (!isset($player_info[$p_id])) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Player ID is invalid.");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $team_list = IohNbaDBI::getTeamList();
        if ($controller->isError($team_list)) {
            $team_list->setPos(__FILE__, __LINE__);
            return $team_list;
        }
        $player_base_info = array();
        if ($player_info[$p_id]["p_name_cnf_flg"]) {
            $player_base_info["name"] = $player_info[$p_id]["p_name"];
        } else {
            $player_base_info["name"] = $player_info[$p_id]["p_first_name"] . " " . $player_info[$p_id]["p_last_name"];
        }
        $player_base_info["name_en"] = $player_info[$p_id]["p_first_name"] . " " . $player_info[$p_id]["p_last_name"];
        $position_list = array(
            "1" => "中锋",
            "2" => "前锋",
            "3" => "后卫"
        );
        $player_base_info["pos"] = $position_list[$player_info[$p_id]["p_position"]];
        if ($player_info[$p_id]["p_position_2"]) {
            $player_base_info["pos"] .= "-" . $position_list[$player_info[$p_id]["p_position_2"]];
        }
        $player_base_info["jersey"] = $player_info[$p_id]["p_jersey"];
        $player_base_info["t_id"] = $player_info[$p_id]["t_id"];
        $player_base_info["team"] = "Undefined";
        if (isset($team_list[$player_info[$p_id]["t_id"]])) {
            $player_base_info["team"] = $team_list[$player_info[$p_id]["t_id"]]["t_city_cn"] . $team_list[$player_info[$p_id]["t_id"]]["t_name_cn"];
        }
//Utility::testVariable($player_base_info);
        return array(
            "base" => $player_base_info
        );
    }
}
?>