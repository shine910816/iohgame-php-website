<?php

/**
 *
 * @author Kinsama
 * @version 2018-05-07
 */
class IohPlayerManage_AddAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("create")) {
            $ret = $this->_doCreateExecute($controller, $user, $request);
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
        return VIEW_DONE;
    }

    /**
     * 执行参数检测
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainValidate(Controller $controller, User $user, Request $request)
    {
        $new_group_flg = 0;
        if ($request->hasParameter("new")) {
            $new_group_flg = 1;
        }
        $request->setAttribute("new_group_flg", $new_group_flg);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $new_group_flg = $request->getAttribute("new_group_flg");
        $group_list = array();
        if (!$new_group_flg) {
            $group_list = IohGroupDBI::getGroup();
            if ($controller->isError($group_list)) {
                $group_list->setPos(__FILE__, __LINE__);
                return $group_list;
            }
        }
        $request->setAttribute("group_list", $group_list);
        return VIEW_DONE;
    }

    private function _doCreateExecute(Controller $controller, User $user, Request $request)
    {
        $new_group_flg = $request->getAttribute("new_group_flg");
        return VIEW_DONE;
    }
}
?>