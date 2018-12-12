{^include file=$mblheader_file^}
<form action="./" method="post">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<div class="ui-body ui-body-a ui-corner-all">
  <h3>用户登录</h3>
  <input type="text" name="custom_account" value="{^$custom_account^}" placeholder="登录名/手机号码/电子邮箱" />
{^if isset($user_err_list["custom_account"])^}
  <h4 style="color:#F60000;">{^$user_err_list["custom_account"]^}</h4>
{^/if^}
  <input type="password" name="custom_password" placeholder="登录密码" autocomplete="off" />
{^if isset($user_err_list["custom_password"])^}
  <h4 style="color:#F60000;">{^$user_err_list["custom_password"]^}</h4>
{^/if^}
  <input type="submit" name="do_login" value="登录" class="ui-shadow ui-btn ui-corner-all" />
</div>
</form>
{^include file=$mblfooter_file^}