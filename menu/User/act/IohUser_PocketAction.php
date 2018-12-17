<?php

/**
 * 用户钱包画面
 * @author Kinsama
 * @version 2018-12-14
 */
class IohUser_PocketAction extends ActionBase
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
        $coupon_apply_range_list = IohCouponEntity::getApplyRangeList();
        $request->setAttribute("coupon_apply_range_list", $coupon_apply_range_list);
        $request->setAttribute("subpanel_file", SRC_PATH . "/menu/User/tpl/IohUser_MobileListView.tpl");
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $custom_id = $user->getVariable("custom_id");
        $custom_info = IohCustomDBI::selectCustomInfo($custom_id);
        if ($controller->isError($custom_info)) {
            $custom_info->setPos(__FILE__, __LINE__);
            return $custom_info;
        }
        if (empty($custom_info)) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $point_info = IohPointDBI::selectPoint($custom_id);
        if ($controller->isError($point_info)) {
            $point_info->setPos(__FILE__, __LINE__);
            return $point_info;
        }
        if (!isset($point_info[$custom_id])) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $coupon_apply_range_list = $request->getAttribute("coupon_apply_range_list");
        $coupon_info = IohCouponDBI::selectCoupon($custom_id, date("Y-m-d H:i:s"), array_keys($coupon_apply_range_list));
        if ($controller->isError($coupon_info)) {
            $coupon_info->setPos(__FILE__, __LINE__);
            return $coupon_info;
        }
//Utility::testVariable($coupon_info);
        $request->setAttribute("custom_point", $point_info[$custom_id]);
        $request->setAttribute("coupon_info", $coupon_info);
        return VIEW_DONE;
    }
}
?>