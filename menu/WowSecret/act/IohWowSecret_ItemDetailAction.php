<?php

/**
 * 魔兽大秘境物品详细画面
 * @author Kinsama
 * @version 2019-09-11
 */
class IohWowSecret_ItemDetailAction extends ActionBase
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
        if (!$request->hasParameter("item_id")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $item_id = $request->getParameter("item_id");
        $item_info = IohWowSecretDBI::selectItem($item_id);
        if ($controller->isError($item_info)) {
            $item_info->setPos(__FILE__, __LINE__);
            return $item_info;
        }
        if (!isset($item_info[$item_id])) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $item_info = $item_info[$item_id];
        $request->setAttribute("item_id", $item_id);
        $request->setAttribute("item_info", $item_info);
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
        $item_info = $request->getAttribute("item_info");
        $item_equit_effect = "";
        $item_use_effect = "";
        if (strlen($item_info["item_equit_effect"]) > 0) {
            $item_equit_effect = sprintf(
                $item_info["item_equit_effect"],
                number_format($item_info["item_equit_effect_num"]),
                number_format($item_info["item_equit_effect_num2"])
            );
        }
        if (strlen($item_info["item_use_effect"]) > 0) {
            $item_use_effect = sprintf(
                $item_info["item_use_effect"],
                number_format($item_info["item_use_effect_num"]),
                number_format($item_info["item_use_effect_num2"])
            );
        }
        $map_info_list = IohWowSecretDBI::getMapList();
        if ($controller->isError($map_info_list)) {
            $map_info_list->setPos(__FILE__, __LINE__);
            return $map_info_list;
        }
        $boss_info_list = IohWowSecretDBI::getBossList();
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
        $map_id = $boss_info_list[$item_info["boss_id"]]["map_id"];
        $boss_id = $item_info["boss_id"];
        $back_url = "./?menu=wow_secret&act=list";
        if ($request->hasParameter("back_map")) {
            $back_url .= "&map_id=" . $map_id;
        } else {
            $back_url .= "&boss_id=" . $boss_id;
        }
        $request->setAttribute("item_equit_effect", $item_equit_effect);
        $request->setAttribute("item_use_effect", $item_use_effect);
        $request->setAttribute("map_info_list", $map_info_list);
        $request->setAttribute("boss_info_list", $boss_info_list);
        $request->setAttribute("class_position_type_list", $class_position_type_list);
        $request->setAttribute("map_id", $map_id);
        $request->setAttribute("boss_id", $boss_id);
        $request->setAttribute("back_url", $back_url);
//Utility::testVariable($request->getAttributes());
        return VIEW_DONE;
    }
}
?>