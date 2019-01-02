<?php

/**
 * 管理员用站内活动详细画面
 * @author Kinsama
 * @version 2019-01-02
 */
class IohEvent_AdminDetailAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("do_submit")) {
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
        $new_event_flg = true;
        if ($request->hasParameter("k")) {
            $event_info = IohEventDBI::selectEventByNumber($request->getParameter("k"));
            if ($controller->isError($event_info)) {
                $event_info->setPos(__FILE__, __LINE__);
                return $event_info;
            }
            if (!isset($event_info[$request->getParameter("k")])) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $event_info = $event_info[$request->getParameter("k")];
            $new_event_flg = false;
        } else {
            $event_info = array(
                "event_key" => "",
                "event_number" => "",
                "event_name" => "",
                "event_descript" => "",
                "event_start_date" => date("Y-m-d H:i:s"),
                "event_expiry_date" => date("Y-m-d H:i:s"),
                "event_open_flg" => "0",
                "event_active_flg" => "0"
            );
        }
        $request->setAttribute("event_info", $event_info);
        $request->setAttribute("new_event_flg", $new_event_flg);
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
        //$event_list = IohEventDBI::selectTotalEvent();
        //if ($controller->isError($event_list)) {
        //    $event_list->setPos(__FILE__, __LINE__);
        //    return $event_list;
        //}
        //$request->setAttribute("event_list", $event_list);
        return VIEW_DONE;
    }

    private function _doSubmitExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_NONE;
    }
}
?>