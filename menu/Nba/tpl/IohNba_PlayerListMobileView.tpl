{^include file=$mblheader_file^}
{^include file=$mblnbanav_file^}
<style type="text/css">
.headshot_box {
  width:56.6px;
  height:56.6px;
  border-radius:28.3px;
  overflow:hidden;
  float:left;
  display:block;
  margin-right:0.5em;
}
.headshot_box img {
  width:77.4px;
  height:56.6px;
  left:-10.4px;
  position:relative;
}
</style>
{^if !empty($player_list)^}
<div class="ui-body">
  <ul data-role="listview" data-inset="true">
{^foreach from=$player_list key=alpha_name item=player_item^}
    <li data-role="list-divider">{^$alpha_name^}</li>
{^foreach from=$player_item key=p_id item=player_info^}
    <li>
      <a href="./?menu=nba&act=player_detail&p_id={^$player_info["id"]^}">
        <div class="headshot_box"><img src="https://ak-static.cms.nba.com/wp-content/uploads/headshots/nba/latest/260x190/{^$player_info["id"]^}.png" /></div>
        <h2>{^$player_info["name"]^}</h2>
        <p>
          <span style="color:#{^$player_info["color"]^};">{^$player_info["team"]^}</span>
          <span>#{^$player_info["jersey"]^}</span>
          <span>{^$player_info["pos"]^}</span>
        </p>
      </a>
    </li>
{^/foreach^}
{^/foreach^}
  </ul>
</div>
{^/if^}
{^include file=$mblfooter_file^}