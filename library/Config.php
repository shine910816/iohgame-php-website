<?php

/**
 * 配置控制器
 * @author Kinsama
 * @version 2017-08-02
 */
class Config
{

    public static function getAllowedCurrent()
    {
        $list_data = array();
        $result = array();
        $result["common"]["home"] = SYSTEM_AUTH_COMMON;
        $result["common"]["error"] = SYSTEM_AUTH_COMMON;
        $result["common"]["calendar"] = SYSTEM_AUTH_COMMON;
        $result["user"]["login"] = SYSTEM_AUTH_COMMON;
        $result["user"]["register"] = SYSTEM_AUTH_COMMON;
        $result["user"]["getback_password"] = SYSTEM_AUTH_COMMON;
        $result["user"]["disp"] = SYSTEM_AUTH_LOGIN;
        $result["user"]["change_nick"] = SYSTEM_AUTH_LOGIN;
        $result["user"]["change_info"] = SYSTEM_AUTH_LOGIN;
        $result["user"]["pocket"] = SYSTEM_AUTH_LOGIN;
        $result["user"]["point_history"] = SYSTEM_AUTH_LOGIN;
        $result["user"]["safety"] = SYSTEM_AUTH_LOGIN;
        $result["user"]["change_password"] = SYSTEM_AUTH_LOGIN;
        $result["user"]["bind_tele"] = SYSTEM_AUTH_LOGIN;
        $result["user"]["bind_mail"] = SYSTEM_AUTH_LOGIN;
        $result["admin"]["top"] = SYSTEM_AUTH_ADMIN;
        $result["event"]["admin_list"] = SYSTEM_AUTH_ADMIN;
        $result["event"]["admin_detail"] = SYSTEM_AUTH_ADMIN;
        $result["event"]["list"] = SYSTEM_AUTH_COMMON;
        $result["event"]["detail"] = SYSTEM_AUTH_COMMON;
        $result["hearth_stone"]["admin_list"] = SYSTEM_AUTH_ADMIN;
        $result["hearth_stone"]["input"] = SYSTEM_AUTH_ADMIN;
        $result["chinese_chess"]["play"] = SYSTEM_AUTH_COMMON;
        $result["onmyouji"]["draw_card"] = SYSTEM_AUTH_COMMON;
        $result["novel"]["disp"] = SYSTEM_AUTH_COMMON;
        $result["novel"]["list"] = SYSTEM_AUTH_COMMON;
        $result["novel"]["content"] = SYSTEM_AUTH_COMMON;
        $result["tool"]["dummy"] = SYSTEM_AUTH_COMMON;
        $result["tool"]["file_chunk"] = SYSTEM_AUTH_COMMON;
        $result["tool"]["java_bean"] = SYSTEM_AUTH_COMMON;
        $result["tool"]["java_bean_cnf"] = SYSTEM_AUTH_COMMON;
        $result["tool"]["trans_object_id"] = SYSTEM_AUTH_ADMIN;
        $result["tool"]["java_dao_create"] = SYSTEM_AUTH_COMMON;
        $result["tool"]["json"] = SYSTEM_AUTH_COMMON;
        $result["mahjong"]["start"] = SYSTEM_AUTH_COMMON;
        $result["mahjong"]["detail"] = SYSTEM_AUTH_COMMON;
        $result["mahjong"]["history"] = SYSTEM_AUTH_COMMON;
        $result["mahjong"]["restart"] = SYSTEM_AUTH_COMMON;
        $result["mahjong_game"]["play"] = SYSTEM_AUTH_COMMON;
        $result["pubg"]["list"] = SYSTEM_AUTH_COMMON;
        $result["pubg"]["list_input"] = SYSTEM_AUTH_ADMIN;
        $result["pubg"]["weapon_list"] = SYSTEM_AUTH_ADMIN;
        $result["pubg"]["weapon_input"] = SYSTEM_AUTH_ADMIN;
        $result["pubg"]["part_list"] = SYSTEM_AUTH_ADMIN;
        $result["pubg"]["part_input"] = SYSTEM_AUTH_ADMIN;
        $result["player_manage"]["add"] = SYSTEM_AUTH_COMMON;
        $result["mrzh"]["item_list"] = SYSTEM_AUTH_COMMON;
        $result["mrzh"]["item_info"] = SYSTEM_AUTH_COMMON;
        $result["mrzh"]["add_item"] = SYSTEM_AUTH_COMMON;
        $result["mrzh"]["item_calculator"] = SYSTEM_AUTH_COMMON;
        $result["sgsgz"]["top"] = SYSTEM_AUTH_COMMON;
        $result["sgsgz"]["card"] = SYSTEM_AUTH_COMMON;
        $result["coupon"]["detail"] = SYSTEM_AUTH_LOGIN;
        $result["nba"]["team_list"] = SYSTEM_AUTH_COMMON;
        $result["nba"]["team_detail"] = SYSTEM_AUTH_COMMON;
        $list_data["php"] = $result;
        $result = array();
        $result["usr_api"]["onmyouji_draw_card"] = SYSTEM_AUTH_COMMON;
        $result["usr_api"]["object_id"] = SYSTEM_AUTH_ADMIN;
        $result["usr_api"]["mahjong_game"] = SYSTEM_AUTH_COMMON;
        $result["usr_api"]["register_present"] = SYSTEM_AUTH_COMMON;
        $result["security"]["send_verify"] = SYSTEM_AUTH_COMMON;
        $list_data["api"] = $result;
        return $list_data;
    }

