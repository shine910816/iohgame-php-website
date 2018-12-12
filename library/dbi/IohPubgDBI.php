<?php

/**
 * 数据库操作类-g_pubg_*
 * @author Kinsama
 * @version 2018-06-22
 */
class IohPubgDBI
{

    public static function selectWeapon($w_id = null)
    {
        $dbi = Database::getInstance();
        $where = "";
        if (!is_null($w_id)) {
            if (!is_array($w_id)) {
                $w_id = array(
                    $w_id
                );
            }
            $where = " AND `w_id` IN (" . implode(", ", $w_id) . ")";
        }
        $sql = "SELECT * FROM `g_pubg_weapon` WHERE `del_flg` = 0" . $where;
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["w_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectWeaponByType($w_type = null)
    {
        $dbi = Database::getInstance();
        $where = " WHERE `del_flg` = 0";
        if (!is_null($w_type)) {
            if (!is_array($w_type)) {
                $w_type = array(
                    $w_type
                );
                $where .= " AND `w_type` IN (" . implode(", ", $w_type) . ")";
            }
        }
        $sql = "SELECT * FROM `g_pubg_weapon`" . $where;
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["w_type"]][$row["w_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectWeaponParamLimit()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT MAX(w_damage) AS damage," . " MAX(w_speed) AS speed," . " MAX(w_distance_max) AS distance," . " MIN(w_interval_time) AS `interval`" . " FROM g_pubg_weapon" . " WHERE del_flg = 0";
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
        return $data[0];
    }

    public static function selectPart($p_id = null)
    {
        $dbi = Database::getInstance();
        $where = "";
        if (!is_null($p_id)) {
            if (!is_array($p_id)) {
                $p_id = array(
                    $p_id
                );
            }
            $where = " AND `p_id` IN (" . implode(", ", $p_id) . ")";
        }
        $sql = "SELECT * FROM `g_pubg_part` WHERE `del_flg` = 0" . $where;
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["p_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectPartByType($p_type = null)
    {
        $dbi = Database::getInstance();
        $where = " WHERE `del_flg` = 0";
        if (!is_null($p_type)) {
            if (!is_array($p_type)) {
                $p_type = array(
                    $p_type
                );
                $where .= " AND `p_type` IN (" . implode(", ", $p_type) . ")";
            }
        }
        $sql = "SELECT * FROM `g_pubg_part`" . $where;
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["p_type"]][$row["p_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectWeaponPart()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT `w_id`, `p_id` FROM `g_pubg_weapon_part` WHERE `del_flg` = 0";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["w_id"]][$row["p_id"]] = "1";
        }
        $result->free();
        return $data;
    }

    public static function selectWeaponPartByType()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT w.w_type, wp.w_id, p.p_type, wp.p_id" . " FROM g_pubg_weapon_part wp" . " LEFT OUTER JOIN g_pubg_weapon w ON w.w_id = wp.w_id" . " LEFT OUTER JOIN g_pubg_part p ON p.p_id = wp.p_id" . " WHERE wp.del_flg = 0 AND w.del_flg = 0 AND p.del_flg = 0" . " ORDER BY p.p_order ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            if ($row["p_type"] != "6") {
                $data[$row["w_type"]][$row["w_id"]][$row["p_type"]][$row["p_id"]] = $row["p_id"];
            } else {
                $data[$row["w_type"]][$row["w_id"]][$row["p_type"]] = $row["p_id"];
            }
        }
        $result->free();
        return $data;
    }

    public static function insertWeapon($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("g_pubg_weapon", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function updateWeapon($update_data, $w_id)
    {
        $dbi = Database::getInstance();
        $result = $dbi->update("g_pubg_weapon", $update_data, "w_id = " . $w_id);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function insertPart($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("g_pubg_part", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function updatePart($update_data, $p_id)
    {
        $dbi = Database::getInstance();
        $result = $dbi->update("g_pubg_part", $update_data, "p_id = " . $p_id);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function insertWeaponPart($w_id, $p_id)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("g_pubg_weapon_part", array(
            "w_id" => $w_id,
            "p_id" => $p_id
        ));
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function cleanWeaponPart()
    {
        $dbi = Database::getInstance();
        $result = $dbi->delete("g_pubg_weapon_part", "`w_id` > 0 AND `p_id` > 0");
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>