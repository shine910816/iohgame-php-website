<?php

/**
 * 数据库操作类-security_verifycode
 * @author Kinsama
 * @version 2018-06-22
 */
class IohSecurityVerifyCodeDBI
{

    public static function insertVerifyCode($phone, $code, $type)
    {
        $dbi = Database::getInstance();
        $validity = date("Y-m-d H:i:s", time() + 300);
        $insert_data = array(
            "v_phone_num" => $phone,
            "v_code" => $code,
            "v_type" => $type,
            "v_validity" => $validity
        );
        $result = $dbi->insert("security_verifycode", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>