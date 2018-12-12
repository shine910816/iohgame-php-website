<?php

/**
 * 数据库操作类-c_file
 * @author Kinsama
 * @version 2018-02-11
 */
class IohCFileDBI
{

    /**
     * 获取类型列表
     *
     * @return array or object
     */
    public static function getFileList($file_id = null)
    {
        $dbi = Database::getInstance();
        $where = "`del_flg` = 0";
        if (!is_null($file_id)) {
            if (!is_array($file_id)) {
                $file_id = array(
                    $file_id
                );
            }
            $where .= " AND `file_id` IN (" . implode(", ", $file_id) . ")";
        }
        $sql = sprintf("SELECT `file_id`" . ", `file_name_upload`" . ", `file_md5`" . ", `file_extension`" . ", `file_type`" . ", `file_subpath`" . ", `insert_date`" . " FROM `c_file`" . " WHERE %s" . " ORDER BY `insert_date` DESC", $where);
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $insert_date_ts = strtotime($row["insert_date"]);
            $display_date = date("H:i", $insert_date_ts);
            if (date("Ymd", $insert_date_ts) < date("Ymd")) {
                $display_date = date("Y-m-d", $insert_date_ts);
            }
            $row['display_date'] = $display_date;
            if (!is_null($file_id)) {
                $data[$row["file_id"]] = $row;
            } else {
                $data[] = $row;
            }
        }
        $result->free();
        return $data;
    }

    /**
     * 插入c_file
     *
     * @param array $insert_data 插入数据
     * @return int or object
     */
    public static function insertCFile($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("c_file", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>