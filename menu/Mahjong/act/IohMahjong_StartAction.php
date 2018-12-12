<?php

/**
 *
 * @author Kinsama
 * @version 2018-04-30
 */
class IohMahjong_StartAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("start")) {
            $ret = $this->_doStartExecute($controller, $user, $request);
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
        $history_flg = 0;
        if ($request->hasParameter("history")) {
            $history_flg = 1;
        }
        $request->setAttribute("ts", time());
        $request->setAttribute("gaming_list", array());
        $request->setAttribute("history_flg", $history_flg);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $history_flg = $request->getAttribute("history_flg");
        $game_info = IohMahjongDBI::getGameInfo($history_flg);
        if ($controller->isError($game_info)) {
            $game_info->setPos(__FILE__, __LINE__);
            return $game_info;
        }
        $request->setAttribute("gaming_list", $game_info);
        return VIEW_DONE;
    }

    private function _doStartExecute(Controller $controller, User $user, Request $request)
    {
        $m_name = $request->getParameter("m_name");
        $m_point = $request->getParameter("m_point");
        if ($m_name == "") {
            $m_name = "麻将桌" . substr(time(), -5);
        }
        $insert_data = array(
            "m_name" => $m_name,
            "m_point" => $m_point,
            "m_round" => "1",
            "m_part" => "1",
            "m_pullbanker" => "0000",
            "final_flg" => "0"
        );
        $m_id = IohMahjongDBI::insertMahjong($insert_data);
        if ($controller->isError($m_id)) {
            $m_id->setPos(__FILE__, __LINE__);
            return $m_id;
        }
        $m_player = $request->getParameter("m_player");
        foreach ($m_player as $m_player => $m_player_name) {
            $insert_data = array();
            $insert_data["m_id"] = $m_id;
            $insert_data["m_player"] = $m_player;
            $insert_data["m_player_name"] = $m_player_name;
            if ($m_player == "1") {
                $insert_data["m_banker_flg"] = "1";
            } else {
                $insert_data["m_banker_flg"] = "0";
            }
            $insert_data["m_point"] = $m_point;
            $insert_data["m_gang_point"] = "0";
            $detail_res = IohMahjongDBI::insertMahjongDetail($insert_data);
            if ($controller->isError($detail_res)) {
                $detail_res->setPos(__FILE__, __LINE__);
                return $detail_res;
            }
        }
        $controller->redirect("./?menu=mahjong&act=detail&m_id=" . $m_id);
        return VIEW_DONE;
    }
}
?>