<?php

/**
 *
 * @author Kinsama
 * @version 2020-06-16
 */
class IohPubg_StatsAction extends ActionBase
{
    private $_pubg;

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
        $this->_pubg = Utility::getPubgRequest();
        $custom_id = $user->getCustomId();
        $account_list = IohPubgRequestDBI::getAccountId($custom_id);
        if ($controller->isError($account_list)) {
            $account_list->setPos(__FILE__, __LINE__);
            return $account_list;
        }
        if (!isset($account_list[$custom_id])) {
            $controller->redirect("./?menu=pubg&act=bind_account");
            return VIEW_DONE;
        }
        $fpp_flg = false;
        if ($request->hasParameter("fpp_mode")) {
            $fpp_flg = true;
        }
        $account_id = $account_list[$custom_id]["account_id"];
        $request->setAttribute("account_id", $account_id);
        $request->setAttribute("fpp_flg", $fpp_flg);
        return VIEW_DONE;
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
        $stats_info = $this->_getStats($controller, $user, $request);
        if ($controller->isError($stats_info)) {
            $stats_info->setPos(__FILE__, __LINE__);
            return $stats_info;
        }
Utility::testVariable($stats_info);
        return VIEW_DONE;
    }

    private function _getStats(Controller $controller, User $user, Request $request)
    {
        $account_id = $request->getAttribute("account_id");
        $fpp_flg = $request->getAttribute("fpp_flg");
        $result = array(
            "season" => array(),
            "ranked" => array()
        );
        $ranked_info = $this->_pubg->getPlayerRankedStats($account_id);
        if ($controller->isError($ranked_info)) {
            $ranked_info->setPos(__FILE__, __LINE__);
            return $result;
        }
        $season_info = $this->_pubg->getPlayerSeasonStats($account_id);
        if ($controller->isError($season_info)) {
            $season_info->setPos(__FILE__, __LINE__);
            return $result;
        }
        $game_type_list = explode(",", "solo,duo,squad");
        if (isset($season_info["data"]["attributes"]["gameModeStats"])) {
            $season_data = $season_info["data"]["attributes"]["gameModeStats"];
            $result["season"] = array(
                "roundsPlayed" => "0",        //场数
                "top10s" => "0",              //前十场数
                "wins" => "0",                //吃鸡
                "damageDealt" => "0",         //伤害
                "timeSurvived" => "0",        //生存时间
                "dBNOs" => "0",               //击倒
                "kills" => "0",               //击杀
                "headshotKills" => "0",       //爆头击败
                "roadKills" => "0",           //载具击败
                "assists" => "0",             //助攻
                "revives" => "0",             //复活
                "heals" => "0",               //治疗
                "boosts" => "0",              //加速
                "losses" => "0",              //死亡
                "teamKills" => "0",           //队友击败
                "suicides" => "0",            //自杀
                "walkDistance" => "0",        //步行距离
                "swimDistance" => "0",        //游泳距离
                "rideDistance" => "0",        //驾驶距离
                "vehicleDestroys" => "0",     //载具破坏
                "weaponsAcquired" => "0",     //武器拾取
                "roundMostKills" => "0",      //单场最高击败
                "maxKillStreaks" => "0",      //最高连杀
                "longestKill" => "0",         //单场最高击败距离
                "longestTimeSurvived" => "0"  //单场最高生存时间
            );
            foreach ($game_type_list as $game_type) {
                $data_key = $game_type;
                if ($fpp_flg) {
                    $data_key .= "-fpp";
                }
                if (empty($result["season"])) {
                    $result["season"] = $season_data[$data_key];
                } else {
                    foreach ($season_data[$data_key] as $stats_key => $stats_value) {
                        $result["season"][$stats_key] += $stats_value;
                    }
                }
            }
        }
Utility::testVariable($season_info);
        return $result;
    }
}
?>