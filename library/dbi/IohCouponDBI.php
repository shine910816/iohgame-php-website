<?php

/**
 * 数据库操作类-c_coupon
 * @author Kinsama
 * @version 2017-12-11
 */
class IohCouponDBI
{
    public static function selectCoupon($custom_id, $use_date, $coupon_apply_range = null)
    {
        $dbi = Database::getInstance();
        $where = " WHERE del_flg = 0";
        $use_datetime = new DateTime($use_date);
        $where .= " AND coupon_vaildity_start <= \"" . $use_datetime->format("Y-m-d H:i:s");
        $where .= "\" AND coupon_vaildity_expiry >= \"" . $use_datetime->format("Y-m-d H:i:s");
        $where .= "\" AND custom_id = " . $custom_id;
        $where .= " AND coupon_apply_flg = " . IohCouponEntity::COUPON_APPLY_NO;
        $apply_range_arr = array();
        if (!is_null($coupon_apply_range)) {
            if (!is_array($coupon_apply_range)) {
                $coupon_apply_range = array($coupon_apply_range);
            }
            $apply_range_arr = $coupon_apply_range;
        }
        if (!in_array(IohCouponEntity::COUPON_APPLY_RANGE_TOTAL, $apply_range_arr)) {
            $apply_range_arr[] = IohCouponEntity::COUPON_APPLY_RANGE_TOTAL;
        }
        $where .= " AND coupon_apply_range IN (" . implode(", ", $apply_range_arr) . ")";
        $order = " ORDER BY coupon_vaildity_expiry ASC";
        $sql = "SELECT * FROM c_coupon" . $where . $order;
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["coupon_number"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectCouponNumberByDay($publish)
    {
        $dbi = Database::getInstance();
        $publish_date = new DateTime($publish);
        $start_datetime = mktime(
            0, 0, 0,
            $publish_date->format("n"), $publish_date->format("j"), $publish_date->format("Y")
        );
        $end_datetime = mktime(
            0, 0, -1,
            $publish_date->format("n"), $publish_date->format("j") + 1, $publish_date->format("Y")
        );
        $sql = sprintf(
            "SELECT * FROM c_coupon WHERE del_flg = 0 AND coupon_publish_date >= \"%s\" AND coupon_publish_date <= \"%s\"",
            date("Y-m-d H:i:s", $start_datetime),
            date("Y-m-d H:i:s", $end_datetime)
        );
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["coupon_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectCouponHistory($custom_id, $coupon_apply_range = null)
    {
        $dbi = Database::getInstance();
        $where = " WHERE del_flg = 0 AND custom_id = " . $custom_id;
        if (!is_null($coupon_apply_range)) {
            if (!is_array($coupon_apply_range)) {
                $coupon_apply_range = array($coupon_apply_range);
            }
            $where .= " AND coupon_apply_range IN (" . implode(", ", $coupon_apply_range) . ")";
        }
        $sql = "SELECT coupon_number, custom_id, coupon_apply_range, insert_date FROM c_coupon_history" . $where;
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["coupon_number"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function insertCoupon($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("c_coupon", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function updateCoupon($update_data, $where)
    {
        $dbi = Database::getInstance();
        $result = $dbi->update("c_coupon", $update_data, $where);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function insertRegisterCouponPresent($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("c_coupon_history", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>