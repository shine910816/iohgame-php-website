<div data-role="panel" id="rightpanel" data-display="reveal" data-position="right">
{^foreach from=$class_name_list key=class_value item=class_name^}
  <ul data-role="listview" data-inset="true" data-divider-theme="a">
    <li data-role="list-divider">{^$class_name^}</li>
{^foreach from=$type_name_list[$class_value] key=type_value item=type_name^}
    <li><a href="./?menu={^$current_menu^}&act={^$current_act^}&item_class={^$class_value^}&item_type={^$type_value^}">{^$type_name^}</a></li>
{^/foreach^}
  </ul>
{^/foreach^}
</div>