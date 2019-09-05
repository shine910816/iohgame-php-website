<?php

/**
 * 用户信息一览画面
 * @author Kinsama
 * @version 2017-01-13
 */
class IohUser_DispAction extends ActionBase
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
        $custom_id = $user->getVariable("custom_id");
        $request->setAttribute("custom_id", $custom_id);
        $request->setAttribute("open_level_list", IohCustomEntity::getOpenLevelList());
        $request->setAttribute("subpanel_file", SRC_PATH . "/menu/User/tpl/IohUser_MobileListView.tpl");
        return VIEW_DONE;
    }

    /**
     * 执行默认命令
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $custom_id = $request->getAttribute("custom_id");
        $custom_info = IohCustomDBI::selectCustomInfo($custom_id);
        if ($controller->isError($custom_info)) {
            $custom_info->setPos(__FILE__, __LINE__);
            return $custom_info;
        }
        $request->setAttribute("custom_birth_info", Utility::getBirthInfo($custom_info["custom_birth"]));
        $request->setAttribute("custom_info", $custom_info);
        return VIEW_DONE;
    }
}
?>