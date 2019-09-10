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

    const ITEM_POSITION_0 = "0";
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

    const ITEM_TYPE_0 = "0";
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
                self::ITEM_TYPE_10 => "弓",
                self::ITEM_TYPE_11 => "弩",
                self::ITEM_TYPE_12 => "枪械",
                self::ITEM_TYPE_13 => "魔杖",
                self::ITEM_TYPE_14 => "板甲",
                self::ITEM_TYPE_15 => "锁甲",
                self::ITEM_TYPE_16 => "皮甲",
                self::ITEM_TYPE_17 => "布甲"
            )
        );
    }

    public static function getWeaponList()
    {
        return array(
            "双手" => array(
                array(
                    "name" => "双手剑",
                    "position" => self::ITEM_POSITION_1,
                    "type" => self::ITEM_TYPE_1
                ),
                array(
                    "name" => "双手锤",
                    "position" => self::ITEM_POSITION_1,
                    "type" => self::ITEM_TYPE_2
                ),
                array(
                    "name" => "双手斧",
                    "position" => self::ITEM_POSITION_1,
                    "type" => self::ITEM_TYPE_3
                ),
                array(
                    "name" => "法杖",
                    "position" => self::ITEM_POSITION_1,
                    "type" => self::ITEM_TYPE_4
                ),
                array(
                    "name" => "长柄武器",
                    "position" => self::ITEM_POSITION_1,
                    "type" => self::ITEM_TYPE_5
                )
            ),
            "单手" => array(
                array(
                    "name" => "单手剑",
                    "position" => self::ITEM_POSITION_2,
                    "type" => self::ITEM_TYPE_1
                ),
                array(
                    "name" => "单手锤",
                    "position" => self::ITEM_POSITION_2,
                    "type" => self::ITEM_TYPE_2
                ),
                array(
                    "name" => "单手斧",
                    "position" => self::ITEM_POSITION_2,
                    "type" => self::ITEM_TYPE_3
                ),
                array(
                    "name" => "匕首",
                    "position" => self::ITEM_POSITION_2,
                    "type" => self::ITEM_TYPE_6
                ),
                array(
                    "name" => "拳套",
                    "position" => self::ITEM_POSITION_2,
                    "type" => self::ITEM_TYPE_7
                ),
                array(
                    "name" => "战刃",
                    "position" => self::ITEM_POSITION_2,
                    "type" => self::ITEM_TYPE_8
                )
            ),
            "副手" => array(
                array(
                    "name" => "副手物品",
                    "position" => self::ITEM_POSITION_3,
                    "type" => self::ITEM_TYPE_0
                ),
                array(
                    "name" => "盾牌",
                    "position" => self::ITEM_POSITION_3,
                    "type" => self::ITEM_TYPE_9
                )
            ),
            "远程" => array(
                array(
                    "name" => "弓",
                    "position" => self::ITEM_POSITION_4,
                    "type" => self::ITEM_TYPE_10
                ),
                array(
                    "name" => "弩",
                    "position" => self::ITEM_POSITION_4,
                    "type" => self::ITEM_TYPE_11
                ),
                array(
                    "name" => "枪械",
                    "position" => self::ITEM_POSITION_4,
                    "type" => self::ITEM_TYPE_12
                ),
                array(
                    "name" => "魔杖",
                    "position" => self::ITEM_POSITION_4,
                    "type" => self::ITEM_TYPE_13
                ),
            )
        );
    }

    public static function getEquitList()
    {
        return array(
            "头部" => array(
                array(
                    "name" => "板甲头部",
                    "position" => self::ITEM_POSITION_5,
                    "type" => self::ITEM_TYPE_14
                ),
                array(
                    "name" => "锁甲头部",
                    "position" => self::ITEM_POSITION_5,
                    "type" => self::ITEM_TYPE_15
                ),
                array(
                    "name" => "皮甲头部",
                    "position" => self::ITEM_POSITION_5,
                    "type" => self::ITEM_TYPE_16
                ),
                array(
                    "name" => "布甲头部",
                    "position" => self::ITEM_POSITION_5,
                    "type" => self::ITEM_TYPE_17
                )
            ),
            "肩部" => array(
                array(
                    "name" => "板甲肩部",
                    "position" => self::ITEM_POSITION_6,
                    "type" => self::ITEM_TYPE_14
                ),
                array(
                    "name" => "锁甲肩部",
                    "position" => self::ITEM_POSITION_6,
                    "type" => self::ITEM_TYPE_15
                ),
                array(
                    "name" => "皮甲肩部",
                    "position" => self::ITEM_POSITION_6,
                    "type" => self::ITEM_TYPE_16
                ),
                array(
                    "name" => "布甲肩部",
                    "position" => self::ITEM_POSITION_6,
                    "type" => self::ITEM_TYPE_17
                )
            ),
            "背部" => array(
                array(
                    "name" => "背部",
                    "position" => self::ITEM_POSITION_7,
                    "type" => self::ITEM_TYPE_0
                )
            ),
            "胸部" => array(
                array(
                    "name" => "板甲胸部",
                    "position" => self::ITEM_POSITION_8,
                    "type" => self::ITEM_TYPE_14
                ),
                array(
                    "name" => "锁甲胸部",
                    "position" => self::ITEM_POSITION_8,
                    "type" => self::ITEM_TYPE_15
                ),
                array(
                    "name" => "皮甲胸部",
                    "position" => self::ITEM_POSITION_8,
                    "type" => self::ITEM_TYPE_16
                ),
                array(
                    "name" => "布甲胸部",
                    "position" => self::ITEM_POSITION_8,
                    "type" => self::ITEM_TYPE_17
                )
            ),
            "腕部" => array(
                array(
                    "name" => "板甲腕部",
                    "position" => self::ITEM_POSITION_9,
                    "type" => self::ITEM_TYPE_14
                ),
                array(
                    "name" => "锁甲腕部",
                    "position" => self::ITEM_POSITION_9,
                    "type" => self::ITEM_TYPE_15
                ),
                array(
                    "name" => "皮甲腕部",
                    "position" => self::ITEM_POSITION_9,
                    "type" => self::ITEM_TYPE_16
                ),
                array(
                    "name" => "布甲腕部",
                    "position" => self::ITEM_POSITION_9,
                    "type" => self::ITEM_TYPE_17
                )
            ),
            "手" => array(
                array(
                    "name" => "板甲手",
                    "position" => self::ITEM_POSITION_10,
                    "type" => self::ITEM_TYPE_14
                ),
                array(
                    "name" => "锁甲手",
                    "position" => self::ITEM_POSITION_10,
                    "type" => self::ITEM_TYPE_15
                ),
                array(
                    "name" => "皮甲手",
                    "position" => self::ITEM_POSITION_10,
                    "type" => self::ITEM_TYPE_16
                ),
                array(
                    "name" => "布甲手",
                    "position" => self::ITEM_POSITION_10,
                    "type" => self::ITEM_TYPE_17
                )
            ),
            "腰部" => array(
                array(
                    "name" => "板甲腰部",
                    "position" => self::ITEM_POSITION_11,
                    "type" => self::ITEM_TYPE_14
                ),
                array(
                    "name" => "锁甲腰部",
                    "position" => self::ITEM_POSITION_11,
                    "type" => self::ITEM_TYPE_15
                ),
                array(
                    "name" => "皮甲腰部",
                    "position" => self::ITEM_POSITION_11,
                    "type" => self::ITEM_TYPE_16
                ),
                array(
                    "name" => "布甲腰部",
                    "position" => self::ITEM_POSITION_11,
                    "type" => self::ITEM_TYPE_17
                )
            ),
            "腿部" => array(
                array(
                    "name" => "板甲腿部",
                    "position" => self::ITEM_POSITION_12,
                    "type" => self::ITEM_TYPE_14
                ),
                array(
                    "name" => "锁甲腿部",
                    "position" => self::ITEM_POSITION_12,
                    "type" => self::ITEM_TYPE_15
                ),
                array(
                    "name" => "皮甲腿部",
                    "position" => self::ITEM_POSITION_12,
                    "type" => self::ITEM_TYPE_16
                ),
                array(
                    "name" => "布甲腿部",
                    "position" => self::ITEM_POSITION_12,
                    "type" => self::ITEM_TYPE_17
                )
            ),
            "脚" => array(
                array(
                    "name" => "板甲脚",
                    "position" => self::ITEM_POSITION_13,
                    "type" => self::ITEM_TYPE_14
                ),
                array(
                    "name" => "锁甲脚",
                    "position" => self::ITEM_POSITION_13,
                    "type" => self::ITEM_TYPE_15
                ),
                array(
                    "name" => "皮甲脚",
                    "position" => self::ITEM_POSITION_13,
                    "type" => self::ITEM_TYPE_16
                ),
                array(
                    "name" => "布甲脚",
                    "position" => self::ITEM_POSITION_13,
                    "type" => self::ITEM_TYPE_17
                )
            ),
            "手指" => array(
                array(
                    "name" => "手指",
                    "position" => self::ITEM_POSITION_14,
                    "type" => self::ITEM_TYPE_0
                )
            ),
            "饰品" => array(
                array(
                    "name" => "饰品",
                    "position" => self::ITEM_POSITION_15,
                    "type" => self::ITEM_TYPE_0
                )
            )
        );
    }
}
?>