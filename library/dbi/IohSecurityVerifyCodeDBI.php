<?php

/**
 * 数据库操作类-security_verifycode
 * @author Kinsama
 * @version 2018-06-22
 */
class IohSecurityVerifycodeDBI
{

    public static function insertVerifyCode($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("security_verifycode", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>