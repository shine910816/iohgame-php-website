<?php

/**
 * 首页画面
 * @author Kinsama
 * @version 2018-11-16
 */
class IohMrzh_ItemCalculatorAction extends ActionBase
{

    private $_material_item_list = array();

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
        } elseif ($request->hasParameter("do_confirm")) {
            $ret = $this->_doConfirmExecute($controller, $user, $request);
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
        $added_item_id_list = array();
        if ($request->hasParameter("add_item")) {
            $add_item_list = explode(",", $request->getParameter("add_item"));
            $item_id_option = array(
                "min" => 1
            );
            $item_quanlity_option = array(
                "min" => 1,
                "max" => 100
            );
            foreach ($add_item_list as $add_item_info) {
                $add_item_info_arr = explode(":", $add_item_info);
                if (Validate::checkDecimalNumber($add_item_info_arr[0], $item_id_option)) {
                    $target_item_quality = 1;
                    if (isset($add_item_info_arr[1]) && Validate::checkDecimalNumber($add_item_info_arr[1], $item_quanlity_option)) {
                        $target_item_quality = (int)$add_item_info_arr[1];
                    }
                    $added_item_id_list[(int)$add_item_info_arr[0]] = $target_item_quality;
                } else {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
            }
        }
        $color_list = IohMrzhEntity::getColorList();
        $request->setAttribute("quality_color_list", $color_list["item_quality"]);
        $request->setAttribute("added_item_id_list", $added_item_id_list);
        return VIEW_NONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $added_item_id_list = $request->getAttribute("added_item_id_list");
        $option_list = array();
        foreach ($added_item_id_list as $target_item_id => $target_item_quantity) {
            $option_result = array();
            $option_result["content"] = file_get_contents(SYSTEM_APP_HOST . "?menu=mrzh&act=item_calculator&ajax=1&item_id=" . $target_item_id);
            $option_result["quantity"] = $target_item_quantity;
            $option_list[] = $option_result;
        }
        $request->setAttribute("option_list", $option_list);
        $request->setAttribute("list_start_index", count($option_list));
        $request->setAttribute("has_result_display", false);
        return VIEW_DONE;
    }

    private function _doConfirmExecute(Controller $controller, User $user, Request $request)
    {
        $item_list = array();
        if ($request->hasParameter("item_list")) {
            $item_list = $request->getParameter("item_list");
        }
        $disp_item_list = array();
        if (!empty($item_list)) {
            $opt = array(
                "min" => 0,
                "max" => 9999
            );
            foreach ($item_list as $material_item_list) {
                if (isset($material_item_list["item_id"]) && isset($material_item_list["quantity"]) && Validate::checkDecimalNumber($material_item_list["item_id"], $opt) && Validate::checkDecimalNumber($material_item_list["quantity"], $opt)) {
                    if (!isset($disp_item_list[$material_item_list["item_id"]])) {
                        $disp_item_list[$material_item_list["item_id"]] = array();
                        $disp_item_list[$material_item_list["item_id"]]["expect"] = 0;
                    }
                    $disp_item_list[$material_item_list["item_id"]]["expect"] += $material_item_list["quantity"];
                }
            }
            ksort($disp_item_list);
        }
        if (!empty($disp_item_list)) {
            foreach ($disp_item_list as $item_id => $item_quantity) {
                $request_url = sprintf(SYSTEM_APP_HOST . "?menu=mrzh&act=item_info&ajax=1&item_id=%s&item_expect=%s", $item_id, $item_quantity["expect"]);
                $json_data = json_decode(file_get_contents($request_url), true);
                if (!is_null($json_data)) {
                    $disp_item_list[$item_id]["actual"] = $json_data["actual"];
                    foreach ($json_data["list"] as $target_item_id => $target_quantity) {
                        if (!isset($this->_material_item_list[$target_item_id])) {
                            $this->_material_item_list[$target_item_id] = 0;
                        }
                        $this->_material_item_list[$target_item_id] += $target_quantity;
                    }
                } else {
                    unset($disp_item_list[$item_id]);
                }
            }
            ksort($this->_material_item_list);
        }
        $item_info = array();
        $added_item_list = "";
        if (!empty($this->_material_item_list)) {
            $request->setAttribute("has_result_display", true);
            $item_id_list = array_keys($this->_material_item_list);
            foreach ($disp_item_list as $disp_item_id => $tmp) {
                $item_id_list[] = $disp_item_id;
                $added_item_list .= "," . $disp_item_id . ":" . $tmp["expect"];
            }
            if (strlen($added_item_list) != 0) {
                $added_item_list = ltrim($added_item_list, ",");
            }
            $item_info = IohMrzhDBI::selectItem($item_id_list);
            if ($controller->isError($item_info)) {
                $item_info->setPos(__FILE__, __LINE__);
                return $item_info;
            }
        } else {
            $controller->redirect("./?menu=mrzh&act=item_calculator");
        }
        $color_list = IohMrzhEntity::getColorList();
        $request->setAttribute("quality_color_list", $color_list["item_quality"]);
        $request->setAttribute("disp_item_list", $disp_item_list);
        $request->setAttribute("material_item_list", $this->_material_item_list);
        $request->setAttribute("item_info", $item_info);
        $request->setAttribute("added_item_list", $added_item_list);
        return VIEW_DONE;
    }

    private function _doAjaxExecute(Controller $controller, User $user, Request $request)
    {
        $selected_item_id = "0";
        if ($request->hasParameter("item_id")) {
            $selected_item_id = $request->getParameter("item_id");
        }
        $total_item_list = IohMrzhDBI::selectTotalItem();
        if ($controller->isError($total_item_list)) {
            $total_item_list->setPos(__FILE__, __LINE__);
            return $total_item_list;
        }
        if (isset($total_item_list["1"])) {
            $tmp_item_list = $total_item_list["1"];
            unset($total_item_list["1"]);
            $total_item_list["1"] = $tmp_item_list;
        }
        $name_list = IohMrzhEntity::getNameList();
        header("Content-type:text/plain; charset=utf-8");
        echo "<option value=\"0\">未选择</option>";
        foreach ($total_item_list as $item_class => $type_key_item_info) {
            foreach ($type_key_item_info as $item_type => $id_key_item_info) {
                echo "<optgroup label=\"" . $name_list["item_type"][$item_class][$item_type] . " - " . $name_list["item_class"][$item_class] . "\">";
                foreach ($id_key_item_info as $item_info) {
                    $is_selected = "";
                    if ($item_info["item_id"] == $selected_item_id) {
                        $is_selected = " selected";
                    }
                    printf("<option value=\"%s\"%s>%s</option>", $item_info["item_id"], $is_selected, $item_info["item_name"]);
                }
                echo "</optgroup>";
            }
        }
        exit();
        return VIEW_NONE;
    }
}
?>