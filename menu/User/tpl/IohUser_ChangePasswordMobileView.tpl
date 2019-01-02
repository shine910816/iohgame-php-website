{^include file=$mblheader_file^}
<form action="./" method="post" data-ajax="false">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<div class="ui-body ui-body-a ui-corner-all">
  <h3>修改登录密码</h3>
  <label for="custom_password">请输入旧登录密码</label>
  <input name="custom_password" id="custom_password" type="password" />
  <label for="custom_password_new">请输入新登录密码</label>
  <input name="custom_password_new" id="custom_password_new" type="password" />
  <label for="custom_password_confirm">请确认新登录密码</label>
  <input name="custom_password_confirm" id="custom_password_confirm" type="password" />
{^if isset($user_err_list["custom_password"])^}
  <p class="fc_red">{^$user_err_list["custom_password"]^}</p>
{^/if^}
</div>
<button type="submit" name="do_change" class="ui-btn ui-corner-all ui-btn-b" />确认</button>
<a href="./?menu=user&act=safety" class="ui-btn ui-corner-all ui-btn-a" data-ajax="false">返回</a>
</form>
{^include file=$mblfooter_file^}