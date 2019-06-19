<?php

/**
 * NBA比赛详情
 * @author Kinsama
 * @version 2019-04-23
 */
class IohNba_GameDetailAction
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
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Game ID is invalid.");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $game_id = $request->getParameter("id");
        $game_base_info = IohNbaDBI::selectGameBaseInfo($game_id);
        if ($controller->isError($game_base_info)) {
            $game_base_info->setPos(__FILE__, __LINE__);
            return $game_base_info;
        }
        if (!isset($game_base_info[$game_id])) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Game ID is invalid.");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $game_base_info = $game_base_info[$game_id];
        $game_date = $game_base_info["game_date"];
        $game_season = $game_base_info["game_season"];
        $game_season_stage = $game_base_info["game_season_stage"];
        $game_start = date("n月j日 H:i ", strtotime($game_base_info["game_start_date"]));
        $arena_list = IohNbaEntity::getArenaList();
        $game_arena = $game_base_info["game_arena"];
        if (isset($arena_list[$game_base_info["game_arena"]])) {
            $game_arena = $arena_list[$game_base_info["game_arena"]];
        }
        $result = array(
            "base" => array(
                "id" => $game_id,
                "season" => $game_season,
                "season_stage" => $game_season_stage,
                "start" => $game_start,
                "arena" => $game_arena,
            ),
            "team" => array(),
            "box_score" => array(),
            "play_by_play" => array()
        );
        $away_linescore = explode(",", $game_base_info["game_away_line_score"]);
        $home_linescore = explode(",", $game_base_info["game_home_line_score"]);
        if (count($away_linescore) != count($home_linescore)) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Data error.");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $game_current = count($away_linescore);
        $game_current_name = array();
        for ($c_name = 1; $c_name <= $game_current; $c_name++) {
            if ($c_name > 4) {
                $game_current_name[] = "OT" . ($c_name - 4);
            } else {
                $game_current_name[] = "Q" . $c_name;
            }
        }
Utility::testVariable($game_base_info);
        //Play by play package
        //if ($game_current > 0) {
        //    for ($i = 0; $i < $game_current; $i++) {
        //        $pbp_json = Utility::transJson("http://data.nba.net/10s/prod/v1/" . $game_date . "/00" . $game_id . "_pbp_" . ($i + 1) . ".json");
        //        if ($controller->isError($pbp_json)) {
        //            continue;
        //        }
        //        $pbp_item = array(
        //            "current_name" => $game_current_name[$i],
        //            "plays" => array()
        //        );
        //        foreach ($pbp_json["plays"] as $play_by_play_item) {
        //            $item = array(
        //                "current" => $pbp_item["current_name"],
        //                "clock" => $play_by_play_item["clock"],
        //                "type" => $play_by_play_item["eventMsgType"],
        //                "p_id" => $play_by_play_item["personId"],
        //                "t_id" => $play_by_play_item["teamId"],
        //                "score" => $play_by_play_item["vTeamScore"] . "-" . $play_by_play_item["hTeamScore"],
        //                "change" => $play_by_play_item["isScoreChange"] ? "1" : "0",
        //                "desc" => ""
        //            );
        //            $desc = $play_by_play_item["formatted"]["description"];
        //            if (strpos($desc, " - ")) {
        //                $desc_arr = explode(" - ", $desc);
        //                $item["desc"] = $desc_arr[1];
        //            } else {
        //                $item["desc"] = $desc;
        //            }
        //            $pbp_item["plays"][] = $item;
        //        }
        //        $result["play_by_play"][$pbp_item["current_name"]] = $pbp_item["plays"];
        //    }
        //}
        return $result;
    }
}
?>