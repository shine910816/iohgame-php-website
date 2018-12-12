<?php
require_once SRC_PATH . "/menu/MahjongGame/lib/IohMahjongGame_Master.php";
require_once SRC_PATH . "/menu/MahjongGame/lib/IohMahjongGame_Slave.php";

/**
 * Mahjong game
 * @author Kinsama
 * @version 2018-08-09
 */
class IohUsrApi_MahjongGameAction
{

    private $_master;

    private $_slave;

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("refresh")) {
            $ret = $this->_doRefreshExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("kong")) {
            $ret = $this->_doKongExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("pong")) {
            $ret = $this->_doPongExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("cancel")) {
            $ret = $this->_doCancelExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("win")) {
            $ret = $this->_doWinExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("drop")) {
            $ret = $this->_doDropExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } else {
            $ret = array(
                "none_data" => null
            );
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
        $this->_master = IohMahjongGame_Master::getInstance();
        $this->_slave = IohMahjongGame_Slave::getInstance();
        $m_room_id = "0";
        $banker_player = 1;
        if ($request->hasParameter("m_room_id")) {
            $m_room_id = $request->getParameter("m_room_id");
        } elseif ($request->hasParameter("start_game")) {
            $m_room_id = $request->getParameter("start_game");
        }
        if ($m_room_id == "0") {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "参数m_room_id值被窜改");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        if ($request->hasParameter("banker_player")) {
            $banker_player = $request->getParameter("banker_player");
        }
        $player_id = $user->getVariable("cus_id");
        $player_id = "102";
        $player_position = IohMahjongGameDBI::getPlayerPosition($m_room_id, $player_id);
        if ($controller->isError($player_position)) {
            $player_position->setPos(__FILE__, __LINE__);
            return $player_position;
        }
        if ($player_position == "0") {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "参数cus_id值被窜改");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $m_table_id = IohMahjongGameDBI::getTableIdFromRoom($m_room_id);
        if ($controller->isError($m_table_id)) {
            $m_table_id->setPos(__FILE__, __LINE__);
            return $m_table_id;
        }
        $m_order_id = "0";
        if ($request->hasParameter("drop")) {
            $m_order_id = $request->getParameter("drop");
        }
        $tile_type = "0";
        if ($request->hasParameter("kong")) {
            $tile_type = $request->getParameter("kong");
        }
        $request->setAttribute("m_room_id", $m_room_id);
        $request->setAttribute("banker_player", $banker_player);
        $request->setAttribute("player_position", $player_position);
        $request->setAttribute("m_table_id", $m_table_id);
        $request->setAttribute("m_order_id", $m_order_id);
        $request->setAttribute("tile_type", $tile_type);
        return VIEW_DONE;
    }

    private function _doRefreshExecute(Controller $controller, User $user, Request $request)
    {
        $m_table_id = $request->getAttribute("m_table_id");
        $table_info = IohMahjongGameDBI::getTableInfo($m_table_id);
        if ($controller->isError($table_info)) {
            $table_info->setPos(__FILE__, __LINE__);
            return $table_info;
        }
        return array(
            "target" => $table_info[$m_table_id]["m_turn_player"]
        );
    }

    private function _doWinExecute(Controller $controller, User $user, Request $request)
    {
    }

    private function _doCancelExecute(Controller $controller, User $user, Request $request)
    {
    }

    private function _doKongExecute(Controller $controller, User $user, Request $request)
    {
    }

    private function _doPongExecute(Controller $controller, User $user, Request $request)
    {
    }

    private function _doDropExecute(Controller $controller, User $user, Request $request)
    {
        // 基本参数获取
        $m_table_id = $request->getAttribute("m_table_id");
        $m_order_id = $request->getAttribute("m_order_id");
        $player_position = $request->getAttribute("player_position");
        // 待检证玩家
        $next_player = $this->_slave->getNextPlayer($player_position);
        $oppo_player = $this->_slave->getOppoPlayer($player_position);
        $prev_player = $this->_slave->getPrevPlayer($player_position);
        $check_list = array(
            $next_player,
            $oppo_player,
            $prev_player
        );
        // 打出牌信息
        $drop_card_info = IohMahjongGameDBI::getCardInfoByOrderId($m_table_id, $m_order_id);
        if ($controller->isError($drop_card_info)) {
            $drop_card_info->setPos(__FILE__, __LINE__);
            return $drop_card_info;
        }
        $drop_card_type = $drop_card_info["c_type"];
        // 手牌信息
        $hand_card_info = IohMahjongGameDBI::getCardNumberGroupByType($m_table_id);
        if ($controller->isError($hand_card_info)) {
            $hand_card_info->setPos(__FILE__, __LINE__);
            return $hand_card_info;
        }
        // 碰杠结果集
        $check_pong_kong_result = "0";
        foreach ($check_list as $check_player) {
            if (isset($hand_card_info[$check_player][$drop_card_type])) {
                if ($hand_card_info[$check_player][$drop_card_type]["0"] > 1) {
                    $check_pong_kong_result = $check_player;
                    break;
                }
            }
        }
        $dbi = Database::getInstance();
        $begin_res = $dbi->begin();
        if ($dbi->isError($begin_res)) {
            $begin_res->setPos(__FILE__, __LINE__);
            $dbi->rollback();
            return $begin_res;
        }
        // 目标牌信息
        $target_card_info = IohMahjongGameDBI::getTargetCard($m_table_id);
        if ($controller->isError($target_card_info)) {
            $target_card_info->setPos(__FILE__, __LINE__);
            $dbi->rollback();
            return $target_card_info;
        }
        if (empty($target_card_info)) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "参数m_room_id值被窜改");
            $err->setPos(__FILE__, __LINE__);
            $dbi->rollback();
            return $err;
        }
        // 目标牌信息更新
        $target_order_id = $target_card_info["m_order_id"];
        $target_update_data = array();
        $target_update_data["m_card_target_flg"] = "0";
        $target_update_where = sprintf("m_order_id = %s AND m_table_id = %s", $target_order_id, $m_table_id);
        $target_update_res = IohMahjongGameDBI::updateTableCard($target_update_data, $target_update_where);
        if ($dbi->isError($target_update_res)) {
            $target_update_res->setPos(__FILE__, __LINE__);
            $dbi->rollback();
            return $begin_res;
        }
        // -------------------------------------
        // 有碰杠时的处理
        // -------------------------------------
        if ($check_pong_kong_result != "0") {
            // 打出牌信息更新
            $drop_update_data = array();
            $drop_update_data["m_card_position"] = "5";
            $drop_update_data["m_drop_from"] = $player_position;
            $drop_update_data["m_card_getable_flg"] = "1";
            $drop_update_data["m_card_target_flg"] = "1";
            $drop_update_where = sprintf("m_order_id = %s AND m_table_id = %s", $m_order_id, $m_table_id);
            $drop_update_res = IohMahjongGameDBI::updateTableCard($drop_update_data, $drop_update_where);
            if ($dbi->isError($drop_update_res)) {
                $drop_update_res->setPos(__FILE__, __LINE__);
                $dbi->rollback();
                return $drop_update_res;
            }
            // 牌桌信息更新
            $table_update_data = array();
            $table_update_data["m_request_player"] = $check_pong_kong_result;
            $table_update_where = sprintf("m_table_id = %s", $m_table_id);
            $table_update_res = IohMahjongGameDBI::updateTable($table_update_data, $table_update_where);
            if ($dbi->isError($table_update_res)) {
                $table_update_res->setPos(__FILE__, __LINE__);
                $dbi->rollback();
                return $table_update_res;
            }
            // -------------------------------------
            // 无碰杠时的处理
            // -------------------------------------
        } else {
            // 打出牌信息更新
            $drop_update_data = array();
            $drop_update_data["m_card_position"] = "5";
            $drop_update_data["m_drop_from"] = $player_position;
            $drop_update_where = sprintf("m_order_id = %s AND m_table_id = %s", $m_order_id, $m_table_id);
            $drop_update_res = IohMahjongGameDBI::updateTableCard($drop_update_data, $drop_update_where);
            if ($dbi->isError($drop_update_res)) {
                $drop_update_res->setPos(__FILE__, __LINE__);
                $dbi->rollback();
                return $drop_update_res;
            }
            // 获取新的牌
            $get_order_id = $this->_slave->getTileAsc($m_table_id);
            if ($dbi->isError($get_order_id)) {
                $get_order_id->setPos(__FILE__, __LINE__);
                $dbi->rollback();
                return $get_order_id;
            }
            $table_update_data = array();
            // 无法获取新牌时以流局结算
            if ($get_order_id == "0") {
                $table_update_data["m_finish_flg"] = "1";
            } else {
                // 获取牌信息更新
                $get_update_data = array();
                $get_update_data["m_card_position"] = $next_player;
                $get_update_data["m_card_getable_flg"] = "0";
                $get_update_data["m_card_target_flg"] = "1";
                $get_update_where = sprintf("m_order_id = %s AND m_table_id = %s", $get_order_id, $m_table_id);
                $get_update_res = IohMahjongGameDBI::updateTableCard($get_update_data, $get_update_where);
                if ($dbi->isError($get_update_res)) {
                    $get_update_res->setPos(__FILE__, __LINE__);
                    $dbi->rollback();
                    return $get_update_res;
                }
                $table_update_data["m_turn_player"] = $next_player;
                $table_update_data["m_request_player"] = $next_player;
            }
            // 牌桌信息更新
            $table_update_where = sprintf("m_table_id = %s", $m_table_id);
            $table_update_res = IohMahjongGameDBI::updateTable($table_update_data, $table_update_where);
            if ($dbi->isError($table_update_res)) {
                $table_update_res->setPos(__FILE__, __LINE__);
                $dbi->rollback();
                return $table_update_res;
            }
        }
        $commit_res = $dbi->commit();
        if ($dbi->isError($commit_res)) {
            $commit_res->setPos(__FILE__, __LINE__);
            $dbi->rollback();
            return $commit_res;
        }
    }
}
?>