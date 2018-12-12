{^include file=$empheader_file^}
<style type="text/css">
{^foreach from=$quality_color_list key=quality_value item=color^}
.item_quality_{^$quality_value^} {
  color: #{^$color^}!important;
  text-shadow: 1px 1px 1px #000;
  text-decoration: none;
}
{^/foreach^}
.cols_title {
  width:70px;
}
.sub_item_name_box {
  width:150px;
}
.sub_item_num_box {
  width: 100px;
}
</style>
<table class="tb tb_p_05 tb_brn mt_10">
  <tr>
    <th class="cols_title">名称</th>
    <td colspan="2"><a href="./?menu={^$current_menu^}&act=item_calculator&add_item={^$item_id^}" class="item_quality_{^$total_item_info[$item_id]["item_quality"]^}">{^$total_item_info[$item_id]["item_name"]^}</a></td>
  </tr>
  <tr>
    <th>描述</th>
    <td colspan="2">{^$total_item_info[$item_id]["item_description"]^}</td>
  </tr>
{^if isset($item_material_info[$item_id])^}
{^assign var="material_idx" value=0^}
{^foreach from=$item_material_info[$item_id] key=m_item_id item=m_item_number^}
{^if $material_idx eq 0^}
  <tr>
    <th rowspan="{^$item_material_info[$item_id]|@count^}">材料</th>
    <td class="sub_item_name_box"><a href="./?menu={^$current_menu^}&act={^$current_act^}&item_id={^$m_item_id^}" class="item_quality_{^$total_item_info[$m_item_id]["item_quality"]^}">{^$total_item_info[$m_item_id]["item_name"]^}</a></td>
    <td class="sub_item_num_box">{^$m_item_number^}</td>
  </tr>
{^else^}
  <tr>
    <td><a href="./?menu={^$current_menu^}&act={^$current_act^}&item_id={^$m_item_id^}" class="item_quality_{^$total_item_info[$m_item_id]["item_quality"]^}">{^$total_item_info[$m_item_id]["item_name"]^}</a></td>
    <td>{^$m_item_number^}</td>
  </tr>
{^/if^}
{^assign var="material_idx" value=$material_idx + 1^}
{^/foreach^}
{^else^}
  <tr>
    <th>材料</th>
    <td class="sub_item_name_box"></td>
    <td class="sub_item_num_box"></td>
  </tr>
{^/if^}
{^if !empty($madeby_material_info)^}
  <tr>
    <th colspan="3">相关物品</th>
  </tr>
{^foreach from=$madeby_material_info key=madeby_item_id item=tmp_madeby_item_info^}
  <tr>
    <td></td>
    <td><a href="./?menu={^$current_menu^}&act={^$current_act^}&item_id={^$madeby_item_id^}" class="item_quality_{^$total_item_info[$madeby_item_id]["item_quality"]^}">{^$total_item_info[$madeby_item_id]["item_name"]^}</a></td>
    <td>{^$madeby_material_info[$madeby_item_id][$item_id]^}</td>
  </tr>
{^/foreach^}
{^/if^}
</table>
{^include file=$empfooter_file^}