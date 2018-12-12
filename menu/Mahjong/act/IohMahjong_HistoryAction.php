<?php

/**
 *
 * @author Kinsama
 * @version 2018-05-02
 */
class IohMahjong_HistoryAction extends ActionBase
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
        $m_id = $request->getParameter("m_id");
        $game_info = IohMahjongDBI::getGameInfoById($m_id);
        if ($controller->isError($game_info)) {
            $game_info->setPos(__FILE__, __LINE__);
            return $game_info;
        }
        if (!isset($game_info[$m_id])) {
            $controller->redirect("./?menu=mahjong&act=start");
        }
        $game_info = $game_info[$m_id];
        $game_detail = IohMahjongDBI::getGameDetailById($m_id);
        if ($controller->isError($game_detail)) {
            $game_detail->setPos(__FILE__, __LINE__);
            return $game_detail;
        }
        $game_history = IohMahjongDBI::getGameHistoryById($m_id);
        if ($controller->isError($game_history)) {
            $game_history->setPos(__FILE__, __LINE__);
            return $game_history;
        }
        $request->setAttribute("game_info", $game_info);
        $request->setAttribute("game_detail", $game_detail);
        $request->setAttribute("game_history", $game_history);
        $request->setAttribute("m_id", $m_id);
        $request->setAttribute("ts", time());
        $restart_flg = false;
        $updated_time = time() - strtotime($game_info["update_date"]);
        if ($game_info["final_flg"] && $updated_time <= 600) {
            $restart_flg = true;
        }
        $request->setAttribute("restart_flg", $restart_flg);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $m_id = $request->getAttribute("m_id");
        $game_info = $request->getAttribute("game_info");
        $game_detail = $request->getAttribute("game_detail");
        $game_history = $request->getAttribute("game_history");
        $series_data_player_name = array();
        $series_data_round_number = array();
        $series_data_banker_point_trend = array();
        $series_data_player_point_trend = array();
        $series_data_round_base_point = array();
        $series_data_player_point_total = array();
        $series_data_player_point_four = array();
        $player_num = array();
        foreach ($game_detail as $detail_info) {
            $player_num[$detail_info["m_player"]] = $detail_info["m_player"];
            $series_data_player_name[] = $detail_info["m_player_name"];
            $series_data_player_point_total[] = (int) $detail_info["m_point"];
            $series_data_player_point_four[] = $detail_info["m_gang_point"] * 3;
            $series_data_player_point_trend[$detail_info["m_player"]] = array();
        }
        foreach ($game_history as $his_key => $history_info) {
            $series_data_round_number[] = $history_info["m_round"] . "/" . $history_info["m_part"];
            $series_data_round_base_point[] = (int) $history_info["win_base_point"];
            $banker_key = "point_player_" . $history_info["banker_player"];
            if ($his_key == 0) {
                $series_data_banker_point_trend[] = $history_info[$banker_key] - $game_info["m_point"];
            } else {
                $series_data_banker_point_trend[] = $history_info[$banker_key] - $game_history[$his_key - 1][$banker_key];
            }
            foreach ($player_num as $m_player) {
                $player_key = "point_player_" . $m_player;
                $series_data_player_point_trend[$m_player][] = (int) $history_info[$player_key];
            }
        }
        $json_result = array();
        $json_result["player_name"] = $series_data_player_name;
        $json_result["round_number"] = $series_data_round_number;
        $json_result["player_point"] = $series_data_player_point_total;
        $json_result["player_point_gang"] = $series_data_player_point_four;
        $json_result["winner_point"] = $series_data_round_base_point;
        $json_result["banker_point"] = $series_data_banker_point_trend;
        foreach ($player_num as $m_player_tmp) {
            $json_key = "player_" . $m_player_tmp . "_point";
            $json_result[$json_key] = $series_data_player_point_trend[$m_player_tmp];
        }
        $javascript_text = '<script type="text/javascript">' . "\n";
        $javascript_text .= "var m_point = " . $game_info["m_point"] . ";\n";
        foreach ($game_detail as $detail_info) {
            $javascript_text .= "var player_name_" . $detail_info["m_player"] . ' = "' . $detail_info["m_player_name"] . "\";\n";
        }
        foreach ($json_result as $json_key => $json_value) {
            $javascript_text .= "var " . $json_key . " = [";
            if ($json_key == "player_name" || $json_key == "round_number") {
                $javascript_text .= '"' . implode('", "', $json_value) . '"';
            } else {
                $javascript_text .= implode(', ', $json_value);
            }
            $javascript_text .= "];\n";
        }
        $javascript_text .= '</script>';
        $request->setAttribute("javascript_text", $javascript_text);
        return VIEW_DONE;
    }
}
?>