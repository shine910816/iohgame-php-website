{^include file=$mblheader_file page_title="天津麻将记分器"^}
<form class="top_box" id="top_box" method="post" action="./" data-ajax="false">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<div data-role="collapsible" data-iconpos="right">
  <h4>开一局</h4>
  <label for="m_name">名称</label>
  <input name="m_name" id="m_name" type="text" />
  <label for="m_point">底番</label>
  <input name="m_point" id="m_point" value="50" min="25" max="200" step="25" data-highlight="true" type="range" />
  <label for="m_player">玩家</label>
  <input name="m_player[1]" id="m_player" type="text" placeholder="东" />
  <input name="m_player[2]" type="text" placeholder="南" />
  <input name="m_player[3]" type="text" placeholder="西" />
  <input name="m_player[4]" type="text" placeholder="北" />
  <input type="submit" name="start" value="确定" class="ui-btn ui-corner-all" />
</div>
</form>
<fieldset class="ui-grid-a">
  <div class="ui-block-a"><a class="ui-btn ui-corner-all ui-btn-{^if !$history_flg^}b{^else^}a{^/if^}" href="./?menu=mahjong&act=start">进行中</a></div>
  <div class="ui-block-b"><a class="ui-btn ui-corner-all ui-btn-{^if $history_flg^}b{^else^}a{^/if^}" href="./?menu=mahjong&act=start&history=1">已结束</a></div>
</fieldset>
{^if !empty($gaming_list)^}
<ul data-role="listview" data-inset="true">
{^foreach from=$gaming_list key=m_id item=m_info^}
  <li><a href="./?menu=mahjong&act={^if $history_flg^}history{^else^}detail{^/if^}&m_id={^$m_id^}" data-ajax="false">{^$m_info["m_name"]^}</a></li>
{^/foreach^}
</ul>
{^/if^}
{^include file=$mblfooter_file^}