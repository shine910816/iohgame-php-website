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
    <th>物品名</th>
    <td>{^$item_info["item_name"]^}<input type="hidden" name="item_id" value="{^$item_id^}" /></td>
  </tr>
  <tr>
    <th>最小值</th>
    <td><input type="text" name="weapon_info[item_damage_min]" value="{^$weapon_info["min"]^}" class="auto_select" /></td>
  </tr>
  <tr>
    <th>最大值</th>
    <td><input type="text" name="weapon_info[item_damage_max]" value="{^$weapon_info["max"]^}" class="auto_select" /></td>
  </tr>
  <tr>
    <th>速度</th>
    <td><input type="text" name="weapon_info[item_speed]" value="{^$weapon_info["spd"]^}" class="auto_select" /></td>
  </tr>
  <tr>
    <th>秒伤</th>
    <td><input type="text" name="weapon_info[item_damage_per_second]" value="{^$weapon_info["dps"]^}" class="auto_select" /></td>
  </tr>
  <tr>
    <td colspan="4">
      <input type="submit" name="execute" value="提交" />
      <a href="./?menu=wow_secret&act=admin_weapon_list">返回</a>
    </td>
  </tr>
</table>
</form>
</body>
</html>