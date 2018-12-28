<?php

/**
 * 数据库应用类-security_verifycode
 * @author Kinsama
 * @version 2018-12-18
 */
class IohSecurityVerifycodeEntity
{
    const CODE_TYPE_TELEPHONE = "0";
    const CODE_TYPE_MAILADDRESS = "1";

    const CODE_METHOD_BIND = "1";
    const CODE_METHOD_RESET = "2";
    const CODE_METHOD_GETBACK = "3";
    const CODE_METHOD_REMOVE = "4";

    public static function getCodeTypeList()
    {
        return array(
            self::CODE_TYPE_TELEPHONE => "手机号码",
            self::CODE_TYPE_MAILADDRESS => "电子邮箱"
        );
    }
}
?>