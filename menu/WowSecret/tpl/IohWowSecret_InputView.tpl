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
    <th>物品位置</th>
    <td>
      <select name="item_info[item_position]">
        <option value="0">未选择</option>
{^foreach from=$item_position_list key=position_key item=position_item^}
        <option value="{^$position_key^}"{^if $item_info["item_position"] eq $position_key^} selected{^/if^}>{^$position_item^}</option>
{^/foreach^}
      </select>
    </td>
  </tr>
  <tr>
    <th>物品类型</th>
    <td>
      <select name="item_info[item_type]">
        <option value="0">未选择</option>
{^foreach from=$item_type_list key=type_key item=type_item^}
        <option value="{^$type_key^}"{^if $item_info["item_type"] eq $type_key^} selected{^/if^}>{^$type_item^}</option>
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
      <select name="item_from">
{^foreach from=$boss_list key=map_id item=map_item^}
{^foreach from=$map_item key=boss_order item=boss_name^}
        <option value="{^$map_id^}-{^$boss_order^}"{^if $item_info["map_id"] eq $map_id and $item_info["boss_order"] eq $boss_order^} selected{^/if^}>{^$map_list[$map_id]^}-{^$boss_name^}</option>
{^/foreach^}
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