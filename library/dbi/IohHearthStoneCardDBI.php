<?php

/**
 * 数据库操作类-hearth_stone
 * @author Kinsama
 * @version 2017-03-05
 */
class IohHearthStoneCardDBI
{

    /**
     * 获取下一个c_id
     *
     * @return int
     */
    public static function getNextCId()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT MAX(`c_id`) FROM `" . IohHearthStoneCardEntity::getEntityName() . "`";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $row = $result->fetch_row();
        $result->free();
        return $row[0] + 1;
    }

    /**
     * 插入卡牌信息
     *
     * @param array $insert_data 卡牌信息
     * @return boolean
     */
    public static function insertCard($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert(IohHearthStoneCardEntity::getEntityName(), $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    /**
     * 修改卡牌信息
     *
     * @param array $c_id 卡牌ID
     * @param array $update_data 卡牌信息
     * @return boolean
     */
    public static function updateCard($c_id, $update_data)
    {
        $dbi = Database::getInstance();
        $where = "`c_id` = " . $dbi->quote($c_id);
        $result = $dbi->update(IohHearthStoneCardEntity::getEntityName(), $update_data, $where);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    /**
     * 获取卡牌信息
     *
     * @param int $c_id 卡牌ID
     * @return array or boolean
     */
    public static function getCardInfoByCId($c_id)
    {
        $dbi = Database::getInstance();
        if (!is_array($c_id)) {
            $c_id = array(
                $c_id
            );
        }
        $c_id_str = implode(", ", $dbi->quote($c_id));
        $volumn_name = IohHearthStoneCardEntity::getVolumnName();
        $volumn_str = implode(", ", $dbi->quote(array_keys($volumn_name), true));
        $sql = sprintf("SELECT %s FROM %s WHERE `c_id` IN (%s) AND `del_flg` = 0", $volumn_str, $dbi->quote(IohHearthStoneCardEntity::getEntityName(), true), $c_id_str);
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['c_id']] = $row;
        }
        $result->free();
        return $data;
    }

    /**
     * 根据职业获取卡牌信息(admin_list用)
     *
     * @param int $c_class 职业
     * @return array or boolean
     */
    public static function getCardInfoByCClassForAdminList($c_class, $disp_mode)
    {
        $dbi = Database::getInstance();
        $c_class = $dbi->quote($c_class);
        $volumn_list = IohHearthStoneCardEntity::getNotNullVolumnName();
        $volumn_str = implode(", ", $dbi->quote($volumn_list['info'], true));
        $where = sprintf("`c_class` = %s AND `del_flg` = 0", $c_class);
        $order_by = "`c_from` DESC, `c_cost` ASC, `c_name` ASC";
        if ($disp_mode) {
            $where .= " AND `c_mode` = 0";
            $order_by = "`c_cost` ASC, `c_name` ASC";
        }
        $sql = sprintf("SELECT %s FROM %s WHERE %s ORDER BY %s", $volumn_str, $dbi->quote(IohHearthStoneCardEntity::getEntityName(), true), $where, $order_by);
        $result = $dbi->query($sql);
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['c_id']] = $row;
        }
        $result->free();
        return $data;
    }
}
?>