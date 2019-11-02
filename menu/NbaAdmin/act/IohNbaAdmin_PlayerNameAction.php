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
        $player_info_list = IohNbaDBI::selectStandardPlayerGroupByTeam();
        if ($controller->isError($player_info_list)) {
            $player_info_list->setPos(__FILE__, __LINE__);
            return $player_info_list;
        }
        $request->setAttribute("t_id", $t_id);
        $request->setAttribute("eastern_team_list", $team_list[IohNbaEntity::CONFERENCE_EASTERN]);
        $request->setAttribute("western_team_list", $team_list[IohNbaEntity::CONFERENCE_WESTERN]);
        $request->setAttribute("player_info_list", $player_info_list[$t_id]);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $request->setAttribute("country_list", IohNbaEntity::getCountryList());
        $request->setAttribute("alpha_list", IohNbaEntity::getNameAlphabet());
        return VIEW_DONE;
    }

    private function _doSubmitExecute(Controller $controller, User $user, Request $request)
    {
        $t_id = $request->getAttribute("t_id");
        if ($request->hasParameter("p_name") && $request->hasParameter("p_alpha")) {
            $name_list = $request->getParameter("p_name");
            $alpha_list = $request->getParameter("p_alpha");
            if (!empty($name_list)) {
                foreach ($name_list as $p_id => $p_name) {
                    if (isset($alpha_list[$p_id])) {
                        $update_data = array(
                            "p_name" => $p_name,
                            "p_name_alphabet" => $alpha_list[$p_id]
                        );
                        $update_res = IohNbaDBI::updatePlayer($p_id, $update_data);
                        if ($controller->isError($update_res)) {
                            $update_res->setPos(__FILE__, __LINE__);
                            return $update_res;
                        }
                    }
                }
            }
        }
        $controller->redirect("./?menu=nba_admin&act=player_name&t_id=" . $t_id);
        return VIEW_DONE;
    }

    private function _doSynchoExecute(Controller $controller, User $user, Request $request)
    {
        $t_id = $request->getAttribute("t_id");
        $p_id = $request->getParameter("syncho");
        if ($request->hasParameter("p_name") && $request->hasParameter("p_alpha")) {
            $name_list = $request->getParameter("p_name");
            $alpha_list = $request->getParameter("p_alpha");
            if (isset($name_list[$p_id]) && isset($alpha_list[$p_id])) {
                $update_data = array(
                    "p_name" => $name_list[$p_id],
                    "p_name_alphabet" => $alpha_list[$p_id]
                );
                $update_res = IohNbaDBI::updatePlayer($p_id, $update_data);
                if ($controller->isError($update_res)) {
                    $update_res->setPos(__FILE__, __LINE__);
                    return $update_res;
                }
            }
        }
        $controller->redirect("./?menu=nba_admin&act=player_name&t_id=" . $t_id);
        return VIEW_DONE;
    }
}
?>