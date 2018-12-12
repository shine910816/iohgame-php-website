<?php

/**
 * 数据库操作类-data_object_id
 * @author Kinsama
 * @version 2018-07-05
 */
class IohDataObjectIdDBI
{

    public static function selectObjectId($object_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT `object_id` FROM `data_object_id` WHERE `del_flg` = 0 AND `object_id` = " . $dbi->quote($object_id);
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['object_id']] = $row['object_id'];
        }
        $result->free();
        return $data;
    }

    public static function getObjectIdList()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM `data_object_id` WHERE `del_flg` = 0";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['o_id']] = $row;
        }
        $result->free();
        return $data;
    }

    public static function getObjectIdListByLanguage($language)
    {
        $dbi = Database::getInstance();
        $lang = "";
        if ($language == 1) {
            $lang = "o_en";
        } elseif ($language == 2) {
            $lang = "o_ja";
        } else {
            $lang = "o_cn";
        }
        $sql = "SELECT `object_id`, `" . $lang . "` FROM `data_object_id` WHERE `del_flg` = 0";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['object_id']] = $row[$lang];
        }
        $result->free();
        return $data;
    }

    public static function insertObjectId($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("data_object_id", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function updateObjectId($update_data, $where)
    {
        $dbi = Database::getInstance();
        $result = $dbi->update("data_object_id", $update_data, $where);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>