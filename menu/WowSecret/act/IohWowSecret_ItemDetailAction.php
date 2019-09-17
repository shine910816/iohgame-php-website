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
        $item_id = $request->getAttribute("item_id");
        $item_info = $request->getAttribute("item_info");
        $special_flg = false;
        if ($item_info["item_class"] == IohWowSecretEntity::ITEM_CLASS_2 && (
            $item_info["item_position"] == IohWowSecretEntity::ITEM_POSITION_5 ||
            $item_info["item_position"] == IohWowSecretEntity::ITEM_POSITION_7 ||
            $item_info["item_position"] == IohWowSecretEntity::ITEM_POSITION_9)) {
            $special_flg = true;
        }
        $special_info = array(
            IohWowSecretEntity::ITEM_POSITION_5 => array(15, 30, 34, 38, 42),
            IohWowSecretEntity::ITEM_POSITION_7 => array(15, 32, 36, 40, 44),
            IohWowSecretEntity::ITEM_POSITION_9 => array(15, 31, 35, 39, 43)
        );
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
        $class_position_type_list = IohWowSecretEntity::getPropertyList(true);
        $map_id = $boss_info_list[$item_info["boss_id"]]["map_id"];
        $boss_id = $item_info["boss_id"];
        $back_url = "./?menu=wow_secret&act=list";
        if ($request->hasParameter("back_map")) {
            $back_url .= "&map_id=" . $map_id;
        } else {
            $back_url .= "&boss_id=" . $boss_id;
        }
        $weapon_info = array();
        $weapon_display_flg = false;
        if ($item_info["item_class"] == IohWowSecretEntity::ITEM_CLASS_1 &&
            $item_info["item_position"] != IohWowSecretEntity::ITEM_POSITION_3) {
            $weapon_display_flg = true;
            $weapon_info_list = IohWowSecretDBI::selectWeaponInfoList();
            if ($controller->isError($weapon_info_list)) {
                $weapon_info_list->setPos(__FILE__, __LINE__);
                return $weapon_info_list;
            }
            if (isset($weapon_info_list[$item_id])) {
                $weapon_info = $weapon_info_list[$item_id];
            }
        }
        $suit_info = array();
        $suit_id = IohWowSecretDBI::selectSuitByItemId($item_id);
        if ($controller->isError($suit_id)) {
            $suit_id->setPos(__FILE__, __LINE__);
            return $suit_id;
        }
        if ($suit_id) {
            $tmp_suit_info = IohWowSecretDBI::selectSuitInfo($suit_id);
            if ($controller->isError($tmp_suit_info)) {
                $tmp_suit_info->setPos(__FILE__, __LINE__);
                return $tmp_suit_info;
            }
            $tmp_suit_item = IohWowSecretDBI::selectSuitItem($suit_id);
            if ($controller->isError($tmp_suit_item)) {
                $tmp_suit_item->setPos(__FILE__, __LINE__);
                return $tmp_suit_item;
            }
            $suit_info["suit_name"] = $tmp_suit_info[$suit_id]["suit_name"];
            $suit_info["suit_equit_effect"] = array();
            if (strlen($tmp_suit_info[$suit_id]["suit_equit_effect"]) > 0 && $tmp_suit_info[$suit_id]["suit_equit_effect_amount"] > 0) {
                $suit_info["suit_equit_effect"][$tmp_suit_info[$suit_id]["suit_equit_effect_amount"]] = $tmp_suit_info[$suit_id]["suit_equit_effect"];
            }
            if (strlen($tmp_suit_info[$suit_id]["suit_equit_effect_2"]) > 0 && $tmp_suit_info[$suit_id]["suit_equit_effect_amount_2"] > 0) {
                $suit_info["suit_equit_effect"][$tmp_suit_info[$suit_id]["suit_equit_effect_amount_2"]] = $tmp_suit_info[$suit_id]["suit_equit_effect_2"];
            }
            $suit_info["suit_item"] = $tmp_suit_item;
            $suit_info["suit_item_amount"] = count($tmp_suit_item);
        }
        $request->setAttribute("special_flg", $special_flg);
        $request->setAttribute("special_info", $special_info);
        $request->setAttribute("item_equit_effect", $item_equit_effect);
        $request->setAttribute("item_use_effect", $item_use_effect);
        $request->setAttribute("map_info_list", $map_info_list);
        $request->setAttribute("boss_info_list", $boss_info_list);
        $request->setAttribute("type_info", $class_position_type_list[$item_info["item_class"]][$item_info["item_position"]][$item_info["item_type"]]);
        $request->setAttribute("map_id", $map_id);
        $request->setAttribute("boss_id", $boss_id);
        $request->setAttribute("back_url", $back_url);
        $request->setAttribute("weapon_display_flg", $weapon_display_flg);
        $request->setAttribute("weapon_info", $weapon_info);
        $request->setAttribute("suit_info", $suit_info);
        return VIEW_DONE;
    }
}
?>