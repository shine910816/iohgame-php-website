{^include file=$mblheader_file^}
  <a href="./?menu=mrzh&act=item_calculator" data-ajax="false" class="ui-btn ui-corner-all">计算器</a>
  <a href="#rightpanel" class="ui-btn ui-corner-all">{^$class_name_list[$item_class]^} - {^$type_name_list[$item_class][$item_type]^}</a>
{^if !empty($item_info_list)^}
  <ul data-role="listview" data-inset="true">
{^foreach from=$item_info_list key=item_id item=item_info^}
    <li><a href="./?menu=mrzh&act=item_info&item_id={^$item_id^}">{^$item_info["item_name"]^}</a></li>
{^/foreach^}
  </ul>
{^/if^}
{^include file=$mblfooter_file^}