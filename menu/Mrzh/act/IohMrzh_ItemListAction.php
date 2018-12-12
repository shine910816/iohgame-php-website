<?php

/**
 * 首页画面
 * @author Kinsama
 * @version 2018-11-15
 */
class IohMrzh_ItemListAction extends ActionBase
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
        $item_class = "1";
        $item_type = "1";
        $name_list = IohMrzhEntity::getNameList();
        if ($request->hasParameter("item_class")) {
            $item_class = $request->getParameter("item_class");
        }
        if (!isset($name_list["item_class"][$item_class])) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        if ($request->hasParameter("item_type")) {
            $item_type = $request->getParameter("item_type");
        }
        if (!isset($name_list["item_type"][$item_class][$item_type])) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $color_list = IohMrzhEntity::getColorList();
        $request->setAttribute("item_class", $item_class);
        $request->setAttribute("item_type", $item_type);
        $request->setAttribute("class_name_list", $name_list["item_class"]);
        $request->setAttribute("type_name_list", $name_list["item_type"]);
        $request->setAttribute("quality_color_list", $color_list["item_quality"]);
        $request->setAttribute("subpanel_file", SRC_PATH . "/menu/Mrzh/tpl/IohMrzh_ItemListMobileView_ItemClassTypePage.tpl");
        return VIEW_NONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $item_class = $request->getAttribute("item_class");
        $item_type = $request->getAttribute("item_type");
        $item_info_list = IohMrzhDBI::selectDisplayItem($item_class, $item_type);
        if ($controller->isError($item_info_list)) {
            $item_info_list->setPos(__FILE__, __LINE__);
            return $item_info_list;
        }
        $request->setAttribute("item_info_list", $item_info_list);
        return VIEW_DONE;
    }
}
?>