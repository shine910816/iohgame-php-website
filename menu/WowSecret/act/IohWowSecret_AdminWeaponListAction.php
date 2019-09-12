<?php

/**
 * 魔兽大秘境录入编辑画面
 * @author Kinsama
 * @version 2019-09-11
 */
class IohWowSecret_AdminWeaponListAction extends ActionBase
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
        $weapon_item_list = IohWowSecretDBI::selectWeaponForAdmin();
        if ($controller->isError($weapon_item_list)) {
            $weapon_item_list->setPos(__FILE__, __LINE__);
            return $weapon_item_list;
        }
        $boss_info_list = IohWowSecretDBI::selectBossInfoList();
        if ($controller->isError($boss_info_list)) {
            $boss_info_list->setPos(__FILE__, __LINE__);
            return $boss_info_list;
        }
        $class_position_type_list = array();
        $weapon_list = IohWowSecretEntity::getWeaponList();
        foreach ($weapon_list as $pos_info) {
            foreach ($pos_info as $item_arr) {
                $class_position_type_list[IohWowSecretEntity::ITEM_CLASS_1][$item_arr["position"]][$item_arr["type"]] = $item_arr["name"];
            }
        }
        $weapon_info_list = IohWowSecretDBI::selectWeaponInfoList();
        if ($controller->isError($weapon_info_list)) {
            $weapon_info_list->setPos(__FILE__, __LINE__);
            return $weapon_info_list;
        }
        $hylight_boss_id = "0";
        if ($request->hasParameter("boss_id")) {
            $hylight_boss_id = $request->getParameter("boss_id");
        }
        $request->setAttribute("weapon_item_list", $weapon_item_list);
        $request->setAttribute("boss_info_list", $boss_info_list);
        $request->setAttribute("class_position_type_list", $class_position_type_list);
        $request->setAttribute("weapon_info_list", $weapon_info_list);
        $request->setAttribute("hylight_boss_id", $hylight_boss_id);
        return VIEW_DONE;
    }
}
?>