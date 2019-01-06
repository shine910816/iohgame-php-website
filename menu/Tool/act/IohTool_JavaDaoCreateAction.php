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
            $enum_info_tmp = $request->getParameter("enum_info");
            if (!empty($enum_info_tmp)) {
                foreach ($enum_info_tmp as $enum_item) {
                    if (isset($enum_item["enum_name"]) && $enum_item["enum_name"] != "") {
                        $enum_info[$enum_item["enum_name"]] = array();
                        if (isset($enum_item["enum_column"]) && !empty($enum_item["enum_column"])) {
                            foreach ($enum_item["enum_column"] as $enum_column_item) {
                                if (isset($enum_column_item["enum_column_name"]) && isset($enum_column_item["enum_column_value"]) &&
                                    $enum_column_item["enum_column_name"] != "" && $enum_column_item["enum_column_value"] != "") {
                                    $enum_column_array = array();
                                    $enum_column_array["name"] = strtoupper($enum_column_item["enum_column_name"]);
                                    $enum_column_array["value"] = $enum_column_item["enum_column_value"];
                                    $enum_info[$enum_item["enum_name"]][] = $enum_column_array;
                                }
                            }
                        }
                    }
                }
            }
        }
        $request->setAttribute("enum_info", $enum_info);
        $column_info = array();
        if ($request->hasParameter("column_info")) {
            $column_info_tmp = $request->getParameter("column_info");
            if (!empty($column_info_tmp)) {
                foreach ($column_info_tmp as $column_item) {
                    if (isset($column_item["data_type"]) && isset($column_item["column_name"]) && $column_item["column_name"] != "") {
                        $item_array = array();
                        $item_array["data_type"] = $column_item["data_type"];
                        $item_array["column_name"] = $column_item["column_name"];
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
        $enum_info = $request->getAttribute("enum_info");
        $enum_index = count($enum_info);
        $enum_column_index = array();
        if ($enum_index > 0) {
            foreach ($enum_info as $enum_name => $enum_column_info) {
                $enum_column_index[] = count($enum_column_info);
            }
        }
        $added_enum_list = implode(",", array_keys($enum_info));
        $column_info = $request->getAttribute("column_info");
        if (!empty($column_info)) {
            foreach ($column_info as $column_idx =>$column_itm) {
                $column_info[$column_idx]["data_type_select_content"] = file_get_contents(
                    SYSTEM_APP_HOST . "?menu=tool&act=java_dao_create" .
                    "&select_list=" . $column_itm["data_type"] .
                    "&added_enum_list=" . $added_enum_list
                );
            }
        }
        $column_index = count($column_info);
        $request->setAttribute("column_info", $column_info);
        $request->setAttribute("column_index", $column_index);
        $request->setAttribute("enum_index", $enum_index);
        $request->setAttribute("enum_column_index", $enum_column_index);
        $request->setAttribute("added_enum_list", $added_enum_list);
        return VIEW_DONE;
    }

    private function _doSubmitExecute(Controller $controller, User $user, Request $request)
    {
        $file_info = $request->getAttribute("file_info");
        $file_name = $file_info["file_name"] . "Dao";
        header("Content-type:java/*; charset=utf-8");
        //header("Content-type:text/plain; charset=utf-8");
        header("Content-Disposition: attachment; filename=" . $file_name . ".java");
        $enum_text = "";
        $enum_info = $request->getAttribute("enum_info");
        if (!empty($enum_info)) {
            foreach ($enum_info as $enum_name => $enum_item) {
                $enum_text .= WINDOWS_FILE_DELIMITER . "    public enum " . $enum_name;
                $enum_text .= " implements Parameters" . WINDOWS_FILE_DELIMITER . "    {" . WINDOWS_FILE_DELIMITER;
                $enum_volumn_list = array();
                if (!empty($enum_item)) {
                    foreach ($enum_item as $enum_volumn_item) {
                        $enum_volumn_list[] = $enum_volumn_item["name"] . "(\"" . $enum_volumn_item["value"] . "\")";
                    }
                }
                if (!empty($enum_volumn_list)) {
                    $enum_text .= "        " . implode("," . WINDOWS_FILE_DELIMITER . WINDOWS_FILE_DELIMITER . "        ", $enum_volumn_list) . ";";
                } else {
                    $enum_text .= "        ;";
                }
                $enum_text .= WINDOWS_FILE_DELIMITER . WINDOWS_FILE_DELIMITER . "        private String m_val;";
                $enum_text .= WINDOWS_FILE_DELIMITER . WINDOWS_FILE_DELIMITER . "        private " . $enum_name;
                $enum_text .= "(String val)" . WINDOWS_FILE_DELIMITER . "        {" . WINDOWS_FILE_DELIMITER;
                $enum_text .= "            m_val = val;" . WINDOWS_FILE_DELIMITER . "        }";
                $enum_text .= WINDOWS_FILE_DELIMITER . WINDOWS_FILE_DELIMITER . "        @Override";
                $enum_text .= WINDOWS_FILE_DELIMITER . "        public String val()" . WINDOWS_FILE_DELIMITER;
                $enum_text .= "        {" . WINDOWS_FILE_DELIMITER . "            return m_val;" . WINDOWS_FILE_DELIMITER;
                $enum_text .= "        }" . WINDOWS_FILE_DELIMITER . "" . WINDOWS_FILE_DELIMITER . "        @Override";
                $enum_text .= WINDOWS_FILE_DELIMITER . "        public Parameters unknown()" . WINDOWS_FILE_DELIMITER;
                $enum_text .= "        {" . WINDOWS_FILE_DELIMITER . "            return null;";
                $enum_text .= WINDOWS_FILE_DELIMITER . "        }" . WINDOWS_FILE_DELIMITER;
                $enum_text .= "    }" . WINDOWS_FILE_DELIMITER;
            }
        }
        $column_text = "";
        $column_info = $request->getAttribute("column_info");
        $date_import_flg = false;
        foreach ($column_info as $column_item) {
            $column_text .= "    private final " . $column_item["data_type"] . " m_" . $column_item["column_name"] . ";" . WINDOWS_FILE_DELIMITER;
            if (!$date_import_flg && $column_item["data_type"] == "Date") {
                $date_import_flg = true;
            }
        }
        $column_text .= WINDOWS_FILE_DELIMITER . "    private " . $file_name . "(ContainerBuilder builder)" . WINDOWS_FILE_DELIMITER;
        $column_text .= "    {" . WINDOWS_FILE_DELIMITER;
        foreach ($column_info as $column_item) {
            $column_text .= "        m_" . $column_item["column_name"] . " = builder.m_" . $column_item["column_name"] . ";" . WINDOWS_FILE_DELIMITER;
        }
        $column_text .= "    }" . WINDOWS_FILE_DELIMITER;
        foreach ($column_info as $column_item) {
            $column_text .= WINDOWS_FILE_DELIMITER;
            $column_text .= "    public " . $column_item["data_type"] . " " . $column_item["column_name"] . "()" . WINDOWS_FILE_DELIMITER;
            $column_text .= "    {" . WINDOWS_FILE_DELIMITER;
            $column_text .= "        return m_" . $column_item["column_name"] . ";" . WINDOWS_FILE_DELIMITER;
            $column_text .= "    }" . WINDOWS_FILE_DELIMITER;
        }
        $column_text .= WINDOWS_FILE_DELIMITER . "    public static class ContainerBuilder implements Builder<" . $file_name . ">" . WINDOWS_FILE_DELIMITER;
        $column_text .= "    {" . WINDOWS_FILE_DELIMITER;
        foreach ($column_info as $column_item) {
            $column_text .= "        private " . $column_item["data_type"] . " m_" . $column_item["column_name"] . ";" . WINDOWS_FILE_DELIMITER;
        }
        foreach ($column_info as $column_item) {
            $column_text .= WINDOWS_FILE_DELIMITER . "        public ContainerBuilder " . $column_item["column_name"];
            $column_text .= "(" .$column_item["data_type"] . " " . $column_item["column_name"] . ")" . WINDOWS_FILE_DELIMITER;
            $column_text .= "        {" . WINDOWS_FILE_DELIMITER;
            $column_text .= "            m_" . $column_item["column_name"] . " = " . $column_item["column_name"] . ";" . WINDOWS_FILE_DELIMITER;
            $column_text .= "            return this;" . WINDOWS_FILE_DELIMITER;
            $column_text .= "        }" . WINDOWS_FILE_DELIMITER;
        }
        $column_text .= WINDOWS_FILE_DELIMITER . "        @Override" . WINDOWS_FILE_DELIMITER;
        $column_text .= "        public " . $file_name . " build()" . WINDOWS_FILE_DELIMITER;
        $column_text .= "        {" . WINDOWS_FILE_DELIMITER;
        $column_text .= "            return new " . $file_name . "(this);" . WINDOWS_FILE_DELIMITER;
        $column_text .= "        }" . WINDOWS_FILE_DELIMITER;
        $column_text .= "    }" . WINDOWS_FILE_DELIMITER;
        $file_context = "";
        $file_context .= "package com.iohgame.database.service." . $file_info["package_name"] . ".dao;" . WINDOWS_FILE_DELIMITER . WINDOWS_FILE_DELIMITER;
        if ($date_import_flg) {
            $file_context .= "import java.util.Date;" . WINDOWS_FILE_DELIMITER . WINDOWS_FILE_DELIMITER;
        }
        $file_context .= "import com.iohgame.framework.property.parameters.Builder;" . WINDOWS_FILE_DELIMITER;
        $file_context .= "import com.iohgame.framework.property.parameters.Dao;" . WINDOWS_FILE_DELIMITER;
        $file_context .= "import com.iohgame.framework.property.parameters.Parameters;" . WINDOWS_FILE_DELIMITER . WINDOWS_FILE_DELIMITER;
        $file_context .= "public class " . $file_name . " implements Dao" . WINDOWS_FILE_DELIMITER;
        $file_context .= "{" . WINDOWS_FILE_DELIMITER;
        $file_context .= $column_text . $enum_text;
        $file_context .= "}" . WINDOWS_FILE_DELIMITER;
        echo $file_context;
        exit;
    }

    private function _doSelectListExecute(Controller $controller, User $user, Request $request)
    {
        $selected_option = $request->getParameter("select_list");
        $added_enum_list = $request->getParameter("added_enum_list");
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
        if ($added_enum_list != "") {
            $option_list_str .= "<optgroup label=\"自定义枚举类型\">";
            foreach (explode(",", $added_enum_list) as $enum_name) {
                $option_list_str .= "<option value =\"" . $enum_name . "\"";
                if ($selected_option == $enum_name) {
                    $option_list_str .= " selected";
                }
                $option_list_str .= ">" . $enum_name . "</option>";
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