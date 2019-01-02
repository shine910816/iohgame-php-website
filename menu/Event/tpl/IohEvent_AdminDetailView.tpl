<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>站内活动管理</title>
<link rel="shortcut icon" type="image/x-icon" href="img/ico/favicon.ico"/>
<link rel="stylesheet" href="css/common/common.css" type="text/css" />
<link rel="stylesheet" href="css/common/common_font.css" type="text/css" />
<link rel="stylesheet" href="css/font-awesome.css" type="text/css" />
<link rel="stylesheet" href="css/common/common_form.css" type="text/css" />
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $("#event_key").change(function(){
        var url = "./systool/trans/?k=" + $(this).val();
        $.get(url, function(data){
            $("#event_number").val(data);
        });
    });
});
</script>
</head>
<body>
<form action="./" method="get">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<input type="hidden" name="new_event_flg" value="{^if $new_event_flg^}1{^else^}0{^/if^}" />
<table class="tb tb_p_05 tb_org">
  <tr>
    <th>主键</th>
    <td><input type="text" class="textbox" name="event_info[event_key]" value="{^$event_info["event_key"]^}"{^if !$new_event_flg^} readonly{^/if^} id="event_key" /></td>
  </tr>
  <tr>
    <th>活动编号</th>
    <td><input type="text" class="textbox" name="event_info[event_number]" value="{^$event_info["event_number"]^}" readonly id="event_number" /></td>
  </tr>
  <tr>
    <th>活动名</th>
    <td><input type="text" class="textbox" name="event_info[event_name]" value="{^$event_info["event_name"]^}" /></td>
  </tr>
  <tr>
    <th>描述</th>
    <td><textarea class="textbox textarea" name="event_info[event_descript]">{^$event_info["event_descript"]^}</textarea></td>
  </tr>
  <tr>
    <th>活动开始日</th>
    <td><input type="date" class="textbox" name="event_info[event_start_date]" value="{^$event_info["event_start_date"]|date_format:"%Y-%m-%d"^}" /></td>
  </tr>
  <tr>
    <th rowspan="2">活动结束日</th>
    <td><label><input type="checkbox" name="event_info[event_expiry_date]" value="9999-12-31"{^if $event_info["event_expiry_date"] eq "9999-12-31 23:59:59"^} checked{^/if^} />无限期</label></td>
  <tr>
    <td><input type="date" class="textbox" name="event_info[event_expiry_date]" value="{^if $event_info["event_expiry_date"] neq "9999-12-31 23:59:59"^}{^$event_info["event_expiry_date"]|date_format:"%Y-%m-%d"^}{^else^}9999-12-31{^/if^}"{^if $event_info["event_expiry_date"] eq "9999-12-31 23:59:59"^} disabled{^/if^} /></td>
  </tr>
  <tr>
    <th>公开状态</th>
    <td>
      <label><input type="radio" name="event_info[event_open_flg]" value="1"{^if $event_info["event_open_flg"] eq "1"^} checked{^/if^} />公开中</label>
      <label><input type="radio" name="event_info[event_open_flg]" value="0"{^if $event_info["event_open_flg"] eq "0"^} checked{^/if^} />不公开</label>
    </td>
  </tr>
  <tr>
    <th>参与模式</th>
    <td>
      <label><input type="radio" name="event_info[event_active_flg]" value="1"{^if $event_info["event_active_flg"] eq "1"^} checked{^/if^} />主动参与</label>
      <label><input type="radio" name="event_info[event_active_flg]" value="0"{^if $event_info["event_active_flg"] eq "0"^} checked{^/if^} />被动参与</label>
    </td>
  </tr>
  <tr>
    <td colspan="2"><input type="submit" name="do_submit" value="提交" /></td>
  </tr>
</table>
</form>
</body>
</html>