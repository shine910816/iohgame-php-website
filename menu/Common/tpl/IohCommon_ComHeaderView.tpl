<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="{^$system_page_keyword^}" />
<meta name="description" content="{^$system_page_description^}" />
<title>{^$page_title^}</title>
<link rel="shortcut icon" type="image/x-icon" href="img/ico/favicon.ico"/>
<link rel="stylesheet" href="css/common/common.css" type="text/css" />
<link rel="stylesheet" href="css/common/common_font.css" type="text/css" />
<link rel="stylesheet" href="css/common/common_header.css" type="text/css" />
<link rel="stylesheet" href="css/font-awesome.css" type="text/css" />
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript">var m_language_selected = "{^$language_code^}";</script>
<script type="text/javascript" src="js/object_id.js"></script>
</head>
<body>
{^include file=$testbox_file^}
<div class="header-area bx_sh">
<div class="top-box">
<div class="language-select">
  <a href="javascript:void(0)" data-language="cn" class="language-selected" data-object-id="9A8D78BD-58AE-A139-3EFC-03BC69CEC484"></a>
  <a href="javascript:void(0)" data-language="en" class="language-selected" data-object-id="69A67E85-DC8D-37DB-26E5-4E93A8731EEF"></a>
  <a href="javascript:void(0)" data-language="ja" class="language-selected" data-object-id="91B37302-6882-BF80-2EAD-372282AF01BF"></a>
</div>
<div class="user-disp">
  {^$display_custom_nick^}
{^if $user_login_flg^}
  <a href="./?menu=user&act=disp" target="_blank" data-object-id="1F3298DE-330A-0DDB-8051-BBC5504C3E07"></a>
  <a href="./?menu=user&act=login&do_logout=1" data-object-id="0323DE4F-66A1-700E-2173-E9BCDCE02715"></a>
{^else^}
  <a href="./?menu=user&act=login" data-object-id="ABA4A99B-EF21-0307-3CEF-3D7CDCE81AFB"></a>
  <a href="./?menu=user&act=getback_password" target="_blank" data-object-id="66E99113-7A42-5E68-E8B9-981F23709066"></a>
  <a href="./?menu=user&act=register" target="_blank" data-object-id="0BA75836-39A2-74C4-34BB-E6EF797115A4"></a>
{^/if^}
</div>
</div>
<div class="page-logo-bar">
  <div class="main-logo">
    <a href="./"><img alt="main-logo" width="72px" height="72px" src="img/common/logo.png" /></a>
  </div>
  <div class="sub-logo">
      <div class="website-title-1 tx_sh">永恒荣耀</div>
      <div class="website-title-2 tx_sh">Infinity of Honor</div>
    </div>
</div>
<div class="quick-nav">
{^foreach from=$main_module item=main_module_info^}
  <a href="{^$main_module_info["link_url"]^}">{^$main_module_info["disp_name"]^}</a>
{^/foreach^}
{^if $test_mode_info['auth_level'] eq 3^}
  <a href="./?menu=admin&act=top">后台管理</a>
{^/if^}
</div>
</div>
