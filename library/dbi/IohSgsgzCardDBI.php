<?php

/**
 * 数据库操作类-g_sgsgz_card_*
 * @author Kinsama
 * @version 2019-01-22
 */
class IohSgsgzCardDBI
{
    public static function selectCardType()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM g_sgsgz_card_type WHERE del_flg = 0";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["card_type"]][$row["card_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function insert($custom_id, $question_id, $answer)
    {
        $dbi = Database::getInstance();
        $insert_data = array();
        $insert_data["custom_id"] = $custom_id;
        $insert_data["question_id"] = $question_id;
        $insert_data["answer"] = $answer;
        $result = $dbi->insert("security_question", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>