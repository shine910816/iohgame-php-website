<?php

/**
 *
 * @author Kinsama
 * @version 2018-05-06
 */
class IohMahjong_RestartAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
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
        $updated_time = time() - strtotime($game_info["update_date"]);
        if (!$game_info["final_flg"] && $updated_time > 600) {
            $controller->redirect("./?menu=mahjong&act=detail&m_id=" . $m_id);
        }
        $game_detail = IohMahjongDBI::getGameDetailById($m_id);
        if ($controller->isError($game_detail)) {
            $game_detail->setPos(__FILE__, __LINE__);
            return $game_detail;
        }
        $request->setAttribute("m_id", $m_id);
        $request->setAttribute("game_info", $game_info);
        $request->setAttribute("game_detail", $game_detail);
        $request->setAttribute("ts", time());
        return VIEW_DONE;
    }
}
?>