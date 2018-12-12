<?php

/**
 * 数据库应用类-c_event
 * @author Kinsama
 * @version 2018-12-11
 */
class IohEventEntity
{
    const EVENT_OPEN_ON = "1";
    const EVENT_OPEN_OFF = "0";

    const EVENT_ACTIVE = "1";
    const EVENT_PASSIVE = "0";

    public static function getEntityName()
    {
        return "c_event";
    }
}
?>