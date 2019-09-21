<?php

/**
 * 数据库操作类-g_wow_secret_*
 * @author Kinsama
 * @version 2019-09-08
 */
class IohWowSecretDBI
{

    public static function getMapList()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT map_id, map_name FROM g_wow_secret_map WHERE del_flg = 0";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["map_id"]] = $row["map_name"];
        }
        $result->free();
        return $data;
    }

    public static function getBossList($map_id = null)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT boss_id, map_id, boss_order, boss_name FROM g_wow_secret_boss WHERE del_flg = 0";
        if (!is_null($map_id)) {
            $sql .= " AND map_id = " . $map_id;
        }
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["boss_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function getBossInfo($boss_id)
    {
        $dbi = Database::getInstance();
        if (!is_array($boss_id)) {
            $boss_id = array($boss_id);
        }
        $sql = "SELECT boss_id, map_id, boss_order, boss_name FROM g_wow_secret_boss WHERE del_flg = 0";
        $sql .= " AND boss_id IN (" . implode(", ", $boss_id) . ")";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["boss_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectBossInfoList()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT b.boss_id, b.map_id, b.boss_order, m.map_name, b.boss_name" .
               " FROM g_wow_secret_boss b LEFT OUTER JOIN g_wow_secret_map m ON m.map_id = b.map_id" .
               " WHERE b.del_flg = 0 AND m.del_flg = 0";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["boss_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectItem($item_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT item_id, item_name, item_class, item_position, item_type," .
               " item_armor, item_block, item_strength, item_agility, item_intellect, item_stamina," .
               " item_critical, item_haste, item_mastery, item_versatility," .
               " item_equit_effect, item_equit_effect_num, item_equit_effect_num2," .
               " item_use_effect, item_use_effect_num, item_use_effect_num2, boss_id FROM g_wow_secret_item" .
               " WHERE del_flg = 0 AND item_id = " . $item_id;
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["item_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectItemList()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM g_wow_secret_item WHERE del_flg = 0 ORDER BY boss_id ASC, item_class ASC, item_position ASC, item_type ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["item_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectItemByMapId($map_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT i.item_id, i.item_name, i.item_class, i.item_position, i.item_type, i.boss_id" .
               " FROM g_wow_secret_item i" .
               " LEFT OUTER JOIN g_wow_secret_boss b ON b.boss_id = i.boss_id" .
               " LEFT OUTER JOIN g_wow_secret_map m ON m.map_id = b.map_id" .
               " WHERE i.del_flg = 0" .
               " AND b.del_flg = 0" .
               " AND m.del_flg = 0" .
               " AND m.map_id = " . $map_id .
               " ORDER BY i.item_class ASC, i.item_position ASC, i.item_type ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["item_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectItemByBossId($boss_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT item_id, item_name, item_class, item_position, item_type, boss_id" .
               " FROM g_wow_secret_item" .
               " WHERE del_flg = 0" .
               " AND boss_id = " . $boss_id .
               " ORDER BY item_class ASC, item_position ASC, item_type ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["item_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectEnableInfoForAdmin($type_group = "1")
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM g_wow_secret_item WHERE del_flg = 0";
        switch ($type_group) {
            case "1":
                $sql .= " AND item_class = 2 AND item_type = 17";
                break;
            case "2":
                $sql .= " AND item_class = 2 AND item_type = 16";
                break;
            case "3":
                $sql .= " AND item_class = 2 AND item_type = 15";
                break;
            case "4":
                $sql .= " AND item_class = 2 AND item_type = 14";
                break;
            case "6":
                $sql .= " AND item_class = 2 AND item_position IN (6, 8, 15)";
                break;
            default:
                $sql .= " AND (item_class = 1 OR (item_class = 2 AND item_position = 16))";
                break;
        }
        $sql .= " ORDER BY item_class ASC, item_position ASC, item_type ASC, item_strength DESC, item_agility DESC, item_intellect DESC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["item_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectWeaponForAdmin()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM g_wow_secret_item WHERE del_flg = 0" .
               " AND item_class = 1 AND item_position IN (1, 2, 4)" .
               " ORDER BY boss_id ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["item_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectWeaponInfoList()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT item_id," .
               " item_damage_min AS min," .
               " item_damage_max AS max," .
               " item_speed AS spd," .
               " item_damage_per_second AS dps" .
               " FROM g_wow_secret_weapon WHERE del_flg = 0";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["item_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectSuitByItemId($item_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM g_wow_secret_suit_item" .
               " WHERE del_flg = 0 AND item_id = " . $item_id . " LIMIT 1";
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
        if (count($data) > 0) {
            return $data[0]["suit_id"];
        }
        return "0";
    }

    public static function selectSuitInfo($suit_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM g_wow_secret_suit WHERE del_flg = 0 AND suit_id = " . $suit_id;
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["suit_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectSuitItem($suit_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT s.item_id, i.item_name" .
               " FROM g_wow_secret_suit_item s" .
               " LEFT OUTER JOIN g_wow_secret_item i ON i.item_id = s.item_id" .
               " WHERE s.del_flg = 0 AND i.del_flg = 0 AND s.suit_id = " . $suit_id .
               " ORDER BY i.item_position ASC, i.item_type ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["item_id"]] = $row["item_name"];
        }
        $result->free();
        return $data;
    }

    public static function insertItem($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("g_wow_secret_item", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function updateItem($item_id, $update_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->update("g_wow_secret_item", $update_data, "item_id = " . $item_id);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function insertWeaponItem($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("g_wow_secret_weapon", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function updateWeaponItem($item_id, $update_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->update("g_wow_secret_weapon", $update_data, "item_id = " . $item_id);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>