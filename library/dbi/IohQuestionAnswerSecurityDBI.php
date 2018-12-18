<?php

/**
 * 数据库操作类-question_answer_security
 * @author Kinsama
 * @version 2018-12-18
 */
class IohQuestionAnswerSecurityDBI
{
    public static function selectByCustomId($custom_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM question_answer_security WHERE del_flg = 0 AND custom_id = " . $custom_id;
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
        $result = $dbi->insert("question_answer_security", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function unsetByCustomId($custom_id)
    {
        $dbi = Database::getInstance();
        $result = $dbi->delete("question_answer_security", "custom_id = " . $custom_id);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>