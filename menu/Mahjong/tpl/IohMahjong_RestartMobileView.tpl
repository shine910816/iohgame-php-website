{^include file=$mblheader_file page_title="天津麻将记分器"^}
<form class="top_box" id="top_box" method="post" action="./" data-ajax="false">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="start" />
<div data-role="collapsible" data-iconpos="right" data-collapsed="false">
  <h4>再开一局</h4>
  <label for="m_name">名称</label>
  <input name="m_name" id="m_name" type="text" value="{^$game_info["m_name"]^}" />
  <label for="m_point">底番</label>
  <input name="m_point" id="m_point" value="{^$game_info["m_point"]^}" min="25" max="200" step="25" data-highlight="true" type="range" />
  <label for="m_player">玩家</label>
  <input name="m_player[1]" id="m_player" type="text" placeholder="东" value="{^$game_detail["1"]["m_player_name"]^}" />
  <input name="m_player[2]" type="text" placeholder="南" value="{^$game_detail["2"]["m_player_name"]^}" />
  <input name="m_player[3]" type="text" placeholder="西" value="{^$game_detail["3"]["m_player_name"]^}" />
  <input name="m_player[4]" type="text" placeholder="北" value="{^$game_detail["4"]["m_player_name"]^}" />
  <input type="submit" name="start" value="确定" class="ui-btn ui-corner-all" />
</div>
</form>
<fieldset class="ui-grid-a">
  <div class="ui-block-a"><a class="ui-btn ui-corner-all ui-btn-a" href="./?menu=mahjong&act=start">返回大厅</a></div>
  <div class="ui-block-b"><a class="ui-btn ui-corner-all ui-btn-b" href="./?menu=mahjong&act=history&m_id={^$m_id^}">返回统计</a></div>
</fieldset>
{^include file=$mblfooter_file^}