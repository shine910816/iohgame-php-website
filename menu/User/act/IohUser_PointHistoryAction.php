<?php

/**
 * 用户积分记录一览画面
 * @author Kinsama
 * @version 2017-01-18
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
     * 执行默认命令
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $cus_id = $user->getVariable("cus_id");
        $point_info = IohCPointHistoryDBI::getPointInfoByCusId($cus_id);
        if ($controller->isError($point_info)) {
            $point_info->setPos(__FILE__, __LINE__);
            return $point_info;
        }
        if (!empty($point_info)) {
            $point_info = Utility::getPaginationData($request, $point_info, "./?menu=user&act=point_history&");
            if ($controller->isError($point_info)) {
                $point_info->setPos(__FILE__, __LINE__);
                return $point_info;
            }
        }
        $reason_cd_list = IohCPointHistoryEntity::getReasonCodeList();
        $request->setAttribute("point_info", $point_info);
        $request->setAttribute("reason_cd_list", $reason_cd_list);
        return VIEW_DONE;
    }
}
?>