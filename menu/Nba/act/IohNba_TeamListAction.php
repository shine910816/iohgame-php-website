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
        $conference = "0";
        $division = "0";
        $conf_list = IohNbaEntity::getConferenceList();
        $divi_list = IohNbaEntity::getDivisionList();
        if ($request->hasParameter("conf")) {
            if (!Validate::checkAcceptParam($request->getParameter("conf"), array_keys($conf_list["cn"]))) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $conference = $request->getParameter("conf");
        }
        if ($request->hasParameter("divi")) {
            if (!Validate::checkAcceptParam($request->getParameter("divi"), array_keys($divi_list["cn"]))) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $division = $request->getParameter("divi");
        }
        $request->setAttribute("conf_list", $conf_list);
        $request->setAttribute("divi_list", $divi_list);
        $request->setAttribute("conference", $conference);
        $request->setAttribute("division", $division);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $conference = $request->getAttribute("conference");
        $division = $request->getAttribute("division");
        $team_list = IohNbaDBI::getTeamList($conference, $division);
        if ($controller->isError($team_list)) {
            $team_list->setPos(__FILE__, __LINE__);
            return $team_list;
        }
        $request->setAttribute("team_list", $team_list);
        return VIEW_DONE;
    }
}
?>