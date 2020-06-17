{^include file=$mblheader_file^}
<form action="./" method="post" data-ajax="false">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<input type="hidden" name="mode" value="{^if $update_flg^}1{^else^}0{^/if^}" />
<div class="ui-body ui-body-a ui-corner-all">
  <h3>{^if $update_flg^}修改{^/if^}绑定游戏角色</h3>
  <input type="text" name="player_name" value="{^$player_name^}" />
{^if isset($user_err_list["player_name"])^}
  <p class="fc_red">{^$user_err_list["player_name"]^}</p>
{^/if^}
  <button type="submit" name="do_submit" value="1">确认提交</button>
</div>
</form>
{^include file=$mblfooter_file^}