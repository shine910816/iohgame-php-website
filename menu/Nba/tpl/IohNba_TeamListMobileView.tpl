{^include file=$mblheader_file^}
<fieldset class="ui-grid-a">
  <div class="ui-block-a"><a {^if $group eq "1"^}href="./?menu=nba&act=team_list" class="ui-btn ui-btn-b ui-corner-all ui-shadow"{^else^}href="./?menu=nba&act=team_list&group=1" class="ui-btn ui-btn-a ui-corner-all ui-shadow"{^/if^}>联盟</a></div>
  <div class="ui-block-b"><a {^if $group eq "2"^}href="./?menu=nba&act=team_list" class="ui-btn ui-btn-b ui-corner-all ui-shadow"{^else^}href="./?menu=nba&act=team_list&group=2" class="ui-btn ui-btn-a ui-corner-all ui-shadow"{^/if^}>分区</a></div>
</fieldset>
{^if $group eq "1"^}
{^foreach from=$conf_list["cn"] key=t_conference item=conf_name^}
<h3 class="ui-bar ui-bar-a ui-corner-all">{^$conf_name^}</h3>
<div class="ui-body">
  <ul data-role="listview" data-inset="true">
{^foreach from=$team_group_list[$t_conference] key=t_id item=team_item^}
    <li>
      <a href="./?menu=nba&act=team_detail&t_id={^$t_id^}">
        <img src="https://china.nba.com/media/img/teams/logos/{^$team_item["t_name_short"]^}_logo.svg">
        <h2>{^$team_item["t_city_cn"]^} {^$team_item["t_name_cn"]^}</h2>
        <p>{^$team_item["t_name"]^}</p>
      </a>
    </li>
{^/foreach^}
  </ul>
</div>
{^/foreach^}
{^elseif $group eq "2"^}
{^foreach from=$divi_list["cn"] key=t_division item=divi_name^}
<h3 class="ui-bar ui-bar-a ui-corner-all">{^$divi_name^}</h3>
<div class="ui-body">
  <ul data-role="listview" data-inset="true">
{^foreach from=$team_group_list[$t_division] key=t_id item=team_item^}
    <li>
      <a href="./?menu=nba&act=team_detail&t_id={^$t_id^}">
        <img src="https://china.nba.com/media/img/teams/logos/{^$team_item["t_name_short"]^}_logo.svg">
        <h2>{^$team_item["t_city_cn"]^} {^$team_item["t_name_cn"]^}</h2>
        <p>{^$team_item["t_name"]^}</p>
      </a>
    </li>
{^/foreach^}
  </ul>
</div>
{^/foreach^}
{^else^}
<div class="ui-body">
  <ul data-role="listview" data-inset="true">
{^foreach from=$team_group_list key=t_id item=team_item^}
    <li>
      <a href="./?menu=nba&act=team_detail&t_id={^$t_id^}">
        <img src="https://china.nba.com/media/img/teams/logos/{^$team_item["t_name_short"]^}_logo.svg">
        <h2>{^$team_item["t_city_cn"]^} {^$team_item["t_name_cn"]^}</h2>
        <p>{^$team_item["t_name"]^}</p>
      </a>
    </li>
{^/foreach^}
  </ul>
</div>
{^/if^}
{^include file=$mblfooter_file^}