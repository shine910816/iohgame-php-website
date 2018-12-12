{^include file=$empheader_file^}
<link rel="stylesheet" href="css/hearth_stone/input.css" type="text/css">
<style type="text/css">
{^foreach from=$quality_color_list key=quality_value item=color^}
.item_quality_{^$quality_value^} {
  color: #{^$color^}!important;
  text-shadow: 1px 1px 1px #000;
  text-decoration: none;
}
{^/foreach^}
.cols_title {
  width:211px;
}
.name_title {
  width: 150px;
}
.link_box td a {
  color: #000;
  text-decoration: none;
}
</style>
{^if $has_result_display^}
<table class="tb tb_p_05 tb_brn mt_10">
  <tr>
    <th colspan="3">需求品</th>
  </tr>
  <tr>
    <th>名称</th>
    <th>需求数量</th>
    <th>实际数量</th>
  </tr>
{^foreach from=$disp_item_list key=item_id item=item_quantity^}
  <tr>
    <td class="name_title"><a href="./?menu={^$current_menu^}&act=item_info&item_id={^$item_id^}" class="item_quality_{^$item_info[$item_id]["item_quality"]^}">{^$item_info[$item_id]["item_name"]^}</a></td>
    <td>{^$item_quantity["expect"]^}</td>
    <td>{^$item_quantity["actual"]^}</td>
  </tr>
{^/foreach^}
  <tr>
    <th colspan="3">基础材料需求量</th>
  </tr>
  <tr>
    <th>名称</th>
    <th colspan="2">数量</th>
  </tr>
{^foreach from=$material_item_list key=item_id item=item_quantity^}
  <tr>
    <td><a href="./?menu={^$current_menu^}&act=item_info&item_id={^$item_id^}" class="item_quality_{^$item_info[$item_id]["item_quality"]^}">{^$item_info[$item_id]["item_name"]^}</a></td>
    <td colspan="2">{^$item_quantity^}</td>
  </tr>
{^/foreach^}
  <tr class="link_box">
    <td colspan="3">
      <a href="./?menu={^$current_menu^}&act={^$current_act^}&add_item={^$added_item_list^}">调整</a>
      <a href="./?menu={^$current_menu^}&act={^$current_act^}">返回</a>
    </td>
  </tr>
</table>
{^else^}
<script type="text/javascript">
var list_index = {^$list_start_index^};
var select_content = "";
$(document).ready(function(){
    $.get("./?menu=mrzh&act=item_calculator&ajax=1", function(result){
        select_content = result;
    });
    $("#add_item").click(function(){
        var text_content = "<tr><td><select name=\"item_list[" + list_index;
        text_content += "][item_id]\" class=\"select-box\">" + select_content + "</select></td>";
        text_content += "<td><input type=\"text\" name=\"item_list[" + list_index;
        text_content += "][quantity]\" value=\"1\" class=\"text-box\" /></td></tr>";
        $("#item_box").append(text_content);
        list_index++;
    });
});
</script>
<form action="./?menu={^$current_menu^}&act={^$current_act^}" method="post">
<table class="tb tb_p_05 tb_brn mt_10" id="item_box">
  <tr>
    <td>
      <input type="button" id="add_item" value="添加物品" class="execute-button bl_c" />
    </td>
    <td>
      <input type="submit" name="do_confirm" value="确认提交" class="execute-button bl_c" />
    </td>
  </tr>
  <tr class="link_box">
    <td colspan="2"><a href="./?menu={^$current_menu^}&act=item_list">返回</a></td>
  </tr>
  <tr>
    <th class="cols_title">物品</th>
    <th class="cols_title">数量</th>
  </tr>
{^if !empty($option_list)^}
{^foreach from=$option_list key=item_idx item=item_info^}
  <tr>
    <td>
      <select name="item_list[{^$item_idx^}][item_id]" class="select-box">{^$item_info["content"]^}</select>
    </td>
    <td>
      <input type="text" name="item_list[{^$item_idx^}][quantity]" value="{^$item_info["quantity"]^}" class="text-box" />
    </td>
  </tr>
{^/foreach^}
{^/if^}
</table>
</form>
{^/if^}
{^include file=$empfooter_file^}