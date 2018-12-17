{^include file=$mblheader_file^}
  <a href="./?menu={^$current_menu^}&act=item_calculator&add_item={^$item_id^}" class="ui-btn ui-corner-all">添加到计算器</a>
  <a href="./?menu={^$current_menu^}&act=item_list&item_class={^$total_item_info[$item_id]["item_class"]^}&item_type={^$total_item_info[$item_id]["item_type"]^}" class="ui-btn ui-corner-all">返回列表</a>
  <div class="ui-corner-all custom-corners">
    <div class="ui-bar ui-bar-a">
      <h3>名称</h3>
    </div>
    <div class="ui-body ui-body-a">
      <p>{^$total_item_info[$item_id]["item_name"]^}</p>
    </div>
  </div>
  <h3></h3>
  <div class="ui-corner-all custom-corners">
    <div class="ui-bar ui-bar-a">
      <h3>描述</h3>
    </div>
    <div class="ui-body ui-body-a">
      <p>&nbsp;{^$total_item_info[$item_id]["item_description"]^}</p>
    </div>
  </div>
{^if isset($item_material_info[$item_id])^}
  <div class="ui-corner-all custom-corners">
    <ul data-role="listview" data-inset="true" data-divider-theme="a">
      <li data-role="list-divider">材料</li>
{^foreach from=$item_material_info[$item_id] key=m_item_id item=m_item_number^}
      <li><a href="./?menu={^$current_menu^}&act={^$current_act^}&item_id={^$m_item_id^}">{^$total_item_info[$m_item_id]["item_name"]^}<span class="ui-li-count">{^$m_item_number^}</span></a></li>
{^/foreach^}
    </ul>
  </div>
{^/if^}
{^if !empty($madeby_material_info)^}
  <div class="ui-corner-all custom-corners">
    <ul data-role="listview" data-inset="true" data-divider-theme="a">
      <li data-role="list-divider">相关物品</li>
{^foreach from=$madeby_material_info key=madeby_item_id item=tmp_madeby_item_info^}
      <li><a href="./?menu={^$current_menu^}&act={^$current_act^}&item_id={^$madeby_item_id^}">{^$total_item_info[$madeby_item_id]["item_name"]^}</a></li>
{^/foreach^}
    </ul>
  </div>
{^/if^}
{^include file=$mblfooter_file^}