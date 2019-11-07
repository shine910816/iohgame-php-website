<?php

/**
 * NBA球员列表
 * @author Kinsama
 * @version 2019-11-07
 */
class IohNba_PlayerListAction
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
        $detail_flg = true;
        $player_list = IohNbaDBI::selectStandardPlayerGroupByTeam(true);
        if ($controller->isError($player_list)) {
            $player_list->setPos(__FILE__, __LINE__);
            return $player_list;
        }
        if ($request->hasParameter("only")) {
            return array_keys($player_list);
        }
        $team_list = IohNbaDBI::getFranchiseTeamList();
        if ($controller->isError($team_list)) {
            $team_list->setPos(__FILE__, __LINE__);
            return $team_list;
        }
        $alpha_list = IohNbaEntity::getNameAlphabet();
        $position_list = array(
            "1" => "中锋",
            "2" => "前锋",
            "3" => "后卫"
        );
        $result = array();
        foreach ($player_list as $p_id => $player_info) {
            $alpha_name = $alpha_list[$player_info["p_name_alphabet"]];
            $player_name = $player_info["p_first_name"] . " " . $player_info["p_last_name"];
            if ($player_info["p_name_cnf_flg"]) {
                $player_name = $player_info["p_name"];
            }
            $player_position = $position_list[$player_info["p_position"]];
            if ($player_info["p_position_2"]) {
                $player_position .= "-" . $position_list[$player_info["p_position_2"]];
            }
            $team_name = $team_list[$player_info["t_id"]]["t_name_cn"];
            $team_color = $team_list[$player_info["t_id"]]["t_color"];
            $result[$alpha_name][$p_id] = array(
                "id" => $p_id,
                "name" => $player_name,
                "team" => $team_name,
                "color" => $team_color,
                "jersey" => $player_info["p_jersey"],
                "pos" => $player_position
            );
        }
        return $result;
    }
}
?>