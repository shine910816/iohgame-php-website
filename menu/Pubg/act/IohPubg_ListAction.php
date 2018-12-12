<?php

/**
 *
 * @author Kinsama
 * @version 2018-06-22
 */
class IohPubg_ListAction extends ActionBase
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
        $weapon_type_list = IohPubgEntity::getWeaponTypeList();
        $part_type_list = IohPubgEntity::getPartTypeList();
        $request->setAttribute("weapon_type_list", $weapon_type_list);
        $request->setAttribute("part_type_list", $part_type_list);
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
        $weapon_list = IohPubgDBI::selectWeaponByType();
        if ($controller->isError($weapon_list)) {
            $weapon_list->setPos(__FILE__, __LINE__);
            return $weapon_list;
        }
        $part_list = IohPubgDBI::selectPartByType();
        if ($controller->isError($part_list)) {
            $part_list->setPos(__FILE__, __LINE__);
            return $part_list;
        }
        $weapon_part_list = IohPubgDBI::selectWeaponPartByType();
        if ($controller->isError($weapon_part_list)) {
            $weapon_part_list->setPos(__FILE__, __LINE__);
            return $weapon_part_list;
        }
        $param_limit = IohPubgDBI::selectWeaponParamLimit();
        if ($controller->isError($param_limit)) {
            $param_limit->setPos(__FILE__, __LINE__);
            return $param_limit;
        }
        foreach ($weapon_list as $w_type => $weapon_info_tmp) {
            foreach ($weapon_info_tmp as $w_id => $weapon_info) {
                $weapon_list[$w_type][$w_id]["w_damage_percent"] = str_replace(".0", "", sprintf("%3.1f", $weapon_info["w_damage"] / $param_limit["damage"] * 100));
                $weapon_list[$w_type][$w_id]["w_distance_percent"] = str_replace(".0", "", sprintf("%3.1f", $weapon_info["w_distance_max"] / $param_limit["distance"] * 100));
                $weapon_list[$w_type][$w_id]["w_speed_percent"] = str_replace(".0", "", sprintf("%3.1f", $weapon_info["w_speed"] / $param_limit["speed"] * 100));
                $weapon_list[$w_type][$w_id]["w_interval_percent"] = str_replace(".0", "", sprintf("%3.1f", $param_limit["interval"] / $weapon_info["w_interval_time"] * 100));
            }
        }
        $request->setAttribute("weapon_list", $weapon_list);
        $request->setAttribute("part_list", $part_list);
        $request->setAttribute("weapon_part_list", $weapon_part_list);
        // Utility::testVariable($weapon_list);
        return VIEW_DONE;
    }
}
?>