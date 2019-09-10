<?php

/**
 * 魔兽大秘境录入编辑画面
 * @author Kinsama
 * @version 2019-09-10
 */
class IohWowSecret_ListAction extends ActionBase
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
        $map_id = "0";
        $boss_id = "0";
        if ($request->hasParameter("boss_id")) {
            $boss_id = $request->getParameter("boss_id");
            $boss_info = IohWowSecretDBI::getBossInfo($boss_id);
            if ($controller->isError($boss_info)) {
                $boss_info->setPos(__FILE__, __LINE__);
                return $boss_info;
            }
            if (!isset($boss_info[$boss_id])) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $map_id = $boss_info[$boss_id]["map_id"];
        } elseif ($request->hasParameter("map_id")) {
            $map_id = $request->getParameter("map_id");
            $map_list = IohWowSecretDBI::getMapList();
            if ($controller->isError($map_list)) {
                $map_list->setPos(__FILE__, __LINE__);
                return $map_list;
            }
            if (!isset($map_list[$map_id])) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
        } else {
            $map_id = "1";
        }
        $request->setAttribute("map_id", $map_id);
        $request->setAttribute("boss_id", $boss_id);
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
        $map_id = $request->getAttribute("map_id");
        $boss_id = $request->getAttribute("boss_id");
        $boss_display_flg = false;
        $item_list = array();
        if ($boss_id) {
            $item_list = IohWowSecretDBI::selectItemByBossId($boss_id);
            if ($controller->isError($item_list)) {
                $item_list->setPos(__FILE__, __LINE__);
                return $item_list;
            }
        } else {
            $boss_display_flg = true;
            $item_list = IohWowSecretDBI::selectItemByMapId($map_id);
            if ($controller->isError($item_list)) {
                $item_list->setPos(__FILE__, __LINE__);
                return $item_list;
            }
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
        $request->setAttribute("item_list", $item_list);
        $request->setAttribute("map_info_list", $map_info_list);
        $request->setAttribute("boss_info_list", $boss_info_list);
        $request->setAttribute("boss_display_flg", $boss_display_flg);
        $request->setAttribute("class_position_type_list", $class_position_type_list);
Utility::testVariable($request->getAttributes());
        return VIEW_DONE;
    }
}
?>