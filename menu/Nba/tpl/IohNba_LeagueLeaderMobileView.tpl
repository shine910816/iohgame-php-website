{^include file=$mblheader_file^}
<fieldset class="ui-grid-a">
  <div class="ui-block-a"><a href="./?menu=nba&act=league_leader&period=daily" class="ui-btn ui-shadow ui-corner-all ui-btn-{^if $period eq "daily"^}b{^else^}a{^/if^}">每日</a></div>
  <div class="ui-block-b"><a href="./?menu=nba&act=league_leader&period=season" class="ui-btn ui-shadow ui-corner-all ui-btn-{^if $period eq "season"^}b{^else^}a{^/if^}">赛季</a></div>
</fieldset>
{^if $period eq "daily"^}
<select id="daily_option" data-native-menu="false" onchange="window.location.href='./?menu=nba&act=league_leader&period=daily&option='+this.value;">
{^foreach from=$daily_option_list key=daily_option_key item=daily_option_item^}
  <option value="{^$daily_option_key^}"{^if $option eq $daily_option_key^} selected{^/if^}>{^$daily_option_item^}</option>
{^/foreach^}
</select>
<table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
  <tbody>
{^foreach from=$daily_info key=daily_index item=daily_info_item^}
    <tr>
      <th style="text-align:right;">{^$daily_index + 1^}.</th>
      <td><img src="./image/nba/headshot/?person={^$daily_info_item["p_id"]^}" style="width:48px; height:48px; border-radius:24px;"></td>
      <td><a href="./?menu=nba&act=player_detail&p_id={^$daily_info_item["p_id"]^}"><b>{^if isset($player_info_list[$daily_info_item["p_id"]])^}{^if !empty($player_info_list[$daily_info_item["p_id"]]["p_name"])^}{^$player_info_list[$daily_info_item["p_id"]]["p_name"]^}{^else^}{^$player_info_list[$daily_info_item["p_id"]]["p_first_name"]^} {^$player_info_list[$daily_info_item["p_id"]]["p_last_name"]^}{^/if^}{^else^}(Undefined){^/if^}</b></a><br/>{^$team_info_list[$daily_info_item["t_id"]]["t_name_cn"]^}</td>
      <td style="text-align:right;">{^$daily_info_item[$option]^}</td>
    </tr>
{^/foreach^}
  </tbody>
</table>
{^else^}
<!-- TODO season league leader -->
{^/if^}
{^include file=$mblfooter_file^}