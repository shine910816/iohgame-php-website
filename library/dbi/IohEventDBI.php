<?php

/**
 * 数据库操作类-c_event
 * @author Kinsama
 * @version 2017-12-11
 */
class IohEventDBI
{
    public static function selectPassiveEvent($current_date)
    {
        $dbi = Database::getInstance();
        $current_datetime = new DateTime($current_date);
        $target_date = $current_datetime->format("Y-m-d H:i:s");
        $sql = "SELECT * FROM c_event WHERE del_flg = 0 AND event_start_date <= \"" . $target_date .
               "\" AND event_expiry_date >= \"" . $target_date . "\" AND event_active_flg = " . IohEventEntity::EVENT_PASSIVE .
               " AND event_open_flg = " . IohEventEntity::EVENT_OPEN_ON;
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
}
?>