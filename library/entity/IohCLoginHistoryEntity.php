<?php

/**
 * 数据库应用类-c_login_history
 * @author Kinsama
 * @version 2017-01-09
 */
class IohCLoginHistoryEntity
{

    public static function getEntityName()
    {
        return 'c_login_history';
    }

    public static function getVolumnName()
    {
        return array(
            'his_id', // 记录ID
            'cus_id', // 用户ID
            'cus_ip_address' // 用户IP地址
        );
    }
}
?>