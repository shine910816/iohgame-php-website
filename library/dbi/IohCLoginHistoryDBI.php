<?php

/**
 * 数据库操作类-c_login_history
 * @author Kinsama
 * @version 2017-01-08
 */
class IohCLoginHistoryDBI
{

    /**
     * 插入一条登录信息
     *
     * @param int $cus_id 用户ID
     * @param string $cus_ip_address 用户IP地址
     * @return int or object
     */
    public static function insertLoginHistory($cus_id, $cus_ip_address)
    {
        $dbi = Database::getInstance();
        $insert_data = array(
            'cus_id' => $cus_id,
            'cus_ip_address' => $cus_ip_address
        );
        $result = $dbi->insert(IohCLoginHistoryEntity::getEntityName(), $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function getCustomerLoginInfo($cus_ip_address)
    {
        $dbi = Database::getInstance();
        $cus_ip_address = $dbi->quote($cus_ip_address);
        $sql = sprintf("SELECT" . " `cus_id`," . " MAX(`insert_date`) AS `last_date`" . " FROM" . " `c_login_history`" . " WHERE" . " `cus_ip_address` = %s" . " AND `del_flg` = 0" . " GROUP BY `cus_id`", $cus_ip_address);
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['cus_id']] = $row['last_date'];
        }
        $result->free();
        arsort($data);
        return $data;
    }

    public static function getLoginHistoryByCusId($cus_id)
    {
        $dbi = Database::getInstance();
        $cus_id = $dbi->quote($cus_id);
        $sql = sprintf("SELECT" . " `his_id`," . " `cus_id`," . " `cus_ip_address`," . " `insert_date`" . " FROM `c_login_history`" . " WHERE `cus_id` = %s" . " AND `del_flg` = 0" . " ORDER BY `insert_date` DESC", $cus_id);
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['his_id']] = $row;
        }
        $result->free();
        return $data;
    }
}
?>