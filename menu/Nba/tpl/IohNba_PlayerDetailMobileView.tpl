{^include file=$mblheader_file^}
{^include file=$mblnbanav_file^}
{^if $player_display_flg^}
<style type="text/css">
.detail_headshot_box {
  width:160px;
  height:160px;
  border-radius:80px;
  display:block;
  margin:0 auto;
  overflow:hidden;
  position:relative;
}
.detail_headshot_box .headshot_img {
  width:219px;
  height:160px;
  position:absolute;
  left:-29.5px;
}
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
.team_stats_chartbox {
   width:311px;
   height:311px;
   display:block;
   margin:0 auto;
}
</style>
<fieldset class="ui-grid-a">
  <div class="ui-block-a">
    <div class="detail_headshot_box">
      <img src="https://ak-static.cms.nba.com/wp-content/uploads/headshots/nba/latest/260x190/{^$p_id^}.png" class="headshot_img">
    </div>
  </div>
  <div class="ui-block-b">
    <h3>{^if $player_base_info["name"] neq $player_base_info["name_en"]^}{^$player_base_info["name"]^}{^else^}{^$player_base_info["name_en"]^}{^/if^}</h3>
    <p><a href="./?menu=nba&act=team_detail&t_id={^$player_base_info["t_id"]^}">{^$player_base_info["team"]^}</a></p>
    <p>#{^$player_base_info["jersey"]^} {^$player_base_info["pos"]^}</p>
  </div>
</fieldset>
<h4 class="ui-bar ui-bar-a ui-corner-all">技术统计</h4>
<p style="text-align:center!important;">{^$stats_title^}</p>
<div class="ui-body"><img src="./?menu=nba&act=chart&t={^$chart_send_text^}" class="team_stats_chartbox" /></div>
<fieldset class="ui-grid-b">
  <div class="ui-block-a stats_box"><b>出场</b><p>{^$player_stats_info["gp"]^}</p></div>
  <div class="ui-block-b stats_box"><b>首发</b><p>{^$player_stats_info["gs"]^}</p></div>
  <div class="ui-block-c stats_box"><b>时间</b><p>{^$player_stats_info["mpg"]^}</p></div>
</fieldset>
<fieldset class="ui-grid-b">
  <div class="ui-block-a stats_box"><b>得分</b><p>{^$player_stats_info["ppg"]^}</p></div>
  <div class="ui-block-b stats_box"><b>篮板</b><p>{^$player_stats_info["rpg"]^}</p></div>
  <div class="ui-block-c stats_box"><b>助攻</b><p>{^$player_stats_info["apg"]^}</p></div>
</fieldset>
<fieldset class="ui-grid-b">
  <div class="ui-block-a stats_box"><b>抢断</b><p>{^$player_stats_info["spg"]^}</p></div>
  <div class="ui-block-b stats_box"><b>盖帽</b><p>{^$player_stats_info["bpg"]^}</p></div>
  <div class="ui-block-c stats_box"><b>投篮%</b><p>{^$player_stats_info["fgp"]^}</p></div>
</fieldset>
<fieldset class="ui-grid-b">
  <div class="ui-block-a stats_box"><b>三分%</b><p>{^$player_stats_info["tpp"]^}</p></div>
  <div class="ui-block-b stats_box"><b>罚球%</b><p>{^$player_stats_info["ftp"]^}</p></div>
  <div class="ui-block-c stats_box"><b>前场</b><p>{^$player_stats_info["opg"]^}</p></div>
</fieldset>
<fieldset class="ui-grid-b">
  <div class="ui-block-a stats_box"><b>后场</b><p>{^$player_stats_info["dpg"]^}</p></div>
  <div class="ui-block-b stats_box"><b>犯规</b><p>{^$player_stats_info["pfpg"]^}</p></div>
  <div class="ui-block-c stats_box"><b>失误</b><p>{^$player_stats_info["topg"]^}</p></div>
</fieldset>
<fieldset class="ui-grid-b">
  <div class="ui-block-a stats_box"><b>+/-</b><p>{^$player_stats_info["pmpg"]^}</p></div>
  <div class="ui-block-b stats_box"><b>两双</b><p>{^$player_stats_info["dd2"]^}</p></div>
  <div class="ui-block-c stats_box"><b>三双</b><p>{^$player_stats_info["td3"]^}</p></div>
</fieldset>
{^if !empty($player_last5_info)^}
<h4 class="ui-bar ui-bar-a ui-corner-all">过去五战</h4>



{^/if^}
<h4 class="ui-bar ui-bar-a ui-corner-all">数据排名</h4>
<fieldset class="ui-grid-b">
  <div class="ui-block-a stats_box">
    <b>得分</b>
{^if $player_leader_info["ppg"] gt 5^}
    <p>第{^$player_leader_info["ppg"]^}名</p>
{^elseif $player_leader_info["ppg"] eq 0^}
    <p style="color:#CCC;">20名以外</p>
{^else^}
    <p style="color:#F30;">第{^$player_leader_info["ppg"]^}名</p>
{^/if^}
    <p>{^$player_stats_info["ppg"]^}</p>
  </div>
  <div class="ui-block-b stats_box">
    <b>篮板</b>
{^if $player_leader_info["rpg"] gt 5^}
    <p>第{^$player_leader_info["rpg"]^}名</p>
{^elseif $player_leader_info["rpg"] eq 0^}
    <p style="color:#CCC;">20名以外</p>
{^else^}
    <p style="color:#F30;">第{^$player_leader_info["rpg"]^}名</p>
{^/if^}
    <p>{^$player_stats_info["rpg"]^}</p>
  </div>
  <div class="ui-block-c stats_box">
    <b>助攻</b>
{^if $player_leader_info["apg"] gt 5^}
    <p>第{^$player_leader_info["apg"]^}名</p>
{^elseif $player_leader_info["apg"] eq 0^}
    <p style="color:#CCC;">20名以外</p>
{^else^}
    <p style="color:#F60;">第{^$player_leader_info["apg"]^}名</p>
{^/if^}
    <p>{^$player_stats_info["apg"]^}</p>
  </div>
</fieldset>
{^else^}
<p style="text-align:center;">非在籍球员暂无数据</p>
{^/if^}
{^include file=$mblfooter_file^}