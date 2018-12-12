<?php

/**
 * 转译方法类
 * @author Kinsama
 * @version 2017-07-14
 */
class Translate
{

    /**
     * 数组转XML文档
     *
     * @param mixed $value 对象数组
     * @return string
     */
    public function transArrayToXML($value)
    {
        $xml_text = '<?xml version="1.0" encoding="UTF-8"?><data>';
        $xml_text .= $this->_arrayToXml($value);
        $xml_text .= "</data>";
        return $xml_text;
    }

    /**
     * XML文档转数组
     *
     * @param string $xml_file 对象XML文档路径
     * @return string
     */
    public function transXMLToArray($xml_file)
    {
        $xml = simplexml_load_file($xml_file);
        if ($xml === false) {
            $err = Error::getInstance();
            $err->raiseError(ERROR_CODE_API_GET_FALSIFY, $xml_file);
            return $err;
        }
        if ($xml->status != "200" && $xml->error == "1") {
            $err = Error::getInstance();
            $err->raiseError(ERROR_CODE_API_ERROR_FALSIFY, $xml_file);
            return $err;
        }
        return $this->_xmlToArray($xml->results);
    }

    /**
     * XML文档转数组
     *
     * @param mixed $value XML对象
     * @access private
     * @return string
     */
    private function _xmlToArray($value)
    {
        if (is_object($value)) {
            $value = (array) $value;
        }
        if (!is_array($value)) {
            return $value;
        }
        $new_data = array();
        foreach ($value as $item_key => $item_val) {
            $item_val = $this->_xmlToArray($item_val);
            $new_data[$item_key] = $item_val;
        }
        return $new_data;
    }

    /**
     * 数组转XML文档
     *
     * @param mixed $in_value 对象数组
     * @param string $out_key 上一级键名
     * @access private
     * @return string
     */
    private function _arrayToXml($in_value, $out_key = null)
    {
        if (!is_array($in_value)) {
            return $in_value;
        }
        $result = "";
        $assoc_array_key_name = "";
        $assoc_array_flg = false;
        if ($this->_checkAssocArray($in_value)) {
            if (is_null($out_key)) {
                $assoc_array_key_name = "Item";
            } elseif (isset($out_key) && substr($out_key, -1) == "s") {
                $assoc_array_key_name = substr($out_key, 0, -1);
            } else {
                $assoc_array_key_name = $out_key . "Item";
            }
            $assoc_array_flg = true;
        }
        foreach ($in_value as $item_key => $item_value) {
            $xml_key = $item_key;
            if ($assoc_array_flg) {
                $xml_key = $assoc_array_key_name;
            }
            $result .= sprintf('<%s>%s</%s>', $xml_key, $this->_arrayToXml($item_value, $item_key), $xml_key);
        }
        return $result;
    }

    /**
     * 检测值是否为索引数组
     *
     * @param mixed $value 待检测值
     * @return boolean
     */
    private function _checkAssocArray($value)
    {
        if (is_array($value)) {
            $keys = array_keys($value);
            foreach ($keys as $itm_key => $itm_val) {
                if ($itm_key !== $itm_val) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    /**
     * 获取本类实例化对象
     *
     * @return object
     */
    public static function getInstance()
    {
        return new Translate();
    }
}
?>