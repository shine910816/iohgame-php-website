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
.team_stats_chartbox {
   width:311px;
   height:311px;
   display:block;
   margin:0 auto;
}
.schedule_table_box {
  width:500px;
  margin:0 auto;
}
.roster_info_table_box {
  width:750px;
  margin:0 auto;
}
tr.title_tr {
  background-color:#333;
  color:#FFF;
}
tr.title_tr th {
  text-align:center!important;
}
tr.even_tr {
  background-color:#EEE;
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
.stage_type_1 {
  color:#FFF468!important;
}
.stage_type_2 {
  color:#AAD372!important;
}
.stage_type_3 {
  color:#68CCEF!important;
}
.stage_type_4 {
  color:#9382C9!important;
}
.win_type_0 {
  display:none;
}
.win_type_1,
.started_type_1 {
  color:#000!important;
}
.win_type_2,
.started_type_0 {
  color:#CCC!important;
}
.schedule_team_name,
.schedule_text {
  height:3.875em;
  line-height:3.875em;
}
.schedule_text {
  text-align:center!important;
}
.schedule_team_name {
  text-align:left!important;
}
.schedule_team_logo {
  width:3.875em;
  height:3.875em;
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
<p style="text-align:center!important;">{^$stats_title^}</p>
<div class="ui-body"><img src="./?menu=nba&act=chart&team_stats={^$chart_send_text^}" class="team_stats_chartbox" /></div>
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
<h4 class="ui-bar ui-bar-a ui-corner-all" id="team_schedule">赛程</h4>
<select data-native-menu="false" data-mini="true" onchange="window.location.href='./?menu=nba&act=team_detail&t_id={^$t_id^}&cal_date='+this.value;">
  <option value="{^$calendar_date^}">未选择</option>
{^foreach from=$calendar_list key=cal_key item=cal_item^}
  <option value="{^$cal_key^}"{^if $cal_key eq $calendar_date^} selected{^/if^}>{^$cal_item^}</option>
{^/foreach^}
</select>
{^if !empty($team_schedule_info)^}
<div class="ui-body scroll_box">
<div class="schedule_table_box">
<table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
  <thead>
    <tr class="title_tr">
      <th colspan="2">日期·赛程</th>
      <th colspan="3">对手</th>
      <th colspan="2">结果</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
{^foreach from=$team_schedule_info key=game_id item=schedule_item^}
    <tr>
      <td><div class="schedule_text">{^$schedule_item["game_date"]^}</div></td>
      <td><div class="schedule_text"><span class="stage_type_{^$schedule_item["stage"]^}">●</span></div></td>
      <td><div class="schedule_text">{^if !$schedule_item["is_home"]^}@{^/if^}</div></td>
      <td><img src="./img/nba/logo/{^$schedule_item["oppo_team_id"]^}.svg" class="schedule_team_logo" /></td>
      <td><div class="schedule_team_name"><a href="./?menu=nba&act=team_detail&t_id={^$schedule_item["oppo_team_id"]^}">{^$schedule_item["oppo_team_name"]^}</a></div></td>
      <td><div class="schedule_text"><span class="win_type_{^$schedule_item["is_win"]^}">●</span></div></td>
      <td><div class="schedule_text"><span class="started_type_{^$schedule_item["is_started"]^}">{^$schedule_item["review_text"]^}</span></div></td>
      <td><a href="./?menu=nba&act=game_detail&game_id={^$game_id^}" class="ui-shadow ui-btn ui-corner-all">详细</a></td>
    </tr>
{^/foreach^}
  </tbody>
</table>
<p>
注:
@客场对战
<span class="win_type_1">●</span>胜
<span class="win_type_2">●</span>负
<span class="stage_type_1">●</span>季前赛
<span class="stage_type_2">●</span>常规赛
<span class="stage_type_3">●</span>全明星赛
<span class="stage_type_4">●</span>季后赛
</p>
</div>
</div>
{^/if^}
{^/if^}
{^if !empty($team_roster_info)^}
<h4 class="ui-bar ui-bar-a ui-corner-all" id="team_roster">球员名册</h4>
<div class="ui-body scroll_box">
<div class="roster_info_table_box">
<table data-role="table" data-mode="columntoggle:none" class="ui-responsive disp_table">
  <thead>
    <tr class="title_tr">
      <th colspan="2">球员</th>
      <th>号码</th>
      <th>位置</th>
      <th>身高</th>
      <th>体重</th>
      <th>生日</th>
      <th>国籍</th>
    </tr>
  </thead>
  <tbody>
{^foreach from=$team_roster_info key=p_id item=player_item^}
    <tr{^if $player_item["info"]["is_even"]^} class="even_tr"{^/if^}>
      <td><div class="headshot_box"><img src="https://ak-static.cms.nba.com/wp-content/uploads/headshots/nba/latest/260x190/{^$p_id^}.png" /></div></td>
      <td class="name_box"><a href="./?menu=nba&act=player_detail&p_id={^$player_item["info"]["id"]^}">{^$player_item["info"]["name"]^}</a></td>
      <td class="number_box">{^$player_item["info"]["jersey"]^}</td>
      <td class="number_box">{^$player_item["info"]["position"]^}</td>
      <td class="number_box">{^$player_item["info"]["height"]^}</td>
      <td class="number_box">{^$player_item["info"]["weight"]^}</td>
      <td class="number_box">{^$player_item["info"]["birth"]^}</td>
      <td class="number_box">{^$player_item["info"]["country"]^}</td>
    </tr>
<!--img src="https://ak-static.cms.nba.com/wp-content/uploads/silos/nba/latest/440x700/{^$p_id^}.png" /-->
{^/foreach^}
  </tbody>
</table>
</div>
</div>
{^/if^}
{^include file=$mblfooter_file^}