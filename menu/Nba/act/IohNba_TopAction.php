<?php

/**
 * Object NBA首页
 * @author Kinsama
 * @version 2019-03-14
 */
class IohNba_TopAction extends ActionBase
{

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
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        //$url = "http://data.nba.net/10s/prod/v1/2018/schedule.json";
        //$json_array = Utility::transJson($url);
        //if (Error::isError($json_array)) {
        //    $json_array->setPos(__FILE__, __LINE__);
        //    return $json_array;
        //}
        //$json_array = $json_array["league"]["standard"];
        //foreach ($json_array as $game_info) {
        //    if ($game_info["seasonStageId"] == 2) {
        //        $game_url_code_arr = explode("/", $game_info["gameUrlCode"]);
        //        $insert_data = array(
        //            "game_season" => "2018",
        //            "game_date" => $game_url_code_arr[0],
        //            "game_id" => $game_info["gameId"],
        //            "game_name" => $game_url_code_arr[1],
        //            "game_start_date" => date("Y-m-d H:i:s", strtotime($game_info["startTimeUTC"])),
        //            "game_home_team" => $game_info["hTeam"]["teamId"],
        //            "game_away_team" => $game_info["vTeam"]["teamId"]
        //        );
        //        IohNbaDBI::insertSchedule($insert_data);
        //    }
        //}
        //Utility::testVariable($json_array);
        return VIEW_DONE;
    }
}
?>