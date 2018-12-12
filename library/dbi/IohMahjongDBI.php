<?php

class IohMahjongDBI
{

    public static function getGameInfo($history_flg = false)
    {
        $dbi = Database::getInstance();
        $where = "WHERE `final_flg` = ";
        if ($history_flg) {
            $where .= "1";
        } else {
            $where .= "0";
        }
        $sql = "SELECT * FROM `g_mahjong` " . $where . " AND `del_flg` = 0 ORDER BY `update_date` DESC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['m_id']] = $row;
        }
        $result->free();
        return $data;
    }

    public static function getGameInfoById($m_id)
    {
        $dbi = Database::getInstance();
        if (!is_array($m_id)) {
            $m_id = array(
                $m_id
            );
        }
        $m_id_str = implode(", ", $m_id);
        $where = "WHERE `del_flg` = 0 AND `m_id` IN (" . $m_id_str . ")";
        $sql = "SELECT * FROM `g_mahjong` " . $where;
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['m_id']] = $row;
        }
        $result->free();
        return $data;
    }

    public static function getGameDetailById($m_id)
    {
        $dbi = Database::getInstance();
        $where = "WHERE `del_flg` = 0 AND `m_id` = " . $m_id;
        $sql = "SELECT * FROM `g_mahjong_detail` " . $where;
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['m_player']] = $row;
        }
        $result->free();
        return $data;
    }

    public static function getGameHistoryById($m_id)
    {
        $dbi = Database::getInstance();
        $where = "WHERE `del_flg` = 0 AND `m_id` = " . $m_id;
        $sql = "SELECT * FROM `g_mahjong_history` " . $where . " ORDER BY `m_round` ASC, `m_part` ASC";
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

    public static function insertMahjong($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("g_mahjong", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function insertMahjongDetail($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("g_mahjong_detail", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function insertMahjongHistory($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("g_mahjong_history", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function updateMahjong($update_data, $where)
    {
        $dbi = Database::getInstance();
        $result = $dbi->update("g_mahjong", $update_data, $where);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function updateMahjongDetail($update_data, $where)
    {
        $dbi = Database::getInstance();
        $result = $dbi->update("g_mahjong_detail", $update_data, $where);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>