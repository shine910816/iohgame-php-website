<?php

/**
 * 数据库操作类-c_novel
 * @author Kinsama
 * @version 2017-08-22
 */
class IohCNovelDBI
{

    /**
     * 根据ID获取小说信息
     *
     * @param int $n_id 小说ID
     * @return array or object
     */
    public static function getNovelInfoByNId($n_id)
    {
        $dbi = Database::getInstance();
        if (!is_array($n_id)) {
            $n_id = array(
                $n_id
            );
        }
        $n_id_str = implode(", ", $dbi->quote($n_id));
        $sql = sprintf("SELECT *" . " FROM `%s`" . " WHERE `n_id` IN (%s)" . " AND `del_flg` = 0", IohCNovelEntity::getEntityName(), $n_id_str);
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['n_id']] = $row;
        }
        $result->free();
        return $data;
    }

    /**
     * 根据类型获取小说列表
     *
     * @param int $n_type 类型
     * @return array or object
     */
    public static function getNovelByType($n_type = null)
    {
        $dbi = Database::getInstance();
        $where = "";
        if (!is_null($n_type)) {
            if (!is_array($n_type)) {
                $n_type = array(
                    $n_type
                );
            }
            $where = " AND `n_type` IN (" . implode(", ", $n_type) . ")";
        }
        $sql = sprintf("SELECT *" . " FROM `%s`" . " WHERE `del_flg` = 0" . "%s" . " ORDER BY `update_date` DESC", IohCNovelEntity::getEntityName(), $where);
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        $limit_date_ts = mktime(0, 0, 0, date("n"), date("j") - NOVEL_NEW_DISP_DAY, date("Y"));
        while ($row = $result->fetch_assoc()) {
            $data[$row['n_id']] = $row;
            $new_flg = 0;
            if (strtotime($row['update_date']) >= $limit_date_ts) {
                $new_flg = 1;
            }
            $data[$row['n_id']]['new_flg'] = $new_flg;
        }
        $result->free();
        return $data;
    }

    /**
     * 插入c_novel
     *
     * @param array $insert_data 插入数据
     * @return int or object
     */
    public static function insertCNovel($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert(IohCNovelEntity::getEntityName(), $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    /**
     * 编辑c_novel
     *
     * @param int $n_id 小说ID
     * @param array $update_data 编辑数据
     * @return int or object
     */
    public static function updateCNovel($n_id, $update_data)
    {
        $dbi = Database::getInstance();
        $where = '`n_id` = ' . $dbi->quote($n_id);
        $result = $dbi->update(IohCNovelEntity::getEntityName(), $update_data, $where);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>