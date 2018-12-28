<?php

/**
 * 数据库操作类-security_question
 * @author Kinsama
 * @version 2018-12-18
 */
class IohSecurityQuestionDBI
{
    public static function selectByCustomId($custom_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM security_question WHERE del_flg = 0 AND custom_id = " . $custom_id;
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["question_id"]] = $row;
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