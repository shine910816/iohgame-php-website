{^include file=$mblheader_file^}
{^if $has_result_display^}
  <a href="./?menu={^$current_menu^}&act={^$current_act^}&add_item={^$added_item_list^}" data-ajax="false" class="ui-btn ui-corner-all">调整物品</a>
  <a href="./?menu={^$current_menu^}&act={^$current_act^}" data-ajax="false" class="ui-btn ui-corner-all">重新计算</a>
  <ul data-role="listview" data-inset="true" data-divider-theme="a">
    <li data-role="list-divider">需求物品</li>
{^foreach from=$disp_item_list key=item_id item=item_quantity^}
    <li><a href="./?menu={^$current_menu^}&act=item_info&item_id={^$item_id^}">{^$item_info[$item_id]["item_name"]^}<span class="ui-li-count">{^$item_quantity["actual"]^}{^if $item_quantity["actual"] neq $item_quantity["expect"]^}({^$item_quantity["expect"]^}){^/if^}</span></a></li>
{^/foreach^}
  </ul>
  <ul data-role="listview" data-inset="true" data-divider-theme="a">
    <li data-role="list-divider">基础材料</li>
{^foreach from=$material_item_list key=item_id item=item_quantity^}
    <li><a href="./?menu={^$current_menu^}&act=item_info&item_id={^$item_id^}">{^$item_info[$item_id]["item_name"]^}<span class="ui-li-count">{^$item_quantity^}</span></a></li>
{^/foreach^}
  </ul>
{^else^}
<script type="text/javascript">
var list_index = {^$list_start_index^};
var select_content = "";
$(document).ready(function(){
    $.get("./?menu=mrzh&act=item_calculator&ajax=1", function(result){
        select_content = result;
    });
});
$(document).on("pagecreate",function(){
    $("#add_item_button").click(function(){
        var add_text_content = "<div class=\"ui-body ui-body-a ui-corner-all added_item_box\"><select name=\"item_list["
            + list_index + "][item_id]\" id=\"item_id_"
            + list_index + "\" data-native-menu=\"false\">"
            + select_content + "</select><input name=\"item_list["
            + list_index + "][quantity]\" id=\"item_quanlity_"
            + list_index + "\" value=\"1\" min=\"1\" max=\"100\" data-highlight=\"true\" type=\"range\"></div>";
        list_index++;
        $("#item_box").append(add_text_content).trigger("create");
    });
});
</script>
<style type="text/css">
.added_item_box {
  margin-top: 8px!important;
}
</style>
  <form action="./?menu={^$current_menu^}&act={^$current_act^}" method="post" id="item_box" data-role="fieldcontain">
    <a href="./?menu={^$current_menu^}&act=item_list" class="ui-btn ui-corner-all" data-ajax="false">返回列表</a>
    <input type="button" class="ui-btn ui-corner-all" id="add_item_button" value="添加物品" />
    <input type="submit" name="do_confirm" value="确认提交" class="ui-btn ui-corner-all" />
{^if !empty($option_list)^}
{^foreach from=$option_list key=item_idx item=item_info^}
      <div class="ui-body ui-body-a ui-corner-all added_item_box">
        <select name="item_list[{^$item_idx^}][item_id]" id="item_id_{^$item_idx^}" data-native-menu="false">{^$item_info["content"]^}</select>
        <input name="item_list[{^$item_idx^}][quantity]" id="item_quanlity_{^$item_idx^}" value="{^$item_info["quantity"]^}" min="1" max="100" data-highlight="true" type="range">
      </div>
{^/foreach^}
{^/if^}
  </form>
{^/if^}
{^include file=$mblfooter_file^}