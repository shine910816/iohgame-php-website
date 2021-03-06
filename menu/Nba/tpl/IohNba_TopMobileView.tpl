{^include file=$mblheader_file^}
<link rel="stylesheet" href="css/common/common_font_plus.css" type="text/css" />
<style type="text/css">
.game_prev_next_box {
  width:20%!important;
}
.game_title_box {
  width:60%!important;
}
.game_box {
  margin-top:0.75em;
  padding-left:0;
  padding-right:0;
}
.game_box .date_arena_box {
  width:100%;
  height:2.5em;
  text-align:center;
  line-height:3em;
  color:#777;
}
.game_box .team_score_box {
  width:100%;
  margin-top:0.5em;
}
.game_box .team_score_box .team_box,
.game_box .team_score_box .score_box,
.game_box .team_score_box .vs_box {
  height:4.5em;
  float:left;
}
.game_box .team_score_box .team_box {
  width:25%;
  height:4.5em;
}
.game_box .team_score_box .score_box {
  width:20%;
  height:1em;
  text-align:center;
  line-height:1.5em;
  color:#777;
  font-size:3em;
  font-family:Nba;
}
.game_box .team_score_box .vs_box {
  width:10%;
  height:3em;
  text-align:center;
  line-height:3em;
  font-size:1.5em;
  color:#000;
  font-family:Nba;
}
.game_box .team_score_box .team_box img.team_logo {
  width:3em;
  height:3em;
  margin:0 auto;
  display:block;
}
.game_box .team_score_box .team_box .team_name {
  width:100%;
  height:1.5em;
  text-align:center;
  line-height:1.5em;
  color:#777;
  font-weight:400!important;
}
.win_score {
  color:#000!important;
}
</style>
{^include file=$mblnbanav_file^}
<fieldset class="ui-grid-b">
  <div class="ui-block-a game_prev_next_box"><a href="./?menu=nba&act=top&date={^$calendar_prev^}" class="ui-shadow ui-btn ui-corner-all">&lt;</a></div>
  <div class="ui-block-b game_title_box"><a href="#calendar" class="ui-shadow ui-btn ui-corner-all ui-btn-b">{^$calendar_title^}</a></div>
  <div class="ui-block-c game_prev_next_box"><a href="./?menu=nba&act=top&date={^$calendar_next^}" class="ui-shadow ui-btn ui-corner-all">&gt;</a></div>
</fieldset>
{^if !empty($game_info)^}
{^foreach from=$game_info item=game_item^}
<div class="ui-body ui-body-a ui-corner-all game_box">
  <div class="date_arena_box">{^$game_item["game_title"]^}</div>
  <div class="team_score_box">
    <a href="/?menu=nba&act=team_detail&t_id={^$game_item["away_team"]["t_id"]^}">
    <div class="team_box">
      <img class="team_logo" src="./img/nba/logo/{^$game_item["away_team"]["t_id"]^}.svg"/>
      <div class="team_name">{^$game_item["away_team"]["t_name"]^}</div>
    </div>
    </a>
    <div class="score_box{^if $game_item["game_status"] eq "3" and $game_item["away_team"]["is_win"]^} win_score{^/if^}">{^if $game_item["game_status"] eq "3"^}{^$game_item["away_team"]["score"]^}{^/if^}</div>
    <div class="vs_box">VS</div>
    <div class="score_box{^if $game_item["game_status"] eq "3" and $game_item["home_team"]["is_win"]^} win_score{^/if^}">{^if $game_item["game_status"] eq "3"^}{^$game_item["home_team"]["score"]^}{^/if^}</div>
    <a href="/?menu=nba&act=team_detail&t_id={^$game_item["home_team"]["t_id"]^}">
    <div class="team_box">
      <img class="team_logo" src="./img/nba/logo/{^$game_item["home_team"]["t_id"]^}.svg"/>
      <div class="team_name">{^$game_item["home_team"]["t_name"]^}</div>
    </div>
    </a>
  </div>
  <div class="ui-body">
    <a href="./?menu=nba&act=game_detail&game_id={^$game_item["game_id"]^}" class="ui-shadow ui-btn ui-corner-all ui-btn-a ui-mini">比赛详细</a>
  </div>
</div>
{^/foreach^}
{^else^}
<h3 style="text-align:center;">今日无比赛</h3>
{^/if^}
{^include file=$mblfooter_file^}