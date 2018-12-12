<?php

/**
 * 首页画面
 * @author Kinsama
 * @version 2018-11-14
 */
class IohMrzh_AddItemAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("do_back")) {
            $ret = $this->_doBackExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("ajax")) {
            $ret = $this->_doAjaxExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("add_done")) {
            $ret = $this->_doInputExecute($controller, $user, $request);
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
        $item_info = array();
        $item_info["item_id"] = "0";
        $item_info["item_name"] = "";
        $item_info["item_quality"] = "0";
        $item_info["item_class"] = "1";
        $item_info["item_type"] = "1";
        $item_info["item_food_type"] = "0";
        $item_info["item_made_num"] = "1";
        $item_info["item_base_flg"] = "0";
        $item_info["item_description"] = "";
        if ($user->hasVariable("MRZH_QUICK_INPUT")) {
            $session_info = $user->getVariable("MRZH_QUICK_INPUT");
            $item_info["item_class"] = $session_info["item_class"];
            $item_info["item_type"] = $session_info["item_type"];
            $user->freeVariable("MRZH_QUICK_INPUT");
        }
        if ($request->hasParameter("item_id")) {
            $item_id = $request->getParameter("item_id");
            $item_info = IohMrzhDBI::selectItem($item_id);
            if ($controller->isError($item_info)) {
                $item_info->setPos(__FILE__, __LINE__);
                return $item_info;
            }
            if (empty($item_info)) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $item_info = $item_info[$item_id];
        }
        $color_list = IohMrzhEntity::getColorList();
        $name_list = IohMrzhEntity::getNameList();
        $request->setAttribute("quality_color_list", $color_list["item_quality"]);
        $request->setAttribute("quality_name_list", $name_list["item_quality"]);
        $request->setAttribute("class_name_list", $name_list["item_class"]);
        $request->setAttribute("type_name_list", $name_list["item_type"][$item_info["item_class"]]);
        $request->setAttribute("food_type_name_list", $name_list["item_food_type"]);
        $request->setAttribute("item_info", $item_info);
        return VIEW_NONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $item_info = $request->getAttribute("item_info");
        $add_item_index = 0;
        $material_list = array();
        if ($item_info["item_id"] != "0") {
            $material_item_list = IohMrzhDBI::selectItemMaterial($item_info["item_id"]);
            if ($controller->isError($material_item_list)) {
                $material_item_list->setPos(__FILE__, __LINE__);
                return $material_item_list;
            }
            if (isset($material_item_list[$item_info["item_id"]])) {
                foreach ($material_item_list[$item_info["item_id"]] as $material_item_id => $material_quantity) {
                    $option_content = file_get_contents(SYSTEM_APP_HOST . "?menu=mrzh&act=add_item&ajax=1&base_item=" . $material_item_id);
                    $item_one = array();
                    $item_one["material_item_id"] = $material_item_id;
                    $item_one["material_quantity"] = $material_quantity;
                    $item_one["option_content"] = $option_content;
                    $material_list[] = $item_one;
                }
                $add_item_index = count($material_list);
            }
        }
        $request->setAttribute("add_item_index", $add_item_index);
        $request->setAttribute("material_list", $material_list);
        return VIEW_DONE;
    }

    private function _doAjaxExecute(Controller $controller, User $user, Request $request)
    {
        $name_list = IohMrzhEntity::getNameList();
        if ($request->hasParameter("item_class")) {
            $item_class = $request->getParameter("item_class");
            $type_info = $name_list["item_type"][$item_class];
            header("Content-type:text/plain; charset=utf-8");
            foreach ($type_info as $type_key => $type_name) {
                printf('<option value="%s">%s</option>', $type_key, $type_name);
            }
            exit();
        } elseif ($request->hasParameter("base_item")) {
            $base_item_id = $request->getParameter("base_item");
            $base_item_list = IohMrzhDBI::selectBaseItem();
            if ($controller->isError($base_item_list)) {
                $base_item_list->setPos(__FILE__, __LINE__);
                return $base_item_list;
            }
            $trans_base_item_list = array();
            foreach ($base_item_list as $item_id => $item_info) {
                $list_key = $item_info["item_class"] . "_" . $item_info["item_type"];
                if (!isset($trans_base_item_list[$list_key])) {
                    $trans_base_item_list[$list_key] = array();
                }
                $trans_base_item_list[$list_key][$item_id] = $item_info["item_name"];
            }
            header("Content-type:text/plain; charset=utf-8");
            foreach ($trans_base_item_list as $class_type_key => $item_list) {
                $class_type_arr = explode("_", $class_type_key);
                printf('<optgroup label="%s">', $name_list["item_type"][$class_type_arr[0]][$class_type_arr[1]]);
                foreach ($item_list as $item_id => $item_name) {
                    $is_selected = "";
                    if ($item_id == $base_item_id) {
                        $is_selected = " selected";
                    }
                    printf('<option value="%s"%s>%s</option>', $item_id, $is_selected, $item_name);
                }
                echo "</optgroup>";
            }
            exit();
        }
        return VIEW_NONE;
    }

    private function _doInputExecute(Controller $controller, User $user, Request $request)
    {
        $item_info = $request->getParameter("item_info");
        $item_id = $item_info["item_id"];
        if ($item_id == "0") {
            $base_flg = false;
            if ($item_info["item_class"] != "1") {
                $base_flg = true;
            }
            $item_id = IohMrzhDBI::selectLastId($base_flg);
            if ($controller->isError($item_id)) {
                $item_id->setPos(__FILE__, __LINE__);
                return $item_id;
            }
            $item_id++;
            $item_info["item_id"] = $item_id;
        } else {
            unset($item_info["item_id"]);
        }
        if (!isset($item_info["item_base_flg"])) {
            $item_info["item_base_flg"] = "0";
        }
        if (!($item_info["item_class"] == "1" && $item_info["item_type"] == "5")) {
            $item_info["item_food_type"] = "0";
        }
        $add_info = array();
        if ($request->hasParameter("add_info")) {
            $getting_add_info = $request->getParameter("add_info");
            $base_item_list = IohMrzhDBI::selectBaseItem();
            if ($controller->isError($base_item_list)) {
                $base_item_list->setPos(__FILE__, __LINE__);
                return $base_item_list;
            }
            foreach ($getting_add_info as $getting_add_item) {
                $opt = array(
                    "min" => 0
                );
                if (isset($getting_add_item["material_item_id"]) && isset($base_item_list[$getting_add_item["material_item_id"]]) && isset($getting_add_item["material_quantity"]) && Validate::checkDecimalNumber($getting_add_item["material_quantity"], $opt)) {
                    $add_info_one = array();
                    $add_info_one["item_id"] = $item_id;
                    $add_info_one["material_item_id"] = $getting_add_item["material_item_id"];
                    $add_info_one["material_quantity"] = $getting_add_item["material_quantity"];
                    $add_info[] = $add_info_one;
                }
            }
        }
        $dbi = Database::getInstance();
        $dbi->begin();
        if (isset($item_info["item_id"])) {
            $insert_res = IohMrzhDBI::insertItem($item_info);
            if ($controller->isError($insert_res)) {
                $insert_res->setPos(__FILE__, __LINE__);
                $dbi->rollback();
                return $insert_res;
            }
        } else {
            $update_res = IohMrzhDBI::updateItem($item_id, $item_info);
            if ($controller->isError($update_res)) {
                $update_res->setPos(__FILE__, __LINE__);
                $dbi->rollback();
                return $update_res;
            }
        }
        $unset_res = IohMrzhDBI::unsetItemFormula($item_id);
        if ($controller->isError($unset_res)) {
            $unset_res->setPos(__FILE__, __LINE__);
            $dbi->rollback();
            return $unset_res;
        }
        if (!empty($add_info)) {
            foreach ($add_info as $add_insert_data) {
                $add_insert_res = IohMrzhDBI::insertItemFormula($add_insert_data);
                if ($controller->isError($add_insert_res)) {
                    $add_insert_res->setPos(__FILE__, __LINE__);
                    $dbi->rollback();
                    return $add_insert_res;
                }
            }
        }
        $dbi->commit();
        if (isset($item_info["item_id"])) {
            $user->setVariable("MRZH_QUICK_INPUT", array(
                "item_class" => $item_info["item_class"],
                "item_type" => $item_info["item_type"]
            ));
            $controller->redirect("./?menu=mrzh&act=add_item");
        } else {
            $controller->redirect(sprintf("./?menu=mrzh&act=item_list&item_class=%s&item_type=%s", $item_info["item_class"], $item_info["item_type"]));
        }
        return VIEW_NONE;
    }

    private function _doBackExecute(Controller $controller, User $user, Request $request)
    {
        $item_info = $request->getParameter("item_info");
        $controller->redirect(sprintf("./?menu=mrzh&act=item_list&item_class=%s&item_type=%s", $item_info["item_class"], $item_info["item_type"]));
        return VIEW_NONE;
    }
}
?>