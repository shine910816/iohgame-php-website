<?php

class IohPubgRequestDBI
{

    public static function getAccountId($custom_id)
    {
        $dbi = Database::getInstance();
        if (!is_array($custom_id)) {
            $custom_id = array($custom_id);
        }
        $sql = "SELECT custom_id," .
               " player_name," .
               " account_id" .
               " FROM g_pubg_account" .
               " WHERE del_flg = 0" .
               " AND custom_id IN (" . implode(", ", $custom_id) . ")";
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

    public static function insertPlayerAccount($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("g_pubg_account", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function updatePlayerAccount($update_data, $where)
    {
        $dbi = Database::getInstance();
        $result = $dbi->update("g_pubg_account", $update_data, $where);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>