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

    public static function getCodeTypeList()
    {
        return array(
            self::CODE_TYPE_TELEPHONE => "手机号码",
            self::CODE_TYPE_MAILADDRESS => "电子邮箱"
        );
    }
}
?>