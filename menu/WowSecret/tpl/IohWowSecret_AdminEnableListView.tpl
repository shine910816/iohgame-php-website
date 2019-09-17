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
    <td colspan="41">
      <a href="./?menu=wow_secret&act=admin_list" style="color:#000;">返回</a>
    </td>
  </tr>
  <tr>
    <th rowspan="2">名称</th>
    <th rowspan="2" style="width:75px;">类型</th>
    <th colspan="3">主属性</th>
{^foreach from=$talents_list key=classes_id item=classes_talents_item^}
    <th colspan="{^$classes_talents_item|@count^}">{^$classes_list[$classes_id]^}</th>
{^/foreach^}
  </tr>
  <tr>
    <th style="width:60px;">力量</th>
    <th style="width:60px;">敏捷</th>
    <th style="width:60px;">智力</th>
{^foreach from=$talents_list key=classes_id item=classes_talents_item^}
{^foreach from=$classes_talents_item item=talent_name^}
    <th>{^$talent_name^}</th>
{^/foreach^}
{^/foreach^}
  </tr>
{^assign var="tr_num" value="1"^}
{^foreach from=$item_info_list key=item_id item=item_info^}
  <tr{^if $tr_num^} bgcolor="#DDDDDD"{^/if^}>
    <td>{^$item_info["item_name"]^}</td>
    <td>{^$type_list[$item_info["item_class"]][$item_info["item_position"]][$item_info["item_type"]]^}</td>
    <td>{^if $item_info["item_strength"] gt 0^}{^$item_info["item_strength"]^}{^/if^}</td>
    <td>{^if $item_info["item_agility"] gt 0^}{^$item_info["item_agility"]^}{^/if^}</td>
    <td>{^if $item_info["item_intellect"] gt 0^}{^$item_info["item_intellect"]^}{^/if^}</td>
{^foreach from=$talents_list key=classes_id item=classes_talents_item^}
{^foreach from=$classes_talents_item key=enable_index item=tmp^}
{^assign var="enable_key" value="item_enable_"|cat:$enable_index|cat:"_flg"^}
    <td><input type="checkbox" name="enable_info[{^$item_id^}][{^$enable_key^}]" value="1"{^if $item_info[$enable_key]^} checked{^/if^} /></td>
{^/foreach^}
{^/foreach^}
  </tr>
{^if $tr_num^}
{^assign var="tr_num" value="0"^}
{^else^}
{^assign var="tr_num" value="1"^}
{^/if^}
{^/foreach^}
</table>
</body>
</html>