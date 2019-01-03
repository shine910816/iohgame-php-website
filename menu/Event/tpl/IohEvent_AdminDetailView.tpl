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
        var url = "./?menu={^$current_menu^}&act={^$current_act^}&check=" + encodeURI($(this).val());
        $.get(url, function(data){
            var json = eval("(" + data + ")");
            var event_number = $("#event_number");
            var event_key_error = $("#event_key_error");
            var confirm_button = $("#confirm_button");
            if (json.error == 0) {
                event_number.val(json.event_number);
                event_key_error.empty();
                event_key_error.addClass("ui-hidden");
                confirm_button.removeAttr("disabled");
            } else {
                event_number.val("");
                event_key_error.empty().html(json.err_msg);
                event_key_error.removeClass("ui-hidden");
                confirm_button.attr("disabled", "disabled");
            }
        });
    });
    $("#no_expiry_checkbox").change(function(){
        var datebox = $("#no_expiry_date");
        if ($(this).prop("checked")) {
            datebox.attr("disabled", "disabled");
        } else {
            datebox.removeAttr("disabled");
        }
    });
});
</script>
</head>
<body>
<form action="./" method="post" class="ui-formbox">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<input type="hidden" name="new_event_flg" value="{^if $new_event_flg^}1{^else^}0{^/if^}" />
<input type="hidden" name="event_id" value="{^$event_info["event_id"]^}" />
<table class="tb tb_p_05 tb_org">
  <tr>
    <th>活动关键字</th>
    <td>
      <input type="text" class="ui-textbox" name="event_info[event_key]" value="{^$event_info["event_key"]^}"{^if !$new_event_flg^} readonly{^/if^} id="event_key" />
      <p class="fc_red ui-hidden" id="event_key_error"></p>
    </td>
  </tr>
  <tr>
    <th>活动编号</th>
    <td><input type="text" class="ui-textbox" name="event_info[event_number]" value="{^$event_info["event_number"]^}" readonly id="event_number" /></td>
  </tr>
  <tr>
    <th>活动名</th>
    <td><input type="text" class="ui-textbox" name="event_info[event_name]" value="{^$event_info["event_name"]^}" /></td>
  </tr>
  <tr>
    <th>描述</th>
    <td><textarea class="ui-textbox ui-textarea" name="event_info[event_descript]">{^$event_info["event_descript"]^}</textarea></td>
  </tr>
  <tr>
    <th>活动开始日</th>
    <td><input type="date" class="ui-textbox" name="event_info[event_start_date]" value="{^$event_info["event_start_date"]^}" /></td>
  </tr>
  <tr>
    <th rowspan="2">活动结束日</th>
    <td><label><input type="checkbox" name="event_info[event_expiry_date]" value="9999-12-31"{^if $event_info["event_expiry_date"] eq "9999-12-31"^} checked{^/if^} id="no_expiry_checkbox" />无限期</label></td>
  <tr>
    <td><input type="date" class="ui-textbox" name="event_info[event_expiry_date]" value="{^$event_info["event_expiry_date"]^}"{^if $event_info["event_expiry_date"] eq "9999-12-31"^} disabled{^/if^} id="no_expiry_date" /></td>
  </tr>
  <tr>
    <th>公开状态</th>
    <td>
      <label><input type="radio" name="event_info[event_open_flg]" value="1"{^if $event_info["event_open_flg"] eq "1"^} checked{^/if^} />公开中</label>
      <label><input type="radio" name="event_info[event_open_flg]" value="0"{^if $event_info["event_open_flg"] eq "0"^} checked{^/if^} />不公开</label>
    </td>
  </tr>
  <tr>
    <th>活动参与地址</th>
    <td>
      <input type="text" class="ui-textbox" name="event_info[event_active_url]" value="{^$event_info["event_active_url"]^}" />
    </td>
  </tr>
  <tr>
    <th>活动参与文字</th>
    <td>
      <input type="text" class="ui-textbox" name="event_info[event_active_name]" value="{^$event_info["event_active_name"]^}" />
    </td>
  </tr>
  <tr>
    <td colspan="2"><input type="submit" name="do_submit" value="提交" class="ui-button ui-box-orange" id="confirm_button"{^if $new_event_flg^} disabled{^/if^} /></td>
  </tr>
  <tr>
    <td colspan="2"><a class="ui-button ui-box-grey" href="./?menu={^$current_menu^}&act=admin_list">返回</a></td>
  </tr>
</table>
</form>
</body>
</html>