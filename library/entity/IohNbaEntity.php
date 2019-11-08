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
                self::CONFERENCE_EASTERN => "东部",
                self::CONFERENCE_WESTERN => "西部"
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
                self::DIVISION_ATLANTIC => "大西洋",
                self::DIVISION_CENTERAL => "中央",
                self::DIVISION_SOUTHEAST => "东南",
                self::DIVISION_NORTHWEST => "西北",
                self::DIVISION_PACIFIC => "太平洋",
                self::DIVISION_SOUTHWEST => "西南"
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
            "AmericanAirlines Arena" => "美国航空球馆",
            "Amway Center" => "安利中心",
            "AT&T Center" => "AT&T中心",
            "Bankers Life Fieldhouse" => "班克斯人寿球馆",
            "Barclays Center" => "巴克莱中心",
            "Capital One Arena" => "第一资本球馆",
            "Chase Center" => "大通中心",
            "Chesapeake Energy Arena" => "切萨皮克球馆",
            "FedExForum" => "联邦快递球馆",
            "FedEx Forum" => "联邦快递球馆",
            "Fiserv Forum" => "费哲球馆",
            "Golden 1 Center" => "黄金一号中心",
            "Little Caesars Arena" => "奥本山宫殿球馆",
            "Madison Square Garden" => "麦迪逊广场花园",
            "Moda Center" => "摩达中心",
            "ORACLE Arena" => "甲骨文球馆",
            "Pepsi Center" => "百事中心",
            "Quicken Loans Arena" => "速贷球馆",
            "Rocket Mortgage FieldHouse" => "火箭典当中心",
            "Scotiabank Arena" => "丰业银行球馆",
            "Smoothie King Center" => "冰沙国王中心",
            "Spectrum Center" => "光谱中心",
            "Staples Center" => "斯台普斯中心",
            "State Farm Arena" => "农业保险球馆",
            "Talking Stick Resort Arena" => "托金斯迪克球馆",
            "Target Center" => "标靶中心",
            "TD Garden" => "北岸花园",
            "Toyota Center" => "丰田中心",
            "United Center" => "联合中心",
            "Vivint Smart Home Arena" => "威英特球馆",
            "Wells Fargo Center" => "富国银行中心",
            "Saitama Super Arena" => "琦玉超级球馆",
            "Mercedes-Benz Arena" => "梅赛德斯奔驰中心",
            "Shenzhen Universiade Center" => "深圳大运中心"
        );
    }

    public static function getNameAlphabet()
    {
        $index_str = "#ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $result = array();
        for ($i = 0; $i < strlen($index_str); $i++) {
            $result[] = substr($index_str, $i, 1);
        }
        return $result;
    }

    public static function getCoachName()
    {
        return array(
            "Lloyd Pierce" => "劳埃德-皮尔斯",
            "Brad Stevens" => "布拉德-史蒂文斯",
            "John Beilein" => "约翰-贝莱茵",
            "Alvin Gentry" => "阿尔文-金特里",
            "Jim Boylen" => "吉姆-博伊伦",
            "Rick Carlisle" => "里克-卡莱尔",
            "Michael Malone" => "迈克尔-马龙",
            "Steve Kerr" => "史蒂夫-科尔",
            "Mike D'Antoni" => "迈克-德安东尼",
            "Doc Rivers" => "道格-里弗斯",
            "Frank Vogel" => "弗兰克-沃格尔",
            "Erik Spoelstra" => "埃里克-斯波尔斯特拉",
            "Mike Budenholzer" => "迈克-布登霍尔泽",
            "Ryan Saunders" => "莱恩-桑德斯",
            "Kenny Atkinson" => "肯尼-阿特金森",
            "David Fizdale" => "大卫-菲兹戴尔",
            "Steve Clifford" => "史蒂夫-克利福德",
            "Nate McMillan" => "内特-麦克米兰",
            "Brett Brown" => "布雷特-布朗",
            "Monty Williams" => "蒙蒂-威廉姆斯",
            "Terry Stotts" => "特里-斯托茨",
            "Luke Walton" => "卢克-沃顿",
            "Gregg Popovich" => "格雷格-波波维奇",
            "Billy Donovan" => "比利-多诺万",
            "Nick Nurse" => "尼克-纳斯",
            "Quin Snyder" => "奎因-斯奈德",
            "Taylor Jenkins" => "泰勒-詹金斯",
            "Scott Brooks" => "斯科特-布鲁克斯",
            "Dwane Casey" => "德维恩-凯西",
            "James Borrego" => "詹姆斯-博雷戈"
        );
    }

    public static function getArenaCoachName()
    {
        return array(
            1610612737 => array(
                "arena" => "State Farm Arena",
                "coach" => "Lloyd Pierce"
            ),
            1610612738 => array(
                "arena" => "TD Garden",
                "coach" => "Brad Stevens"
            ),
            1610612739 => array(
                "arena" => "Rocket Mortgage FieldHouse",
                "coach" => "John Beilein"
            ),
            1610612740 => array(
                "arena" => "Smoothie King Center",
                "coach" => "Alvin Gentry"
            ),
            1610612741 => array(
                "arena" => "United Center",
                "coach" => "Jim Boylen"
            ),
            1610612742 => array(
                "arena" => "American Airlines Center",
                "coach" => "Rick Carlisle"
            ),
            1610612743 => array(
                "arena" => "Pepsi Center",
                "coach" => "Michael Malone"
            ),
            1610612744 => array(
                "arena" => "Chase Center",
                "coach" => "Steve Kerr"
            ),
            1610612745 => array(
                "arena" => "Toyota Center",
                "coach" => "Mike D'Antoni"
            ),
            1610612746 => array(
                "arena" => "Staples Center",
                "coach" => "Doc Rivers"
            ),
            1610612747 => array(
                "arena" => "Staples Center",
                "coach" => "Frank Vogel"
            ),
            1610612748 => array(
                "arena" => "AmericanAirlines Arena",
                "coach" => "Erik Spoelstra"
            ),
            1610612749 => array(
                "arena" => "Fiserv Forum",
                "coach" => "Mike Budenholzer"
            ),
            1610612750 => array(
                "arena" => "Target Center",
                "coach" => "Ryan Saunders"
            ),
            1610612751 => array(
                "arena" => "Barclays Center",
                "coach" => "Kenny Atkinson"
            ),
            1610612752 => array(
                "arena" => "Madison Square Garden",
                "coach" => "David Fizdale"
            ),
            1610612753 => array(
                "arena" => "Amway Center",
                "coach" => "Steve Clifford"
            ),
            1610612754 => array(
                "arena" => "Bankers Life Fieldhouse",
                "coach" => "Nate McMillan"
            ),
            1610612755 => array(
                "arena" => "Wells Fargo Center",
                "coach" => "Brett Brown"
            ),
            1610612756 => array(
                "arena" => "Talking Stick Resort Arena",
                "coach" => "Monty Williams"
            ),
            1610612757 => array(
                "arena" => "Moda Center",
                "coach" => "Terry Stotts"
            ),
            1610612758 => array(
                "arena" => "Golden 1 Center",
                "coach" => "Luke Walton"
            ),
            1610612759 => array(
                "arena" => "AT&T Center",
                "coach" => "Gregg Popovich"
            ),
            1610612760 => array(
                "arena" => "Chesapeake Energy Arena",
                "coach" => "Billy Donovan"
            ),
            1610612761 => array(
                "arena" => "Scotiabank Arena",
                "coach" => "Nick Nurse"
            ),
            1610612762 => array(
                "arena" => "Vivint Smart Home Arena",
                "coach" => "Quin Snyder"
            ),
            1610612763 => array(
                "arena" => "FedExForum",
                "coach" => "Taylor Jenkins"
            ),
            1610612764 => array(
                "arena" => "Capital One Arena",
                "coach" => "Scott Brooks"
            ),
            1610612765 => array(
                "arena" => "Little Caesars Arena",
                "coach" => "Dwane Casey"
            ),
            1610612766 => array(
                "arena" => "Spectrum Center",
                "coach" => "James Borrego"
            )
        );
    }
}
?>