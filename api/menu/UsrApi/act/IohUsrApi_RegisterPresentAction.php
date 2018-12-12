<?php

/**
 * 注册赠送优惠券
 * @author Kinsama
 * @version 2018-12-11
 */
class IohUsrApi_RegisterPresentAction
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        $custom_id = $request->getAttribute("custom_id");
        if ($request->getAttribute("present_point_flg")) {
            $point_res = $this->_presentPoint($custom_id);
            if ($controller->isError($point_res)) {
                $point_res->setPos(__FILE__, __LINE__);
                return $point_res;
            }
        }
        if ($request->getAttribute("present_coupon_flg")) {
            $coupon_number = $this->_presentCoupon($custom_id);
            if ($controller->isError($coupon_number)) {
                $custom_info->setPos(__FILE__, __LINE__);
                return $coupon_number;
            }
        }
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
        $custom_id = $request->getParameter("k");
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
        $event_info = IohEventDBI::selectPassiveEvent(date("Y-m-d H:i:s"));
        if ($controller->isError($event_info)) {
            $event_info->setPos(__FILE__, __LINE__);
            return $event_info;
        }
        $event_number = $request->getAttribute("event_number");
        if (!isset($event_info[$event_number])) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $point_presented = IohPointDBI::selectRewardPoint($custom_id, IohPointEntity::POINT_TYPE_REGISTER);
        if ($controller->isError($point_presented)) {
            $point_presented->setPos(__FILE__, __LINE__);
            return $point_presented;
        }
        $present_point_flg = true;
        if (count($point_presented) > 0) {
            $present_point_flg = false;
        }
        $coupon_presented = IohCouponDBI::selectCouponHistory($custom_id, IohCouponEntity::COUPON_APPLY_RANGE_CHANGENICK);
        if ($controller->isError($coupon_presented)) {
            $coupon_presented->setPos(__FILE__, __LINE__);
            return $coupon_presented;
        }
        $present_coupon_flg = true;
        if (count($coupon_presented) > 0) {
            $present_coupon_flg = false;
        }
        $request->setAttribute("custom_id", $custom_id);
        $request->setAttribute("present_point_flg", $present_point_flg);
        $request->setAttribute("present_coupon_flg", $present_coupon_flg);
        return VIEW_DONE;
    }
    
    private function _presentCoupon($custom_id)
    {
        $now_time = time();
        $dbi = Database::getInstance();
        $begin_res = $dbi->begin();
        if ($dbi->isError($begin_res)) {
            $dbi->rollback();
            $begin_res->setPos(__FILE__, __LINE__);
            return $begin_res;
        }
        $today_coupon_count = IohCouponDBI::selectCouponNumberByDay(date("Y-m-d H:i:s", $now_time));
        if ($dbi->isError($today_coupon_count)) {
            $dbi->rollback();
            $today_coupon_count->setPos(__FILE__, __LINE__);
            return $today_coupon_count;
        }
        $coupon_number = sprintf("%sC%07d", date("Ymd", $now_time), count($today_coupon_count) + 1);
        $coupon_vaildity_start = mktime(
            0, 0, 0,
            date("n", $now_time), date("j", $now_time), date("Y", $now_time)
        );
        $coupon_vaildity_expiry = mktime(
            0, 0, -1,
            date("n", $now_time), date("j", $now_time) + 7, date("Y", $now_time)
        );
        $insert_data = array();
        $insert_data["coupon_number"] = $coupon_number;
        $insert_data["coupon_name"] = "昵称修改抵价券";
        $insert_data["coupon_descript"] = "注册即日起7日内有效，只能用于修改昵称，抵价300积分。";
        $insert_data["coupon_favour_type"] = IohCouponEntity::COUPON_FAVOUR_QUANTITY;
        $insert_data["coupon_favour_value"] = CUSTOM_CHANGE_NICK_POINT;
        $insert_data["coupon_favour_value_2"] = 0;
        $insert_data["coupon_publish_date"] = date("Y-m-d H:i:s", $now_time);
        $insert_data["coupon_vaildity_start"] = date("Y-m-d H:i:s", $coupon_vaildity_start);
        $insert_data["coupon_vaildity_expiry"] = date("Y-m-d H:i:s", $coupon_vaildity_expiry);
        $insert_data["coupon_apply_range"] = IohCouponEntity::COUPON_APPLY_RANGE_CHANGENICK;
        $insert_data["coupon_apply_flg"] = "0";
        $insert_data["coupon_apply_date"] = "";
        $insert_data["custom_id"] = $custom_id;
        $insert_res = IohCouponDBI::insertCoupon($insert_data);
        if ($dbi->isError($insert_res)) {
            $dbi->rollback();
            $insert_res->setPos(__FILE__, __LINE__);
            return $insert_res;
        }
        $history_data = array();
        $history_data["custom_id"] = $custom_id;
        $history_data["coupon_number"] = $coupon_number;
        $history_data["coupon_apply_range"] = IohCouponEntity::COUPON_APPLY_RANGE_CHANGENICK;
        $history_res = IohCouponDBI::insertRegisterCouponPresent($history_data);
        if ($dbi->isError($history_res)) {
            $dbi->rollback();
            $history_res->setPos(__FILE__, __LINE__);
            return $history_res;
        }
        $commit_res = $dbi->commit();
        if ($dbi->isError($commit_res)) {
            $dbi->rollback();
            $commit_res->setPos(__FILE__, __LINE__);
            return $commit_res;
        }
        return $coupon_number;
    }

    private function _presentPoint($custom_id)
    {
        $dbi = Database::getInstance();
        $begin_res = $dbi->begin();
        if ($dbi->isError($begin_res)) {
            $dbi->rollback();
            $begin_res->setPos(__FILE__, __LINE__);
            return $begin_res;
        }
        $point_info = IohPointDBI::selectPoint($custom_id);
        if ($dbi->isError($point_info)) {
            $dbi->rollback();
            $point_info->setPos(__FILE__, __LINE__);
            return $point_info;
        }
        if (!isset($point_info[$custom_id])) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $point_before = $point_info[$custom_id];
        $point_after = $point_before + CUSTOM_INITIAL_POINT;
        $update_res = IohPointDBI::updatePoint($custom_id, $point_after);
        if ($dbi->isError($update_res)) {
            $dbi->rollback();
            $update_res->setPos(__FILE__, __LINE__);
            return $update_res;
        }
        $history_data = array();
        $history_data["custom_id"] = $custom_id;
        $history_data["point_value"] = CUSTOM_INITIAL_POINT;
        $history_data["point_type"] = IohPointEntity::POINT_TYPE_REGISTER;
        $history_data["point_note"] = "";
        $history_data["point_before"] = $point_before;
        $history_data["point_after"] = $point_after;
        $insert_res = IohPointDBI::insertPointHistory($history_data);
        if ($dbi->isError($insert_res)) {
            $dbi->rollback();
            $insert_res->setPos(__FILE__, __LINE__);
            return $insert_res;
        }
        $commit_res = $dbi->commit();
        if ($dbi->isError($commit_res)) {
            $dbi->rollback();
            $commit_res->setPos(__FILE__, __LINE__);
            return $commit_res;
        }
        return true;
    }
}
?>