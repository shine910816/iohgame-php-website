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

    public static function getBossList()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT map_id, boss_order, boss_name FROM g_wow_secret_boss WHERE del_flg = 0";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["map_id"]][$row["boss_order"]] = $row["boss_name"];
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
}
?>