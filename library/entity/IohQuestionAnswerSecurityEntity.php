<?php

/**
 * 数据库应用类-question_answer_security
 * @author Kinsama
 * @version 2018-08-23
 */
class IohQuestionAnswerSecurityEntity
{

    public static function getEntityName()
    {
        return 'question_answer_security';
    }

    public static function getQuestions()
    {
        return array(
            "1" => "您出生的城市？",
            "2" => "您父亲的生日？",
            "3" => "您母亲的生日？",
            "4" => "您最喜欢的书？",
            "5" => "您最喜欢的电影？",
            "6" => "您最喜欢的明星？",
            "7" => "您爱人的名字？"
        );
    }
}
?>