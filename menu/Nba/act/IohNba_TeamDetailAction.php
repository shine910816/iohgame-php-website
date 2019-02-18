<?php

/**
 * Object NBA球队详细
 * @author Kinsama
 * @version 2019-02-18
 */
class IohNba_TeamDetailAction extends ActionBase
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
        $conf_list = IohNbaEntity::getConferenceList();
        $divi_list = IohNbaEntity::getDivisionList();
        $t_id = "0";
        if (!$request->hasParameter("t_id")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $t_id = $request->getParameter("t_id");
        $group = "0";
        if ($request->hasParameter("group")) {
            if (!Validate::checkAcceptParam($request->getParameter("group"), array("0", "1", "2"))) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $group = $request->getParameter("group");
        }
        $request->setAttribute("conf_list", $conf_list);
        $request->setAttribute("divi_list", $divi_list);
        $request->setAttribute("t_id", $t_id);
        $request->setAttribute("group", $group);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $t_id = $request->getAttribute("t_id");
        $group = $request->getAttribute("group");
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
        $back_url = "./?menu=nba&act=team_list";
        if ($group != "0") {
            $back_url .= "&group=" . $group;
        }
        $request->setAttribute("team_info", $team_info[$t_id]);
        $request->setAttribute("back_url", $back_url);
//Utility::testVariable($request->getAttributes());
        return VIEW_DONE;
    }
}
?>