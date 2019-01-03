<?php

/**
 * 站内活动一览画面
 * @author Kinsama
 * @version 2019-01-03
 */
class IohEvent_ListAction extends ActionBase
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
        $event_list = IohEventDBI::selectOpenEvent(date("Y-m-d H:i:s"));
        if ($controller->isError($event_list)) {
            $event_list->setPos(__FILE__, __LINE__);
            return $event_list;
        }
        if (!empty($event_list)) {
            $url_for_page = "./?menu=event&act=list&";
            $event_list = Utility::getPaginationData($request, $event_list, $url_for_page);
            if ($controller->isError($event_list)) {
                $event_list->setPos(__FILE__, __LINE__);
                return $event_list;
            }
        }
        foreach ($event_list as $event_number => $event_item) {
            $detail_param = array();
            $detail_param["back_url"] = "./?menu=event&act=list&page=" . $request->current_page;
            $detail_param["event_number"] = $event_number;
            $event_list[$event_number]["detail_param"] = Utility::encodeCookieInfo($detail_param);
        }
        $request->setAttribute("event_list", $event_list);
        return VIEW_DONE;
    }
}
?>