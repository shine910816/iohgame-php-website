<?php

/**
 * 数据库操作类-c_point_history
 * @author Kinsama
 * @version 2017-01-18
 */
class IohCPointHistoryDBI
{

    /**
     * 插入一条积分信息
     *
     * @param int $cus_id 用户ID
     * @param int $point 积分数量
     * @param int $reason_cd 理由
     * @return int or object
     */
    public static function insertPointHistory($cus_id, $point, $reason_cd)
    {
        $dbi = Database::getInstance();
        $insert_data = array(
            'cus_id' => $cus_id,
            'point' => $point,
            'reason_cd' => $reason_cd
        );
        $result = $dbi->insert(IohCPointHistoryEntity::getEntityName(), $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function getPointInfoGroupByCusId($cus_id)
    {
        $dbi = Database::getInstance();
        if (!is_array($cus_id)) {
            $cus_id = array(
                $cus_id
            );
        }
        $cus_id_list = implode(", ", $dbi->quote($cus_id));
        $sql = sprintf("SELECT" . " `cus_id`," . " SUM(`point`) AS `point`" . " FROM" . " `c_point_history`" . " WHERE" . " `cus_id` IN (%s)" . " AND `del_flg` = 0" . " GROUP BY `cus_id`", $cus_id_list);
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['cus_id']] = $row['point'];
        }
        $result->free();
        return $data;
    }

    public static function getPointInfoByCusId($cus_id)
    {
        $dbi = Database::getInstance();
        $cus_id = $dbi->quote($cus_id);
        $sql = sprintf("SELECT" . " `point_id`," . " `cus_id`," . " `point`," . " `reason_cd`," . " `insert_date`" . " FROM" . " `c_point_history`" . " WHERE" . " `cus_id` = %s" . " AND `del_flg` = 0" . " ORDER BY `insert_date` DESC", $cus_id);
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['point_id']] = $row;
        }
        $result->free();
        return $data;
    }
}
?>