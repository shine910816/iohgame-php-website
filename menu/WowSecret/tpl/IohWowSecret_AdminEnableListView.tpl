<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>大秘境装备</title>
<link rel="shortcut icon" type="image/x-icon" href="img/ico/favicon.ico"/>
<link rel="stylesheet" href="css/wow/talents.css" type="text/css" />
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
.tr_hylight {
  background-color: #FFF;
}
.tr_hylight:hover {
  background-color: #CCC!important;
}
.talent_icon_box {
  width:16px;
  height:16px;
  border:5px solid #AAA;
  border-radius:5px;
  display:block;
}
.talent_icon_box input {
  display:none;
}
.talent_icon_box_checked {
  border-color:#F60!important;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
    $("input.talent_enable_option").change(function(){
        //alert($(this).parent().html());
        if ($(this).prop("checked")) {
            $(this).parent().addClass("talent_icon_box_checked");
        } else {
            $(this).parent().removeClass("talent_icon_box_checked");
        }
    });
});
</script>
</head>
<body>
<form action="./" method="post">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<input type="hidden" name="type_group" value="{^$type_group^}" />
<input type="hidden" name="duty_group" value="{^$duty_group^}" />
<table class="tb tb_p_03">
  <tr>
    <td>
      <a href="./?menu=wow_secret&act=admin_list" style="color:#000;">返回</a>
      <input type="submit" name="execute" value="提交" />
    </td>
  </tr>
  <tr>
    <td>
{^foreach from=$type_group_list key=type_group_id item=type_group_name^}
{^if $type_group_id eq $type_group^}
      <span>{^$type_group_name^}</span>
{^else^}
      <a href="./?menu=wow_secret&act=admin_enable_list&type_group={^$type_group_id^}&duty_group={^$duty_group^}" style="color:#000;">{^$type_group_name^}</a>
{^/if^}
{^/foreach^}
    </td>
  </tr>
  <tr>
    <td>
{^foreach from=$duty_list key=duty_id item=duty_name^}
{^if $duty_id eq $duty_group^}
      <span>{^$duty_name^}</span>
{^else^}
      <a href="./?menu=wow_secret&act=admin_enable_list&type_group={^$type_group^}&duty_group={^$duty_id^}" style="color:#000;">{^$duty_name^}</a>
{^/if^}
{^/foreach^}
    </td>
  </tr>
</table><br/>
<table class="tb tb_p_03" style="width:1000px;">
  <tr>
    <th rowspan="2" style="width:200px;">名称</th>
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
{^foreach from=$classes_talents_item key=enable_index item=talent_name^}
{^assign var="enable_key" value="item_enable_"|cat:$enable_index|cat:"_flg"^}
    <th style="width:60px;">{^$talent_name^}<input type="hidden" name="enable_flg_list[]" value = "{^$enable_key^}" /></th>
{^/foreach^}
{^/foreach^}
  </tr>
{^foreach from=$item_info_list key=item_id item=item_info^}
  <tr class="tr_hylight">
    <td>{^$item_info["item_name"]^}<input type="hidden" name="item_id_list[]" value="{^$item_id^}" /></td>
    <td>{^$type_list[$item_info["item_class"]][$item_info["item_position"]][$item_info["item_type"]]^}</td>
    <td>{^if $item_info["item_strength"] gt 0^}{^$item_info["item_strength"]^}{^/if^}</td>
    <td>{^if $item_info["item_agility"] gt 0^}{^$item_info["item_agility"]^}{^/if^}</td>
    <td>{^if $item_info["item_intellect"] gt 0^}{^$item_info["item_intellect"]^}{^/if^}</td>
{^foreach from=$talents_list key=classes_id item=classes_talents_item^}
{^foreach from=$classes_talents_item key=enable_index item=tmp^}
{^assign var="enable_key" value="item_enable_"|cat:$enable_index|cat:"_flg"^}
    <td><label class="talent_icon_box{^if $item_info[$enable_key]^} talent_icon_box_checked{^/if^}"><input type="checkbox" name="enable_info[{^$item_id^}][{^$enable_key^}]" value="1" class="talent_enable_option"{^if $item_info[$enable_key]^} checked{^/if^} /><div class="talent_icon talent_icon_16 talent_16_{^$enable_index^}"></div></label></td>
{^/foreach^}
{^/foreach^}
  </tr>
{^/foreach^}
</table>
</form>
</body>
</html>