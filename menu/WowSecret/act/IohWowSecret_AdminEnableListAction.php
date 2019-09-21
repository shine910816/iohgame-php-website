<?php

/**
 * 魔兽大秘境录入编辑画面
 * @author Kinsama
 * @version 2019-09-18
 */
class IohWowSecret_AdminEnableListAction extends ActionBase
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
            $ret = $this->_doUpdateExecute($controller, $user, $request);
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
        $type_group = "1";
        if ($request->hasParameter("type_group")) {
            $type_group = $request->getParameter("type_group");
        }
        $duty_group = IohWowClassesEntity::DUTY_TANK;
        if ($request->hasParameter("duty_group")) {
            $duty_group = $request->getParameter("duty_group");
        }
        $request->setAttribute("type_group", $type_group);
        $request->setAttribute("duty_group", $duty_group);
        $request->setAttribute("type_group_list", array(
            "1" => "布甲",
            "2" => "皮甲",
            "3" => "锁甲",
            "4" => "板甲",
            "5" => "武器饰品",
            "6" => "披风戒指"
        ));
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
        $type_group = $request->getAttribute("type_group");
        $item_info_list = IohWowSecretDBI::selectEnableInfoForAdmin($type_group);
        if ($controller->isError($item_info_list)) {
            $item_info_list->setPos(__FILE__, __LINE__);
            return $item_info_list;
        }
        $duty_display_flg = false;
        $duty_config_list = array();
        if ($type_group == "5") {
            $duty_group = $request->getAttribute("duty_group");
            $duty_tmp_list = IohWowClassesEntity::getDutyConfigList();
            $duty_config_list = $duty_tmp_list[$duty_group];
            $duty_display_flg = true;
        } elseif ($type_group == "6") {
            $duty_config_list = IohWowClassesEntity::getTalentsList();
        } else {
            $duty_tmp_list = IohWowClassesEntity::getArmorTypeList();
            $duty_config_list = $duty_tmp_list[$type_group];
        }
        $table_width = 509;
        foreach ($duty_config_list as $classes_info) {
            $table_width += count($classes_info) * 76;
        }
        $request->setAttribute("item_info_list", $item_info_list);
        $request->setAttribute("classes_list", IohWowClassesEntity::getClassesList());
        $request->setAttribute("talents_list", $duty_config_list);
        $request->setAttribute("type_list", IohWowSecretEntity::getPropertyList());
        $request->setAttribute("duty_list", IohWowClassesEntity::getDutyList());
        $request->setAttribute("duty_display_flg", $duty_display_flg);
        $request->setAttribute("table_width", $table_width);
//Utility::testVariable($request->getAttributes());
        return VIEW_DONE;
    }

    private function _doUpdateExecute(Controller $controller, User $user, Request $request)
    {
//Utility::testVariable($request->getParameters());
        $type_group = $request->getAttribute("type_group");
        $duty_group = $request->getAttribute("duty_group");
        $item_id_list = $request->getParameter("item_id_list");
        $enable_flg_list = $request->getParameter("enable_flg_list");
        $enable_info = $request->getParameter("enable_info");
        foreach ($item_id_list as $item_id) {
            $update_arr = array();
            if (isset($enable_info[$item_id])) {
                foreach ($enable_flg_list as $enable_key) {
                    if (isset($enable_info[$item_id][$enable_key])) {
                        $update_arr[$enable_key] = "1";
                    } else {
                        $update_arr[$enable_key] = "0";
                    }
                }
            } else {
                foreach ($enable_flg_list as $enable_key) {
                    $update_arr[$enable_key] = "0";
                }
            }
            $update_res = IohWowSecretDBI::updateItem($item_id, $update_arr);
            if ($controller->isError($update_res)) {
                $update_res->setPos(__FILE__, __LINE__);
                return $update_res;
            }
        }
        $controller->redirect("./?menu=wow_secret&act=admin_enable_list&type_group=" . $type_group . "&duty_group=" . $duty_group);
        return VIEW_NONE;
    }
}
?>