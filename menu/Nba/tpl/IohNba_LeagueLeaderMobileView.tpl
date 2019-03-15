{^include file=$mblheader_file^}
<fieldset class="ui-grid-a">
  <div class="ui-block-a"><a href="./?menu=nba&act=league_leader&period=daily" class="ui-btn ui-shadow ui-corner-all ui-btn-{^if $period eq "daily"^}b{^else^}a{^/if^}">每日</a></div>
  <div class="ui-block-b"><a href="./?menu=nba&act=league_leader&period=season" class="ui-btn ui-shadow ui-corner-all ui-btn-{^if $period eq "season"^}b{^else^}a{^/if^}">赛季</a></div>
</fieldset>
{^if $period eq "daily"^}
<fieldset class="ui-grid-a">
  <div class="ui-block-a"><a href="./?menu=nba&act=league_leader&period=daily&option=pts" class="ui-btn ui-shadow ui-corner-all ui-btn-{^if $option eq "pts"^}b{^else^}a{^/if^}">得分</a></div>
  <div class="ui-block-b"><a href="./?menu=nba&act=league_leader&period=daily&option=reb" class="ui-btn ui-shadow ui-corner-all ui-btn-{^if $option eq "reb"^}b{^else^}a{^/if^}">篮板</a></div>
</fieldset>
<fieldset class="ui-grid-b">
  <div class="ui-block-a"><a href="./?menu=nba&act=league_leader&period=daily&option=ast" class="ui-btn ui-shadow ui-corner-all ui-btn-{^if $option eq "ast"^}b{^else^}a{^/if^}">助攻</a></div>
  <div class="ui-block-b"><a href="./?menu=nba&act=league_leader&period=daily&option=blk" class="ui-btn ui-shadow ui-corner-all ui-btn-{^if $option eq "blk"^}b{^else^}a{^/if^}">盖帽</a></div>
  <div class="ui-block-c"><a href="./?menu=nba&act=league_leader&period=daily&option=stl" class="ui-btn ui-shadow ui-corner-all ui-btn-{^if $option eq "stl"^}b{^else^}a{^/if^}">抢断</a></div>
</fieldset>
<table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
  <tbody>
{^foreach from=$daily_info key=daily_index item=daily_info_item^}
    <tr>
      <th>{^$daily_index + 1^}</th>
      <td><img src="./image/nba/headshot/?person={^$daily_info_item["p_id"]^}" style="width:48px; height:48px; border-radius:24px;"></td>
      <td><a href="./?menu=nba&act=player_detail&p_id={^$daily_info_item["p_id"]^}"><b>{^if !empty($player_info_list[$daily_info_item["p_id"]]["p_name"])^}{^$player_info_list[$daily_info_item["p_id"]]["p_name"]^}{^else^}{^$player_info_list[$daily_info_item["p_id"]]["p_first_name"]^} {^$player_info_list[$daily_info_item["p_id"]]["p_last_name"]^}{^/if^}</b></a><br/>{^$team_info_list[$player_info_list[$daily_info_item["p_id"]]["t_id"]]["t_name_cn"]^}</td>
      <td>{^$daily_info_item[$option]^}</td>
    </tr>
{^/foreach^}
  </tbody>
</table>
<form action="./" method="post">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<input type="hidden" name="period" value="{^$period^}" />
<input type="hidden" name="option" value="{^$option^}" />
<input type="submit" name="refresh" value="刷新" class="ui-btn ui-shadow ui-corner-all ui-btn-a" />
</form>
{^else^}
<!-- TODO season league leader -->
{^/if^}
{^include file=$mblfooter_file^}