    public static function getNavigation()
    {
        $result = array();
        $result["common"]["home"] = array();
        $result["user"]["login"] = array("用户登录");
        $result["user"]["disp"] = array("个人信息");
        $result["user"]["change_nick"] = array('<a href="./?menu=user&act=disp">个人信息</a>', "修改昵称");
        $result["user"]["login_history"] = array('<a href="./?menu=user&act=disp">个人信息</a>', "登录记录");
        $result["user"]["point_history"] = array('<a href="./?menu=user&act=disp">个人信息</a>', "积分记录");
        $result["user"]["friend_disp"] = array('<a href="./?menu=user&act=dialog_disp">社区交友</a>', "好友列表");
        $result["user"]["friend_search"] = array('<a href="./?menu=user&act=dialog_disp">社区交友</a>', "查找朋友");
        $result["hearth_stone"]["admin_list"] = array('<a href="./?menu=admin&act=top">后台管理</a>', "炉石传说卡牌");
        $result["hearth_stone"]["input"] = array('<a href="./?menu=admin&act=top">后台管理</a>', '<a href="./?menu=hearth_stone&act=admin_list">炉石传说卡牌</a>', "");
        $result["onmyouji"]["draw_card"] = array("阴阳师抽卡模拟");
        $result["novel"]["disp"] = array("小说阅读");
        $result["novel"]["list"] = array('<a href="./?menu=novel&act=disp">小说阅读</a>', "");
        $result["novel"]["content"] = array('<a href="./?menu=novel&act=disp">小说阅读</a>', "");
        return $result;
    }

    public static function getDataSourceName()
    {
        $list_data = array();
        $result = array();
        $result["host"] = "127.0.0.1";
        $result["user"] = "root";
        $result["pswd"] = "";
        $result["name"] = "wod";
        $result["port"] = "3306";
        $list_data["local"] = $result;
        $result = array();
        $result["host"] = "qdm174930477.my3w.com";
        $result["user"] = "qdm174930477";
        $result["pswd"] = "kinsama317317";
        $result["name"] = "qdm174930477_db";
        $result["port"] = "3306";
        $list_data["server"] = $result;
        return $list_data;
    }

    public static function getUsableGlobalKeys()
    {
        $result = array();
        $result[REDIRECT_URL] = array("user:login");
        $result[USER_CHANGE_NICK] = array("user:change_nick", "coupon:detail");
        $result[USER_GETBACK_PASSWORD] = array("user:getback_password");
        return $result;
    }
}
?>