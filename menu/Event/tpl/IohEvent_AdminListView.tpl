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
</head>
<body>
<div class="ui-formbox">
<table class="tb tb_p_05 tb_org">
  <tr>
    <td><a href="./?menu=event&act=admin_detail" class="ui-linktext">创建活动</a></td>
    <th>活动编号</th>
    <th>活动名</th>
    <th>公开状态</th>
  </tr>
{^if !empty($event_list)^}
{^foreach from=$event_list item=event_info^}
  <tr>
    <td>{^$event_info["event_key"]^}</td>
    <td><a href="./?menu=event&act=admin_detail&edit_event_id={^$event_info["event_id"]^}" class="ui-linktext">{^$event_info["event_number"]^}</a></td>
    <td>{^$event_info["event_name"]^}</td>
    <td>{^if $event_info["event_open_flg"] eq "1"^}公开中{^else^}未公开{^/if^}</td>
  </tr>
{^/foreach^}
{^/if^}
</table>
</div>
</body>
</html>