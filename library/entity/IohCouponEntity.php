<?php

/**
 * 数据库应用类-c_coupon
 * @author Kinsama
 * @version 2018-12-11
 */
class IohCouponEntity
{
    const COUPON_FAVOUR_QUANTITY = "0";
    const COUPON_FAVOUR_PERCENT = "1";
    const COUPON_FAVOUR_EACH_OFF = "2";

    const COUPON_APPLY_RANGE_TOTAL = "0";
    const COUPON_APPLY_RANGE_CHANGENICK = "1";

    const COUPON_APPLY_YES = "1";
    const COUPON_APPLY_NO = "0";

    public static function getEntityName()
    {
        return 'c_coupon';
    }

    public static function getVolumnName()
    {
        return array();
    }
}
?>