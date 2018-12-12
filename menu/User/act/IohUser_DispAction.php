<?php

/**
 * 用户信息一览画面
 * @author Kinsama
 * @version 2017-01-13
 */
class IohUser_DispAction extends ActionBase
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
        $request->setAttribute("custom_id", $custom_id);
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
        //$cus_id = $user->getVariable("cus_id");
        $custom_id = $request->getAttribute("custom_id");
        $custom_info = IohCustomDBI::selectCustomInfo($custom_id);
        if ($controller->isError($custom_info)) {
            $custom_info->setPos(__FILE__, __LINE__);
            return $custom_info;
        }
        $request->setAttribute("custom_birth_info", $this->_getPersonalInfo($custom_info["custom_birth"]));
        $request->setAttribute("custom_info", $custom_info);
        //$cus_info = IohCustomerDBI::getCustomLoginInfoByCusId($cus_id);
        //if ($controller->isError($cus_info)) {
        //    $cus_info->setPos(__FILE__, __LINE__);
        //    return $cus_info;
        //}
        //if (!isset($cus_info[$cus_id])) {
        //    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
        //    $err->setPos(__FILE__, __LINE__);
        //    return $err;
        //}
        //$request->setAttributes($cus_info[$cus_id]);
        //$request->setAttribute("constell_list", IohCustomerEntity::getConstellList());
        
        return VIEW_DONE;
    }

    private function _getPersonalInfo($custom_birth)
    {
        $result = array();
        $birthday = new DateTime($custom_birth);
        $month_day = $birthday->format("nd");
        $now_month_day = date("nd");
        $result["age"] = date("Y") - $birthday->format("Y");
        if ($now_month_day < $month_day) {
            $result["age"] -= 1;
        }
        if ($month_day >= 321 && $month_day <= 419) {
            $result["con"] = "白羊座&#9800;";
        }
        if ($month_day >= 420 && $month_day <= 520) {
            $result["con"] = "金牛座&#9801;";
        }
        if ($month_day >= 521 && $month_day <= 621) {
            $result["con"] = "双子座&#9802;";
        }
        if ($month_day >= 622 && $month_day <= 722) {
            $result["con"] = "巨蟹座&#9803;";
        }
        if ($month_day >= 723 && $month_day <= 822) {
            $result["con"] = "狮子座&#9804;";
        }
        if ($month_day >= 823 && $month_day <= 922) {
            $result["con"] = "处女座&#9805;";
        }
        if ($month_day >= 923 && $month_day <= 1023) {
            $result["con"] = "天秤座&#9806;";
        }
        if ($month_day >= 1024 && $month_day <= 1122) {
            $result["con"] = "天蝎座&#9807;";
        }
        if ($month_day >= 1123 && $month_day <= 1221) {
            $result["con"] = "射手座&#9808;";
        }
        if ($month_day >= 1222 || $month_day <= 119) {
            $result["con"] = "摩羯座&#9809;";
        }
        if ($month_day >= 120 && $month_day <= 218) {
            $result["con"] = "水瓶座&#9810;";
        }
        if ($month_day >= 219 && $month_day <= 320) {
            $result["con"] = "双鱼座&#9811;";
        }
        return $result;
    }
}
?>