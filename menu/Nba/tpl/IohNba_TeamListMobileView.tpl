{^include file=$mblheader_file^}
{^if !empty($team_list)^}
{^foreach from=$team_list item=team_item^}
<div data-role="collapsible" data-collapsed-icon="carat-d" data-expanded-icon="carat-u" data-collapsed="false" data-iconpos="right">
  <h4>{^$team_item["t_name_short"]^}</h4>
  <div style="width:100%; height:309px;">
    <img src="https://china.nba.com/media/img/teams/logos/{^$team_item["t_name_short"]^}_logo.svg" style="width:309px; height:309px; margin:0 auto;"/>
  </div
  <p>{^$team_item["t_city_cn"]^} {^$team_item["t_name_cn"]^}</p>
  <p>{^$team_item["t_name"]^}</p>
  <p>{^$team_item["t_city_ja"]^}·{^$team_item["t_name_ja"]^}</p>
  <hr/>
  <p>{^$conf_list["cn"][$team_item["t_conference"]]^} / {^$divi_list["cn"][$team_item["t_division"]]^}</p>
  <p>{^$conf_list["en"][$team_item["t_conference"]]^} / {^$divi_list["en"][$team_item["t_division"]]^}</p>
  <p>{^$conf_list["ja"][$team_item["t_conference"]]^} / {^$divi_list["ja"][$team_item["t_division"]]^}</p>
</div>
{^/foreach^}
{^/if^}
{^include file=$mblfooter_file^}