<?php

/**
 * JavaBean生成
 * @author Kinsama
 * @version 2018-03-01
 */
class IohTool_JavaBeanAction
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->isError()) {
            $ret = $this->_doErrorExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("do_upload")) {
            $ret = $this->_doUploadExecute($controller, $user, $request);
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
        $option_list = $this->_getOptionList();
        $json_code = json_encode(array(
            "index" => 23,
            "name" => "nananana",
            "gender" => true,
            "animalsFinds" => array(
                "dogs" => array(
                    array(
                        "name" => "nana",
                        "age" => 0,
                        "variety" => "Goldeb Retriever",
                        "gender" => "f"
                    )
                ),
                "cat" => array(
                    "name" => "nana",
                    "age" => 3,
                    "variety" => "Siamese Kitten",
                    "gender" => array(
                        "kind" => true
                    )
                )
            ),
            "items" => array(
                array(
                    "name" => "nanananana",
                    "price" => 1500,
                    "insurance" => false
                )
            )
        ));
        $modifier_list = $option_list["modifier"];
        $datatype_list = $option_list["datatype"];
        $package_name = "";
        $class_name = "";
        $subclass_modifier = "1";
        if ($request->hasParameter("do_upload")) {
            $package_name = $request->getParameter("package_name");
            $class_name = $request->getParameter("class_name");
            $subclass_modifier = $request->getParameter("subclass_modifier");
            $json_code = $request->getParameter("json_code");
            if (!Validate::checkNotEmpty($package_name)) {
                $request->setError("package_name", "package 不能为空");
            }
            if (!Validate::checkNotEmpty($class_name)) {
                $request->setError("class_name", "文件名 不能为空");
            }
            if (!Validate::checkAcceptParam($subclass_modifier, array_keys($modifier_list))) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "内部类修饰符");
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            if (!Validate::checkNotEmpty($json_code)) {
                $request->setError("json_code", "Json内容 不能为空");
            } elseif (is_null(json_decode($json_code))) {
                $request->setError("json_code", "Json内容 无效");
            }
        }
        $request->setAttribute("modifier_list", $modifier_list);
        $request->setAttribute("datatype_list", $datatype_list);
        $request->setAttribute("package_name", $package_name);
        $request->setAttribute("class_name", $class_name);
        $request->setAttribute("subclass_modifier", $subclass_modifier);
        $request->setAttribute("json_code", $json_code);
        return VIEW_DONE;
    }

    /**
     * 执行默认程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        if ($user->hasVariable("java_bean_rollback") && $request->hasParameter("rollback")) {
            $java_bean_rollback = $user->getVariable("java_bean_rollback");
            $request->setAttribute("package_name", $java_bean_rollback["package_name"]);
            $request->setAttribute("class_name", $java_bean_rollback["class_name"]);
            $request->setAttribute("subclass_modifier", $java_bean_rollback["subclass_modifier"]);
            $request->setAttribute("json_code", $java_bean_rollback["json_code"]);
        }
        return VIEW_DONE;
    }

    /**
     * 执行报错程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    private function _doErrorExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }

    /**
     * 执行报错程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    private function _doUploadExecute(Controller $controller, User $user, Request $request)
    {
        $json_array = json_decode($request->getAttribute("json_code"), true);
        require_once SRC_PATH . "/menu/Tool/lib/IohTool_JavaBeanAnalysis.php";
        $class_object = new IohTool_JavaBeanAnalysis();
        $package_name = $request->getAttribute("package_name");
        $class_name = $request->getAttribute("class_name");
        $modifier_list = $request->getAttribute("modifier_list");
        $datatype_list = $request->getAttribute("datatype_list");
        $subclass_modifier = $request->getAttribute("subclass_modifier");
        $this->_doJsonArrayAnalysis($json_array, $class_name, $class_object);
        $tmp_class_list = $class_object->getClassList();
        $class_name_list = array();
        $class_object_list = array();
        $class_list_index = 0;
        foreach ($tmp_class_list as $class_idx => $class_itm) {
            $class_name_list[$class_list_index] = $class_idx;
            $class_object_list[$class_list_index] = $class_itm;
            $class_list_index++;
        }
        foreach ($class_object_list as $class_list_index => $class_list_itm) {
            $class_list = array(
                "class_type" => false,
                "class_property" => array()
            );
            if ($class_list_index == 0) {
                $class_list["class_type"] = true;
            }
            $prop_info = $class_list_itm->getClassProperty();
            foreach ($prop_info as $prop_itm) {
                $property_list = array(
                    "property_name" => "",
                    "property_datatype" => 0,
                    "property_datatype_class" => 0,
                    "property_list_flg" => false
                );
                $property_list["property_name"] = $prop_itm->getPropertyName();
                $data_type = $prop_itm->getPropertyDatatype();
                if (is_numeric($data_type)) {
                    $property_list["property_datatype"] = $data_type;
                } else {
                    $property_list["property_datatype_class"] = $this->_getClassNameIndex($data_type, $class_name_list);
                }
                if ($prop_itm->getPropertyIsList()) {
                    $property_list["property_list_flg"] = true;
                }
                $class_list["class_property"][] = $property_list;
            }
            $class_object_list[$class_list_index] = $class_list;
        }
        foreach ($class_name_list as $class_name_idx => $class_name_itm) {
            if ($class_name_idx != 0) {
                $class_name_itm = $this->_adjustClassName($class_name_itm);
            }
            $class_name_list[$class_name_idx] = $class_name_itm;
        }
        $result = array(
            "java_bean_data" => array(
                "class_name_list" => $class_name_list,
                "class_object_list" => $class_object_list,
                "datatype_list" => $datatype_list,
                "subclass_modifier" => $modifier_list[$subclass_modifier]
            )
        );
        $user->setVariables($result);
        $result = array(
            "java_bean_rollback" => array(
                "package_name" => $package_name,
                "class_name" => $class_name,
                "subclass_modifier" => $subclass_modifier,
                "json_code" => $request->getAttribute("json_code")
            )
        );
        $user->setVariables($result);
        $url = "./tool/java_bean_cnf/";
        if ($request->current_level) {
            $url = "./?menu=tool&act=java_bean_cnf";
        }
        $controller->redirect($url);
        return VIEW_DONE;
    }

    /**
     * 获取选项列表
     * @return array
     */
    private function _getOptionList()
    {
        return array(
            "modifier" => array(
                "1" => "public",
                "2" => "protected",
                "3" => "private"
            ),
            "datatype" => array(
                "1" => "String",
                "2" => "int",
                "3" => "boolean",
                "4" => "Date"
            )
        );
    }

    /**
     * Json数组解析
     * @param array $json_array Json数组
     * @param string $class_name 类名称
     * @param object $class_object Json数组解析对象类
     */
    private function _doJsonArrayAnalysis($json_array, $class_name, IohTool_JavaBeanAnalysis $class_object)
    {
        $class_object->setClass($class_name, false);
        foreach ($json_array as $json_idx => $json_itm) {
            $list_flg = false;
            $property_datatype = "1";
            $oppo_arr = null;
            if (is_array($json_itm)) {
                $oppo_arr = $json_itm;
                if (isset($oppo_arr[0])) {
                    $oppo_arr = $oppo_arr[0];
                    $list_flg = true;
                }
                $property_datatype = $json_idx;
            } else {
                if (is_bool($json_itm)) {
                    $property_datatype = "3";
                } elseif (is_int($json_itm)) {
                    $property_datatype = "2";
                }
            }
            $class_object->setClassProperty($class_name, $json_idx, $property_datatype, $list_flg);
            if (!is_null($oppo_arr) && !$class_object->hasClass($json_idx)) {
                $this->_doJsonArrayAnalysis($oppo_arr, $json_idx, $class_object);
            }
        }
    }

    private function _getClassNameIndex($handle, $find_list)
    {
        foreach ($find_list as $idx => $itm) {
            if ($handle == $itm) {
                return $idx;
            }
        }
        return 0;
    }

    private function _adjustClassName($class_name_itm)
    {
        $class_name_itm = ucfirst($class_name_itm);
        $class_name_itm = Utility::getParamFormatName($class_name_itm);
        $class_name_itm = explode("_", $class_name_itm);
        foreach ($class_name_itm as $idx => $itm) {
            $class_name_itm[$idx] = rtrim($itm, "s");
        }
        $class_name_itm = implode("_", $class_name_itm);
        $class_name_itm = Utility::getFileFormatName($class_name_itm);
        return $class_name_itm;
    }
}
?>