<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="keywords" content="{^$system_page_keyword^}" />
<meta name="description" content="{^$system_page_description^}" />
<link type="text/css" rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<style type="text/css">
.ui-li-static.ui-collapsible > .ui-collapsible-heading {
  margin: 0;
}
.ui-li-static.ui-collapsible {
  padding: 0;
}
.ui-li-static.ui-collapsible > .ui-collapsible-heading > .ui-btn {
  border-top-width: 0;
}
.ui-li-static.ui-collapsible > .ui-collapsible-heading.ui-collapsible-heading-collapsed > .ui-btn,
.ui-li-static.ui-collapsible > .ui-collapsible-content {
  border-bottom-width: 0;
}
</style>
</head>
<body>
<div data-role="page">
<div data-role="panel" id="leftpanel" data-display="reveal">
  <ul data-role="listview" data-shadow="false">
    <li><a href="./" class="ui-btn ui-btn-icon-right ui-icon-home" data-ajax="false">首页</a></li>
    <li data-role="collapsible" data-iconpos="right" data-inset="false">
      <h2>站内导航</h2>
      <ul data-role="listview" data-theme="b">
{^foreach from=$main_module item=main_module_info^}
        <li><a href="{^$main_module_info["link_url"]^}" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-ajax="false">{^$main_module_info["disp_name"]^}</a></li>
{^/foreach^}
      </ul>
    </li>
    <li data-role="collapsible" data-iconpos="right" data-inset="false">
      <h2>用户管理</h2>
      <ul data-role="listview" data-theme="b">
{^if $user_login_flg^}
        <li><a href="./?menu=user&act=disp" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-ajax="false">{^$display_custom_nick^}</a></li>
        <li><a href="./?menu=user&act=login&do_logout=1" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-ajax="false">用户注销</a></li>
{^else^}
        <li><a href="./?menu=user&act=login" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-ajax="false">用户登录</a></li>
        <li><a href="./?menu=user&act=register" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-ajax="false">用户注册</a></li>
        <li><a href="./?menu=user&act=getback_password" class="ui-btn ui-btn-icon-right ui-icon-carat-r" data-ajax="false">忘记密码</a></li>
{^/if^}
      </ul>
    </li>
  </ul>
</div>
{^if $subpanel_file neq ""^}
{^include file=$subpanel_file^}
{^/if^}
<div data-role="header" data-tap-toggle="false" data-position="fixed">
  <h1><a href="#leftpanel" class="ui-nodisc-icon ui-alt-icon ui-btn-left ui-btn ui-icon-bars ui-btn-icon-notext ui-corner-all">{^$page_title^}</a></h1>
</div>
<div data-role="content">
