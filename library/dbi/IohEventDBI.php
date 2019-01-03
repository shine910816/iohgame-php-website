<?php

/**
 * 数据库操作类-c_event
 * @author Kinsama
 * @version 2017-12-11
 */
class IohEventDBI
{
    public static function selectOpenEvent($current_date)
    {
        $dbi = Database::getInstance();
        $current_datetime = new DateTime($current_date);
        $target_date = $current_datetime->format("Y-m-d H:i:s");
        $sql = "SELECT * FROM c_event WHERE del_flg = 0 AND event_start_date <= \"" . $target_date .
               "\" AND event_expiry_date >= \"" . $target_date . "\"" .
               " AND event_open_flg = " . IohEventEntity::EVENT_OPEN_ON .
               " ORDER BY event_expiry_date DESC, event_start_date ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["event_number"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectTotalEvent()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM c_event WHERE del_flg = 0";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["event_key"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectEventById($event_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM c_event WHERE del_flg = 0 AND event_id = " . $event_id;
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["event_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectEventByNumber($event_number)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM c_event WHERE del_flg = 0 AND event_number = \"" . $event_number . "\"";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["event_number"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function insertEvent($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("c_event", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function updateEvent($update_data, $where)
    {
        $dbi = Database::getInstance();
        $result = $dbi->update("c_event", $update_data, $where);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>