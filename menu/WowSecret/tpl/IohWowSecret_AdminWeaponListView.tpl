<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>大秘境装备</title>
<link rel="shortcut icon" type="image/x-icon" href="img/ico/favicon.ico"/>
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<style type="text/css">
table.tb {
  border-collapse:collapse;
  border-top:1px solid #AAA;
  border-left:1px solid #AAA;
}
table.tb tr th {
  border-bottom:1px solid #AAA;
  border-right:1px solid #AAA;
  text-align:center;
  white-space:nowrap;
  padding:1px;
  cursor:default;
  background-color:#555;
  color:#FFF;
}
table.tb tr td {
  border-bottom:1px solid #AAA;
  border-right:1px solid #AAA;
  text-align:left;
  word-break:break-all;
  padding:1px;
}
table.tb_p_03 tr th,
table.tb_p_03 tr td {
  padding:3px!important;
}
.porp_num {
  text-shadow:1px 1px 1px #000;
  text-align:center!important;
}
.item_name_common,
.item_name_hylight {
  text-shadow:1px 1px 1px #000;
}
.item_name_common {
  color:#000;
}
.item_name_hylight {
  color:#F60;
}
</style>
</head>
<body>
<table class="tb tb_p_03">
  <tr>
    <td colspan="7">
      <a href="./?menu=wow_secret&act=admin_list" style="color:#000;">返回</a>
    </td>
  </tr>
  <tr>
    <th>名称</th>
    <th style="width:75px;">类型</th>
    <th style="width:60px;">最小值</th>
    <th style="width:60px;">最大值</th>
    <th style="width:60px;">速度</th>
    <th style="width:60px;">秒伤</th>
    <th>来源</th>
  </tr>
{^if !empty($weapon_item_list)^}
{^assign var="tr_num" value="1"^}
{^foreach from=$weapon_item_list key=item_id item=item_info^}
  <tr{^if $tr_num^} bgcolor="#DDDDDD"{^/if^}>
    <td><a href="./?menu=wow_secret&act=weapon_input&item_id={^$item_id^}" id="{^$item_id^}" class="item_name_{^if $item_info["boss_id"] eq $hylight_boss_id^}hylight{^else^}common{^/if^}">{^$item_info["item_name"]^}</a></td>
    <td style="text-align:center;">{^$class_position_type_list[$item_info["item_class"]][$item_info["item_position"]][$item_info["item_type"]]^}</td>
{^if isset($weapon_info_list[$item_id])^}
    <td style="text-align:center;">{^$weapon_info_list[$item_id]["min"]^}</td>
    <td style="text-align:center;">{^$weapon_info_list[$item_id]["max"]^}</td>
    <td style="text-align:center;">{^$weapon_info_list[$item_id]["spd"]^}</td>
    <td style="text-align:center;">{^$weapon_info_list[$item_id]["dps"]^}</td>
{^else^}
    <td colspan="4" style="text-align:center;">未登录</td>
{^/if^}
    <td>{^$boss_info_list[$item_info["boss_id"]]["map_name"]^}-{^$boss_info_list[$item_info["boss_id"]]["boss_name"]^}</td>
  </tr>
{^if $tr_num^}
{^assign var="tr_num" value="0"^}
{^else^}
{^assign var="tr_num" value="1"^}
{^/if^}
{^/foreach^}
{^/if^}
</table>
</body>
</html>