<?php

/**
 * 优惠券明细画面
 * @author Kinsama
 * @version 2018-12-17
 */
class IohCoupon_DetailAction extends ActionBase
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
        if (!$request->hasParameter("k")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $keyword_arr = Utility::decodeCookieInfo($request->getParameter("k"));
        if (!isset($keyword_arr["coupon_number"])) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $back_url = "";
        if (isset($keyword_arr["from_menu"]) && isset($keyword_arr["from_act"])) {
            $back_url = "?menu=" . $keyword_arr["from_menu"] . "&act=" . $keyword_arr["from_act"];
        }
        $request->setAttribute("custom_id", $custom_id);
        $request->setAttribute("coupon_number", $keyword_arr["coupon_number"]);
        $request->setAttribute("back_url", $back_url);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $custom_id = $request->getAttribute("custom_id");
        $coupon_number = $request->getAttribute("coupon_number");
        $coupon_info = IohCouponDBI::selectCouponByCustomIdCouponNumber($custom_id, $coupon_number);
        if ($controller->isError($coupon_info)) {
            $coupon_info->setPos(__FILE__, __LINE__);
            return $coupon_info;
        }
        if (!isset($coupon_info[$coupon_number])) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $request->setAttribute("coupon_info", $coupon_info[$coupon_number]);
        return VIEW_DONE;
    }
}
?>