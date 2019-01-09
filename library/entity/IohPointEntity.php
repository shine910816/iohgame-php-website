<?php

/**
 * 数据库应用类-c_point
 * @author Kinsama
 * @version 2018-12-11
 */
class IohPointEntity
{
    const POINT_TYPE_REGISTER = "0";
    const POINT_TYPE_SIGNIN = "1";
    const POINT_TYPE_SITE_SERVICE = "2";
    const POINT_TYPE_COMPENSATE = "3";
    const POINT_TYPE_BIRTHDAY = "4";

    public static function getEntityName()
    {
        return 'c_point';
    }

    public static function getReasonCodeList()
    {
        return array(
            self::POINT_TYPE_REGISTER => "注册奖励活动",
            self::POINT_TYPE_SIGNIN => "签到",
            self::POINT_TYPE_SITE_SERVICE => "站内服务",
            self::POINT_TYPE_COMPENSATE => "系统补偿",
            self::POINT_TYPE_BIRTHDAY => "生日赠礼"
        );
    }
}
?>