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
            )
        );
    }

    public static function getCountryList()
    {
        return array(
            "Argentina" => "阿根廷",
            "Australia" => "澳大利亚",
            "Austria" => "奥地利",
            "Bahamas" => "巴哈马",
            //"Bosnia and Herzegovina" => "波斯尼亚和黑塞哥维那",
            "Bosnia and Herzegovina" => "波黑",
            "Brazil" => "巴西",
            "Cameroon" => "喀麦隆",
            "Canada" => "加拿大",
            "China" => "中国",
            "Croatia" => "克罗地亚",
            "Czech Republic" => "捷克",
            "Democratic Republic of the Congo" => "刚果(金)",
            "Dominican Republic" => "多米尼克",
            "Egypt" => "埃及",
            "Finland" => "芬兰",
            "France" => "法国",
            "Georgia" => "格鲁吉亚",
            "Germany" => "德国",
            "Greece" => "希腊",
            "Guadeloupe" => "瓜德罗普",
            "Haiti" => "海地",
            "Israel" => "以色列",
            "Italy" => "意大利",
            "Jamaica" => "牙买加",
            "Japan" => "日本",
            "Latvia" => "拉脱维亚",
            "Lithuania" => "立陶宛",
            "Mali" => "马里",
            "Montenegro" => "黑山",
            "New Zealand" => "新西兰",
            "Nigeria" => "尼日利亚",
            "Puerto Rico" => "波多黎各",
            "Russia" => "俄罗斯",
            "Senegal" => "塞内加尔",
            "Serbia" => "塞尔维亚",
            "Slovenia" => "斯洛文尼亚",
            "South Sudan" => "南苏丹",
            "Spain" => "西班牙",
            "Sudan" => "苏丹",
            "Sweden" => "瑞典",
            "Switzerland" => "瑞士",
            "Tunisia" => "突尼斯",
            "Turkey" => "土耳其",
            "Ukraine" => "乌克兰",
            "United Kingdom" => "英国",
            "USA" => "美国",
            "Venezuela" => "委内瑞拉"
        );
    }

    public static function getArenaList()
    {
        return array(
            "American Airlines Center" => "美航中心",
            "AmericanAirlines Arena" => "美国航空球场",
            "Amway Center" => "安利中心",
            "AT&T Center" => "AT&T中心球馆",
            "Bankers Life Fieldhouse" => "班克斯人寿球馆",
            "Barclays Center" => "巴克莱中心",
            "Capital One Arena" => "第一资本球馆",
            "Chase Center" => "大通中心",
            "Chesapeake Energy Arena" => "切萨皮克能源球场",
            "FedExForum" => "联邦快递体育馆",
            "FedEx Forum" => "联邦快递体育馆",
            "Fiserv Forum" => "费哲球馆",
            "Golden 1 Center" => "黄金一号中心",
            "Little Caesars Arena" => "奥本山宫殿球场",
            "Madison Square Garden" => "麦迪逊广场花园",
            "Moda Center" => "摩达中心",
            "ORACLE Arena" => "甲骨文球馆",
            "Pepsi Center" => "百事中心球馆",
            "Quicken Loans Arena" => "速贷球馆",
            "Rocket Mortgage FieldHouse" => "速贷球馆",
            "Scotiabank Arena" => "丰业银行球馆",
            "Smoothie King Center" => "冰沙国王中心",
            "Spectrum Center" => "光谱中心",
            "Staples Center" => "斯台普斯中心",
            "State Farm Arena" => "州立农业保险球馆",
            "Talking Stick Resort Arena" => "托金斯迪克度假酒店球馆",
            "Target Center" => "标靶中心",
            "TD Garden" => "北岸花园球馆",
            "Toyota Center" => "丰田中心球馆",
            "United Center" => "联合中心球馆",
            "Vivint Smart Home Arena" => "威英特智能家居球馆",
            "Wells Fargo Center" => "富国银行中心",
            "Saitama Super Arena" => "琦玉超级球馆",
            "Mercedes-Benz Arena" => "梅赛德斯奔驰中心",
            "Shenzhen Universiade Center" => "深圳大运中心"
        );
    }
}
?>