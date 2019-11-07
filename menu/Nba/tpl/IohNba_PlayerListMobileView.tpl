{^include file=$mblheader_file^}
{^include file=$mblnbanav_file^}
<style type="text/css">
.headshot_box {
  width:48px;
  height:48px;
  overflow:hidden;
  border-radius:24px;
}
.headshot_box img {
  width:66px;
  height:48px;
  left:-9px;
  position:relative;
}
</style>
{^if !empty($player_list)^}
{^foreach from=$player_list key=alpha_name item=player_item^}
<h4 class="ui-bar ui-bar-a ui-corner-all">{^$alpha_name^}</h4>
<table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
  <tbody>
{^foreach from=$player_item key=p_id item=player_info^}
    <tr>
      <td><div class="headshot_box"><img src="https://ak-static.cms.nba.com/wp-content/uploads/headshots/nba/latest/260x190/{^$player_info["id"]^}.png" /></div></td>
      <td>
        <a href="./?menu=nba&act=player_detail&p_id={^$player_info["id"]^}"><b>{^$player_info["name"]^}</b></a><br/>
        <span style="color:#{^$player_info["color"]^};">{^$player_info["team"]^}</span>
        <span>#{^$player_info["jersey"]^}</span>
        <span>{^$player_info["pos"]^}</span>
      </td>
    </tr>
{^/foreach^}
  </tbody>
</table>
{^/foreach^}
{^/if^}
{^include file=$mblfooter_file^}