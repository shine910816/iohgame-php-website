<?php

/**
 * 数据库应用类-g_sgsgz_card_*
 * @author Kinsama
 * @version 2019-01-22
 */
class IohSgsgzCardEntity
{
    const CARD_TYPE_BASIC = "1";
    const CARD_TYPE_EQUIT = "2";
    const CARD_TYPE_MAGIC = "3";

    const EQUIT_TYPE_NONE = "0";
    const EQUIT_TYPE_WEAPON = "1";
    const EQUIT_TYPE_HELMET = "2";
    const EQUIT_TYPE_HORSE = "3";
    const EQUIT_TYPE_TREASURE = "4";
    
    const MAGIC_DELEY_YES = "1";
    const MAGIC_DELEY_NO = "0";

    const RESET_YES = "1";
    const RESET_NO = "0";

    const HORIZ_YES = "1";
    const HORIZ_NO = "0";

    public static function getCardTypeList()
    {
        return array(
            self::CARD_TYPE_BASIC => "基本",
            self::CARD_TYPE_EQUIT => "装备",
            self::CARD_TYPE_MAGIC => "锦囊"
        );
    }

    public static function getEquitTypeList()
    {
        return array(
            self::EQUIT_TYPE_WEAPON => "武器",
            self::EQUIT_TYPE_HELMET => "防具",
            self::EQUIT_TYPE_HORSE => "坐骑",
            self::EQUIT_TYPE_TREASURE => "宝物"
        );
    }

    public static function getSuitNumber($c_suit, $c_number)
    {
        $suit_list = array(
            "1" => "♠",
            "2" => "♥",
            "3" => "♣",
            "4" => "♦"
        );
        $suit_text = $suit_list[$c_suit];
        $number_text = $c_number;
        if ($c_number == "1") {
            $number_text = "A";
        } elseif ($c_number == "11") {
            $number_text = "J";
        } elseif ($c_number == "12") {
            $number_text = "Q";
        } elseif ($c_number == "13") {
            $number_text = "K";
        }
        return $suit_text . $number_text;
    }
}
?>