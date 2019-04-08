<?php
require_once SRC_PATH . "/menu/Nba/lib/IohNba_Common.php";

/**
 * Object NBA球队详细
 * @author Kinsama
 * @version 2019-02-18
 */
class IohNba_TeamDetailAction extends ActionBase
{
    private $_common;

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
        $this->_common = new IohNba_Common();
        $conf_list = IohNbaEntity::getConferenceList();
        $divi_list = IohNbaEntity::getDivisionList();
        $t_id = "0";
        if (!$request->hasParameter("t_id")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $t_id = $request->getParameter("t_id");
        $request->setAttribute("conf_list", $conf_list);
        $request->setAttribute("divi_list", $divi_list);
        $request->setAttribute("t_id", $t_id);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $t_id = $request->getAttribute("t_id");
        $team_info = IohNbaDBI::getTeamInfo($t_id);
        if ($controller->isError($team_info)) {
            $team_info->setPos(__FILE__, __LINE__);
            return $team_info;
        }
        if (!isset($team_info[$t_id])) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $standings_all = $this->_common->getStandings();
        if ($controller->isError($standings_all)) {
            $standings_all->setPos(__FILE__, __LINE__);
            return $standings_all;
        }
        if (!isset($standings_all[$t_id])) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $player_list = $this->_common->getPlayers(true);
        if ($controller->isError($player_list)) {
            $player_list->setPos(__FILE__, __LINE__);
            return $player_list;
        }
        if (!isset($player_list[$t_id])) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $player_info_list = IohNbaDBI::selectPlayer(array_keys($player_list[$t_id]));
        if ($controller->isError($player_info_list)) {
            $player_info_list->setPos(__FILE__, __LINE__);
            return $player_info_list;
        }
        $back_url = "./?menu=nba&act=team_list";
        $request->setAttribute("team_info", $team_info[$t_id]);
        $request->setAttribute("back_url", $back_url);
        $request->setAttribute("standings_info", $standings_all[$t_id]);
        $request->setAttribute("player_list", $player_list[$t_id]);
        $request->setAttribute("player_info_list", $player_info_list);
        $request->setAttribute("position_info_list", array(
            "1" => "中锋",
            "2" => "前锋",
            "3" => "后卫"
        ));
        return VIEW_DONE;
    }
}
?>