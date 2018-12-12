{^include file=$empheader_file^}
<script type="text/javascript">
var addItemIndex = {^$add_item_index^};
var select_content = "";
$(document).ready(function(){
    $.get("./?menu=mrzh&act=add_item&ajax=1&base_item=0", function(result){
        select_content = result;
    });
    $("select[name='item_info[item_class]']").change(function(){
        $.get("./?menu=mrzh&act=add_item&ajax=1&item_class=" + $(this).val(), function(result){
            $("select[name='item_info[item_type]']").empty().html(result);
        });
    });
    $("select[name='item_info[item_type]']").change(function(){
        if ($("select[name='item_info[item_class]']").val() == "1" && $(this).val() == "5") {
            $("#item_food_type_cols").removeClass("no_disp");
        } else {
            $("#item_food_type_cols").addClass("no_disp");
        }
    });
    $("#add_item").click(function(){
        var addColsText = "<tr><td><select name=\"add_info[" + addItemIndex + "][material_item_id]\" class=\"select-box\"><option value=\"0\">未选择</option>" + select_content + "</select></td>";
        addColsText += "<td><input type=\"text\" name=\"add_info[" + addItemIndex + "][material_quantity]\" class=\"text-box\" /></td></tr>";
        $("#material_item_box").append(addColsText);
        addItemIndex++;
    });
});
</script>
<link rel="stylesheet" href="css/hearth_stone/input.css" type="text/css">
<style type="text/css">
.no_disp {
    display: none;
}
</style>
<form action="./" method="post" class="bl_c mt_30">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<input type="hidden" name="item_info[item_id]" value="{^$item_info["item_id"]^}" />
<table class="tb tb_p_05 tb_org">
  <tr>
    <th>名称</th>
    <td><input type="text" name="item_info[item_name]" value="{^$item_info["item_name"]^}" class="text-box" /></td>
  </tr>
  <tr>
    <th>品质</th>
    <td>
{^foreach from=$quality_name_list key=quality_value item=quality_name^}
      <label><input type="radio" name="item_info[item_quality]" value="{^$quality_value^}"{^if $item_info["item_quality"] eq $quality_value^} checked{^/if^} /><span style="color:#{^$quality_color_list[$quality_value]^}; text-shadow:1px 1px 1px #000;">{^$quality_name^}</span></label>
{^/foreach^}
    </td>
  </tr>
  <tr>
    <th rowspan="2">分类</th>
    <td>
      <select name="item_info[item_class]" class="select-box">
{^foreach from=$class_name_list key=class_value item=class_name^}
        <option value="{^$class_value^}"{^if $item_info["item_class"] eq $class_value^} selected{^/if^}>{^$class_name^}</option>
{^/foreach^}
      </select>
    </td>
  </tr>
  <tr>
    <td>
      <select name="item_info[item_type]" class="select-box">
{^foreach from=$type_name_list key=type_value item=type_name^}
        <option value="{^$type_value^}"{^if $item_info["item_type"] eq $type_value^} selected{^/if^}>{^$type_name^}</option>
{^/foreach^}
      </select>
    </td>
  </tr>
  <tr id="item_food_type_cols"{^if !($item_info["item_class"] eq "1" and $item_info["item_type"] eq "5")^} class="no_disp"{^/if^}>
    <th>食材类型</th>
    <td>
      <select name="item_info[item_food_type]" class="select-box">
{^foreach from=$food_type_name_list key=food_type_value item=food_type_name^}
        <option value="{^$food_type_value^}"{^if $item_info["item_food_type"] eq $food_type_value^} selected{^/if^}>{^$food_type_name^}</option>
{^/foreach^}
      </select>
    </td>
  </tr>
  <tr>
    <th>制造基数</th>
    <td>
      <label><input type="radio" name="item_info[item_made_num]" value="1"{^if $item_info["item_made_num"] eq "1"^} checked{^/if^} /><span>1</span></label>
      <label><input type="radio" name="item_info[item_made_num]" value="4"{^if $item_info["item_made_num"] eq "4"^} checked{^/if^} /><span>4</span></label>
    </td>
  </tr>
  <tr>
    <th>成品类型</th>
    <td><label><input type="checkbox" name="item_info[item_base_flg]" value="1"{^if $item_info["item_base_flg"] eq "1"^} checked{^/if^} /><span>非成品</span></label></td>
  </tr>
  <tr>
    <th>描述</th>
    <td>
      <textarea name="item_info[item_description]" class="textarea-box">{^$item_info["item_description"]^}</textarea>
    </td>
  </tr>
  <tr valign="top">
    <td><input type="button" id="add_item" value="添加材料" class="execute-button bl_c" /></td>
    <td>
      <table id="material_item_box" class="tb tb_p_05 tb_grn">
        <tr>
          <th width="211px">材料</th>
          <th width="211px">数量</th>
        </tr>
{^if !empty($material_list)^}
{^foreach from=$material_list key=material_idx item=material_info^}
        <tr>
          <td><select name="add_info[{^$material_idx^}][material_item_id]" class="select-box">{^$material_info["option_content"]^}</select></td>
          <td><input type="text" name="add_info[{^$material_idx^}][material_quantity]" value="{^$material_info["material_quantity"]^}" class="text-box" /></td>
        </tr>
{^/foreach^}
{^/if^}
      </table>
    </td>
  </tr>
  <tr>
    <td>
      <input type="submit" name="do_back" value="返回" class="execute-button bl_c" />
    </td>
    <td>
      <input type="submit" name="add_done" value="提交" class="execute-button bl_c" />
    </td>
  </tr>
</table>
</form>
{^include file=$empfooter_file^}