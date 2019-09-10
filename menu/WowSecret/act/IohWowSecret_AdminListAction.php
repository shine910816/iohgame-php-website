<?php

/**
 * 魔兽大秘境录入编辑画面
 * @author Kinsama
 * @version 2019-09-10
 */
class IohWowSecret_AdminListAction extends ActionBase
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
        $item_info_list = IohWowSecretDBI::selectItemList();
        if ($controller->isError($item_info_list)) {
            $item_info_list->setPos(__FILE__, __LINE__);
            return $item_info_list;
        }
        $boss_info_list = IohWowSecretDBI::selectBossInfoList();
        if ($controller->isError($boss_info_list)) {
            $boss_info_list->setPos(__FILE__, __LINE__);
            return $boss_info_list;
        }
        $class_position_type_list = array(
            IohWowSecretEntity::ITEM_CLASS_0 => array(
                IohWowSecretEntity::ITEM_POSITION_0 => array(
                    IohWowSecretEntity::ITEM_TYPE_0 => "坐骑"
                )
            )
        );
        $weapon_list = IohWowSecretEntity::getWeaponList();
        foreach ($weapon_list as $pos_info) {
            foreach ($pos_info as $item_arr) {
                $class_position_type_list[IohWowSecretEntity::ITEM_CLASS_1][$item_arr["position"]][$item_arr["type"]] = $item_arr["name"];
            }
        }
        $equit_list = IohWowSecretEntity::getEquitList();
        foreach ($equit_list as $pos_info) {
            foreach ($pos_info as $item_arr) {
                $class_position_type_list[IohWowSecretEntity::ITEM_CLASS_2][$item_arr["position"]][$item_arr["type"]] = $item_arr["name"];
            }
        }
        $request->setAttribute("item_info_list", $item_info_list);
        $request->setAttribute("boss_info_list", $boss_info_list);
        $request->setAttribute("class_position_type_list", $class_position_type_list);
        return VIEW_DONE;
    }
}
?>