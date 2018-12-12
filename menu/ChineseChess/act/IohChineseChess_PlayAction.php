<?php
// Common引入
require_once SRC_PATH . "/menu/ChineseChess/lib/IohChineseChess_Common.php";

/**
 * 进行中国象棋比赛
 * @author Kinsama
 * @version 2017-05-10
 */
class IohChineseChess_PlayAction extends ActionBase
{

    /**
     * common object
     */
    private $_common;

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("get_chess_mobile")) {
            $ret = $this->_doChessMobileAjaxExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("do_refresh_chess")) {
            $ret = $this->_doChessRefreshExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("do_chess_mobile")) {
            $ret = $this->_doChessMobileExecute($controller, $user, $request);
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
     * 执行默认程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $game_id = $request->getAttribute("game_id");
        $request->setAttribute("chess_list", $this->_common->chess_table_info);
        $request->setAttribute("chess_info", IohChineseChessBookEntity::getChessInfoList());
        return VIEW_DONE;
    }

    /**
     * 执行获取棋子可能移动位置
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doChessMobileAjaxExecute(Controller $controller, User $user, Request $request)
    {
        $game_id = $request->getAttribute("game_id");
        $chess_id = $request->getParameter("get_chess_mobile");
        $pos_arr = $this->_common->getChessMove($chess_id, true);
        echo json_encode($pos_arr);
        return VIEW_NONE;
    }

    /**
     * 执行获取棋子移动
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doChessMobileExecute(Controller $controller, User $user, Request $request)
    {
        $game_id = $request->getAttribute("game_id");
        $chess_id = $request->getParameter("chess_id");
        $to_cols_num = str_replace("cols", "", $request->getParameter("to_cols_num"));
        $to_rows_num = str_replace("rows", "", $request->getParameter("to_rows_num"));
        if ($chess_id == "" || $to_cols_num == "" || $to_rows_num == "") {
            $ret = $this->_doChessRefreshExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
            return $ret;
        }
        // 检测棋子位置是否有效
        $pos_arr = $this->_common->getChessMove($chess_id);
        if ($controller->isError($pos_arr)) {
            $pos_arr->setPos(__FILE__, __LINE__);
            return $pos_arr;
        }
        if (!isset($pos_arr[$to_cols_num][$to_rows_num])) {
            $ret = $this->_doChessRefreshExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
            return $ret;
        }
        // 获取棋子位置
        $chess_pos = $this->_common->chess_table_info;
        // 开始事件
        $dbi = Database::getInstance();
        $begin_res = $dbi->begin();
        if ($dbi->isError($begin_res)) {
            $begin_res->setPos(__FILE__, __LINE__);
            return $begin_res;
        }
        // 吃子
        if (isset($chess_pos[$to_cols_num][$to_rows_num])) {
            $drop_chess_id = $chess_pos[$to_cols_num][$to_rows_num]['chess_id'];
            $drop_chess_result = IohChineseChessBookDBI::update($game_id, $drop_chess_id, array(
                "disp_flg" => 0
            ));
            if ($controller->isError($drop_chess_result)) {
                $dbi->rollback();
                $drop_chess_result->setPos(__FILE__, __LINE__);
                return $drop_chess_result;
            }
        }
        // 移子
        $move_chess_result = IohChineseChessBookDBI::update($game_id, $chess_id, array(
            "cols_num" => $to_cols_num,
            "rows_num" => $to_rows_num
        ));
        if ($controller->isError($move_chess_result)) {
            $dbi->rollback();
            $move_chess_result->setPos(__FILE__, __LINE__);
            return $move_chess_result;
        }
        // 提交事件
        $commit_res = $dbi->commit();
        if ($dbi->isError($commit_res)) {
            $commit_res->setPos(__FILE__, __LINE__);
            return $commit_res;
        }
        $ret = $this->_doChessRefreshExecute($controller, $user, $request);
        if ($controller->isError($ret)) {
            $ret->setPos(__FILE__, __LINE__);
            return $ret;
        }
        return $ret;
    }

    /**
     * 执行刷新
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doChessRefreshExecute(Controller $controller, User $user, Request $request)
    {
        $game_id = $request->getAttribute("game_id");
        $controller->redirect("./?menu=chinese_chess&act=play&game_id=" . $game_id);
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
        if (!$request->hasParameter("game_id")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "参数game_id值被窜改");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $game_id = $request->getParameter("game_id");
        if (!Validate::checkNotEmpty($game_id)) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "参数game_id值被窜改");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        // 棋盘信息获取
        $common = new IohChineseChess_Common();
        $ret = $common->getChineseChessInfo($game_id);
        if ($controller->isError($ret)) {
            $ret->setPos(__FILE__, __LINE__);
            return $ret;
        }
        $request->setAttribute("game_id", $game_id);
        $this->_common = $common;
        return VIEW_DONE;
    }
}
?>