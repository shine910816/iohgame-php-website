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
        $request->setAttribute("type_group", $type_group);
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
        $request->setAttribute("item_info_list", $item_info_list);
        $request->setAttribute("classes_list", IohWowClassesEntity::getClassesList());
        $request->setAttribute("talents_list", IohWowClassesEntity::getTalentsList());
        $request->setAttribute("type_list", IohWowSecretEntity::getPropertyList());
//Utility::testVariable($request->getAttributes());
        return VIEW_DONE;
    }

    private function _doUpdateExecute(Controller $controller, User $user, Request $request)
    {
        $item_id_list = $request->getParameter("item_id_list");
        $enable_info = $request->getParameter("enable_info");
Utility::testVariable($enable_info);
        return VIEW_NONE;
    }
}
?>