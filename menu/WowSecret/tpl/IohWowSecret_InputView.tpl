<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>大秘境装备</title>
<link rel="shortcut icon" type="image/x-icon" href="img/ico/favicon.ico"/>
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $("input.auto_select").focus(function(){
        $(this).select();
    });
});
</script>
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
</style>
</head>
<body>
<form action="./" method="post">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<table class="tb tb_p_03">
  <tr>
    <th>物品ID</th>
    <td>{^if $update_item_id^}<input type="hidden" name="item_id" value="{^$update_item_id^}" />{^$update_item_id^}{^else^}<input type="text" name="item_info[item_id]" />{^/if^}</td>
    <th>物品名</th>
    <td><input type="text" name="item_info[item_name]" value="{^$item_info["item_name"]^}" /></td>
  </tr>
  <tr>
    <th>物品分类</th>
    <td colspan="3">
{^foreach from=$item_class_list key=class_key item=class_item^}
      <label><input type="radio" name="item_info[item_class]" value="{^$class_key^}"{^if $item_info["item_class"] eq $class_key^} checked{^/if^} />{^$class_item^}</label>
{^/foreach^}
    </td>
  </tr>
  <tr>
    <th>武器类型</th>
    <td>
      <select name="weapon_info">
        <option value="0-0">未选择</option>
{^foreach from=$weapon_list key=weapon_name item=weapon_item^}
        <optgroup label="{^$weapon_name^}">
{^foreach from=$weapon_item item=weapon_info^}
          <option value ="{^$weapon_info["position"]^}-{^$weapon_info["type"]^}"{^if $weapon_info["position"] eq $item_info["item_position"] and $weapon_info["type"] eq $item_info["item_type"]^} selected{^/if^}>{^$weapon_info["name"]^}</option>
{^/foreach^}
        </optgroup>
{^/foreach^}
      </select>
    </td>
    <th>装备类型</th>
    <td>
      <select name="equit_info">
        <option value="0-0">未选择</option>
{^foreach from=$equit_list key=equit_name item=equit_item^}
        <optgroup label="{^$equit_name^}">
{^foreach from=$equit_item item=equit_info^}
          <option value ="{^$equit_info["position"]^}-{^$equit_info["type"]^}"{^if $equit_info["position"] eq $item_info["item_position"] and $equit_info["type"] eq $item_info["item_type"]^} selected{^/if^}>{^$equit_info["name"]^}</option>
{^/foreach^}
        </optgroup>
{^/foreach^}
      </select>
    </td>
  </tr>
  <tr>
    <th>护甲</th>
    <td><input type="text" name="item_info[item_armor]" value="{^$item_info["item_armor"]^}" class="auto_select" /></td>
    <th>格挡</th>
    <td><input type="text" name="item_info[item_block]" value="{^$item_info["item_block"]^}" class="auto_select" /></td>
  </tr>
  <tr>
    <th style="background-color:#C69B6D; text-shadow:1px 1px 1px #000;">力量</th>
    <td><input type="text" name="item_info[item_strength]" value="{^$item_info["item_strength"]^}" class="auto_select" /></td>
    <th style="background-color:#1EFF00; text-shadow:1px 1px 1px #000;">敏捷</th>
    <td><input type="text" name="item_info[item_agility]" value="{^$item_info["item_agility"]^}" class="auto_select" /></td>
  </tr>
  <tr>
    <th style="background-color:#68CCEF; text-shadow:1px 1px 1px #000;">智力</th>
    <td><input type="text" name="item_info[item_intellect]" value="{^$item_info["item_intellect"]^}" class="auto_select" /></td>
    <th style="background-color:#F0EBE0; text-shadow:1px 1px 1px #000;">耐力</th>
    <td><input type="text" name="item_info[item_stamina]" value="{^$item_info["item_stamina"]^}" class="auto_select" /></td>
  </tr>
  <tr>
    <th style="background-color:#FF7C0A; text-shadow:1px 1px 1px #000;">爆击</th>
    <td><input type="text" name="item_info[item_critical]" value="{^$item_info["item_critical"]^}" class="auto_select" /></td>
    <th style="background-color:#FFF468; text-shadow:1px 1px 1px #000;">急速</th>
    <td><input type="text" name="item_info[item_haste]" value="{^$item_info["item_haste"]^}" class="auto_select" /></td>
  </tr>
  <tr>
    <th style="background-color:#2359FF; text-shadow:1px 1px 1px #000;">全能</th>
    <td><input type="text" name="item_info[item_versatility]" value="{^$item_info["item_versatility"]^}" class="auto_select" /></td>
    <th style="background-color:#9382C9; text-shadow:1px 1px 1px #000;">精通</th>
    <td><input type="text" name="item_info[item_mastery]" value="{^$item_info["item_mastery"]^}" class="auto_select" /></td>
  </tr>
  <tr>
    <th>装备效果</th>
    <td colspan="3"><textarea name="item_info[item_equit_effect]">{^$item_info["item_equit_effect"]^}</textarea></td>
  </tr>
  <tr>
    <th>装备效果数字1</th>
    <td><input type="text" name="item_info[item_equit_effect_num]" value="{^$item_info["item_equit_effect_num"]^}" class="auto_select" /></td>
    <th>装备效果数字2</th>
    <td><input type="text" name="item_info[item_equit_effect_num2]" value="{^$item_info["item_equit_effect_num2"]^}" class="auto_select" /></td>
  </tr>
  <tr>
    <th>使用效果</th>
    <td colspan="3"><textarea name="item_info[item_use_effect]">{^$item_info["item_use_effect"]^}</textarea></td>
  </tr>
  <tr>
    <th>使用效果数字1</th>
    <td><input type="text" name="item_info[item_use_effect_num]" value="{^$item_info["item_use_effect_num"]^}" class="auto_select" /></td>
    <th>使用效果数字2</th>
    <td><input type="text" name="item_info[item_use_effect_num2]" value="{^$item_info["item_use_effect_num2"]^}" class="auto_select" /></td>
  </tr>
  <tr>
    <th>来源</th>
    <td colspan="3">
      <select name="item_info[boss_id]">
{^foreach from=$boss_list key=boss_id item=boss_item^}
        <option value="{^$boss_id^}"{^if $item_info["boss_id"] eq $boss_id^} selected{^/if^}>{^$map_list[$boss_item["map_id"]]^}-{^$boss_item["boss_name"]^}</option>
{^/foreach^}
      </select>
    </td>
  </tr>
  <tr>
    <td colspan="4">
      <input type="submit" name="execute" value="提交" />
      <a href="./?menu=wow_secret&act=admin_list">返回</a>
    </td>
  </tr>
</table>
</form>
</body>
</html>