<?php

/**
 * 首页画面
 * @author Kinsama
 * @version 2018-11-16
 */
class IohMrzh_ItemInfoAction extends ActionBase
{

    private $_material_list = array();

    private $_base_item_list = array();

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("ajax")) {
            $ret = $this->_doAjaxExecute($controller, $user, $request);
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
        if (!$request->hasParameter("item_id")) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $item_id = $request->getParameter("item_id");
        $item_info = IohMrzhDBI::selectItem($item_id);
        if ($controller->isError($item_info)) {
            $item_info->setPos(__FILE__, __LINE__);
            return $item_info;
        }
        if (!isset($item_info[$item_id])) {
            $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $item_info = $item_info[$item_id];
        $item_expect = 1;
        $opt = array(
            "min" => 0
        );
        if ($request->hasParameter("item_expect") && Validate::checkDecimalNumber($request->getParameter("item_expect"), $opt)) {
            $item_expect = $request->getParameter("item_expect");
        }
        $item_times = ceil($item_expect / $item_info["item_made_num"]);
        $base_item_list = IohMrzhDBI::selectBaseItem();
        if ($controller->isError($base_item_list)) {
            $base_item_list->setPos(__FILE__, __LINE__);
            return $base_item_list;
        }
        foreach ($base_item_list as $base_item_info) {
            if ($base_item_info["item_class"] == "1") {
                $this->_base_item_list[$base_item_info["item_id"]] = $base_item_info["item_name"];
            }
        }
        $this->_getMaterial($item_info["item_id"], $item_times, true);
        $request->setAttribute("item_info", $item_info);
        $request->setAttribute("item_material_list", $this->_material_list);
        $request->setAttribute("item_expect", $item_expect);
        $request->setAttribute("item_actual", $item_times * $item_info["item_made_num"]);
        if ($request->hasParameter("ajax")) {
            return VIEW_DONE;
        }
        // 画面用数据处理
        $total_item_info = IohMrzhDBI::selectTotalItem(true);
        if ($controller->isError($total_item_info)) {
            $total_item_info->setPos(__FILE__, __LINE__);
            return $total_item_info;
        }
        $item_material_info = IohMrzhDBI::selectItemMaterial($item_id);
        if ($controller->isError($item_material_info)) {
            $item_material_info->setPos(__FILE__, __LINE__);
            return $item_material_info;
        }
        $madeby_material_info = IohMrzhDBI::selectItemMaterialMadeByItem($item_id);
        if ($controller->isError($madeby_material_info)) {
            $madeby_material_info->setPos(__FILE__, __LINE__);
            return $madeby_material_info;
        }
        $color_list = IohMrzhEntity::getColorList();
        $request->setAttribute("quality_color_list", $color_list["item_quality"]);
        $request->setAttribute("item_id", $item_id);
        $request->setAttribute("item_material_info", $item_material_info);
        $request->setAttribute("madeby_material_info", $madeby_material_info);
        $request->setAttribute("total_item_info", $total_item_info);
        return VIEW_NONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }

    private function _doAjaxExecute(Controller $controller, User $user, Request $request)
    {
        $item_info = $request->getAttribute("item_info");
        $item_material_list = $request->getAttribute("item_material_list");
        ksort($item_material_list);
        foreach ($item_material_list as $item_key => $item_value) {
            $item_material_list[$item_key] = (int) $item_value;
        }
        $result = array();
        $result["id"] = (int) $item_info["item_id"];
        $result["expect"] = (int) $request->getAttribute("item_expect");
        $result["actual"] = (int) $request->getAttribute("item_actual");
        $result["list"] = $item_material_list;
        echo json_encode($result);
        exit();
        return VIEW_NONE;
    }

    private function _getMaterial($item_id, $item_times, $add_flg = false)
    {
        $item_material = IohMrzhDBI::selectItemMaterial($item_id);
        if (Error::isError($item_material)) {
            $item_material->setPos(__FILE__, __LINE__);
            return $item_material;
        }
        if (isset($item_material[$item_id])) {
            foreach ($item_material[$item_id] as $tmp_item_id => $tmp_item_num) {
                if (isset($this->_base_item_list[$tmp_item_id])) {
                    $this->_addItem($tmp_item_id, $item_times * $tmp_item_num);
                } else {
                    $this->_getMaterial($tmp_item_id, $item_times * $tmp_item_num);
                }
            }
        } else {
            if ($add_flg) {
                $this->_addItem($item_id, $item_times);
            }
        }
    }

    private function _addItem($item_id, $item_num)
    {
        if (!isset($this->_material_list[$item_id])) {
            $this->_material_list[$item_id] = 0;
        }
        $this->_material_list[$item_id] += $item_num;
    }
}
?>