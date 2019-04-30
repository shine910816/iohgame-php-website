{^include file=$mblheader_file^}
<style type="text/css">
.stats_box {
  border-bottom:1px solid #DDD;
}
.stats_box b {
  width:100%;
  text-align:center;
  display:block;
  margin-top:1em;
}
.stats_box b,
.stats_box p {
  text-align:center;
}
.scroll_box {
  overflow:scroll;
  padding-left:0!important;
  padding-right:0!important;
}
.schedule_table_box {
  width:380px;
}
.disp_table th,
.disp_table td {
  text-align:center;
}
</style>
<fieldset class="ui-grid-a">
  <div class="ui-block-a">
    <img src="./img/nba/logo/{^$t_id^}.svg" style="width:160px; height:160px;">
  </div>
  <div class="ui-block-b">
    <h3>{^$team_base_info["name_cn"]^}</h3>
    <p>{^$team_base_info["name"]^}</p>
  </div>
</fieldset>
{^if !empty($team_standings_info)^}
<h4 class="ui-bar ui-bar-a ui-corner-all">战绩</h4>
<table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
  <tbody>
    <tr>
      <th>胜负</th>
      <td>{^$team_standings_info["win_loss"]^}</td>
    </tr>
    <tr>
      <th></th>
      <td>胜率{^$team_standings_info["win_pct"]^}</td>
    </tr>
    <tr>
      <th>联盟战绩</th>
      <td>{^$team_standings_info["conf_win_loss"]^}</td>
    </tr>
    <tr>
      <th></th>
      <td>{^$team_standings_info["conference"]^}第{^$team_standings_info["conf_rank"]^}名</td>
    </tr>
    <tr>
      <th>分区战绩</th>
      <td>{^$team_standings_info["div_win_loss"]^}</td>
    </tr>
    <tr>
      <th></th>
      <td>{^$team_standings_info["division"]^}第{^$team_standings_info["div_rank"]^}名</td>
    </tr>
    <tr>
      <th>联盟胜差</th>
      <td>{^$team_standings_info["conf_gb"]^}</td>
    </tr>
    <tr>
      <th>主场战绩</th>
      <td>{^$team_standings_info["home_win_loss"]^}</td>
    </tr>
    <tr>
      <th>客场战绩</th>
      <td>{^$team_standings_info["away_win_loss"]^}</td>
    </tr>
    <tr>
      <th>近十战绩</th>
      <td>{^$team_standings_info["last_win_loss"]^}</td>
    </tr>
    <tr>
      <th>连续战绩</th>
      <td>{^$team_standings_info["streak"]^}</td>
    </tr>
  </tbody>
</table>
{^/if^}
{^if !empty($team_stats_info)^}
<h4 class="ui-bar ui-bar-a ui-corner-all">技术统计</h4>
<fieldset class="ui-grid-b">
  <div class="ui-block-a stats_box"><b>场次</b><p>{^$team_stats_info["gp"]^}</p></div>
  <div class="ui-block-b stats_box"><b>得分</b><p>{^$team_stats_info["ppg"]^}</p></div>
  <div class="ui-block-c stats_box"><b>篮板</b><p>{^$team_stats_info["rpg"]^}</p></div>
</fieldset>
<fieldset class="ui-grid-b">
  <div class="ui-block-a stats_box"><b>助攻</b><p>{^$team_stats_info["apg"]^}</p></div>
  <div class="ui-block-b stats_box"><b>抢断</b><p>{^$team_stats_info["spg"]^}</p></div>
  <div class="ui-block-c stats_box"><b>盖帽</b><p>{^$team_stats_info["bpg"]^}</p></div>
</fieldset>
<fieldset class="ui-grid-b">
  <div class="ui-block-a stats_box"><b>投篮%</b><p>{^$team_stats_info["fgp"]^}</p></div>
  <div class="ui-block-b stats_box"><b>三分%</b><p>{^$team_stats_info["tpp"]^}</p></div>
  <div class="ui-block-c stats_box"><b>罚球%</b><p>{^$team_stats_info["ftp"]^}</p></div>
</fieldset>
<fieldset class="ui-grid-b">
  <div class="ui-block-a stats_box"><b>失误</b><p>{^$team_stats_info["topg"]^}</p></div>
  <div class="ui-block-b stats_box"><b>犯规</b><p>{^$team_stats_info["pfpg"]^}</p></div>
  <div class="ui-block-c"></div>
</fieldset>
{^/if^}
{^if !empty($calendar_list)^}
<h4 class="ui-bar ui-bar-a ui-corner-all">赛程</h4>
<select data-native-menu="false" data-mini="true" onchange="window.location.href='./?menu=nba&act=team_detail&t_id={^$t_id^}&roster={^$roster_option^}&cal_date='+this.value;">
{^foreach from=$calendar_list key=cal_key item=cal_item^}
  <option value="{^$cal_key^}"{^if $cal_key eq $calendar_date^} selected{^/if^}>{^$cal_item^}</option>
{^/foreach^}
</select>
{^if !empty($team_schedule_info)^}
<table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
  <tbody>
{^foreach from=$team_schedule_info key=game_id item=schedule_item^}
    <tr>
      <td>{^$schedule_item["game_date"]^}<td>
      <td>{^if $schedule_item["is_home"]^}vs{^else^}@{^/if^}<a href="./?menu=nba&act=team_detail&t_id={^$schedule_item["oppo_team_id"]^}">{^$schedule_item["oppo_team_name"]^}</a><td>
      <td><a href="./?menu=nba&act=game_detail&game_id={^$game_id^}">{^$schedule_item["review_text"]^}</a><td>
    </tr>
{^/foreach^}
  </tbody>
</table>
{^/if^}
{^/if^}
{^if !empty(team_roster_info)^}
<h4 class="ui-bar ui-bar-a ui-corner-all">球员名册</h4>
{^foreach from=$team_roster_info key=p_id item=player_item^}
<img src="https://ak-static.cms.nba.com/wp-content/uploads/headshots/nba/latest/260x190/{^$p_id^}.png" />
<p>#{^$player_item["info"]["jersey"]^} {^$player_item["info"]["name"]^}</p>
<!--img src="https://ak-static.cms.nba.com/wp-content/uploads/silos/nba/latest/440x700/{^$p_id^}.png" /-->
{^/foreach^}
{^/if^}



{^include file=$mblfooter_file^}