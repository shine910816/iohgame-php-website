<?php

/**
 * 魔兽大秘境录入编辑画面
 * @author Kinsama
 * @version 2019-09-12
 */
class IohWowSecret_WeaponInputAction extends ActionBase
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
        if (!$request->hasParameter("item_id")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $item_id = $request->getParameter("item_id");
        $weapon_item_list = IohWowSecretDBI::selectWeaponForAdmin();
        if ($controller->isError($weapon_item_list)) {
            $weapon_item_list->setPos(__FILE__, __LINE__);
            return $weapon_item_list;
        }
        if (!isset($weapon_item_list[$item_id])) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $item_info = $weapon_item_list[$item_id];
        $weapon_info = array(
            "item_id" => "0",
            "min" => "0",
            "max" => "0",
            "spd" => "0.00",
            "dps" => "0.0"
        );
        $weapon_info_list = IohWowSecretDBI::selectWeaponInfoList();
        if ($controller->isError($weapon_info_list)) {
            $weapon_info_list->setPos(__FILE__, __LINE__);
            return $weapon_info_list;
        }
        $update_flg = false;
        if (isset($weapon_info_list[$item_id])) {
            $update_flg = true;
            $weapon_info = $weapon_info_list[$item_id];
        } else {
            $weapon_info["item_id"] = $item_id;
        }
        $form_weapon_info = array();
        if ($request->hasParameter("execute")) {
            $form_weapon_info = $request->getParameter("weapon_info");
        }
        $request->setAttribute("item_id", $item_id);
        $request->setAttribute("boss_id", $item_info["boss_id"]);
        $request->setAttribute("item_info", $item_info);
        $request->setAttribute("weapon_info", $weapon_info);
        $request->setAttribute("update_flg", $update_flg);
        $request->setAttribute("form_weapon_info", $form_weapon_info);
//Utility::testVariable($request->getAttributes());
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
        $item_id = $request->getAttribute("item_id");
        $boss_id = $request->getAttribute("boss_id");
        $update_flg = $request->getAttribute("update_flg");
        $form_weapon_info = $request->getAttribute("form_weapon_info");
        if ($update_flg) {
            $update_res = IohWowSecretDBI::updateWeaponItem($item_id, $form_weapon_info);
            if ($controller->isError($update_res)) {
                $update_res->setPos(__FILE__, __LINE__);
                return $update_res;
            }
        } else {
            $form_weapon_info["item_id"] = $item_id;
            $insert_res = IohWowSecretDBI::insertWeaponItem($form_weapon_info);
            if ($controller->isError($insert_res)) {
                $insert_res->setPos(__FILE__, __LINE__);
                return $insert_res;
            }
        }
        $controller->redirect("./?menu=wow_secret&act=admin_weapon_list&boss_id=" . $boss_id . "#" . $item_id);
        return VIEW_NONE;
    }
}
?>