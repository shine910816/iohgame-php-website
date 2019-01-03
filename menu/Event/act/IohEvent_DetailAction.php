<?php

/**
 * 站内活动详细画面
 * @author Kinsama
 * @version 2019-01-03
 */
class IohEvent_DetailAction extends ActionBase
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
        if (!$request->hasParameter("k")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $param = Utility::decodeCookieInfo($request->getParameter("k"));
        if (!isset($param["event_number"]) || !isset($param["back_url"])) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $request->setAttribute("event_number", $param["event_number"]);
        $request->setAttribute("back_url", $param["back_url"]);
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
        $event_number = $request->getAttribute("event_number");
        $event_info = IohEventDBI::selectEventByNumber($event_number);
        if ($controller->isError($event_info)) {
            $event_info->setPos(__FILE__, __LINE__);
            return $event_info;
        }
        if (!isset($event_info[$event_number])) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $event_info = $event_info[$event_number];
        $request->setAttribute("event_info", $event_info);
        return VIEW_DONE;
    }
}
?>