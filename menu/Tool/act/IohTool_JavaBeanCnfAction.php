<?php

/**
 * JavaBean生成确认
 * @author Kinsama
 * @version 2018-03-05
 */
class IohTool_JavaBeanCnfAction
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("do_rollback")) {
            $ret = $this->_doRollbackExecute($controller, $user, $request);
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
        if (!$user->hasVariable("java_bean_data")) {
            $err = $controller->raiseError(ERROR_CODE_OUTSIDE_FALSIFY);
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $java_bean_data = $user->getVariable("java_bean_data");
        $java_bean_info = $user->getVariable("java_bean_rollback");
        $request->setAttribute("class_name_list", $java_bean_data["class_name_list"]);
        $request->setAttribute("class_object_list", $java_bean_data["class_object_list"]);
        $request->setAttribute("datatype_list", $java_bean_data["datatype_list"]);
        $request->setAttribute("subclass_modifier", $java_bean_data["subclass_modifier"]);
        $request->setAttribute("disp_json_code", $this->_collapseJsonCode($java_bean_info["json_code"]));
        return VIEW_DONE;
    }

    /**
     * 执行默认程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    private function _doRollbackExecute(Controller $controller, User $user, Request $request)
    {
        $url = "./tool/java_bean/?rollback=1";
        if ($request->current_level) {
            $url = "./?menu=tool&act=java_bean&rollback=1";
        }
        $controller->redirect($url);
        return VIEW_DONE;
    }

    /**
     * 执行默认程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    private function _doConfirmExecute(Controller $controller, User $user, Request $request)
    {
        $class_name_list = $request->getParameter("class_name_list");
        $class_object_list = $request->getParameter("class_object_list");
        $java_bean_info = $user->getVariable("java_bean_data");
        $data_type_list = $java_bean_info["datatype_list"];
        $subclass_modifier = $java_bean_info["subclass_modifier"];
        $java_bean_info = $user->getVariable("java_bean_rollback");
        $package_name = $java_bean_info["package_name"];
        define("DELIMITER", "\r\n");
        define("OVER", ";" . DELIMITER);
        $java_bean_text = "package " . $package_name . OVER . DELIMITER;
        $java_bean_text .= "import java.util.List" . OVER;
        $java_bean_text .= "import com.fasterxml.jackson.annotation.JsonProperty" . OVER . DELIMITER;
        foreach ($class_object_list as $class_idx => $class_itm) {
            if ($class_itm["class_type"]) {
                $level_num = 0;
                $mod_text = "public";
            } else {
                $level_num = 1;
                $mod_text = $subclass_modifier;
            }
            $java_bean_text .= $this->_tab($level_num) . $mod_text . " class " . $class_name_list[$class_idx] . DELIMITER;
            $java_bean_text .= $this->_tab($level_num) . "{" . DELIMITER;
            foreach ($class_itm["class_property"] as $prop_info) {
                $java_bean_text .= $this->_tab($level_num + 1) . "@JsonProperty(\"" . $prop_info["property_name"] . "\")" . DELIMITER;
                $java_bean_text .= $this->_tab($level_num + 1) . "private ";
                $type_name = "";
                if ($prop_info["property_datatype_class"]) {
                    $type_name = $class_name_list[$prop_info["property_datatype_class"]];
                    if ($prop_info["property_list_flg"]) {
                        $type_name = "List<" . $type_name . ">";
                    }
                } else {
                    $type_name = $data_type_list[$prop_info["property_datatype"]];
                }
                $java_bean_text .= $type_name . " m_";
                if ($prop_info["property_datatype"] == "3") {
                    $java_bean_text .= "is" . ucwords($prop_info["property_name"]);
                } else {
                    $java_bean_text .= $prop_info["property_name"];
                }
                $java_bean_text .= OVER . DELIMITER;
            }
            foreach ($class_itm["class_property"] as $prop_info) {
                $java_bean_text .= $this->_tab($level_num + 1) . "@JsonProperty(\"" . $prop_info["property_name"] . "\")" . DELIMITER;
                $java_bean_text .= $this->_tab($level_num + 1) . "public ";
                $type_name = "";
                if ($prop_info["property_datatype_class"]) {
                    $type_name = $class_name_list[$prop_info["property_datatype_class"]];
                    if ($prop_info["property_list_flg"]) {
                        $type_name = "List<" . $type_name . ">";
                    }
                } else {
                    $type_name = $data_type_list[$prop_info["property_datatype"]];
                }
                $java_bean_text .= $type_name . " ";
                if ($prop_info["property_datatype"] == "3") {
                    $java_bean_text .= "is";
                } else {
                    $java_bean_text .= "get";
                }
                $java_bean_text .= ucwords($prop_info["property_name"]);
                $java_bean_text .= "()" . DELIMITER;
                $java_bean_text .= $this->_tab($level_num + 1) . "{" . DELIMITER;
                $java_bean_text .= $this->_tab($level_num + 2) . "return m_";
                if ($prop_info["property_datatype"] == "3") {
                    $java_bean_text .= "is" . ucwords($prop_info["property_name"]);
                } else {
                    $java_bean_text .= $prop_info["property_name"];
                }
                $java_bean_text .= OVER;
                $java_bean_text .= $this->_tab($level_num + 1) . "}" . DELIMITER . DELIMITER;
                $java_bean_text .= $this->_tab($level_num + 1) . "public void ";
                if ($class_itm["class_type"]) {
                    $java_bean_text .= $prop_info["property_name"];
                } else {
                    $java_bean_text .= "set" . ucwords($prop_info["property_name"]);
                }
                $type_name = "";
                if ($prop_info["property_datatype_class"]) {
                    $type_name = $class_name_list[$prop_info["property_datatype_class"]];
                    if ($prop_info["property_list_flg"]) {
                        $type_name = "List<" . $type_name . ">";
                    }
                } else {
                    $type_name = $data_type_list[$prop_info["property_datatype"]];
                }
                $java_bean_text .= "(" . $type_name . " ";
                if ($prop_info["property_datatype"] == "3") {
                    $java_bean_text .= "is" . ucwords($prop_info["property_name"]);
                } else {
                    $java_bean_text .= $prop_info["property_name"];
                }
                $java_bean_text .= ")" . DELIMITER;
                $java_bean_text .= $this->_tab($level_num + 1) . "{" . DELIMITER;
                $java_bean_text .= $this->_tab($level_num + 2) . "this.m_";
                if ($prop_info["property_datatype"] == "3") {
                    $java_bean_text .= "is" . ucwords($prop_info["property_name"]);
                } else {
                    $java_bean_text .= $prop_info["property_name"];
                }
                $java_bean_text .= " = ";
                if ($prop_info["property_datatype"] == "3") {
                    $java_bean_text .= "is" . ucwords($prop_info["property_name"]);
                } else {
                    $java_bean_text .= $prop_info["property_name"];
                }
                $java_bean_text .= OVER;
                $java_bean_text .= $this->_tab($level_num + 1) . "}" . DELIMITER . DELIMITER;
            }
            if (!$class_itm["class_type"]) {
                $java_bean_text .= $this->_tab(1) . "}" . DELIMITER . DELIMITER;
            }
        }
        $java_bean_text .= "}" . DELIMITER;
        $user->freeVariable("java_bean_data");
        $user->freeVariable("java_bean_rollback");
        Utility::testVariable($java_bean_text);
        return VIEW_DONE;
    }

    private function _tab($num = 1)
    {
        if ($num > 0) {
            return str_repeat("    ", $num);
        }
        return "";
    }

    private function _collapseJsonCode($json_code)
    {
        $json_code = json_encode(json_decode($json_code, true));
        $result = array();
        for ($i = 0; $i < strlen($json_code); $i++) {
            $result[] = substr($json_code, $i, 1);
        }
        $json_code = "";
        $quote_flg = false;
        $lvl_num = 0;
        foreach ($result as $idx => $itm) {
            if (($itm == "[" || $itm == "{") && !$quote_flg) {
                $lvl_num++;
                $json_code .= $itm . "\n" . $this->_tab($lvl_num);
            } elseif ($itm == "," && !$quote_flg) {
                $json_code .= $itm . "\n" . $this->_tab($lvl_num);
            } elseif ($itm == ":") {
                $json_code .= $itm . " ";
            } elseif ($itm == "\"") {
                if ($result[$idx - 1] != "\\") {
                    $quote_flg = !$quote_flg;
                }
                $json_code .= $itm;
            } elseif (($itm == "]" || $itm == "}") && !$quote_flg) {
                $lvl_num--;
                $json_code .= "\n" . $this->_tab($lvl_num) . $itm;
            } else {
                $json_code .= $itm;
            }
        }
        return $json_code;
    }
}
?>