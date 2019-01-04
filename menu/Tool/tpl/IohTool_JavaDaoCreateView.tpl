<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Create DAO file for java batch - Iohgame</title>
<link rel="shortcut icon" type="image/x-icon" href="img/ico/favicon.ico"/>
<link rel="stylesheet" href="css/common/common.css" type="text/css" />
<link rel="stylesheet" href="css/common/common_font.css" type="text/css" />
<link rel="stylesheet" href="css/common/common_form.css" type="text/css" />
<link rel="stylesheet" href="css/font-awesome.css" type="text/css" />
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
var column_index = {^$column_index^};
var enum_index = {^$enum_index^};
var enum_column_index = new Array();
{^if !empty($enum_column_index)^}
{^foreach from=$enum_column_index key=ex_key item=ec_idx^}
enum_column_index[{^$ex_key^}] = {^$ec_idx^};
{^/foreach^}
{^/if^}
var select_content = "";
$(document).ready(function(){
    $.get("./?menu=tool&act=java_dao_create&select_list=0", function(result){
        select_content = result;
    });
});
$(document).on("click", "#add_column", function(){
    var column_tr_context = '<tr id="column_' + column_index +
                            '"><td><select name="column_info[' + column_index +
                            '][data_type]" class="ui-textbox ui-shortbox">' + select_content +
                            '</select></td><td><input type="text" name="column_info[' + column_index +
                            '][column_name]" class="ui-textbox ui-shortbox" /></td><td><a href="#" class="remove_column" data-column-index="' + column_index +
                            '">移除</a></td></tr>';
    $("#column_table").append(column_tr_context);
    column_index++;
});
$(document).on("click", ".remove_column", function(){
    var target = "#column_" + $(this).data("column-index");
    $(target).remove();
});
$(document).on("click", "#add_enum", function(){
    var enum_table_context = '<table class="tb tb_p_05 tb_grn mt_05" id="enum_' + enum_index +
                             '"><tr><th>枚举名</th><td colspan="2"><input type="text" name="enum_info[' + enum_index +
                             '][enum_name]" value="" class="ui-textbox ui-shortbox" /></td></tr><tr><th>操作</th><td colspan="2">' +
                             '<a href="#" class="add_enum_volumn" data-enum-index="' + enum_index +
                             '">添加枚举键</a>&nbsp;<a href="#" class="remove_enum" data-enum-index="' + enum_index +
                             '">移除枚举</a></td></tr><tr><th>键名</th><th>值</th><th>操作</th></tr></table>';
    $("#enum_box").append(enum_table_context);
    enum_column_index[enum_index] = 0;
    enum_index++;
});
$(document).on("click", ".remove_enum", function(){
    var target = "#enum_" + $(this).data("enum-index");
    $(target).remove();
});
$(document).on("click", ".add_enum_volumn", function(){
    var enum_index_num = parseInt($(this).data("enum-index"));
    var enum_column_index_num = enum_column_index[enum_index_num];
    var enum_column_tr_content = '<tr id="enum_' + enum_index_num +
                                 '_column_' + enum_column_index_num +
                                 '"><td><input type="text" name="enum_info[' + enum_index_num +
                                 '][enum_column][' + enum_column_index_num +
                                 '][enum_column_name]" value="" class="ui-textbox ui-shortbox" /></td><td><input type="text" name="enum_info[' + enum_index_num +
                                 '][enum_column][' + enum_column_index_num +
                                 '][enum_column_value]" value="" class="ui-textbox ui-shortbox" /></td><td><a href="#" class="remove_enum_column" data-enum-index="' + enum_index_num +
                                 '" data-enum-column-index="' + enum_column_index_num +
                                 '">移除</a></td></tr>';
    $("#enum_" + enum_index_num).append(enum_column_tr_content);
    enum_column_index[enum_index_num] = enum_column_index_num + 1;
});
$(document).on("click", ".remove_enum_column", function(){
    var target = "#enum_" + $(this).data("enum-index") + "_column_" + $(this).data("enum-column-index");
    $(target).remove();
});
</script>
</head>
<body>
<form action="./" method="get" class="ui-formbox">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<table class="tb tb_p_05 tb_org">
  <tr>
    <th>组</th>
    <td><input type="text" name="file_info[package_name]" value="{^$file_info["package_name"]^}" class="ui-textbox" /></td>
  </tr>
  <tr>
    <th>名</th>
    <td><input type="text" name="file_info[file_name]" value="{^$file_info["file_name"]^}" class="ui-textbox" /></td>
  </tr>
  <tr>
    <th rowspan="2">字段</th>
    <td><input type="button" id="add_column" value="添加字段" class="ui-button ui-box-grey" /></td>
  </tr>
  <tr>
    <td>
      <table class="tb tb_p_05 tb_grn" id="column_table">
        <tr>
          <th>数据类型</th>
          <th>字段名</th>
          <th>操作</th>
        </tr>
{^if !empty($column_info)^}
{^foreach from=$column_info key=column_key item=column_item^}
        <tr id="column_{^$column_key^}">
          <td><select name="column_info[{^$column_key^}][data_type]" class="ui-textbox ui-shortbox">{^$column_item["data_type_select_content"]^}</select></td>
          <td><input type="text" name="column_info[{^$column_key^}][column_name]" value="{^$column_item["column_name"]^}" class="ui-textbox ui-shortbox" /></td>
          <td><a href="#" class="remove_column" data-column-index="{^$column_key^}">移除</a></td>
        </tr>
{^/foreach^}
{^/if^}
      </table>
    </td>
  </tr>
  <tr>
    <th rowspan="2">自定义枚举</th>
    <td><input type="button" id="add_enum" value="添加枚举" class="ui-button ui-box-grey" /></td>
  </tr>
  <tr>
    <td id="enum_box">
      <table class="tb tb_p_05 tb_grn mt_05" id="enum_0">
        <tr>
          <th>枚举名</th>
          <td colspan="2"><input type="text" name="enum_info[0][enum_name]" value="" class="ui-textbox ui-shortbox" /></td>
        </tr>
        <tr>
          <th>操作</th>
          <td colspan="2">
            <a href="#" class="add_enum_volumn" data-enum-index="0">添加枚举键</a>
            <a href="#" class="remove_enum" data-enum-index="0">移除枚举</a>
          </td>
        </tr>
        <tr>
          <th>键名</th>
          <th>值</th>
          <th>操作</th>
        </tr>
        <tr id="enum_0_column_0">
          <td><input type="text" name="enum_info[0][enum_column][0][enum_column_name]" value="" class="ui-textbox ui-shortbox" /></td>
          <td><input type="text" name="enum_info[0][enum_column][0][enum_column_value]" value="" class="ui-textbox ui-shortbox" /></td>
          <td><a href="#" class="remove_enum_column" data-enum-index="0" data-enum-column-index="0">移除</a></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="2"><input type="submit" name="do_apply" value="应用" class="ui-button ui-box-grey" /></td>
  </tr>
  <tr>
    <td colspan="2"><input type="submit" name="do_submit" value="提交" class="ui-button ui-box-orange" /></td>
  </tr>
</table>
</form>
</body>
</html>