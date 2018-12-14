<?php

/**
 * 首页画面
 * @author Kinsama
 * @version 2016-12-01
 */
class IohCommon_HomeAction extends ActionBase
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

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $event_exec = $this->_doEventExecute($controller, $user, $request);
        if ($controller->isError($event_exec)) {
            $event_exec->setPos(__FILE__, __LINE__);
            return $event_exec;
        }
        return VIEW_DONE;
    }

    private function _doEventExecute(Controller $controller, User $user, Request $request)
    {
        $event_info = IohEventDBI::selectPassiveEvent(date("Y-m-d H:i:s"));
        if ($controller->isError($event_info)) {
            $event_info->setPos(__FILE__, __LINE__);
            return $event_info;
        }
        if (count($event_info) > TOP_PAGE_DISPLAY_MAX) {
            $event_info = array_chunk($event_info, TOP_PAGE_DISPLAY_MAX, true);
            $event_info = $event_info[0];
        }
        $request->setAttribute("event_list", $event_info);
    }
}
?>