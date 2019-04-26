{^include file=$mblheader_file^}
<style type="text/css">
.game_prev_next_box {
  width:20%!important;
}
.game_title_box {
  width:60%!important;
}
</style>
<fieldset class="ui-grid-a">
  <div class="ui-block-a"><a href="./?menu=nba&act=standings" class="ui-shadow ui-btn ui-corner-all ui-btn-a">排名</a></div>
  <div class="ui-block-b"><a href="./?menu=nba&act=league_leader" class="ui-shadow ui-btn ui-corner-all ui-btn-a">数据王</a></div>
</fieldset>
<fieldset class="ui-grid-a">
  <div class="ui-block-a"><a href="./?menu=nba&act=team_list" class="ui-shadow ui-btn ui-corner-all ui-btn-a">球队</a></div>
  <div class="ui-block-b"><a href="./?menu=nba&act=player_list" class="ui-shadow ui-btn ui-corner-all ui-btn-a">球员</a></div>
</fieldset>
<fieldset class="ui-grid-b">
  <div class="ui-block-a game_prev_next_box"><a href="./?menu=nba&act=top&date={^$calendar_prev^}" class="ui-shadow ui-btn ui-corner-all">&lt;</a></div>
  <div class="ui-block-b game_title_box"><a href="#" class="ui-shadow ui-btn ui-corner-all ui-btn-b">{^$calendar_title^}</a></div>
  <div class="ui-block-c game_prev_next_box"><a href="./?menu=nba&act=top&date={^$calendar_next^}" class="ui-shadow ui-btn ui-corner-all">&gt;</a></div>
</fieldset>
{^if !empty($game_info)^}
{^foreach from=$game_info item=game_item^}
<div class="ui-body ui-body-a ui-corner-all" style="margin-top:0.75em;">
  <p>{^$game_item["game_title"]^}</p>
  <p>{^$game_item["away_team"]["t_name"]^} {^if $game_item["game_status"] eq "3"^}{^$game_item["away_team"]["score"]^} vs {^$game_item["home_team"]["score"]^}{^else^}vs{^/if^} {^$game_item["home_team"]["t_name"]^}</p>
</div>
{^/foreach^}
{^else^}
<h3 style="text-align:center;">今日无比赛</h3>
{^/if^}
{^include file=$mblfooter_file^}