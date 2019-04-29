{^include file=$mblheader_file^}
<!--fieldset class="ui-grid-a">
  <div class="ui-block-a">
    <img src="./img/nba/logo/{^$team_info["t_id"]^}.svg" style="width:160px; height:160px;">
  </div>
  <div class="ui-block-b">
    <h3>&nbsp;</h3>
    <h3 style="color:#{^$team_info["t_color"]^}!important;">{^$team_info["t_city_cn"]^}{^$team_info["t_name_cn"]^}</h3>
    <p style="color:#{^$team_info["t_color"]^}!important;">{^$team_info["t_name"]^}</p>
  </div>
</fieldset>
<div class="ui-body">
  <div data-role="collapsible" data-collapsed="false" data-iconpos="right">
    <h4>战绩</h4>
    <table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
      <tbody>
        <tr>
          <th>胜负</th>
          <td>{^$standings_info["win"]^} - {^$standings_info["loss"]^}</td>
        </tr>
        <tr>
          <th></th>
          <td>胜率{^$standings_info["winPctV2"]^}%</td>
        </tr>
        <tr>
          <th>联盟战绩</th>
          <td>{^$standings_info["confWin"]^} - {^$standings_info["confLoss"]^}</td>
        </tr>
        <tr>
          <th></th>
          <td>第{^$standings_info["confRank"]^}名 - {^$conf_list["cn"][$team_info["t_conference"]]^}</td>
        </tr>
        <tr>
          <th>分区战绩</th>
          <td>{^$standings_info["divWin"]^} - {^$standings_info["divLoss"]^}</td>
        </tr>
        <tr>
          <th></th>
          <td>第{^$standings_info["divRank"]^}名 - {^$divi_list["cn"][$team_info["t_division"]]^}</td>
        </tr>
        <tr>
          <th>联盟胜差</th>
          <td>{^$standings_info["gamesBehind"]^}</td>
        </tr>
        <tr>
          <th>主场战绩</th>
          <td>{^$standings_info["homeWin"]^} - {^$standings_info["homeLoss"]^}</td>
        </tr>
        <tr>
          <th>客场战绩</th>
          <td>{^$standings_info["awayWin"]^} - {^$standings_info["awayLoss"]^}</td>
        </tr>
        <tr>
          <th>近十战绩</th>
          <td>{^$standings_info["lastTenWin"]^} - {^$standings_info["lastTenLoss"]^}</td>
        </tr>
        <tr>
          <th>连续战绩</th>
          <td>{^if $standings_info["isWinStreak"]^}胜{^else^}负{^/if^}{^$standings_info["streak"]^}</td>
        </tr>
      </tbody>
    </table>
  </div>
  <div data-role="collapsible" data-iconpos="right">
    <h4>球员名册</h4>
    <ul data-role="listview" data-inset="true">
{^foreach from=$player_list key=player_id item=player_info^}
      <li>
        <a href="./?menu=nba&act=player_detail&p_id={^$player_id^}">
          <img src="./image/nba/headshot/?person={^$player_id^}" style="width:80px; height:80px; border-radius:40px;">
          <h2>{^if empty($player_info_list[$player_id]["p_name"])^}{^$player_info["firstName"]^} {^$player_info["lastName"]^}{^else^}{^$player_info_list[$player_id]["p_name"]^}{^/if^}</h2>
          <p>#{^$player_info["jersey"]^}{^if $player_info_list[$player_id]["p_position"] neq 0^} / {^$position_info_list[$player_info_list[$player_id]["p_position"]]^}{^/if^}{^if $player_info_list[$player_id]["p_position_2"] neq 0^}-{^$position_info_list[$player_info_list[$player_id]["p_position_2"]]^}{^/if^}</p>
        </a>
      </li>
{^/foreach^}
    </ul>
  </div>
</div>
<a href="{^$back_url^}" class="ui-btn ui-shadow ui-btn-a ui-corner-all">返回</a-->
{^include file=$mblfooter_file^}