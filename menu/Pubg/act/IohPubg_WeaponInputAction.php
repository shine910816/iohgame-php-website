<?php

/**
 *
 * @author Kinsama
 * @version 2018-08-23
 */
class IohPubg_WeaponInputAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("back")) {
            $ret = $this->_doBackExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("confirm")) {
            $ret = $this->_doSubmitExecute($controller, $user, $request);
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
        $w_id = "0";
        if ($request->hasParameter("w_id")) {
            $w_id = $request->getParameter("w_id");
        }
        $weapon_info = array(
            "w_name" => "",
            "w_type" => "0",
            "w_damage_vest_0" => "0",
            "w_damage_vest_1" => "0",
            "w_damage_vest_2" => "0",
            "w_damage_vest_3" => "0",
            "w_damage_helmet_0" => "0",
            "w_damage_helmet_1" => "0",
            "w_damage_helmet_2" => "0",
            "w_damage_helmet_3" => "0",
            "w_part_able_1" => "0",
            "w_part_able_2" => "0",
            "w_part_able_3" => "0",
            "w_part_able_4" => "0",
            "w_part_able_5" => "0",
            "w_magazine_default" => "0",
            "w_magazine_extender" => "0",
            "w_image" => "",
            "w_descript" => ""
        );
        $request->setAttribute("w_id", $w_id);
        $request->setAttribute("weapon_info", $weapon_info);
        $request->setAttribute("weapon_type_list", IohPubgEntity::getWeaponTypeList());
        $request->setAttribute("part_type_list", IohPubgEntity::getPartTypeList());
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
        $w_id = $request->getAttribute("w_id");
        if ($w_id != "0") {
            $weapon_info_list = IohPubgDBI::selectWeapon($w_id);
            if ($controller->isError($weapon_info_list)) {
                $weapon_info_list->setPos(__FILE__, __LINE__);
                return $weapon_info_list;
            }
            if (isset($weapon_info_list[$w_id])) {
                $request->setAttribute("weapon_info", $weapon_info_list[$w_id]);
            } else {
                $request->setAttribute("w_id", "0");
            }
        }
        return VIEW_DONE;
    }

    private function _doSubmitExecute(Controller $controller, User $user, Request $request)
    {
        $w_id = $request->getAttribute("w_id");
        $weapon_info = $request->getParameter("weapon_info");
        if ($weapon_info["w_name"] == "") {
            $controller->redirect("./?menu=pubg&act=weapon_input");
            return VIEW_DONE;
        }
        $part_able = array();
        if ($request->hasParameter("part_able")) {
            $part_able = $request->getParameter("part_able");
        }
        for ($i = 1; $i <= 5; $i++) {
            $part_able_key = "w_part_able_" . $i;
            if (isset($part_able[$part_able_key])) {
                $weapon_info[$part_able_key] = "1";
            } else {
                $weapon_info[$part_able_key] = "0";
            }
        }
        $redirect_url = "./?menu=pubg&act=weapon_input&w_id=";
        if ($w_id) {
            $update_res = IohPubgDBI::updateWeapon($weapon_info, $w_id);
            if ($controller->isError($update_res)) {
                $update_res->setPos(__FILE__, __LINE__);
                return $update_res;
            }
            $redirect_url .= $w_id;
        } else {
            $insert_res = IohPubgDBI::insertWeapon($weapon_info);
            if ($controller->isError($insert_res)) {
                $insert_res->setPos(__FILE__, __LINE__);
                return $insert_res;
            }
            $redirect_url .= $insert_res;
        }
        $controller->redirect($redirect_url);
        return VIEW_DONE;
    }

    private function _doBackExecute(Controller $controller, User $user, Request $request)
    {
        $controller->redirect("./?menu=pubg&act=weapon_list");
    }
}
?>