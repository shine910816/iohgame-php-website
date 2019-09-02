<?php

/**
 * 数据库操作类-custom_*
 * @author Kinsama
 * @version 2018-09-20
 */
class IohCustomDBI
{
    public static function selectCustomById($custom_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM custom_login WHERE del_flg = 0 AND custom_id = " . $custom_id;
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

    public static function selectCustomInfoById($custom_id, $detail_flg = false)
    {
        $dbi = Database::getInstance();
        if (!is_array($custom_id)) {
            $custom_id = array($custom_id);
        }
        $sql = "SELECT custom_id, custom_nick";
        if ($detail_flg) {
            $sql .= ", custom_gender, custom_birth, confirm_flg, open_level";
        }
        $sql .= " FROM custom_info WHERE del_flg = 0 AND custom_id IN (" . implode(", ", $custom_id) . ")";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            if ($detail_flg) {
                $data[$row["custom_id"]] = $row;
            } else {
                $data[$row["custom_id"]] = $row["custom_nick"];
            }
        }
        $result->free();
        return $data;
    }

    public static function selectCustomPasswordById($custom_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM custom_password WHERE del_flg = 0 AND custom_id = " . $custom_id;
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

    public static function selectCustomByName($name)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT l.custom_id, l.custom_salt, p.custom_password FROM custom_login l LEFT OUTER JOIN custom_password p ON p.custom_id = l.custom_id" . ' WHERE l.del_flg = 0 AND p.del_flg = 0 AND l.custom_login_name = "' . strtolower($name) . '"';
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $result->free();
        if (count($data) != 1) {
            return array();
        }
        return $data[0];
    }

    public static function selectCustomByTel($tel)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT l.custom_id, l.custom_salt, p.custom_password FROM custom_login l LEFT OUTER JOIN custom_password p ON p.custom_id = l.custom_id" . ' WHERE l.del_flg = 0 AND p.del_flg = 0 AND l.custom_tele_number = "' . strtolower($tel) . '" AND custom_tele_flg = 1';
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $result->free();
        if (count($data) != 1) {
            return array();
        }
        return $data[0];
    }

    public static function selectCustomByMail($address)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT l.custom_id, l.custom_salt, p.custom_password FROM custom_login l LEFT OUTER JOIN custom_password p ON p.custom_id = l.custom_id" . ' WHERE l.del_flg = 0 AND p.del_flg = 0 AND l.custom_mail_address = "' . strtolower($address) . '" AND custom_mail_flg = 1';
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $result->free();
        if (count($data) != 1) {
            return array();
        }
        return $data[0];
    }

    public static function selectCustomNickname($custom_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT custom_id, custom_nick FROM custom_info WHERE del_flg = 0 AND custom_id = " . $custom_id;
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["custom_id"]] = $row["custom_nick"];
        }
        $result->free();
        if (count($data) != 1) {
            return "";
        }
        if (!isset($data[$custom_id])) {
            return "";
        }
        return $data[$custom_id];
    }

    public static function selectAdminLevel($custom_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT custom_id, admin_lvl FROM custom_admin WHERE del_flg = 0 AND custom_id = " . $custom_id;
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["custom_id"]] = $row["admin_lvl"];
        }
        $result->free();
        if (count($data) != 1) {
            return "0";
        }
        if (!isset($data[$custom_id])) {
            return "0";
        }
        return $data[$custom_id];
    }

    public static function selectCustomInfo($custom_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM custom_info WHERE del_flg = 0 AND custom_id = " . $custom_id;
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
        if (count($data) != 1) {
            return array();
        }
        if (!isset($data[$custom_id])) {
            return array();
        }
        return $data[$custom_id];
    }

    public static function insertLogin($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("custom_login", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function insertPassword($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("custom_password", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function insertInfo($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("custom_info", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function updateLogin($update_data, $where)
    {
        $dbi = Database::getInstance();
        $result = $dbi->update("custom_login", $update_data, $where);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function updatePassword($update_data, $where)
    {
        $dbi = Database::getInstance();
        $result = $dbi->update("custom_password", $update_data, $where);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function updateInfo($update_data, $where)
    {
        $dbi = Database::getInstance();
        $result = $dbi->update("custom_info", $update_data, $where);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function addFollow($custom_id, $v_custom_id)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("custom_friend", array("custom_id" => $custom_id, "v_custom_id" => $v_custom_id));
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function removeFollow($custom_id, $v_custom_id)
    {
        $dbi = Database::getInstance();
        $result = $dbi->delete("custom_friend", "custom_id = " . $custom_id . " AND v_custom_id = " . $v_custom_id);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function selectFollower($custom_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT custom_id, v_custom_id FROM custom_friend WHERE del_flg = 0 AND (custom_id = " . $custom_id . " OR v_custom_id = " . $custom_id . ") ORDER BY insert_date DESC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $result->free();
        return $data;
    }
}
?>