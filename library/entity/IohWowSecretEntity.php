<?php

/**
 * 数据库应用类-g_wow_secret_*
 * @author Kinsama
 * @version 2019-09-08
 */
class IohWowSecretEntity
{
    const ITEM_CLASS_0 = "0";
    const ITEM_CLASS_1 = "1";
    const ITEM_CLASS_2 = "2";

    const ITEM_POSITION_1 = "1";
    const ITEM_POSITION_2 = "2";
    const ITEM_POSITION_3 = "3";
    const ITEM_POSITION_4 = "4";

    const ITEM_POSITION_5 = "5";
    const ITEM_POSITION_6 = "6";
    const ITEM_POSITION_7 = "7";
    const ITEM_POSITION_8 = "8";
    const ITEM_POSITION_9 = "9";
    const ITEM_POSITION_10 = "10";
    const ITEM_POSITION_11 = "11";
    const ITEM_POSITION_12 = "12";
    const ITEM_POSITION_13 = "13";
    const ITEM_POSITION_14 = "14";
    const ITEM_POSITION_15 = "15";

    const ITEM_TYPE_1 = "1";
    const ITEM_TYPE_2 = "2";
    const ITEM_TYPE_3 = "3";
    const ITEM_TYPE_4 = "4";
    const ITEM_TYPE_5 = "5";
    const ITEM_TYPE_6 = "6";
    const ITEM_TYPE_7 = "7";
    const ITEM_TYPE_8 = "8";
    const ITEM_TYPE_9 = "9";
    const ITEM_TYPE_10 = "10";
    const ITEM_TYPE_11 = "11";
    const ITEM_TYPE_12 = "12";
    const ITEM_TYPE_13 = "13";
    const ITEM_TYPE_14 = "14";
    const ITEM_TYPE_15 = "15";
    const ITEM_TYPE_16 = "16";
    const ITEM_TYPE_17 = "17";
    const ITEM_TYPE_18 = "18";

    public static function getVolumnName()
    {
        return array(
            "class" => array(
                self::ITEM_CLASS_0 => "坐骑",
                self::ITEM_CLASS_1 => "武器",
                self::ITEM_CLASS_2 => "装备"
            ),
            "position" => array(
            
                self::ITEM_POSITION_1 => "双手",
                self::ITEM_POSITION_2 => "单手",
                self::ITEM_POSITION_3 => "副手",
                self::ITEM_POSITION_4 => "远程",
                self::ITEM_POSITION_5 => "头部",
                self::ITEM_POSITION_6 => "肩部",
                self::ITEM_POSITION_7 => "背部",
                self::ITEM_POSITION_8 => "胸部",
                self::ITEM_POSITION_9 => "腕部",
                self::ITEM_POSITION_10 => "手",
                self::ITEM_POSITION_11 => "腰部",
                self::ITEM_POSITION_12 => "腿部",
                self::ITEM_POSITION_13 => "脚",
                self::ITEM_POSITION_14 => "手指",
                self::ITEM_POSITION_15 => "饰品"
            ),
            "type" => array(
                self::ITEM_TYPE_1 => "剑",
                self::ITEM_TYPE_2 => "锤",
                self::ITEM_TYPE_3 => "斧",
                self::ITEM_TYPE_4 => "法杖",
                self::ITEM_TYPE_5 => "长柄武器",
                self::ITEM_TYPE_6 => "匕首",
                self::ITEM_TYPE_7 => "拳套",
                self::ITEM_TYPE_8 => "战刃",
                self::ITEM_TYPE_9 => "盾牌",
                self::ITEM_TYPE_10 => "副手物品",
                self::ITEM_TYPE_11 => "弓",
                self::ITEM_TYPE_12 => "弩",
                self::ITEM_TYPE_13 => "枪械",
                self::ITEM_TYPE_14 => "魔杖",
                self::ITEM_TYPE_15 => "板甲",
                self::ITEM_TYPE_16 => "锁甲",
                self::ITEM_TYPE_17 => "皮甲",
                self::ITEM_TYPE_18 => "布甲"
            )
        );
    }
}
?>