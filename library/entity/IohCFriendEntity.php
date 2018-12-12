<?php

/**
 * 数据库应用类-c_friend
 * @author Kinsama
 * @version 2017-01-19
 */
class IohCFriendEntity
{
    const FRIEND_STATUS_CLOSE = "1";
    const FRIEND_STATUS_COMMON = "2";
    const FRIEND_STATUS_WAIT = "3";
    const FRIEND_STATUS_BLACK = "4";

    public static function getEntityName()
    {
        return 'c_friend';
    }

    public static function getVolumnName()
    {
        return array(
            'friend_id',
            'cus_id',
            'oppo_cus_id',
            'friend_status',
            'notes'
        );
    }
}
?>