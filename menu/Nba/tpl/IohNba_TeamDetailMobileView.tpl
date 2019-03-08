{^include file=$mblheader_file^}
<fieldset class="ui-grid-a">
  <div class="ui-block-a">
    <img src="./image/nba/logo/?team={^$team_info["t_name_short"]^}" style="width:160px; height:160px;">
  </div>
  <div class="ui-block-b">
    <h3>{^$team_info["t_city_cn"]^}{^$team_info["t_name_cn"]^}</h3>
    <p>{^$team_info["t_name"]^}</p>
  </div>
</fieldset>
<div class="ui-body">
  <h3>战绩</h3>
  <table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
    <tbody>
      <tr>
        <th>胜负</th>
        <td>{^$standings_info["win"]^}-{^$standings_info["loss"]^}</td>
        <td>胜率{^$standings_info["winPctV2"]^}%</td>
      </tr>
      <tr>
        <th>联盟战绩</th>
        <td>{^$standings_info["confWin"]^}-{^$standings_info["confLoss"]^}</td>
        <td>{^$conf_list["cn"][$team_info["t_conference"]]^}第{^$standings_info["confRank"]^}</td>
      </tr>
      <tr>
        <th>分区战绩</th>
        <td>{^$standings_info["divWin"]^}-{^$standings_info["divLoss"]^}</td>
        <td>{^$divi_list["cn"][$team_info["t_division"]]^}第{^$standings_info["divRank"]^}</td>
      </tr>
      <tr>
        <th>主场战绩</th>
        <td>{^$standings_info["homeWin"]^}-{^$standings_info["homeLoss"]^}</td>
        <td></td>
      </tr>
      <tr>
        <th>客场战绩</th>
        <td>{^$standings_info["awayWin"]^}-{^$standings_info["awayLoss"]^}</td>
        <td></td>
      </tr>
      <tr>
        <th>近十战绩</th>
        <td>{^$standings_info["lastTenWin"]^}-{^$standings_info["lastTenLoss"]^}</td>
        <td></td>
      </tr>
      <tr>
        <th>连续战绩</th>
        <td>{^if $standings_info["isWinStreak"]^}胜{^else^}负{^/if^}{^$standings_info["streak"]^}</td>
        <td></td>
      </tr>
    </tbody>
  </table>
  <h3>球员名册</h3>
  <ul data-role="listview" data-inset="true">
{^foreach from=$player_list key=played_id item=player_info^}
    <li>
      <a href="#">
        <img src="./image/nba/headshot/?person={^$played_id^}">
        <h2>{^$player_info["firstName"]^} {^$player_info["lastName"]^}</h2>
        <p>#{^$player_info["jersey"]^} | {^$player_info["pos"]^}</p>
      </a>
    </li>
{^/foreach^}
  </ul>
</div>
<a href="{^$back_url^}" class="ui-btn ui-shadow ui-btn-a ui-corner-all">返回</a>
{^include file=$mblfooter_file^}