<?php

/**
 *
 * @author Kinsama
 * @version 2018-08-24
 */
class IohPubg_WeaponListAction extends ActionBase
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
        $w_type = null;
        $weapon_type_list = IohPubgEntity::getWeaponTypeList();
        if ($request->hasParameter("w_type")) {
            $w_type = $request->getParameter("w_type");
            if (!Validate::checkAcceptParam($w_type, array_keys($weapon_type_list))) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "参数w_type值被窜改");
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
        }
        $request->setAttribute("w_type", $w_type);
        $request->setAttribute("weapon_type_list", $weapon_type_list);
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
        $w_type = $request->getAttribute("w_type");
        $weapon_list = IohPubgDBI::selectWeaponByType($w_type);
        if ($controller->isError($weapon_list)) {
            $weapon_list->setPos(__FILE__, __LINE__);
            return $weapon_list;
        }
        $request->setAttribute("weapon_list", $weapon_list);
        return VIEW_DONE;
    }
}
?>