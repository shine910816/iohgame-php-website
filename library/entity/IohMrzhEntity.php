<?php

/**
 * 数据库应用类-mrzh_item*
 * @author Kinsama
 * @version 2018-11-14
 */
class IohMrzhEntity
{
    const ITEM_QUALITY_COMMON = "0";
    const ITEM_QUALITY_RARE = "1";
    const ITEM_QUALITY_VALUABLE = "2";
    const ITEM_QUALITY_EPIC = "3";
    const ITEM_QUALITY_LEGEND = "4";

    public static function getColorList()
    {
        return array(
            "item_quality" => array(
                self::ITEM_QUALITY_COMMON => "FFFFFF",
                self::ITEM_QUALITY_RARE => "1EFF00",
                self::ITEM_QUALITY_VALUABLE => "0081FF",
                self::ITEM_QUALITY_EPIC => "C600FF",
                self::ITEM_QUALITY_LEGEND => "FF8000"
            )
        );
    }

    public static function getNameList()
    {
        return array(
            "item_quality" => array(
                self::ITEM_QUALITY_COMMON => "普通",
                self::ITEM_QUALITY_RARE => "珍稀",
                self::ITEM_QUALITY_VALUABLE => "贵重",
                self::ITEM_QUALITY_EPIC => "史诗",
                self::ITEM_QUALITY_LEGEND => "传说"
            ),
            "item_class" => array(
                "1" => "基础材料",
                "2" => "建筑",
                "3" => "武器",
                "4" => "护甲",
                "5" => "生存"
            ),
            "item_type" => array(
                "1" => array(
                    "1" => "木材",
                    "2" => "石料",
                    "3" => "麻类",
                    "4" => "掉落",
                    "5" => "食材",
                    "6" => "出售"
                ),
                "2" => array(
                    "1" => "建筑半成品",
                    "2" => "建筑结构",
                    "3" => "建筑家具",
                    "4" => "建筑防御",
                    "5" => "建筑强化"
                ),
                "3" => array(
                    "1" => "武器半成品",
                    "2" => "武器成品",
                    "3" => "武器插件"
                ),
                "4" => array(
                    "1" => "护甲半成品",
                    "2" => "护甲成品",
                    "3" => "护甲插件"
                ),
                "5" => array(
                    "1" => "工具",
                    "2" => "恢复",
                    "3" => "渔具"
                )
            ),
            "item_food_type" => array(
                "0" => "无分类",
                "1" => "肉",
                "2" => "水果",
                "3" => "蘑菇",
                "4" => "蔬菜",
                "5" => "蜂蜜",
                "6" => "面粉",
                "7" => "牛奶",
                "8" => "草鱼",
                "9" => "鲤鱼",
                "10" => "鲶鱼"
            )
        );
    }
}
?>