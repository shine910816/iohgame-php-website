<?php

/**
 * 修改昵称画面
 * @author Kinsama
 * @version 2017-07-31
 */
class IohUser_ChangeNickAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("n")) {
            $ret = $this->_doRememberNickExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->isError()) {
            $ret = $this->_doErrorExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("do_change")) {
            $ret = $this->_doChangeExecute($controller, $user, $request);
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
        if (!$user->hasVariable(USER_CHANGE_NICK)) {
            $user->setVariable(USER_CHANGE_NICK, $custom_info["custom_nick"]);
        }
        if ($request->hasParameter("n")) {
            return VIEW_DONE;
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
        $selected_coupon = "";
        if ($request->hasParameter("selected_coupon")) {
            $selected_coupon = $request->getParameter("selected_coupon");
        }
        $coupon_info = IohCouponDBI::selectCoupon($custom_id, date("Y-m-d H:i:s"), IohCouponEntity::COUPON_APPLY_RANGE_CHANGENICK);
        if ($controller->isError($coupon_info)) {
            $coupon_info->setPos(__FILE__, __LINE__);
            return $coupon_info;
        }
        if (!empty($coupon_info)) {
            foreach ($coupon_info as $coupon_number => $conpon_info_item) {
                $coupon_key_arr = array();
                $coupon_key_arr["coupon_number"] = $coupon_number;
                $coupon_key_arr["from_menu"] = $request->current_menu;
                $coupon_key_arr["from_act"] = $request->current_act;
                $coupon_info[$coupon_number]["translated_coupon_number"] = Utility::encodeCookieInfo($coupon_key_arr);
            }
        }
        if (!empty($coupon_info) && !isset($coupon_info[$selected_coupon])) {
            $selected_coupon = "";
        }
        $deduct_point = 0;
        $cost_point = CUSTOM_CHANGE_NICK_POINT;
        if (strlen($selected_coupon) != 0) {
            if ($coupon_info[$selected_coupon]["coupon_favour_type"] == IohCouponEntity::COUPON_FAVOUR_PERCENT) {
                $deduct_point = floor($coupon_info[$selected_coupon]["coupon_favour_value"] * $cost_point / 100);
            } else {
                $deduct_point = $coupon_info[$selected_coupon]["coupon_favour_value"];
            }
        }
        $total_point = $cost_point - $deduct_point;
        if ($total_point < 0) {
            $total_point = 0;
        }
        $custom_point = $point_info[$custom_id];
        $error_hint_flg = false;
        if ($total_point > $custom_point) {
            $error_hint_flg = true;
        }
        $custom_nick = "";
        if ($request->hasParameter("do_change")) {
            $custom_nick = $request->getParameter("custom_nick");
            $user->setVariable(USER_CHANGE_NICK, $custom_nick);
            if (!Rule::checkCustomNick($custom_nick)) {
                $request->setError("custom_nick", "您所修改的昵称不符合规范。");
            }
            if ($error_hint_flg) {
                $request->setError("custom_point", "当前积分不足，无法完成支付。");
            }
        }
        $request->setAttribute("custom_id", $custom_id);
        $request->setAttribute("custom_info", $custom_info);
        $request->setAttribute("custom_point", $custom_point);
        $request->setAttribute("cost_point", $cost_point);
        $request->setAttribute("coupon_info", $coupon_info);
        $request->setAttribute("selected_coupon", $selected_coupon);
        $request->setAttribute("deduct_point", $deduct_point);
        $request->setAttribute("total_point", $total_point);
        $request->setAttribute("error_hint_flg", $error_hint_flg);
        $request->setAttribute("custom_nick", $custom_nick);
        $request->setAttribute("default_custom_nick", $user->getVariable(USER_CHANGE_NICK));
        return VIEW_DONE;
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
        return VIEW_DONE;
    }

    /**
     * 执行输入错误提示命令
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doErrorExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }

    /**
     * 执行修改昵称命令
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doChangeExecute(Controller $controller, User $user, Request $request)
    {
        $custom_id = $request->getAttribute("custom_id");
        $custom_point = $request->getAttribute("custom_point");
        $selected_coupon = $request->getAttribute("selected_coupon");
        $total_point = $request->getAttribute("total_point");
        $custom_nick = $request->getAttribute("custom_nick");
        $dbi = Database::getInstance();
        $begin_res = $dbi->begin();
        if ($dbi->isError($begin_res)) {
            $dbi->rollback();
            $begin_res->setPos(__FILE__, __LINE__);
            return $begin_res;
        }
        $update_custom_info_res = IohCustomDBI::updateInfo(array("custom_nick" => $custom_nick), "del_flg = 0 AND custom_id = " . $custom_id);
        if ($dbi->isError($update_custom_info_res)) {
            $dbi->rollback();
            $update_custom_info_res->setPos(__FILE__, __LINE__);
            return $update_custom_info_res;
        }
        if (strlen($selected_coupon) != 0) {
            $update_coupon_data = array(
                "coupon_apply_flg" => IohCouponEntity::COUPON_APPLY_YES,
                "coupon_apply_date" => date("Y-m-d H:i:s")
            );
            $update_coupon_where = "del_flg = 0 AND custom_id = " . $custom_id . " AND coupon_number = \"" . $selected_coupon . "\"";
            $update_coupon_res = IohCouponDBI::updateCoupon($update_coupon_data, $update_coupon_where);
            if ($dbi->isError($update_coupon_res)) {
                $dbi->rollback();
                $update_coupon_res->setPos(__FILE__, __LINE__);
                return $update_coupon_res;
            }
        }
        if ($total_point > 0) {
            $point_after = $custom_point - $total_point;
            $update_point_res = IohPointDBI::updatePoint($custom_id, $point_after);
            if ($dbi->isError($update_point_res)) {
                $dbi->rollback();
                $update_point_res->setPos(__FILE__, __LINE__);
                return $update_point_res;
            }
            $insert_point_data = array(
                "custom_id" => $custom_id,
                "point_value" => 0 - $total_point,
                "point_type" => IohPointEntity::POINT_TYPE_SITE_SERVICE,
                "point_note" => "修改昵称",
                "point_before" => $custom_point,
                "point_after" => $point_after
            );
            $insert_point_res = IohPointDBI::insertPointHistory($insert_point_data);
            if ($dbi->isError($insert_point_res)) {
                $dbi->rollback();
                $insert_point_res->setPos(__FILE__, __LINE__);
                return $insert_point_res;
            }
        }
        $commit_res = $dbi->commit();
        if ($dbi->isError($commit_res)) {
            $dbi->rollback();
            $commit_res->setPos(__FILE__, __LINE__);
            return $commit_res;
        }
        $user->setVariable("custom_nick", $custom_nick);
        $user->freeVariable(USER_CHANGE_NICK);
        $controller->redirect("./?menu=user&act=disp");
        return VIEW_NONE;
    }

    private function _doRememberNickExecute(Controller $controller, User $user, Request $request)
    {
        $user->setVariable(USER_CHANGE_NICK, $request->getParameter("n"));
        return VIEW_NONE;
    }
}
?>