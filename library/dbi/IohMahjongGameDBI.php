<?php

class IohMahjongGameDBI
{

    public static function getCardTypeList()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT `c_type`, `c_type_property`, `c_type_value`, `c_img` FROM `g_mahjong_type` WHERE `del_flg` = 0";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['c_type']] = $row;
        }
        $result->free();
        return $data;
    }

    public static function getPlayerHandCard($m_table_id, $player)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT c.m_order_id," . " c.m_card_hand_disp_flg," . " c.m_card_dora_flg," . " c.m_card_target_flg," . " t.c_img," . " t.c_tile" . " FROM g_mahjong_table_card c" . " LEFT OUTER JOIN g_mahjong_type t ON t.c_type = c.c_type" . " WHERE c.del_flg = 0" . " AND c.m_table_id = " . $m_table_id . " AND c.m_card_position = " . $player . " ORDER BY c.m_card_hand_disp_flg DESC," . " c.m_card_dora_flg DESC," . " c.m_card_target_flg ASC," . " t.c_type_property DESC," . " c.m_card_id ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['m_order_id']] = $row;
        }
        $result->free();
        return $data;
    }

    public static function getTargetCard($m_table_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT m_order_id, m_card_position, m_drop_from, c_type FROM g_mahjong_table_card" . " WHERE del_flg = 0 AND m_card_target_flg = 1 AND m_table_id = " . $m_table_id;
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
        if (count($data) < 1) {
            return array();
        }
        return $data[0];
    }

    public static function getCardNumberGroupByType($m_table_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT m_card_position, c_type, m_card_hand_disp_flg, COUNT(*)" . " FROM g_mahjong_table_card" . " WHERE del_flg = 0 AND m_card_position IN (1, 2, 3, 4) AND m_drop_from = 0 AND m_table_id = " . $m_table_id . " GROUP BY m_card_position, c_type, m_card_hand_disp_flg";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            if (!isset($data[$row["m_card_position"]][$row["c_type"]])) {
                $data[$row["m_card_position"]][$row["c_type"]] = array(
                    "0" => "0",
                    "1" => "0"
                );
            }
            $data[$row["m_card_position"]][$row["c_type"]][$row["m_card_hand_disp_flg"]] = $row["COUNT(*)"];
        }
        $result->free();
        return $data;
    }

    public static function getTableIdFromRoom($m_room_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT m_table_id FROM g_mahjong_table" . " WHERE del_flg = 0 AND m_finish_flg = 0 AND m_room_id = " . $m_room_id . " ORDER BY m_table_id DESC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row["m_table_id"];
        }
        $result->free();
        if (count($data) == 1) {
            return $data[0];
        }
        return "0";
    }

    public static function getTableInfo($m_table_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM g_mahjong_table" . " WHERE del_flg = 0 AND m_table_id = " . $m_table_id;
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["m_table_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function getPlayerPosition($m_room_id, $player_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT m_room_id, m_room_player_1, m_room_player_2, m_room_player_3, m_room_player_4 FROM g_mahjong_room" . " WHERE del_flg = 0 AND m_room_id = " . $m_room_id;
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["m_room_id"]] = $row;
        }
        $result->free();
        if (count($data) == 0) {
            return "0";
        }
        foreach ($data[$m_room_id] as $info_key => $player) {
            if ($info_key != "m_room_id" && $player == $player_id) {
                return str_replace("m_room_player_", "", $info_key);
            }
        }
        return "0";
    }

    public static function getCardInfoByOrderId($m_table_id, $m_order_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM g_mahjong_table_card WHERE del_flg = 0 AND m_table_id = " . $m_table_id . " AND m_order_id = " . $m_order_id;
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["m_order_id"]] = $row;
        }
        $result->free();
        return $data[$m_order_id];
    }

    public static function getTileOrderId($m_table_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT m_order_id FROM g_mahjong_table_card" . " WHERE del_flg = 0 AND m_card_getable_flg = 1 AND m_card_desc_order = 0 AND m_table_id = " . $m_table_id . " ORDER BY m_order_id ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row["m_order_id"];
        }
        $result->free();
        return $data;
    }

    public static function getTileOrderIdBack($m_table_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT m_order_id FROM g_mahjong_table_card" . " WHERE del_flg = 0 AND m_card_getable_flg = 1 AND m_card_desc_order > 0 AND m_table_id = " . $m_table_id . " ORDER BY m_card_desc_order ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row["m_order_id"];
        }
        $result->free();
        return $data;
    }

    public static function insertTable($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("g_mahjong_table", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function insertTableCard($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("g_mahjong_table_card", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function updateTable($update_data, $where)
    {
        $dbi = Database::getInstance();
        $result = $dbi->update("g_mahjong_table", $update_data, $where);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function updateTableCard($update_data, $where)
    {
        $dbi = Database::getInstance();
        $result = $dbi->update("g_mahjong_table_card", $update_data, $where);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>