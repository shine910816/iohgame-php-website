<?php

/**
 *
 * @author Kinsama
 * @version 2018-08-26
 */
class IohPubg_PartListAction extends ActionBase
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
        $p_type = null;
        $part_type_list = IohPubgEntity::getPartTypeList();
        if ($request->hasParameter("p_type")) {
            $p_type = $request->getParameter("p_type");
            if (!Validate::checkAcceptParam($p_type, array_keys($part_type_list))) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "参数p_type值被窜改");
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
        }
        $request->setAttribute("p_type", $p_type);
        $request->setAttribute("part_type_list", $part_type_list);
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
        $p_type = $request->getAttribute("p_type");
        $part_list = IohPubgDBI::selectPartByType($p_type);
        if ($controller->isError($part_list)) {
            $part_list->setPos(__FILE__, __LINE__);
            return $part_list;
        }
        $request->setAttribute("part_list", $part_list);
        return VIEW_DONE;
    }
}
?>