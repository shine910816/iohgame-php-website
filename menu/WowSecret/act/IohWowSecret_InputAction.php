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
        $item_info = array(
            "item_name" => "",
            "item_class" => "1",
            "item_position" => "1",
            "item_type" => "1",
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
            "boss_id" => "1"
        );
        $update_item_id = "0";
        if ($request->hasParameter("item_id")) {
            $update_item_id = $request->getParameter("item_id");
        }
        if ($request->hasParameter("execute")) {
            $item_info = $request->getParameter("item_info");
            $position_type_text = "0-0";
            if ($item_info["item_class"] == IohWowSecretEntity::ITEM_CLASS_1) {
                $position_type_text = $request->getParameter("weapon_info");
            } elseif ($item_info["item_class"] == IohWowSecretEntity::ITEM_CLASS_2) {
                $position_type_text = $request->getParameter("equit_info");
            }
            $position_type_arr = explode("-", $position_type_text);
            $item_info["item_position"] = $position_type_arr[0];
            $item_info["item_type"] = $position_type_arr[1];
        } else {
            if ($request->hasParameter("item_id")) {
                $item_id = $request->getParameter("item_id");
                $selected_item_info = IohWowSecretDBI::selectItem($item_id);
                if ($controller->isError($selected_item_info)) {
                    $selected_item_info->setPos(__FILE__, __LINE__);
                    return $selected_item_info;
                }
                if (!isset($selected_item_info[$item_id])) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                $item_info = $selected_item_info[$item_id];
            } else {
                if ($request->hasParameter("boss_id")) {
                    $item_info["boss_id"] = $request->getParameter("boss_id");
                }
                if ($request->hasParameter("item_class") && $request->hasParameter("item_position") && $request->hasParameter("item_type")) {
                    $item_info["item_class"] = $request->getParameter("item_class");
                    $item_info["item_position"] = $request->getParameter("item_position");
                    $item_info["item_type"] = $request->getParameter("item_type");
                }
            }
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
            $code_list = IohWowSecretEntity::getVolumnName();
            $request->setAttribute("item_class_list", $code_list["class"]);
            $request->setAttribute("weapon_list", IohWowSecretEntity::getWeaponList());
            $request->setAttribute("equit_list", IohWowSecretEntity::getEquitList());
            $request->setAttribute("map_list", $map_list);
            $request->setAttribute("boss_list", $boss_list);
        }
        $request->setAttribute("update_item_id", $update_item_id);
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
//Utility::testVariable($request->getAttributes());
        $item_id = $request->getAttribute("update_item_id");
        $item_info = $request->getAttribute("item_info");
        if ($item_id) {
            $update_res = IohWowSecretDBI::updateItem($item_id, $item_info);
            if ($controller->isError($update_res)) {
                $update_res->setPos(__FILE__, __LINE__);
                return $update_res;
            }
            $controller->redirect("./?menu=wow_secret&act=admin_list");
        } else {
            $insert_res = IohWowSecretDBI::insertItem($item_info);
            if ($controller->isError($insert_res)) {
                $insert_res->setPos(__FILE__, __LINE__);
                return $insert_res;
            }
            $redirect_arr = explode(",", "item_class,item_position,item_type,boss_id");
            $redirect_url = "./?menu=wow_secret&act=input";
            foreach ($redirect_arr as $volumn_name) {
                $redirect_url .= "&" . $volumn_name . "=" . $item_info[$volumn_name];
            }
            $controller->redirect($redirect_url);
        }
        return VIEW_NONE;
    }
}
?>