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
        $duty_group = IohWowClassesEntity::DUTY_TANK_STR;
        if ($request->hasParameter("duty_group")) {
            $duty_group = $request->getParameter("duty_group");
        }
        $request->setAttribute("type_group", $type_group);
        $request->setAttribute("duty_group", $duty_group);
        $request->setAttribute("type_group_list", array(
            "1" => "武器饰品",
            "2" => "布甲",
            "3" => "皮甲",
            "4" => "锁甲",
            "5" => "板甲",
            "6" => "其他"
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
        $duty_group = $request->getAttribute("duty_group");
        $duty_config_list = IohWowClassesEntity::getDutyConfigList();
        $request->setAttribute("item_info_list", $item_info_list);
        $request->setAttribute("classes_list", IohWowClassesEntity::getClassesList());
        $request->setAttribute("talents_list", $duty_config_list[$duty_group]);
        $request->setAttribute("type_list", IohWowSecretEntity::getPropertyList());
        $request->setAttribute("duty_list", IohWowClassesEntity::getDutyList());
        return VIEW_DONE;
    }

    private function _doUpdateExecute(Controller $controller, User $user, Request $request)
    {
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