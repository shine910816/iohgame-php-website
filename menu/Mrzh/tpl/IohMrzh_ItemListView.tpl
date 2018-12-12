{^include file=$empheader_file^}
<style type="text/css">
{^foreach from=$quality_color_list key=quality_value item=color^}
.item_quality_{^$quality_value^} {
  color: #{^$color^}!important;
  text-shadow: 1px 1px 1px #000;
}
{^/foreach^}
.tr_link tr td a {
  color: #000;
}
.tr_link tr td span {
  color: #FFF;
  text-shadow: 1px 1px 1px #000;
}
.th_item_name {
  width: 150px;
}
.th_item_edit {
  width: 300px;
}
</style>
<table class="tb tb_p_05 tb_brn mt_10 tr_link">
  <tr>
    <td rowspan="2">
      <a href="./?menu=mrzh&act=item_calculator">计算器</a><br/>
      <a href="./?menu=mrzh&act=add_item">录入物品</a>
    </td>
    <td colspan="2">
{^foreach from=$class_name_list key=class_value item=class_name^}
{^if $class_value eq $item_class^}
      <span>{^$class_name^}</span>
{^else^}
      <a href="./?menu={^$current_menu^}&act={^$current_act^}&item_class={^$class_value^}">{^$class_name^}</a>
{^/if^}
{^/foreach^}
    </td>
  </tr>
  <tr>
    <td colspan="2">
{^foreach from=$type_name_list[$item_class] key=type_value item=type_name^}
{^if $type_value eq $item_type^}
      <span>{^$type_name^}</span>
{^else^}
      <a href="./?menu={^$current_menu^}&act={^$current_act^}&item_class={^$item_class^}&item_type={^$type_value^}">{^$type_name^}</a>
{^/if^}
{^/foreach^}
    </td>
  </tr>
  <tr>
    <th class="th_item_name">名称</th>
    <th class="th_item_edit">操作</th>
  </tr>
{^if !empty($item_info_list)^}
{^foreach from=$item_info_list key=item_id item=item_info^}
  <tr>
    <td class="item_quality_{^$item_info["item_quality"]^}">{^$item_info["item_name"]^}</td>
    <td>
      <a href="./?menu=mrzh&act=item_info&item_id={^$item_id^}">详细</a>
      <a href="./?menu=mrzh&act=add_item&item_id={^$item_id^}">编辑</a>
    </td>
  </tr>
{^/foreach^}
{^/if^}
</table>
{^include file=$empfooter_file^}