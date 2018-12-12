<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>天津麻将记分器</title>
<link rel="shortcut icon" type="image/x-icon" href="img/ico/favicon.ico"/>
<link rel="stylesheet" href="css/sp/common.css?{^$ts^}" type="text/css" />
<link rel="stylesheet" href="css/common/common_font.css" type="text/css" />
<link rel="stylesheet" href="css/font-awesome.css" type="text/css" />
<link rel="stylesheet" href="css/mahjong/start.css?{^$ts^}" type="text/css" />
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="js/mahjong/start.js?{^$ts^}"></script>
</head>
<body>
<form class="top_box" id="top_box" method="post" action="./">
  <input type="hidden" name="menu" value="{^$current_menu^}" />
  <input type="hidden" name="act" value="{^$current_act^}" />
  <div class="top_title" id="new_game_box">开一局</div>
  <ul class="top_box_cols">
    <li class="top_box_cols_name">名称</li>
    <li class="top_box_cols_detail">
      <input class="top_box_cols_text" type="text" name="m_name" />
    </li>
  </ul>
  <ul class="top_box_cols">
    <li class="top_box_cols_name">底番</li>
    <li class="top_box_cols_detail">
      <input class="top_box_cols_text" type="text" name="m_point" value="50" />
    </li>
  </ul>
  <ul class="top_box_cols">
    <li class="top_box_cols_name">东</li>
    <li class="top_box_cols_detail">
      <input class="top_box_cols_text" type="text" name="m_player[1]" />
    </li>
  </ul>
  <ul class="top_box_cols">
    <li class="top_box_cols_name">南</li>
    <li class="top_box_cols_detail">
      <input class="top_box_cols_text" type="text" name="m_player[2]" />
    </li>
  </ul>
  <ul class="top_box_cols">
    <li class="top_box_cols_name">西</li>
    <li class="top_box_cols_detail">
      <input class="top_box_cols_text" type="text" name="m_player[3]" />
    </li>
  </ul>
  <ul class="top_box_cols">
    <li class="top_box_cols_name">北</li>
    <li class="top_box_cols_detail">
      <input class="top_box_cols_text" type="text" name="m_player[4]" />
    </li>
  </ul>
  <div class="top_button_box">
    <label>
      <span class="top_button">确定</span>
      <input type="submit" name="start" value="1" />
    </label>
  </div>
</form>
<div class="buttom_box">
  <ul class="buttom_box_button_cols">
    <li><a class="buttom_button{^if !$history_flg^} button_selected{^/if^}" href="./?menu=mahjong&act=start">进行中</a></li>
    <li><a class="buttom_button{^if $history_flg^} button_selected{^/if^}" href="./?menu=mahjong&act=start&history=1">已结束</a></li>
  </ul>
{^if !empty($gaming_list)^}
{^foreach from=$gaming_list key=m_id item=m_info^}
<a href="./?menu=mahjong&act={^if $history_flg^}history{^else^}detail{^/if^}&m_id={^$m_id^}" class="list_item">{^$m_info["m_name"]^}</a>
{^/foreach^}
{^/if^}
</div>
<div class="footer"></div>
</body>
</html>