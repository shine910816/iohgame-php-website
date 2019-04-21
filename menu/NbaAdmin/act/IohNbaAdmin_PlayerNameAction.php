<?php

/**
 * Object NBA球员姓名汉化
 * @author Kinsama
 * @version 2019-04-02
 */
class IohNbaAdmin_PlayerNameAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("syncho")) {
            $ret = $this->_doSynchoExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("submit")) {
            $ret = $this->_doSubmitExecute($controller, $user, $request);
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
        $team_list = IohNbaDBI::getFranchiseTeamList(true);
        if ($controller->isError($team_list)) {
            $team_list->setPos(__FILE__, __LINE__);
            return $team_list;
        }
        $t_id = "1610612737";
        if ($request->hasParameter("t_id")) {
            $team_id_opt = array();
            foreach ($team_list[IohNbaEntity::CONFERENCE_EASTERN] as $team_info) {
                $team_id_opt[] = $team_info["t_id"];
            }
            foreach ($team_list[IohNbaEntity::CONFERENCE_WESTERN] as $team_info) {
                $team_id_opt[] = $team_info["t_id"];
            }
            $t_id = $request->getParameter("t_id");
            if (!Validate::checkAcceptParam($t_id, $team_id_opt)) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
        }
        $player_info_list = IohNbaDBI::selectPlayerByTeamId($t_id);
        if ($controller->isError($player_info_list)) {
            $player_info_list->setPos(__FILE__, __LINE__);
            return $player_info_list;
        }
        $request->setAttribute("t_id", $t_id);
        $request->setAttribute("eastern_team_list", $team_list[IohNbaEntity::CONFERENCE_EASTERN]);
        $request->setAttribute("western_team_list", $team_list[IohNbaEntity::CONFERENCE_WESTERN]);
        $request->setAttribute("player_info_list", $player_info_list);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $request->setAttribute("country_list", IohNbaEntity::getCountryList());
        return VIEW_DONE;
    }

    private function _doSubmitExecute(Controller $controller, User $user, Request $request)
    {
        $t_id = $request->getAttribute("t_id");
        $p_id = $request->getParameter("submit");
        $player_info_list = $request->getAttribute("player_info_list");
        if (!Validate::checkAcceptParam($p_id, array_keys($player_info_list))) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $p_name = $request->getParameter("p_name");
        $p_birth_date = $request->getParameter("p_birth_date");
        $p_country_cn = $request->getParameter("p_country_cn");
        $update_data = array(
            "p_name" => $p_name[$p_id],
            "p_birth_date" => $p_birth_date[$p_id],
            "p_country_cn" => $p_country_cn[$p_id]
        );
        $update_res = IohNbaDBI::updatePlayer($p_id, $update_data);
        if ($controller->isError($update_res)) {
            $update_res->setPos(__FILE__, __LINE__);
            return $update_res;
        }
        $controller->redirect("./?menu=nba_admin&act=player_name&t_id=" . $t_id);
        return VIEW_DONE;
    }

    private function _doSynchoExecute(Controller $controller, User $user, Request $request)
    {
        $t_id = $request->getAttribute("t_id");
        $p_id = $request->getParameter("syncho");
        $player_info_list = $request->getAttribute("player_info_list");
        if (!Validate::checkAcceptParam($p_id, array_keys($player_info_list))) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $country_list = IohNbaEntity::getCountryList();
        $update_data = array("p_country_cn" => $country_list[$player_info_list[$p_id]["p_country"]]);
        $update_res = IohNbaDBI::updatePlayer($p_id, $update_data);
        if ($controller->isError($update_res)) {
            $update_res->setPos(__FILE__, __LINE__);
            return $update_res;
        }
        $controller->redirect("./?menu=nba_admin&act=player_name&t_id=" . $t_id);
        return VIEW_DONE;
    }
}
?>