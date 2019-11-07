{^include file=$mblheader_file^}
{^include file=$mblnbanav_file^}
{^if $player_display_flg^}
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
</style>
<div class="ui-body"><img src="https://ak-static.cms.nba.com/wp-content/uploads/headshots/nba/latest/260x190/{^$p_id^}.png" style="width:260px; height:190px; display:block; margin:0 auto;" /></div>
<h3 style="text-align:center;"></h3>
<p style="text-align:center;"></p>
<p style="text-align:center;">
</p>






<fieldset class="ui-grid-b">
  <div class="ui-block-a stats_box">
    <b>得分</b>
{^if $player_leader_info["ppg"]^}
{^if $player_leader_info["ppg"] gt 5^}
    <p>第{^$player_leader_info["ppg"]^}名</p>
{^else^}
    <p style="color:#F30;">第{^$player_leader_info["ppg"]^}名</p>
{^/if^}
{^else^}
    <p style="color:#CCC;">20名以外</p>
{^/if^}
    <p>11.1</p>
  </div>
  <div class="ui-block-b stats_box">
    <b>篮板</b>
{^if $player_leader_info["rpg"]^}
{^if $player_leader_info["rpg"] gt 5^}
    <p>第{^$player_leader_info["rpg"]^}名</p>
{^else^}
    <p style="color:#F30;">第{^$player_leader_info["rpg"]^}名</p>
{^/if^}
{^else^}
    <p style="color:#CCC;">20名以外</p>
{^/if^}
    <p>11.1</p>
  </div>
  <div class="ui-block-c stats_box">
    <b>助攻</b>
{^if $player_leader_info["apg"]^}
{^if $player_leader_info["apg"] gt 5^}
    <p>第{^$player_leader_info["apg"]^}名</p>
{^else^}
    <p style="color:#F60;">第{^$player_leader_info["apg"]^}名</p>
{^/if^}
{^else^}
    <p style="color:#CCC;">20名以外</p>
{^/if^}
    <p>11.1</p>
  </div>
</fieldset>
{^else^}
<p style="text-align:center;">非在籍球员暂无数据</p>
{^/if^}
{^include file=$mblfooter_file^}