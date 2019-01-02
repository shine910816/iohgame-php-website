<?php

/**
 * 管理员用站内活动一览画面
 * @author Kinsama
 * @version 2019-01-02
 */
class IohEvent_AdminListAction extends ActionBase
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

    /**
     * 执行默认程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $event_list = IohEventDBI::selectTotalEvent();
        if ($controller->isError($event_list)) {
            $event_list->setPos(__FILE__, __LINE__);
            return $event_list;
        }
        $request->setAttribute("event_list", $event_list);
        return VIEW_DONE;
    }
}
?>