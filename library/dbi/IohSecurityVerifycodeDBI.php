<?php

/**
 * 数据库操作类-security_verifycode
 * @author Kinsama
 * @version 2018-12-18
 */
class IohSecurityVerifycodeDBI
{
    public static function selectLastCode($custom_id, $code_type)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM security_verifycode WHERE del_flg = 0 AND custom_id = " . $custom_id . " AND code_type = " . $code_type;
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["custom_id"]] = $row;
        }
        $result->free();
        return $data;
    }

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

    public static function updateVerifyCode($update_data, $where)
    {
        $dbi = Database::getInstance();
        $result = $dbi->update("security_verifycode", $update_data, $where);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>