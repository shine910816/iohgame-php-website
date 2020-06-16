{^include file=$comheader_file^}
{^include file=$comnaviga_file^}
{^include file=$usererror_file^}
<form action="./" method="post">
  <input type="hidden" name="menu" value="{^$current_menu^}" />
  <input type="hidden" name="act" value="{^$current_act^}" />
  <input type="hidden" name="mode" value="{^if $update_flg^}1{^else^}0{^/if^}" />
  <input type="text" name="player_name" value="{^$player_name^}" />
  <button type="submit" name="do_submit" value="1">确认提交</button>
</form>
{^include file=$comfooter_file^}