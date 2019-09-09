<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>大秘境装备</title>
<link rel="shortcut icon" type="image/x-icon" href="img/ico/favicon.ico"/>
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
</head>
<body>
<form action="./" method="post">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<table>
  <tr>
    <th>物品ID</th>
    <td><input type="text" name="item_info[item_id]" value="{^$item_info["item_id"]^}" /></td>
  </tr>
  <tr>
    <th>物品名</th>
    <td><input type="text" name="item_info[item_name]" value="{^$item_info["item_name"]^}" /></td>
  </tr>
  <tr>
    <th>物品分类</th>
    <td>
      <select name="item_info[item_class]">
{^foreach from=$item_class_list key=class_key item=class_item^}
        <option value="{^$class_key^}"{^if $item_info["item_class"] eq $class_key^} selected{^/if^}>{^$class_item^}</option>
{^/foreach^}
      </select>
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
  </tr>
  <tr>
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
    <td><input type="text" name="item_info[item_armor]" value="{^$item_info["item_armor"]^}" /></td>
  </tr>
  <tr>
    <th>力量</th>
    <td><input type="text" name="item_info[item_strength]" value="{^$item_info["item_strength"]^}" /></td>
  </tr>
  <tr>
    <th>敏捷</th>
    <td><input type="text" name="item_info[item_agility]" value="{^$item_info["item_agility"]^}" /></td>
  </tr>
  <tr>
    <th>智力</th>
    <td><input type="text" name="item_info[item_intellect]" value="{^$item_info["item_intellect"]^}" /></td>
  </tr>
  <tr>
    <th>耐力</th>
    <td><input type="text" name="item_info[item_stamina]" value="{^$item_info["item_stamina"]^}" /></td>
  </tr>
  <tr>
    <th>爆击</th>
    <td><input type="text" name="item_info[item_critical]" value="{^$item_info["item_critical"]^}" /></td>
  </tr>
  <tr>
    <th>急速</th>
    <td><input type="text" name="item_info[item_haste]" value="{^$item_info["item_haste"]^}" /></td>
  </tr>
  <tr>
    <th>精通</th>
    <td><input type="text" name="item_info[item_mastery]" value="{^$item_info["item_mastery"]^}" /></td>
  </tr>
  <tr>
    <th>全能</th>
    <td><input type="text" name="item_info[item_versatility]" value="{^$item_info["item_versatility"]^}" /></td>
  </tr>
  <tr>
    <th>装备效果</th>
    <td><textarea name="item_info[item_equit_effect]">{^$item_info["item_equit_effect"]^}</textarea></td>
  </tr>
  <tr>
    <th>装备效果数字1</th>
    <td><input type="text" name="item_info[item_equit_effect_num]" value="{^$item_info["item_equit_effect_num"]^}" /></td>
  </tr>
  <tr>
    <th>装备效果数字2</th>
    <td><input type="text" name="item_info[item_equit_effect_num2]" value="{^$item_info["item_equit_effect_num2"]^}" /></td>
  </tr>
  <tr>
    <th>使用效果</th>
    <td><textarea name="item_info[item_use_effect]">{^$item_info["item_use_effect"]^}</textarea></td>
  </tr>
  <tr>
    <th>使用效果数字1</th>
    <td><input type="text" name="item_info[item_use_effect_num]" value="{^$item_info["item_use_effect_num"]^}" /></td>
  </tr>
  <tr>
    <th>使用效果数字2</th>
    <td><input type="text" name="item_info[item_use_effect_num2]" value="{^$item_info["item_use_effect_num2"]^}" /></td>
  </tr>
  <tr>
    <th>来源</th>
    <td>
      <select name="item_info[boss_id]">
{^foreach from=$boss_list key=boss_id item=boss_item^}
        <option value="{^$boss_id^}"{^if $item_info["boss_id"] eq $boss_id^} selected{^/if^}>{^$map_list[$boss_item["map_id"]]^}-{^$boss_item["boss_name"]^}</option>
{^/foreach^}
      </select>
    </td>
  </tr>
  <tr>
    <td colspan="2"><input type="submit" name="execute" value="提交" /></td>
  </tr>
</table>
</form>
</body>
</html>