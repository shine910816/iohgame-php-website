<?php

/**
 * 数据库操作类-c_novel_type
 * @author Kinsama
 * @version 2017-08-23
 */
class IohCNovelTypeDBI
{

    /**
     * 获取类型列表
     *
     * @return array or object
     */
    public static function getNovelType()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT `n_type`, `n_type_name` FROM `c_novel_type` WHERE `del_flg` = 0";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['n_type']] = $row['n_type_name'];
        }
        $result->free();
        return $data;
    }

    /**
     * 插入c_novel_type
     *
     * @param array $insert_data 插入数据
     * @return int or object
     */
    public static function insertCNovelType($insert_data)
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
     * 编辑c_novel_type
     *
     * @param int $n_type 分类编号
     * @param array $update_data 编辑数据
     * @return int or object
     */
    public static function updateCNovelType($n_type, $update_data)
    {
        $dbi = Database::getInstance();
        $where = '`n_id` = ' . $n_id;
        $result = $dbi->update(IohCNovelEntity::getEntityName(), $update_data, $where);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>