<?php

/**
 * 数据库操作类-c_novel_article
 * @author Kinsama
 * @version 2017-08-23
 */
class IohCNovelArticleDBI
{

    /**
     * 根据小说ID获取小说篇章列表
     *
     * @param int $n_id 小说ID
     * @return array or object
     */
    public static function getNovelArticle($n_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM `c_novel_article` WHERE `n_id` = ";
        $sql .= $dbi->quote($n_id);
        $sql .= " AND `del_flg` = 0 ORDER BY `n_article_id` ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['n_article_id']] = $row;
        }
        $result->free();
        return $data;
    }

    /**
     * 插入c_novel_article
     *
     * @param array $insert_data 插入数据
     * @return int or object
     */
    public static function insertCNovelArticle($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert(IohCNovelArticleEntity::getEntityName(), $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    /**
     * 编辑c_novel_article
     *
     * @param int $n_id 小说ID
     * @param int $n_article_id 小说章节数
     * @param array $update_data 编辑数据
     * @return int or object
     */
    public static function updateCNovelArticle($n_id, $n_article_id, $update_data)
    {
        $dbi = Database::getInstance();
        $where = '`n_id` = ' . $dbi->quote($n_id);
        $where .= " AND `n_article_id` = " . $dbi->quote($n_article_id);
        $result = $dbi->update(IohCNovelArticleEntity::getEntityName(), $update_data, $where);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>