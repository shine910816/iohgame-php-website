<?php

class IohTool_DBI
{

    public static function insertIndex($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("dummy_data_index", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function insertContent($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("dummy_data_content", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function selectMaster($data_id = null)
    {
        $dbi = Database::getInstance();
        $where = " WHERE del_flg = 0";
        if (is_null($data_id)) {
            $where .= " ORDER BY insert_date DESC";
        } else {
            if (!is_array($data_id)) {
                $data_id = array(
                    $data_id
                );
            }
            $where .= " AND data_id IN (" . implode(", ", $data_id) . ")";
        }
        $sql = "SELECT data_id," . " months," . " group_id," . " group_name," . " store_code," . " store_name," . " insert_date" . " FROM dummy_data_index";
        $sql .= $where;
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $row['creat_time'] = date("m-d H:i:s", strtotime($row['insert_date']));
            $data[$row['data_id']] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectMonthsAggregate($data_id)
    {
        $dbi = Database::getInstance();
        if (!is_array($data_id)) {
            $data_id = array(
                $data_id
            );
        }
        $sql = "SELECT gender_code," . " generation_e_code," . " exist_code," . " SUM(invest_uu_num) AS invest_uu_num," . " SUM(invest_card_num) AS invest_card_num," . " SUM(purchase_amount) AS purchase_amount," . " SUM(invest_num) AS invest_num," . " SUM(invest_point) AS invest_point," . " SUM(use_uu_num) AS use_uu_num," . " SUM(use_num) AS use_num," . " SUM(use_point) AS use_point," . " SUM(use_term_point) AS use_term_point," . " data_id" . " FROM" . " dummy_data_content" . " WHERE" . " del_flg = 0" . " AND data_id IN ( " . implode(", ", $data_id) . " ) GROUP BY data_id," . " gender_code," . " generation_e_code," . " exist_code" . " ORDER BY" . " data_id," . " exist_code," . " gender_code," . " generation_e_code";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectDailyAggregate($data_id)
    {
        $dbi = Database::getInstance();
        if (!is_array($data_id)) {
            $data_id = array(
                $data_id
            );
        }
        $sql = "SELECT days," . " SUM(invest_uu_num) AS invest_uu_num," . " SUM(invest_card_num) AS invest_card_num," . " SUM(purchase_amount) AS purchase_amount," . " SUM(invest_num) AS invest_num," . " SUM(invest_point) AS invest_point," . " data_id" . " FROM" . " dummy_data_content" . " WHERE del_flg = 0" . " AND data_id IN ( " . implode(", ", $data_id) . " ) GROUP BY data_id, days" . " ORDER BY data_id, days";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectUserAggregate($data_id)
    {
        $dbi = Database::getInstance();
        if (!is_array($data_id)) {
            $data_id = array(
                $data_id
            );
        }
        $sql = "SELECT gender_code," . " generation_e_code," . " SUM(invest_uu_num) AS invest_uu_num," . " SUM(invest_card_num) AS invest_card_num," . " SUM(purchase_amount) AS purchase_amount," . " SUM(invest_num) AS invest_num," . " data_id" . " FROM" . " dummy_data_content" . " WHERE" . " del_flg = 0" . " AND data_id IN ( " . implode(", ", $data_id) . " ) GROUP BY data_id," . " gender_code," . " generation_e_code" . " ORDER BY" . " data_id," . " gender_code," . " generation_e_code";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $result->free();
        return $data;
    }

    public static function getNewDataId()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT COUNT(*) AS `number` FROM `dummy_data_index`";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row['number'];
        }
        $result->free();
        return $data[0] + 1;
    }

    public static function deleteData($data_id)
    {
        $dbi = Database::getInstance();
        if (!is_array($data_id)) {
            $data_id = array(
                $data_id
            );
        }
        $where = "`data_id` IN (" . implode(", ", $data_id) . ")";
        $dbi->begin();
        $result = $dbi->update("dummy_data_index", array(
            "del_flg" => "1"
        ), $where);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            $dbi->rollback();
            return $result;
        }
        $result = $dbi->update("dummy_data_content", array(
            "del_flg" => "1"
        ), $where);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            $dbi->rollback();
            return $result;
        }
        $dbi->commit();
        return true;
    }
}
?>