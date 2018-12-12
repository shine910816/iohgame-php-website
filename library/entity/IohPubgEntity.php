<?php

/**
 * 数据库应用类-g_pubg_*
 * @author Kinsama
 * @version 2018-08-23
 */
class IohPubgEntity
{

    public static function getWeaponTypeList()
    {
        return array(
            "1" => "手枪",
            "2" => "弩",
            "3" => "霰弹枪",
            "4" => "冲锋枪",
            "5" => "突击步枪",
            "6" => "精准射手步枪",
            "7" => "狙击步枪",
            "8" => "轻机枪"
        );
    }

    public static function getPartTypeList()
    {
        return array(
            "1" => "上轨道",
            "2" => "枪口",
            "3" => "下轨道",
            "4" => "弹夹",
            "5" => "枪托",
            "6" => "弹药"
        );
    }
}
?>