<?php

/**
 * 数据库操作类-c_point
 * @author Kinsama
 * @version 2017-12-11
 */
class IohPointDBI
{
    public static function selectPoint($custom_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM c_point WHERE del_flg = 0 AND custom_id = " . $custom_id;
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["custom_id"]] = $row["custom_point"];
        }
        $result->free();
        return $data;
    }

    public static function selectRewardPoint($custom_id, $point_type)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM c_point_history WHERE del_flg = 0 AND point_type = " . $point_type . " AND custom_id = " . $custom_id;
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["point_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function insertPoint($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("c_point", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function updatePoint($custom_id, $custom_point)
    {
        $dbi = Database::getInstance();
        $where = "custom_id = " . $custom_id;
        $result = $dbi->update("c_point", array("custom_point" => $custom_point), $where);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;

    }

    public static function insertPointHistory($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("c_point_history", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>