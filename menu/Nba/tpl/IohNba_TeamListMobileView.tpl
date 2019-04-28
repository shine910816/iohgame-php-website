{^include file=$mblheader_file^}
<div class="ui-body">
  <ul data-role="listview" data-inset="true">
{^foreach from=$team_group_list key=t_id item=team_item^}
    <li>
      <a href="./?menu=nba&act=team_detail&t_id={^$t_id^}">
        <img src="./img/nba/logo/{^$team_item["t_id"]^}.svg">
        <h2>{^$team_item["t_city_cn"]^}{^$team_item["t_name_cn"]^}</h2>
        <p>{^$team_item["t_name"]^}</p>
      </a>
    </li>
{^/foreach^}
  </ul>
</div>
{^include file=$mblfooter_file^}