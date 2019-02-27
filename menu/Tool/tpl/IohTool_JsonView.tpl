<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Json结构转换</title>
</head>
<body>
<form action="./" method="post" class="ui-formbox">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<table class="tb tb_p_05 tb_org">
  <tr>
    <th>路径</th>
    <td><textarea name="json_path">{^$json_path^}</textarea></td>
    <td><input type="submit" name="do_submit" value="确定" /></td>
  </tr>
  <tr>
    <td colspan="3"><pre>{^$json_trans_context^}</pre></td>
  </tr>
</table>
</form>
</body>
</html>