<?php

class IohGroupDBI
{

    public static function getGroup()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM `c_game_group` WHERE `del_flg` = 0";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['g_id']] = $row;
        }
        $result->free();
        return $data;
    }

    public static function insertGameGroup($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("c_game_group", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function insertGamePlayer($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("c_game_player", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function updateGameGroup($update_data, $where)
    {
        $dbi = Database::getInstance();
        $result = $dbi->update("c_game_group", $update_data, $where);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function updateGamePlayer($update_data, $where)
    {
        $dbi = Database::getInstance();
        $result = $dbi->update("c_game_player", $update_data, $where);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>