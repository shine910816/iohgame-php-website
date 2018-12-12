<?php
require_once SRC_PATH . "/menu/MahjongGame/lib/IohMahjongGame_Master.php";
require_once SRC_PATH . "/menu/MahjongGame/lib/IohMahjongGame_Slave.php";

/**
 *
 * @author Kinsama
 * @version 2018-08-02
 */
class IohMahjongGame_PlayAction extends ActionBase
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
        if ($request->hasParameter("start_game")) {
            $ret = $this->_doStartExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif (!$request->getAttribute("m_table_id")) {
            $ret = $this->_doWaitExecute($controller, $user, $request);
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
        $request->setAttribute("m_room_id", $m_room_id);
        $request->setAttribute("banker_player", $banker_player);
        $request->setAttribute("player_position", $player_position);
        $request->setAttribute("m_table_id", $m_table_id);
        $request->setAttribute("refresh_flg", false);
        $request->setAttribute("pong_highlight_flg", false);
        $request->setAttribute("kong_highlight_flg", false);
        $request->setAttribute("win_highlight_flg", false);
        $request->setAttribute("cancel_highlight_flg", false);
        $request->setAttribute("target_player", "0");
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        // 基本数据获取
        $m_room_id = $request->getAttribute("m_room_id");
        $m_table_id = $request->getAttribute("m_table_id");
        $player_position = $request->getAttribute("player_position");
        // 牌桌信息获取
        $table_info = IohMahjongGameDBI::getTableInfo($m_table_id);
        if ($controller->isError($table_info)) {
            $table_info->setPos(__FILE__, __LINE__);
            return $table_info;
        }
        if (!isset($table_info[$m_table_id])) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "参数m_table_id值被窜改");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $table_info = $table_info[$m_table_id];
        // 目标信息获取
        $target_info = IohMahjongGameDBI::getTargetCard($m_table_id);
        if ($controller->isError($target_info)) {
            $target_info->setPos(__FILE__, __LINE__);
            return $target_info;
        }
        if (empty($target_info)) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "参数m_table_id值被窜改");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        // Utility::testVariable($table_info);
        // 可开杠牌组
        $kong_able_list = array();
        // -----------------------------
        // 目标玩家为自己时
        // -----------------------------
        if ($table_info["m_request_player"] == $player_position) {
            if ($target_info["m_drop_from"] == "0") {
                $kong_able_list = $this->_slave->getHandKongAble($m_table_id, $player_position);
                if ($controller->isError($kong_able_list)) {
                    $kong_able_list->setPos(__FILE__, __LINE__);
                    return $kong_able_list;
                }
                if (count($kong_able_list) > 0) {
                    $request->setAttribute("kong_highlight_flg", true);
                }
                $win_result = array();
                $win_result = $this->_checkWin();
                if (!empty($win_result)) {
                    $request->setAttribute("win_highlight_flg", true);
                }
            } else {
                $tile_type = $target_info["c_type"];
                $card_type_num = IohMahjongGameDBI::getCardNumberGroupByType($m_table_id);
                if ($dbi->isError($card_type_num)) {
                    $card_type_num->setPos(__FILE__, __LINE__);
                    return $card_type_num;
                }
                if (isset($card_type_num[$player_position][$tile_type])) {
                    if ($card_type_num[$player_position][$tile_type]["0"] == "3") {
                        $request->setAttribute("kong_highlight_flg", true);
                    }
                }
                $request->setAttribute("pong_highlight_flg", true);
                $request->setAttribute("cancel_highlight_flg", true);
            }
            // -----------------------------
            // 目标玩家为他人时
            // -----------------------------
        } else {
            $request->setAttribute("refresh_flg", true);
        }
        // 手牌信息
        $player_hand_card_info = IohMahjongGameDBI::getPlayerHandCard($m_table_id, $player_position);
        if ($controller->isError($player_hand_card_info)) {
            $player_hand_card_info->setPos(__FILE__, __LINE__);
            return $player_hand_card_info;
        }
        $request->setAttribute("kong_able_list", array());
        $request->setAttribute("player_hand_card_info", $player_hand_card_info);
        $request->setAttribute("target_player", $table_info["m_request_player"]);
        return VIEW_DONE;
    }

    private function _doStartExecute(Controller $controller, User $user, Request $request)
    {
        $m_room_id = $request->getAttribute("m_room_id");
        $banker_player = $request->getAttribute("banker_player");
        $m_table_id = $this->_master->newTableCard($m_room_id, $banker_player);
        if ($controller->isError($m_table_id)) {
            $m_table_id->setPos(__FILE__, __LINE__);
            return $m_table_id;
        }
        $controller->redirect("./?menu=mahjong_game&act=play&m_room_id=" . $m_room_id);
        return VIEW_DONE;
    }

    private function _doWaitExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }

    private function _checkWin()
    {
        return array();
    }
}
?>