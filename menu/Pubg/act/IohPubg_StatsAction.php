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
        if (isset($ranked_info["data"]["attributes"]["rankedGameModeStats"])) {
            $result["ranked"] = array(
                "tier" => array(
                    "tier" => "",                 //阶级
                    "rankPoint" => "0",           //积分
                    "bestTier" => "",             //最高阶级
                    "bestRankPoint" => "0"        //最高积分
                ),
                "round" => array(
                    "roundsPlayed" => "0",        //场数
                    "top10s" => "0",              //前十场数
                    "wins" => "0"                 //吃鸡
                ),
                "damage" => array(
                    "damageDealt" => "0",         //伤害
                    "kills" => "0",               //击杀
                    "dBNOs" => "0",               //击倒
                    "assists" => "0",             //助攻
                    "headshotKills" => "0",       //爆头击败
                    "roadKills" => "0"            //载具击败
                ),
                "survive" => array(
                    "timeSurvived" => "0",        //生存时间
                    "revives" => "0",             //复活
                    "heals" => "0",               //治疗
                    "boosts" => "0"               //加速
                ),
                "dead" => array(
                    "losses" => "0",              //死亡
                    "suicides" => "0",            //自杀
                    "teamKills" => "0"            //击败队友
                ),
                "other" => array(
                    "walkDistance" => "0",        //步行距离
                    "swimDistance" => "0",        //游泳距离
                    "rideDistance" => "0",        //驾驶距离
                    "vehicleDestroys" => "0",     //载具破坏
                    "weaponsAcquired" => "0"      //武器拾取
                ),
                "record" => array(
                    "roundMostKills" => "0",      //单场最高击败
                    "maxKillStreaks" => "0",      //最高连杀
                    "longestKill" => "0",         //单场最高击败距离
                    "longestTimeSurvived" => "0"  //单场最高生存时间
                ),
                "average" => array(
                    "top10Ratio" => "-",          //前十率
                    "winRatio" => "-",            //吃鸡率
                    "kda" => "0",                 //KDA
                    "hskPct" => "-",              //爆头击败
                    "damageAvg" => "0",           //场均伤害
                    "surviveTimeAvg" => "0",      //场均生存时间
                    "distanceAvg" => "0"          //场均移动距离
                )
            );
            if (!empty($ranked_info["data"]["attributes"]["rankedGameModeStats"])) {
                $ranked_data = $ranked_info["data"]["attributes"]["rankedGameModeStats"];
                $data_key = "squad";
                if ($fpp_flg) {
                    $data_key .= "-fpp";
                }
                if (isset($ranked_data[$data_key])) {
                    $target_data = $ranked_data[$data_key];
                    $result["ranked"]["tier"]["tier"] = $target_data["currentTier"]["tier"] . " " . $target_data["currentTier"]["subTier"];
                    $result["ranked"]["tier"]["rankPoint"] = $target_data["currentRankPoint"];
                    $result["ranked"]["tier"]["bestTier"] = $target_data["bestTier"]["tier"] . " " . $target_data["bestTier"]["subTier"];
                    $result["ranked"]["tier"]["bestRankPoint"] = $target_data["bestRankPoint"];
                }
            }
        }
        $game_type_list = explode(",", "solo,duo,squad");
        if (isset($season_info["data"]["attributes"]["gameModeStats"])) {
            $season_data = $season_info["data"]["attributes"]["gameModeStats"];
            $result["season"] = array(
                "round" => array(
                    "roundsPlayed" => "0",        //场数
                    "top10s" => "0",              //前十场数
                    "wins" => "0"                 //吃鸡
                ),
                "damage" => array(
                    "damageDealt" => "0",         //伤害
                    "kills" => "0",               //击杀
                    "dBNOs" => "0",               //击倒
                    "assists" => "0",             //助攻
                    "headshotKills" => "0",       //爆头击败
                    "roadKills" => "0"            //载具击败
                ),
                "survive" => array(
                    "timeSurvived" => "0",        //生存时间
                    "revives" => "0",             //复活
                    "heals" => "0",               //治疗
                    "boosts" => "0"               //加速
                ),
                "dead" => array(
                    "losses" => "0",              //死亡
                    "suicides" => "0",            //自杀
                    "teamKills" => "0"            //击败队友
                ),
                "other" => array(
                    "walkDistance" => "0",        //步行距离
                    "swimDistance" => "0",        //游泳距离
                    "rideDistance" => "0",        //驾驶距离
                    "vehicleDestroys" => "0",     //载具破坏
                    "weaponsAcquired" => "0"      //武器拾取
                ),
                "record" => array(
                    "roundMostKills" => "0",      //单场最高击败
                    "maxKillStreaks" => "0",      //最高连杀
                    "longestKill" => "0",         //单场最高击败距离
                    "longestTimeSurvived" => "0"  //单场最高生存时间
                ),
                "average" => array(
                    "top10Ratio" => "-",          //前十率
                    "winRatio" => "-",            //吃鸡率
                    "kda" => "0",                 //KDA
                    "hskPct" => "-",              //爆头击败
                    "damageAvg" => "0",           //场均伤害
                    "surviveTimeAvg" => "0",      //场均生存时间
                    "distanceAvg" => "0"          //场均移动距离
                )
            );
            foreach ($game_type_list as $game_type) {
                $data_key = $game_type;
                if ($fpp_flg) {
                    $data_key .= "-fpp";
                }
                $target_data = $season_data[$data_key];
                $result["season"]["round"]["roundsPlayed"] += $target_data["roundsPlayed"];
                $result["season"]["round"]["top10s"] += $target_data["top10s"];
                $result["season"]["round"]["wins"] += $target_data["wins"];
                $result["season"]["damage"]["damageDealt"] += $target_data["damageDealt"];
                $result["season"]["damage"]["kills"] += $target_data["kills"];
                $result["season"]["damage"]["dBNOs"] += $target_data["dBNOs"];
                $result["season"]["damage"]["assists"] += $target_data["assists"];
                $result["season"]["damage"]["headshotKills"] += $target_data["headshotKills"];
                $result["season"]["damage"]["roadKills"] += $target_data["roadKills"];
                $result["season"]["survive"]["timeSurvived"] += $target_data["timeSurvived"];
                $result["season"]["survive"]["revives"] += $target_data["revives"];
                $result["season"]["survive"]["heals"] += $target_data["heals"];
                $result["season"]["survive"]["boosts"] += $target_data["boosts"];
                $result["season"]["dead"]["losses"] += $target_data["losses"];
                $result["season"]["dead"]["suicides"] += $target_data["suicides"];
                $result["season"]["dead"]["teamKills"] += $target_data["teamKills"];
                $result["season"]["other"]["walkDistance"] += $target_data["walkDistance"];
                $result["season"]["other"]["swimDistance"] += $target_data["swimDistance"];
                $result["season"]["other"]["rideDistance"] += $target_data["rideDistance"];
                $result["season"]["other"]["vehicleDestroys"] += $target_data["vehicleDestroys"];
                $result["season"]["other"]["weaponsAcquired"] += $target_data["weaponsAcquired"];
                if ($target_data["roundMostKills"] > $result["season"]["record"]["roundMostKills"]) {
                    $result["season"]["record"]["roundMostKills"] = $target_data["roundMostKills"];
                }
                if ($target_data["maxKillStreaks"] > $result["season"]["record"]["maxKillStreaks"]) {
                    $result["season"]["record"]["maxKillStreaks"] = $target_data["maxKillStreaks"];
                }
                if ($target_data["longestKill"] > $result["season"]["record"]["longestKill"]) {
                    $result["season"]["record"]["longestKill"] = round($target_data["longestKill"]);
                }
                if ($target_data["longestTimeSurvived"] > $result["season"]["record"]["longestTimeSurvived"]) {
                    $result["season"]["record"]["longestTimeSurvived"] = sprintf("%.0f", $target_data["longestTimeSurvived"] / 60);
                }
            }
            if ($result["season"]["round"]["roundsPlayed"] > 0) {
                $played_count = $result["season"]["round"]["roundsPlayed"];
                $result["season"]["average"]["top10Ratio"] = sprintf("%.1f", $result["season"]["round"]["top10s"] / $played_count * 100) . "%";
                $result["season"]["average"]["winRatio"] = sprintf("%.1f", $result["season"]["round"]["wins"] / $played_count * 100) . "%";
                $result["season"]["average"]["kda"] = sprintf("%.2f", $result["season"]["damage"]["kills"] / $played_count);
                if ($result["season"]["damage"]["kills"] > 0) {
                    $result["season"]["average"]["hskPct"] = sprintf("%.1f", $result["season"]["damage"]["headshotKills"] / $result["season"]["damage"]["kills"] * 100) . "%";
                }
                $result["season"]["average"]["damageAvg"] = sprintf("%.1f", $result["season"]["damage"]["damageDealt"] / $played_count);
                $result["season"]["average"]["surviveTimeAvg"] = sprintf("%.0f", $result["season"]["survive"]["timeSurvived"] / $played_count / 60);
                $result["season"]["average"]["distanceAvg"] = sprintf("%.2f", ($result["season"]["other"]["walkDistance"] + $result["season"]["other"]["swimDistance"] + $result["season"]["other"]["rideDistance"]) / $played_count / 1000);
            }
            if ($result["season"]["average"]["damageAvg"] > 0) {
                $result["season"]["damage"]["damageDealt"] = sprintf("%.0f", $result["season"]["damage"]["damageDealt"]);
            }
            if ($result["season"]["average"]["surviveTimeAvg"] > 0) {
                $result["season"]["survive"]["timeSurvived"] = sprintf("%.0f", $result["season"]["survive"]["timeSurvived"] / 60);
            }
            if ($result["season"]["average"]["distanceAvg"] > 0) {
                $result["season"]["other"]["walkDistance"] = sprintf("%.1f", $result["season"]["other"]["walkDistance"] / 1000);
                $result["season"]["other"]["swimDistance"] = sprintf("%.1f", $result["season"]["other"]["swimDistance"] / 1000);
                $result["season"]["other"]["rideDistance"] = sprintf("%.1f", $result["season"]["other"]["rideDistance"] / 1000);
            }
        }
        return $result;
    }
}
?>