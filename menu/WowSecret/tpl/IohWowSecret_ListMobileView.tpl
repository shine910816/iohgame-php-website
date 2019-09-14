{^include file=$mblheader_file^}
<div data-role="collapsible" data-iconpos="right" data-collapsed-icon="carat-d" data-expanded-icon="carat-u">
  <h4>{^$map_info_list[$map_id]^}</h4>
{^foreach from=$map_info_list key=target_map_id item=map_name^}
  <a href="./?menu=wow_secret&act=list&map_id={^$target_map_id^}" class="ui-btn ui-corner-all ui-shadow ui-btn-{^if $target_map_id eq $map_id^}b{^else^}a{^/if^}" data-ajax="false">{^$map_name^}</a>
{^/foreach^}
</div>

<div data-role="collapsible" data-iconpos="right" data-collapsed-icon="carat-d" data-expanded-icon="carat-u">
  <h4>{^if $boss_id eq 0^}全首领{^else^}{^$boss_info_list[$boss_id]["boss_name"]^}{^/if^}</h4>
{^foreach from=$boss_info_list item=boss_info^}
{^if $boss_info["map_id"] eq $map_id^}
  <a href="./?menu=wow_secret&act=list&{^if $boss_info["boss_id"] eq $boss_id^}map_id={^$map_id^}{^else^}boss_id={^$boss_info["boss_id"]^}{^/if^}" class="ui-btn ui-corner-all ui-shadow ui-btn-{^if $boss_info["boss_id"] eq $boss_id^}b{^else^}a{^/if^}" data-ajax="false">{^$boss_info["boss_name"]^}</a>
{^/if^}
{^/foreach^}
</div>
{^if !empty($item_list)^}
<ul data-role="listview" data-inset="true">
{^foreach from=$item_list key=item_id item=item_info^}
  <li>
    <a href="./?menu=wow_secret&act=item_detail&item_id={^$item_id^}{^if $boss_display_flg^}&back_map=1{^/if^}" data-ajax="false">
      <img alt="{^$item_id^}" />
      <h2>{^$item_info["item_name"]^}</h2>
{^if $boss_display_flg^}
      <p>{^$boss_info_list[$item_info["boss_id"]]["boss_name"]^}</p>
{^/if^}
      <span class="ui-li-count">{^$class_position_type_list[$item_info["item_class"]][$item_info["item_position"]][$item_info["item_type"]]^}</span>
    </a>
  </li>
{^/foreach^}
</ul>
{^/if^}
{^include file=$mblfooter_file^}