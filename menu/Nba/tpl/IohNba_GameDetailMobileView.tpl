{^include file=$mblheader_file^}
{^include file=$mblnbanav_file^}
<link rel="stylesheet" href="css/common/common_font_plus.css" type="text/css" />
<style type="text/css">
.date_arena_box {
  width:100%;
  height:2.5em;
  text-align:center;
  line-height:3em;
  color:#777;
}
.team_score_box {
  width:100%;
  height:5em;
  margin-top:0.5em;
}
.team_score_box .team_box,
.team_score_box .score_box,
.team_score_box .vs_box {
  height:4.5em;
  float:left;
}
.team_score_box .team_box {
  width:25%;
  height:4.5em;
}
.team_score_box .score_box {
  width:20%;
  height:1em;
  text-align:center;
  line-height:1.5em;
  color:#777;
  font-size:3em;
  font-family:Nba;
}
.team_score_box .vs_box {
  width:10%;
  height:3em;
  text-align:center;
  line-height:3em;
  font-size:1.5em;
  color:#000;
  font-family:Nba;
}
.team_score_box .team_box img.team_logo {
  width:3em;
  height:3em;
  margin:0 auto;
  display:block;
}
.team_score_box .team_box .team_name {
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
.loss_score {
  color:#777!important;
}
.mt_75 {
  margin-top:0.75em;
}
.ta_c {
  text-align:center!important;
}
.scroll_box {
  overflow:scroll;
  padding-left:0!important;
  padding-right:0!important;
}
.boxscore_table_box {
  width:1000px;
  margin:0 auto;
}
tr.title_tr {
  background-color:#333;
  color:#FFF;
}
tr.title_tr th {
  text-align:center!important;
}
.headshot_box {
  width:48px;
  height:48px;
  overflow:hidden;
  border-radius:24px;
}
.headshot_box img {
  width:66px;
  height:48px;
  left:-9px;
  position:relative;
}
.name_box {
  text-align:left!important;
}
.number_box {
  text-align:center!important;
}
.name_box, .number_box {
  line-height:3em!important;
}
</style>
<div class="date_arena_box">{^$game_info["start"]^} {^$game_info["arena"]^}</div>
<div class="team_score_box">
  <a href="/?menu=nba&act=team_detail&t_id={^$game_info["away"]^}">
  <div class="team_box">
    <img class="team_logo" src="./img/nba/logo/{^$game_info["away"]^}.svg"/>
    <div class="team_name">{^$team_info[$game_info["away"]]["name_cn"]^}</div>
  </div>
  </a>
  <div class="score_box{^if $game_info["status"] eq "3" and $game_info["score"]["TO"]["0"] gt $game_info["score"]["TO"]["1"]^} win_score{^/if^}">{^if $game_info["status"] eq "3"^}{^$game_info["score"]["TO"]["0"]^}{^/if^}</div>
  <div class="vs_box">VS</div>
  <div class="score_box{^if $game_info["status"] eq "3" and $game_info["score"]["TO"]["1"] gt $game_info["score"]["TO"]["0"]^} win_score{^/if^}">{^if $game_info["status"] eq "3"^}{^$game_info["score"]["TO"]["1"]^}{^/if^}</div>
  <a href="/?menu=nba&act=team_detail&t_id={^$game_info["home"]^}">
  <div class="team_box">
    <img class="team_logo" src="./img/nba/logo/{^$game_info["home"]^}.svg"/>
    <div class="team_name">{^$team_info[$game_info["home"]]["name_cn"]^}</div>
  </div>
  </a>
</div>
<h4 class="ui-bar ui-bar-a ui-corner-all mt_75">比分</h4>
{^if $game_info["status"] eq "1"^}
<h3 style="text-align:center;">比赛未开始</h3>
{^else^}
<table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
  <thead>
    <tr>
      <th class="ta_c">&nbsp;</th>
      <th class="ta_c">{^$team_info[$game_info["away"]]["name_cn"]^}</th>
      <th class="ta_c">{^$team_info[$game_info["home"]]["name_cn"]^}</th>
    </tr>
  </thead>
  <tbody>
{^foreach from=$game_info["score"] key=current_name item=score_item^}
    <tr>
      <th class="ta_c">{^$current_name^}</th>
      <td class="ta_c{^if $score_item["0"] lt $score_item["1"]^} loss_score{^else^} win_score{^/if^}">{^$score_item["0"]^}</td>
      <td class="ta_c{^if $score_item["1"] lt $score_item["0"]^} loss_score{^else^} win_score{^/if^}">{^$score_item["1"]^}</td>
    </tr>
{^/foreach^}
  </tbody>
</table>
{^/if^}
<h4 class="ui-bar ui-bar-a ui-corner-all mt_75">统计</h4>
{^if $game_info["status"] eq "1"^}
<h3 style="text-align:center;">比赛未开始</h3>
{^else^}
{^foreach from=$boxscore_info key=team_id item=boxscore_item^}
<p>{^$team_info[$team_id]["name_full"]^}</p>
<div class="ui-body scroll_box">
<div class="boxscore_table_box">
<table data-role="table" data-mode="columntoggle:none" class="ui-responsive disp_table">
  <thead>
    <tr class="title_tr">
      <th colspan="2">球员</th>
      <th>首发</th>
      <th>时间</th>
      <th>得分</th>
      <th>篮板</th>
      <th>助攻</th>
      <th>抢断</th>
      <th>盖帽</th>
      <th>投篮</th>
      <th>三分</th>
      <th>罚球</th>
      <th>前场</th>
      <th>后场</th>
      <th>犯规</th>
      <th>失误</th>
    </tr>
  </thead>
  <tbody>
{^foreach from=$boxscore_item key=player_id item=player_item^}
{^if $player_item["p"] eq "C"^}
    <tr style="border-bottom:1px solid #CCC!important;">
{^elseif $player_id eq "total"^}
    <tr style="border-top:1px solid #CCC!important;">
{^else^}
    <tr>
{^/if^}
{^if $player_id eq "total"^}
      <td><div class="headshot_box" style="border-radius:0!important;"><img src="./img/nba/logo/{^$team_id^}.svg" style="width:48px; height:48px; left:0!important;" /></div></td>
      <td class="name_box">合计</td>
{^else^}
      <td><div class="headshot_box"><img src="https://ak-static.cms.nba.com/wp-content/uploads/headshots/nba/latest/260x190/{^$player_id^}.png" /></div></td>
      <td class="name_box"><a href="./?menu=nba&act=player_detail&p_id={^$player_id^}">{^$player_item["name"]^}</a></td>
{^/if^}
      <td class="number_box">{^$player_item["p"]^}</td>
      <td class="number_box">{^$player_item["min"]^}</td>
      <td class="number_box">{^$player_item["pts"]^}</td>
      <td class="number_box">{^$player_item["reb"]^}</td>
      <td class="number_box">{^$player_item["ast"]^}</td>
      <td class="number_box">{^$player_item["stl"]^}</td>
      <td class="number_box">{^$player_item["blk"]^}</td>
      <td class="number_box">{^$player_item["fg"]^}</td>
      <td class="number_box">{^$player_item["tp"]^}</td>
      <td class="number_box">{^$player_item["ft"]^}</td>
      <td class="number_box">{^$player_item["off"]^}</td>
      <td class="number_box">{^$player_item["def"]^}</td>
      <td class="number_box">{^$player_item["pf"]^}</td>
      <td class="number_box">{^$player_item["to"]^}</td>
    </tr>
{^/foreach^}
  </tbody>
</table>
</div>
</div>
{^/foreach^}
{^/if^}
<h4 class="ui-bar ui-bar-a ui-corner-all mt_75">实况</h4>
{^if $game_info["status"] eq "1"^}
<h3 style="text-align:center;">比赛未开始</h3>
{^else^}
{^if !empty($pbp_info)^}
<div data-role="collapsibleset">
{^foreach from=$pbp_info key=current_name item=pbp_item^}
  <div data-role="collapsible" data-collapsed-icon="carat-r" data-expanded-icon="carat-d" data-theme="a">
    <h3>{^$current_name^}</h3>
    <table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
      <tbody>
{^foreach from=$pbp_item item=play_by_play_item^}
        <tr>
          <th>{^if $play_by_play_item["type"] eq "12" or $play_by_play_item["type"] eq "13" or $play_by_play_item["change"] eq "1"^}{^$play_by_play_item["score"]^}{^/if^}</th>
          <td>{^$play_by_play_item["clock"]^}</td>
          <td>{^$play_by_play_item["desc"]^}</td>
        </tr>
{^/foreach^}
      </tbody>
    </table>
  </div>
{^/foreach^}
</div>
{^/if^}
{^/if^}
{^include file=$mblfooter_file^}