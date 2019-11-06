{^include file=$mblheader_file^}
{^include file=$mblnbanav_file^}
<fieldset class="ui-grid-a">
  <div class="ui-block-a"><a href="./?menu=nba&act=standings" class="ui-btn ui-shadow ui-corner-all ui-btn-{^if $standings_group eq "1"^}b{^else^}a{^/if^}">联盟</a></div>
  <div class="ui-block-b"><a href="./?menu=nba&act=standings&group=2" class="ui-btn ui-shadow ui-corner-all ui-btn-{^if $standings_group eq "2"^}b{^else^}a{^/if^}">大区</a></div>
</fieldset>
<style type="text/css">
.scroll_box {
  overflow:scroll;
  padding-left:0!important;
  padding-right:0!important;
}
.disp_table_box {
  width:720px;
}
.disp_table th,
.disp_table td {
  text-align:center;
}
td.team_name {
  text-align:left;
}
tr.title_tr {
  background-color:#333;
  color:#FFF;
}
tr.even_tr {
  background-color:#EEE;
}
</style>
{^foreach from=$standings_info key=group_value item=group_item^}
<h3 class="ui-bar ui-bar-a ui-corner-all">{^if $standings_group eq "1"^}{^$conference_list[$group_value]^}联盟{^else^}{^$division_list[$group_value]^}分区{^/if^}</h3>
<div class="ui-body scroll_box">
<div class="disp_table_box">
<table data-role="table" data-mode="columntoggle:none" class="ui-responsive disp_table">
  <thead>
    <tr class="title_tr">
      <td>名次</th>
      <td colspan="2">球队</th>
      <td>胜负</th>
      <td>胜率</th>
      <td>胜差</th>
      <td>联盟</th>
      <td>大区</th>
      <td>主场</th>
      <td>客场</th>
      <td>后十</th>
      <td>战绩</th>
    </tr>
  </thead>
  <tbody>
{^foreach from=$group_item key=rank_number item=team_item^}
    <tr{^if $team_item["even_cols"]^} class="even_tr"{^/if^}>
      <th>{^$rank_number^}.</th>
      <td><img src="./img/nba/logo/{^$team_item["id"]^}.svg" style="width:24px; height:24px; display:inline;"></td>
      <td class="team_name"><a href="./?menu=nba&act=team_detail&t_id={^$team_item["id"]^}">{^$team_item["name"]^}</a></td>
      <td>{^$team_item["win_loss"]^}</td>
      <td>{^$team_item["win_pct"]^}</td>
{^if $standings_group eq "1"^}
      <td>{^$team_item["conf_gb"]^}</td>
{^else^}
      <td>{^$team_item["div_gb"]^}</td>
{^/if^}
      <td>{^$team_item["conf_win_loss"]^}</td>
      <td>{^$team_item["div_win_loss"]^}</td>
      <td>{^$team_item["home_win_loss"]^}</td>
      <td>{^$team_item["away_win_loss"]^}</td>
      <td>{^$team_item["last_ten_win_loss"]^}</td>
      <td>{^$team_item["streak"]^}</td>
    </tr>
{^/foreach^}
  </tbody>
</table>
</div>
</div>
{^/foreach^}
{^include file=$mblfooter_file^}