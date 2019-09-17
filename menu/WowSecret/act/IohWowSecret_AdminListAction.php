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
        $hylight_boss_id = "0";
        if ($request->hasParameter("boss_id")) {
            $hylight_boss_id = $request->getParameter("boss_id");
        }
        $request->setAttribute("item_info_list", $item_info_list);
        $request->setAttribute("boss_info_list", $boss_info_list);
        $request->setAttribute("class_position_type_list", IohWowSecretEntity::getPropertyList());
        $request->setAttribute("hylight_boss_id", $hylight_boss_id);
        return VIEW_DONE;
    }
}
?>