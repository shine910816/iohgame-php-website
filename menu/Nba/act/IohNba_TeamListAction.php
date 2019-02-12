<?php

/**
 * Object NBA球队
 * @author Kinsama
 * @version 2019-01-30
 */
class IohNba_TeamListAction extends ActionBase
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
        $request->setAttribute("group", $group);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $group = $request->getAttribute("group");
        $team_group_list = IohNbaDBI::getTeamGroupList($group);
        if ($controller->isError($team_group_list)) {
            $team_group_list->setPos(__FILE__, __LINE__);
            return $team_group_list;
        }
        $request->setAttribute("team_group_list", $team_group_list);
        return VIEW_DONE;
    }
}
?>