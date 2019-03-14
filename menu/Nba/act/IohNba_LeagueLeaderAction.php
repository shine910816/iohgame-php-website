<?php
require_once SRC_PATH . "/menu/Nba/lib/IohNba_Common.php";

/**
 * Object NBA数据王
 * @author Kinsama
 * @version 2019-03-14
 */
class IohNba_LeagueLeaderAction extends ActionBase
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
        $league_leader = $this->_common->getDailyActivePlayersInfo();
        if ($controller->isError($league_leader)) {
            $league_leader->setPos(__FILE__, __LINE__);
            return $league_leader;
        }
        $player_info_list = $this->_transPlayer($league_leader);
Utility::testVariable($player_info_list);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }

    private function _transPlayer($league_leader)
    {
        $result = array();
        foreach ($league_leader as $player_id => $player_info) {
            $player_item = array();
            $player_item["pts"] = $player_info["points"];
            $player_item["reb"] = $player_info["totReb"];
            $player_item["ast"] = $player_info["assists"];
            $player_item["blk"] = $player_info["blocks"];
            $player_item["stl"] = $player_info["steals"];
            $player_item["sort"] = $player_info["points"] + $player_info["totReb"] + $player_info["steals"]
                + 1.4 * ($player_info["assists"] + $player_info["blocks"])
                + 1.5 * $player_info["fgm"] + 0.25 * $player_info["ftm"]
                - 0.7 * $player_info["turnovers"]
                - 0.8 * ($player_info["fga"] + $player_info["fta"] - $player_info["fgm"] - $player_info["ftm"]);
            $result[$player_id] = $player_item;
        }
        return $result;
    }
}
?>