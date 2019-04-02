<?php

/**
 * 数据库应用类-g_nba_*
 * @author Kinsama
 * @version 2019-01-30
 */
class IohNbaEntity
{
    const CONFERENCE_EASTERN = "1";
    const CONFERENCE_WESTERN = "2";

    const DIVISION_SOUTHEAST = "1";
    const DIVISION_ATLANTIC = "2";
    const DIVISION_CENTERAL = "3";
    const DIVISION_SOUTHWEST = "4";
    const DIVISION_PACIFIC = "5";
    const DIVISION_NORTHWEST = "6";

    public static function getConferenceList()
    {
        return array(
            "cn" => array(
                self::CONFERENCE_EASTERN => "东部联盟",
                self::CONFERENCE_WESTERN => "西部联盟"
            ),
            "en" => array(
                self::CONFERENCE_EASTERN => "Eastern",
                self::CONFERENCE_WESTERN => "Western"
            ),
            "ja" => array(
                self::CONFERENCE_EASTERN => "イースタン",
                self::CONFERENCE_WESTERN => "ウェスタン"
            )
        );
    }

    public static function getDivisionList()
    {
        return array(
            "cn" => array(
                self::DIVISION_ATLANTIC => "大西洋分区",
                self::DIVISION_CENTERAL => "中央分区",
                self::DIVISION_SOUTHEAST => "东南分区",
                self::DIVISION_NORTHWEST => "西北分区",
                self::DIVISION_PACIFIC => "太平洋分区",
                self::DIVISION_SOUTHWEST => "西南分区"
            ),
            "en" => array(
                self::DIVISION_ATLANTIC => "Atlantic",
                self::DIVISION_CENTERAL => "Centeral",
                self::DIVISION_SOUTHEAST => "Southeast",
                self::DIVISION_NORTHWEST => "Northwest",
                self::DIVISION_PACIFIC => "Pacific",
                self::DIVISION_SOUTHWEST => "Southwest"
            ),
            "ja" => array(
                self::DIVISION_ATLANTIC => "アトランティック",
                self::DIVISION_CENTERAL => "セントラル",
                self::DIVISION_SOUTHEAST => "サウスイースト",
                self::DIVISION_NORTHWEST => "ノースウェスト",
                self::DIVISION_PACIFIC => "パシフィック",
                self::DIVISION_SOUTHWEST => "サウスウェスト"
            )
        );
    }

    public static function getCountryList()
    {
        return array(
            "0" => "(空)",
            "1" => "美国",
            "2" => "澳大利亚",
            "3" => "奥地利",
            "4" => "巴哈马",
            "5" => "波斯尼亚和黑塞哥维那",
            "6" => "巴西",
            "7" => "喀麦隆",
            "8" => "加拿大",
            "9" => "中国",
            "10" => "克罗地亚",
            "11" => "捷克",
            "12" => "刚果(金)",
            "13" => "多米尼克",
            "14" => "埃及",
            "15" => "芬兰",
            "16" => "法国",
            "17" => "格鲁吉亚",
            "18" => "德国",
            "19" => "希腊",
            "20" => "海地",
            "21" => "意大利",
            "22" => "日本",
            "23" => "拉脱维亚",
            "24" => "立陶宛",
            "25" => "马里",
            "26" => "黑山",
            "27" => "新西兰",
            "28" => "尼日利亚",
            "29" => "波多黎各",
            "30" => "俄罗斯",
            "31" => "塞内加尔",
            "32" => "塞尔维亚",
            "33" => "斯洛文尼亚",
            "34" => "南苏丹",
            "35" => "西班牙",
            "36" => "苏丹",
            "37" => "瑞典",
            "38" => "瑞士",
            "39" => "突尼斯",
            "40" => "土耳其",
            "41" => "乌克兰",
            "42" => "英国"
        );
    }
}
?>