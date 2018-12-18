<?php

/**
 * 用户积分明细画面
 * @author Kinsama
 * @version 2018-12-17
 */
class IohUser_PointHistoryAction extends ActionBase
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
        $custom_id = $user->getVariable("custom_id");
        $point_reason_code_list = IohPointEntity::getReasonCodeList();
        $request->setAttribute("custom_id", $custom_id);
        $request->setAttribute("point_reason_code_list", $point_reason_code_list);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $custom_id = $request->getAttribute("custom_id");
        $point_history_list = IohPointDBI::selectPointHistory($custom_id);
        if ($controller->isError($point_history_list)) {
            $point_history_list->setPos(__FILE__, __LINE__);
            return $point_history_list;
        }
        $request->setAttribute("point_history_list", $point_history_list);
        return VIEW_DONE;
    }
}
?>