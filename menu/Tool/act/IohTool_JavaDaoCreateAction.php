<?php

/**
 * iohgame-java-batch DAO生成
 * @author Kinsama
 * @version 2019-01-04
 */
class IohTool_JavaDaoCreateAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("select_list")) {
            $ret = $this->_doSelectListExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("do_submit")) {
            $ret = $this->_doSubmitExecute($controller, $user, $request);
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
        if ($request->hasParameter("select_list")) {
            return VIEW_NONE;
        }
        $file_info = array(
            "package_name" => "",
            "file_name" => ""
        );
        if ($request->hasParameter("file_info")) {
            $file_info_tmp = $request->getParameter("file_info");
            if (isset($file_info_tmp["package_name"])) {
                $file_info["package_name"] = $file_info_tmp["package_name"];
            }
            if (isset($file_info_tmp["file_name"])) {
                $file_info["file_name"] = $file_info_tmp["file_name"];
            }
        }
        $request->setAttribute("file_info", $file_info);
        $enum_info = array();
        if ($request->hasParameter("enum_info")) {
            $enum_info_tmp = $request->getParameter("column_info");
            if (!empty($enum_info_tmp)) {
                foreach ($enum_info_tmp as $enum_item) {
                    if (isset($enum_item["enum_name"]) && $enum_item["enum_name"] != "") {
                        $enum_info[$enum_item["enum_name"]] = array();
                        if (isset($enum_item["enum_column"]) && !empty($enum_item["enum_column"])) {
                            foreach ($enum_item["enum_column"] as $enum_column_item) {
                                if (isset($enum_column_item["enum_column_name"]) && isset($enum_column_item["enum_column_value"])) {
                                    $enum_column_array = array();
                                    $enum_column_array["name"] = $enum_column_item["enum_column_name"];
                                    $enum_column_array["value"] = $enum_column_item["enum_column_value"];
                                    $enum_info[$enum_item["enum_name"]][] = $enum_column_array;
                                }
                            }
                        }
                    }
                }
            }
        }
        if (!$user->hasVariable("ENUM_INFO")) {
            $user->setVariable("ENUM_INFO", array());
        }
        if ($request->hasParameter("do_apply")) {
            $user->setVariable("ENUM_INFO", $enum_info);
        }
        $request->setAttribute("enum_info", $enum_info);
        $column_info = array();
        if ($request->hasParameter("column_info")) {
            $column_info_tmp = $request->getParameter("column_info");
            if (!empty($column_info_tmp)) {
                foreach ($column_info_tmp as $column_item) {
                    if (isset($column_item["data_type"]) && isset($column_item["column_name"])) {
                        $item_array = array();
                        $item_array["data_type"] = $column_item["data_type"];
                        $item_array["column_name"] = $column_item["column_name"];
                        $item_array["data_type_select_content"] = file_get_contents(
                            SYSTEM_APP_HOST . "?menu=" . $request->current_menu .
                            "&act=" . $request->current_act .
                            "&select_list=" . $column_item["data_type"]
                        );
                        $column_info[] = $item_array;
                    }
                }
            }
        }
        $request->setAttribute("column_info", $column_info);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $column_info = $request->getAttribute("column_info");
        $enum_info = $request->getAttribute("enum_info");
        $column_index = count($column_info);
        $enum_index = count($enum_info);
        $enum_column_index = array();
        if ($enum_index > 0) {
            foreach ($enum_info as $enum_name => $enum_column_info) {
                $enum_column_index[] = count($enum_column_info);
            }
        }
$enum_column_index[0] = 1;
$enum_column_index[1] = 5;
        $request->setAttribute("column_index", $column_index);
        $request->setAttribute("enum_index", $enum_index +1);
        $request->setAttribute("enum_column_index", $enum_column_index);
//Utility::testVariable($request->getAttributes());
        return VIEW_DONE;
    }

    private function _doSubmitExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_NONE;
    }

    private function _doSelectListExecute(Controller $controller, User $user, Request $request)
    {
        $selected_option = $request->getParameter("select_list");
        $option_list_str = "<option value=\"0\">未选择</option><optgroup label=\"基本数据类型\">";
        $base_data_type_list = $this->_getBaseDataTypeList();
        foreach ($base_data_type_list as $base_data_type) {
            $option_list_str .= "<option value =\"" . $base_data_type . "\"";
            if ($selected_option == $base_data_type) {
                $option_list_str .= " selected";
            }
            $option_list_str .= ">" . $base_data_type . "</option>";
        }
        $option_list_str .= "</optgroup>";
        $enum_info = $user->getVariable("ENUM_INFO");
        if (count($enum_info) > 0) {
            $option_list_str .= "<optgroup label=\"自定义枚举类型\">";
            foreach ($enum_info as $enum_name => $enum_tmp) {
                $option_list_str .= "<option value =\"" . $enum_name . "\"";
                if ($selected_option == $enum_name) {
                    $option_list_str .= " selected";
                }
                $option_list_str .= ">" . $base_data_type . "</option>";
            }
            $option_list_str .= "</optgroup>";
        }
        header("Content-type:text/plain; charset=utf-8");
        echo $option_list_str;
        exit;
    }

    private function _getBaseDataTypeList()
    {
        return array(
            "Integer",
            "String",
            "Boolean",
            "Date",
            "Float"
        );
    }
}
?>