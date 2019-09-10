<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>大秘境装备</title>
<link rel="shortcut icon" type="image/x-icon" href="img/ico/favicon.ico"/>
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
</head>
<body>
<table border="1">
  <tr>
    <td><a href="./?menu=wow_secret&act=input">添加物品</a></td>
    <th>类型</th>
    <th>护甲</th>
    <th>力量</th>
    <th>敏捷</th>
    <th>智力</th>
    <th>耐力</th>
    <th>爆击</th>
    <th>急速</th>
    <th>精通</th>
    <th>全能</th>
    <th>来源</th>
  </tr>
{^if !empty($item_info_list)^}
{^foreach from=$item_info_list key=item_id item=item_info^}
  <tr>
    <td><a href="./?menu=wow_secret&act=input&item_id={^$item_id^}">{^$item_info["item_name"]^}</a></td>
    <td>{^$class_position_type_list[$item_info["item_class"]][$item_info["item_position"]][$item_info["item_type"]]^}</td>
    <td>{^if $item_info["item_armor"] gt 0^}{^$item_info["item_armor"]^}{^/if^}</td>
    <td>{^if $item_info["item_strength"] gt 0^}{^$item_info["item_strength"]^}{^/if^}</td>
    <td>{^if $item_info["item_agility"] gt 0^}{^$item_info["item_agility"]^}{^/if^}</td>
    <td>{^if $item_info["item_intellect"] gt 0^}{^$item_info["item_intellect"]^}{^/if^}</td>
    <td>{^if $item_info["item_stamina"] gt 0^}{^$item_info["item_stamina"]^}{^/if^}</td>
    <td>{^if $item_info["item_critical"] gt 0^}{^$item_info["item_critical"]^}{^/if^}</td>
    <td>{^if $item_info["item_haste"] gt 0^}{^$item_info["item_haste"]^}{^/if^}</td>
    <td>{^if $item_info["item_mastery"] gt 0^}{^$item_info["item_mastery"]^}{^/if^}</td>
    <td>{^if $item_info["item_versatility"] gt 0^}{^$item_info["item_versatility"]^}{^/if^}</td>
    <td>{^$boss_info_list[$item_info["boss_id"]]["map_name"]^}-{^$boss_info_list[$item_info["boss_id"]]["boss_name"]^}</td>
  </tr>
{^/foreach^}
{^/if^}
</table>
</body>
</html>