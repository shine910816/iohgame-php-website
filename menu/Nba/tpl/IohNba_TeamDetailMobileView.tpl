{^include file=$mblheader_file^}
<h3 class="ui-bar ui-bar-a ui-corner-all">{^$team_info["t_name_short"]^}</h3>
<div class="ui-body"><img src="./image/nba/logo/?team={^$team_info["t_name_short"]^}" style="width:311px; height:311px;"></div>
<div class="ui-body">
  <h3>{^$team_info["t_city_cn"]^}{^$team_info["t_name_cn"]^}</h3>
  <p>{^$team_info["t_name"]^}</p>
  <p>{^$team_info["t_city_ja"]^}·{^$team_info["t_name_ja"]^}</p>
  <h3>{^$conf_list["cn"][$team_info["t_conference"]]^} / {^$divi_list["cn"][$team_info["t_division"]]^}</h3>
  <p>{^$conf_list["en"][$team_info["t_conference"]]^} / {^$divi_list["en"][$team_info["t_division"]]^}</p>
  <p>{^$conf_list["ja"][$team_info["t_conference"]]^} / {^$divi_list["ja"][$team_info["t_division"]]^}</p>
</div>
<a href="{^$back_url^}" class="ui-btn ui-shadow ui-btn-a ui-corner-all">返回</a>
{^include file=$mblfooter_file^}