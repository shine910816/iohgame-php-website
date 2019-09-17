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
    <td colspan="11">
      <a href="./?menu=admin&act=top" style="color:#000;">返回</a>
      <a href="./?menu=wow_secret&act=input" style="color:#000;">添加物品</a>
      <a href="./?menu=wow_secret&act=admin_weapon_list" style="color:#000;">武器列表</a>
      <a href="./?menu=wow_secret&act=admin_enable_list" style="color:#000;">检索设定</a>
    </td>
  </tr>
  <tr>
    <th>名称</th>
    <th style="width:75px;">类型</th>
    <th style="width:45px;">力量</th>
    <th style="width:45px;">敏捷</th>
    <th style="width:45px;">智力</th>
    <th style="width:45px;">耐力</th>
    <th style="width:45px;">爆击</th>
    <th style="width:45px;">急速</th>
    <th style="width:45px;">全能</th>
    <th style="width:45px;">精通</th>
    <th>来源</th>
  </tr>
{^if !empty($item_info_list)^}
{^assign var="tr_num" value="1"^}
{^foreach from=$item_info_list key=item_id item=item_info^}
  <tr{^if $tr_num^} bgcolor="#DDDDDD"{^/if^}>
    <td><a href="./?menu=wow_secret&act=input&item_id={^$item_id^}" id="{^$item_id^}" class="item_name_{^if $item_info["boss_id"] eq $hylight_boss_id^}hylight{^else^}common{^/if^}">{^$item_info["item_name"]^}</a></td>
    <td style="text-align:center;">{^$class_position_type_list[$item_info["item_class"]][$item_info["item_position"]][$item_info["item_type"]]^}</td>
    <td class="porp_num" style="color:#C69B6D;">{^if $item_info["item_strength"] gt 0^}{^$item_info["item_strength"]^}{^/if^}</td>
    <td class="porp_num" style="color:#1EFF00;">{^if $item_info["item_agility"] gt 0^}{^$item_info["item_agility"]^}{^/if^}</td>
    <td class="porp_num" style="color:#68CCEF;">{^if $item_info["item_intellect"] gt 0^}{^$item_info["item_intellect"]^}{^/if^}</td>
    <td class="porp_num" style="color:#F0EBE0;">{^if $item_info["item_stamina"] gt 0^}{^$item_info["item_stamina"]^}{^/if^}</td>
    <td class="porp_num" style="color:#FF7C0A;">{^if $item_info["item_critical"] gt 0^}{^$item_info["item_critical"]^}{^/if^}</td>
    <td class="porp_num" style="color:#FFF468;">{^if $item_info["item_haste"] gt 0^}{^$item_info["item_haste"]^}{^/if^}</td>
    <td class="porp_num" style="color:#2359FF;">{^if $item_info["item_versatility"] gt 0^}{^$item_info["item_versatility"]^}{^/if^}</td>
    <td class="porp_num" style="color:#9382C9;">{^if $item_info["item_mastery"] gt 0^}{^$item_info["item_mastery"]^}{^/if^}</td>
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