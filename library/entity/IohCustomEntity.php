<?php

/**
 * 数据库应用类-custom
 * @author Kinsama
 * @version 2018-12-11
 */
class IohCustomEntity
{
    const TELE_CONFIRM_YES = "1";
    const TELE_CONFIRM_NO = "0";

    const MAIL_CONFIRM_YES = "1";
    const MAIL_CONFIRM_NO = "0";

    const CUSTOM_GENDER_MALE = "1";
    const CUSTOM_GENDER_FEMALE = "0";

    const CUSTON_INFO_CONFIRM_YES = "1";
    const CUSTON_INFO_CONFIRM_NO = "0";

    const CUSTOM_OPEN_LEVEL_TOTAL = "2";
    const CUSTOM_OPEN_LEVEL_FRIEND = "1";
    const CUSTOM_OPEN_LEVEL_SELF = "0";

    public static function getEntityName()
    {
        return 'custom_login';
    }

    public static function getVolumnName()
    {
        return array();
    }
}
?>