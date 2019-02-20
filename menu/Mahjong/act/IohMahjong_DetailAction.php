<?php

/**
 *
 * @author Kinsama
 * @version 2018-04-30
 */
class IohMahjong_DetailAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("win")) {
            $ret = $this->_doWinExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("four")) {
            $ret = $this->_doFourExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("round")) {
            $ret = $this->_doRoundExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("pull")) {
            $ret = $this->_doPullExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } else {
            $ret = $this->_doDefaultExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        }
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
        if ($game_info["final_flg"]) {
            $controller->redirect("./?menu=mahjong&act=history&m_id=" . $m_id);
        }
        $game_detail = IohMahjongDBI::getGameDetailById($m_id);
        if ($controller->isError($game_detail)) {
            $game_detail->setPos(__FILE__, __LINE__);
            return $game_detail;
        }
        $banker_player = 0;
        foreach ($game_detail as $m_player => $item) {
            if ($item["m_banker_flg"]) {
                $banker_player = $m_player;
                break;
            }
        }
        $request->setAttribute("game_info", $game_info);
        $request->setAttribute("game_detail", $game_detail);
        $request->setAttribute("m_id", $m_id);
        $request->setAttribute("banker_player", $banker_player);
        $request->setAttribute("ts", time());
        $request->setAttribute("pull_banker", $this->_getPullBankerArr($game_info["m_pullbanker"]));
        $request->setAttribute("pull_banker_list", $this->_getPullBankerList($game_info["m_pullbanker"]));
        return VIEW_DONE;
    }

    private function _doWinExecute(Controller $controller, User $user, Request $request)
    {
        $m_id = $request->getAttribute("m_id");
        $game_info = $request->getAttribute("game_info");
        $game_detail = $request->getAttribute("game_detail");
        $banker_player = $request->getAttribute("banker_player");
        $pull_banker = $request->getAttribute("pull_banker");
        $win_info = $request->getParameter("win");
        $m_player = $this->_getFirstKey($win_info);
        $base_point = $win_info[$m_player];
        if ($base_point == "0") {
            $controller->redirect("./?menu=mahjong&act=detail&m_id=" . $m_id);
        }
        $continue_banker = false;
        if ($banker_player == $m_player) {
            $continue_banker = true;
        }
        $win_times_info = $request->getParameter("win_times");
        $win_times_info = $win_times_info[$m_player];
        $win_type_name = "";
        $gangkai_times = $win_times_info["gangkai"];
        switch ($base_point) {
            case "1":
                $win_plus_info = $win_times_info[$base_point];
                if ($win_plus_info["0"]) {
                    $win_type_name = "素提溜";
                } else {
                    $win_type_name = "提溜";
                }
                break;
            case "2":
                $win_type_name = "混吊";
                break;
            case "3":
                if ($gangkai_times > 3) {
                    break;
                }
                $win_plus_info = $win_times_info[$base_point];
                if (!$win_plus_info["0"] && !$win_plus_info["1"]) {
                    $win_type_name = "捉伍";
                } elseif ($win_plus_info["0"] && !$win_plus_info["1"]) {
                    $win_type_name = "素伍";
                } elseif (!$win_plus_info["0"] && $win_plus_info["1"]) {
                    $win_type_name = "双混伍";
                }
                break;
            case "4":
                if ($gangkai_times > 1) {
                    break;
                }
                $win_plus_info = $win_times_info[$base_point];
                if (!$win_plus_info["0"] && !$win_plus_info["1"] && !$win_plus_info["2"]) {
                    $win_type_name = "龙";
                } elseif ($win_plus_info["0"] && !$win_plus_info["1"] && !$win_plus_info["2"]) {
                    $win_type_name = "素龙";
                } elseif (!$win_plus_info["0"] && $win_plus_info["1"] && !$win_plus_info["2"]) {
                    $win_type_name = "混吊龙";
                } elseif (!$win_plus_info["0"] && !$win_plus_info["1"] && $win_plus_info["2"]) {
                    $win_type_name = "本混龙";
                } elseif ($win_plus_info["0"] && !$win_plus_info["1"] && $win_plus_info["2"]) {
                    $win_type_name = "素本龙";
                } elseif (!$win_plus_info["0"] && $win_plus_info["1"] && $win_plus_info["2"]) {
                    $win_type_name = "混吊本混龙";
                }
                break;
            case "7":
                if ($gangkai_times > 1) {
                    break;
                }
                $win_plus_info = $win_times_info[$base_point];
                if (!$win_plus_info["0"] && !$win_plus_info["1"] && !$win_plus_info["2"]) {
                    $win_type_name = "捉伍龙";
                } elseif ($win_plus_info["0"] && !$win_plus_info["1"] && !$win_plus_info["2"]) {
                    $win_type_name = "素伍龙";
                } elseif (!$win_plus_info["0"] && $win_plus_info["1"] && !$win_plus_info["2"]) {
                    $win_type_name = "双混伍龙";
                } elseif (!$win_plus_info["0"] && !$win_plus_info["1"] && $win_plus_info["2"]) {
                    $win_type_name = "本混捉伍龙";
                } elseif ($win_plus_info["0"] && !$win_plus_info["1"] && $win_plus_info["2"]) {
                    $win_type_name = "素本捉伍龙";
                } elseif (!$win_plus_info["0"] && $win_plus_info["1"] && $win_plus_info["2"]) {
                    $win_type_name = "本混双伍龙";
                }
                break;
        }
        if ($win_type_name == "") {
            $controller->redirect("./?menu=mahjong&act=detail&m_id=" . $m_id);
        }
        if ($gangkai_times > 0) {
            $win_type_name = "杠开" . $win_type_name;
        }
        if ($win_times_info["tianhu"]) {
            $win_type_name .= "(天和)";
        }
        $times = 0;
        if ($win_times_info["tianhu"]) {
            $times += 2;
        }
        $times += $win_times_info["gangkai"];
        if (isset($win_times_info[$base_point])) {
            foreach ($win_times_info[$base_point] as $win_items_item) {
                if ($win_items_item) {
                    $times += 1;
                }
            }
        }
        $point = $base_point * pow(2, $times);
        if ($point < 2) {
            $controller->redirect("./?menu=mahjong&act=detail&m_id=" . $m_id);
        }
        $info_update_data = array();
        $detail_update_data = array();
        $history_insert_data = array();
        $info_update_data["m_part"] = $game_info["m_part"] + 1;
        if ($banker_player == "4" && !$continue_banker) {
            $info_update_data["m_round"] = $game_info["m_round"] + 1;
            $info_update_data["m_part"] = 1;
        }
        $info_update_data["m_pullbanker"] = "0000";
        $history_insert_data["m_id"] = $m_id;
        $history_insert_data["m_round"] = $game_info["m_round"];
        $history_insert_data["m_part"] = $game_info["m_part"];
        $history_insert_data["banker_player"] = $banker_player;
        $history_insert_data["winner_player"] = $m_player;
        $history_insert_data["win_type_name"] = $win_type_name;
        $history_insert_data["win_base_point"] = $point;
        $finishi_flg = false;
        foreach ($game_detail as $detail_item) {
            $his_key = "point_player_" . $detail_item["m_player"];
            $update_data = array();
            if ($continue_banker) {
                if ($detail_item["m_player"] == $banker_player) {
                    $base_times = 0;
                    foreach ($pull_banker as $pull_idx => $pull_itm) {
                        if ($pull_idx != $detail_item["m_player"]) {
                            $base_times += pow(2, $pull_itm + 1);
                        }
                    }
                    $update_data["m_point"] = $detail_item["m_point"] + $point * $base_times;
                } else {
                    $update_data["m_point"] = $detail_item["m_point"] - $point * pow(2, $pull_banker[$detail_item["m_player"]] + 1);
                }
            } else {
                if ($detail_item["m_player"] == $banker_player) {
                    $update_data["m_point"] = $detail_item["m_point"] - $point * pow(2, $pull_banker[$m_player] + 1);
                    $update_data["m_banker_flg"] = 0;
                } elseif ($detail_item["m_player"] == $m_player) {
                    $update_data["m_point"] = $detail_item["m_point"] + $point * (pow(2, $pull_banker[$m_player] + 1) + 2);
                } else {
                    $update_data["m_point"] = $detail_item["m_point"] - $point;
                }
                if ($detail_item["m_player"] == $this->_nextBanker($banker_player)) {
                    $update_data["m_banker_flg"] = 1;
                }
            }
            if ($update_data["m_point"] < 0) {
                $finishi_flg = true;
            }
            $detail_update_data[$detail_item["m_player"]] = $update_data;
            $history_insert_data[$his_key] = $update_data["m_point"];
        }
        $dbi = Database::getInstance();
        $dbi->begin();
        $where = "`m_id` = " . $m_id;
        if ($finishi_flg) {
            $info_update_data["final_flg"] = 1;
        }
        $update_res = IohMahjongDBI::updateMahjong($info_update_data, $where);
        if ($controller->isError($update_res)) {
            $update_res->setPos(__FILE__, __LINE__);
            $dbi->rollback();
            return $update_res;
        }
        foreach ($detail_update_data as $target_m_player => $target_update_data) {
            $this_where = $where . " AND `m_player` = " . $target_m_player;
            $update_res = IohMahjongDBI::updateMahjongDetail($target_update_data, $this_where);
            if ($controller->isError($update_res)) {
                $update_res->setPos(__FILE__, __LINE__);
                $dbi->rollback();
                return $update_res;
            }
        }
        $insert_res = IohMahjongDBI::insertMahjongHistory($history_insert_data);
        if ($controller->isError($insert_res)) {
            $insert_res->setPos(__FILE__, __LINE__);
            $dbi->rollback();
            return $insert_res;
        }
        $dbi->commit();
        if ($finishi_flg) {
            $controller->redirect("./?menu=mahjong&act=history&m_id=" . $m_id);
        } else {
            $controller->redirect("./?menu=mahjong&act=detail&m_id=" . $m_id);
        }
        return VIEW_DONE;
    }

    private function _doFourExecute(Controller $controller, User $user, Request $request)
    {
        $four_option = $request->getParameter("four");
        $m_player = $this->_getFirstKey($four_option);
        $point = $four_option[$m_player];
        $m_id = $request->getAttribute("m_id");
        $game_info = $request->getAttribute("game_info");
        $game_detail = $request->getAttribute("game_detail");
        $dbi = Database::getInstance();
        $dbi->begin();
        foreach ($game_detail as $item_detail) {
            $where = "`m_id` = " . $m_id . " AND `m_player` = " . $item_detail["m_player"];
            $update_data = array();
            if ($item_detail["m_player"] == $m_player) {
                $update_data["m_point"] = $game_detail[$item_detail["m_player"]]["m_point"] + $point * 3;
                $update_data["m_gang_point"] = $game_detail[$item_detail["m_player"]]["m_gang_point"] + $point;
            } else {
                $update_data["m_point"] = $game_detail[$item_detail["m_player"]]["m_point"] - $point;
            }
            $update_res = IohMahjongDBI::updateMahjongDetail($update_data, $where);
            if ($controller->isError($update_res)) {
                $update_res->setPos(__FILE__, __LINE__);
                $dbi->rollback();
                return $update_res;
            }
        }
        $dbi->commit();
        $controller->redirect("./?menu=mahjong&act=detail&m_id=" . $m_id);
        return VIEW_DONE;
    }

    private function _doRoundExecute(Controller $controller, User $user, Request $request)
    {
        $round = $request->getParameter("round");
        $m_id = $request->getAttribute("m_id");
        $game_info = $request->getAttribute("game_info");
        $game_detail = $request->getAttribute("game_detail");
        $banker_player = $request->getAttribute("banker_player");
        $where = "`m_id` = " . $m_id;
        $dbi = Database::getInstance();
        $dbi->begin();
        switch ($round) {
            case "1":
                foreach ($game_detail as $m_player => $item_detail) {
                    $this_where = $where . " AND `m_player` = " . $m_player;
                    $point = $item_detail["m_point"];
                    if ($item_detail["m_banker_flg"]) {
                        $point -= 3;
                    } else {
                        $point += 1;
                    }
                    $update_data = array();
                    $update_data["m_point"] = $point;
                    $update_res = IohMahjongDBI::updateMahjongDetail($update_data, $this_where);
                    if ($controller->isError($update_res)) {
                        $update_res->setPos(__FILE__, __LINE__);
                        $dbi->rollback();
                        return $update_res;
                    }
                }
                $dbi->commit();
                $controller->redirect("./?menu=mahjong&act=detail&m_id=" . $m_id);
                break;
            case "2":
                $update_data = array();
                $update_data["m_part"] = $game_info["m_part"] + 1;
                $update_res = IohMahjongDBI::updateMahjong($update_data, $where);
                if ($controller->isError($update_res)) {
                    $update_res->setPos(__FILE__, __LINE__);
                    $dbi->rollback();
                    return $update_res;
                }
                $insert_data = array();
                $insert_data["m_id"] = $m_id;
                $insert_data["m_round"] = $game_info["m_round"];
                $insert_data["m_part"] = $game_info["m_part"];
                $insert_data["banker_player"] = $banker_player;
                $insert_data["winner_player"] = "0";
                $insert_data["win_type_name"] = "流局";
                $insert_data["win_base_point"] = "0";
                foreach ($game_detail as $detail_item) {
                    $data_key = "point_player_" . $detail_item["m_player"];
                    $insert_data[$data_key] = $detail_item["m_point"];
                }
                $insert_res = IohMahjongDBI::insertMahjongHistory($insert_data);
                if ($controller->isError($insert_res)) {
                    $insert_res->setPos(__FILE__, __LINE__);
                    $dbi->rollback();
                    return $insert_res;
                }
                $dbi->commit();
                $controller->redirect("./?menu=mahjong&act=detail&m_id=" . $m_id);
                break;
            case "3":
                $update_data = array();
                $update_data["final_flg"] = "1";
                $update_res = IohMahjongDBI::updateMahjong($update_data, $where);
                if ($controller->isError($update_res)) {
                    $update_res->setPos(__FILE__, __LINE__);
                    $dbi->rollback();
                    return $update_res;
                }
                $dbi->commit();
                $controller->redirect("./?menu=mahjong&act=history&m_id=" . $m_id);
                break;
        }
        $dbi->commit();
        return VIEW_DONE;
    }

    private function _doPullExecute(Controller $controller, User $user, Request $request)
    {
        $m_id = $request->getAttribute("m_id");
        $game_info = $request->getAttribute("game_info");
        $update_data = array(
            "m_pullbanker" => $request->getParameter("pull")
        );
        $where = "`m_id` = " . $m_id;
        $update_res = IohMahjongDBI::updateMahjong($update_data, $where);
        if ($controller->isError($update_res)) {
            $update_res->setPos(__FILE__, __LINE__);
            return $update_res;
        }
        $controller->redirect("./?menu=mahjong&act=detail&m_id=" . $m_id);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }

    private function _getFirstKey($data)
    {
        $key_list = array_keys($data);
        return $key_list[0];
    }

    private function _nextBanker($now_banker)
    {
        return $now_banker > 3 ? 1 : $now_banker + 1;
    }

    private function _getPullBankerArr($pull_banker_str)
    {
        $result = array();
        for ($i = 1; $i <= strlen($pull_banker_str); $i++) {
            $result[$i] = substr($pull_banker_str, $i - 1, 1);
        }
        return $result;
    }

    private function _getPullBankerList($pull_banker_str)
    {
        $pull_banker_arr = $this->_getPullBankerArr($pull_banker_str);
        $player_list = array_keys($pull_banker_arr);
        $result = array();
        foreach ($player_list as $m_player) {
            for ($i = 0; $i < 3; $i++) {
                $base_times_arr = $pull_banker_arr;
                $base_times_arr[$m_player] = $i;
                $result[$m_player][$i] = implode("", $base_times_arr);
            }
        }
        return $result;
    }
}
?>