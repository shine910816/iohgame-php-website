<?php

/**
 * Object NBA排名
 * @author Kinsama
 * @version 2019-03-14
 */
class IohNba_StandingsAction extends ActionBase
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
        $standings_group = "1";
        if ($request->hasParameter("group")) {
            $standings_group = $request->getParameter("group");
            if (!Validate::checkAcceptParam($standings_group, array("1", "2"))) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Group is invalid.");
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
        }
        $request->setAttribute("standings_group", $standings_group);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $standings_group = $request->getAttribute("standings_group");
        $json_array = Utility::transJson(SYSTEM_API_HOST . "nba/standings/?group=" . $standings_group);
        if ($controller->isError($json_array)) {
            $json_array->setPos(__FILE__, __LINE__);
            return $json_array;
        }
        if ($json_array["error"]) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, $json_array["err_msg"]);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $json_data = $json_array["data"];
        $json_data = $json_array["data"];
        $request->setAttribute("standings_group", $standings_group);
        $request->setAttribute("standings_info", $json_data["standings_info"]);
        $request->setAttribute("conference_list", $json_data["conference_list"]);
        $request->setAttribute("division_list", $json_data["division_list"]);
//Utility::testVariable($request->getAttributes());
        return VIEW_DONE;
    }
}
?>