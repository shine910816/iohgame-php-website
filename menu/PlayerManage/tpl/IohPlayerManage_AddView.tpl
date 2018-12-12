<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户组管理</title>
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
var add_player_text = '<tr><td><input type="text" name="p_name[]" /></td></tr>';
//var new_player_count = parseInt($("#add_player_box").attr("rowspan"));
var new_player_count = $("#add_player_box").attr("rowspan");
alert(add_player_text);
//append
</script>
</head>
<body>
<form>
<table>
  <tbody id="add_player_box"></tbody>
    <tr>
      <td>用户组名</td>
      <td><input type="text" name="g_name" /></td>
    </tr>
    <tr>
      <td rowspan="4" id="add_player_box" valign="top"><input type="button" value="添加用户" id="add_player_button" /></td>
      <td><input type="text" name="p_name[]" /></td>
    </tr>
    <tr>
      <td><input type="text" name="p_name[]" /></td>
    </tr>
    <tr>
      <td><input type="text" name="p_name[]" /></td>
    </tr>
    <tr>
      <td><input type="text" name="p_name[]" /></td>
    </tr>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="2"><input type="submit" name="create" value="创建" /></td>
    </tr>
  </tfoot>
</table>
</form>
</body>
</html>