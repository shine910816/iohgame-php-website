<?php

/**
 * 魔兽大秘境录入编辑画面
 * @author Kinsama
 * @version 2019-09-08
 */
class IohWowSecret_InputAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("execute")) {
            $ret = $this->_doInputExecute($controller, $user, $request);
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
        $code_list = IohWowSecretEntity::getVolumnName();
        $item_info = array(
            "item_id" => "",
            "item_name" => "",
            "item_class" => "2",
            "item_position" => "0",
            "item_type" => "0",
            "item_armor" => "0",
            "item_strength" => "0",
            "item_agility" => "0",
            "item_intellect" => "0",
            "item_stamina" => "0",
            "item_critical" => "0",
            "item_haste" => "0",
            "item_mastery" => "0",
            "item_versatility" => "0",
            "item_equit_effect" => "",
            "item_equit_effect_num" => "0",
            "item_equit_effect_num2" => "0",
            "item_use_effect" => "",
            "item_use_effect_num" => "0",
            "item_use_effect_num2" => "0",
            "map_id" => "4",
            "boss_order" => "3"
        );
        $map_list = IohWowSecretDBI::getMapList();
        if ($controller->isError($map_list)) {
            $map_list->setPos(__FILE__, __LINE__);
            return $map_list;
        }
        $boss_list = IohWowSecretDBI::getBossList();
        if ($controller->isError($boss_list)) {
            $boss_list->setPos(__FILE__, __LINE__);
            return $boss_list;
        }
        $request->setAttribute("item_class_list", $code_list["class"]);
        $request->setAttribute("item_position_list", $code_list["position"]);
        $request->setAttribute("item_type_list", $code_list["type"]);
        $request->setAttribute("item_info", $item_info);
        $request->setAttribute("map_list", $map_list);
        $request->setAttribute("boss_list", $boss_list);
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
//Utility::testVariable($request->getAttributes());
        return VIEW_DONE;
    }

    /**
     * 执行卡牌录入程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doInputExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_NONE;
    }

    //private function _getTypeList($item_position, $item_type = null)
    //{
    //    $code_list = IohWowSecretEntity::getVolumnName();
    //    $item_position_list = $code_list["position"];
    //    $item_type_list = $code_list["type"];
    //}
}
?>