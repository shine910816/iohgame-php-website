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

    const DIVISION_ATLANTIC = "1";
    const DIVISION_CENTERAL = "2";
    const DIVISION_SOUTHEAST = "3";
    const DIVISION_NORTHWEST = "4";
    const DIVISION_PACIFIC = "5";
    const DIVISION_SOUTHWEST = "6";

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
}
?>