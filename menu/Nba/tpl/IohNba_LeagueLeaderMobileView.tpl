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
{^if !empty($leader_player_list)^}
<table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
  <tbody>
{^foreach from=$leader_player_list item=daily_info_item^}
    <tr>
      <th style="text-align:right;">{^$daily_info_item["rank"]^}.</th>
      <td><img src="./image/nba/headshot/?person={^$daily_info_item["p_id"]^}" style="width:48px; height:48px; border-radius:24px;"></td>
      <td>
        <a href="./?menu=nba&act=player_detail&p_id={^$daily_info_item["p_id"]^}"><b>{^$daily_info_item["player_name"]^}</b></a><br/>
        <span style="color:#{^$daily_info_item["team_color"]^};">{^$daily_info_item["team_name"]^}</span>
      </td>
      <td style="text-align:right;">{^$daily_info_item["value"]^}</td>
    </tr>
{^/foreach^}
  </tbody>
</table>
{^/if^}
{^else^}
<!-- TODO season league leader -->
{^/if^}
{^include file=$mblfooter_file^}