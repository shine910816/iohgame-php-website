{^include file=$mblheader_file^}
{^if isset($user_err_list["no_login"])^}
<p class="fc_orange">{^$user_err_list["no_login"]^}</p>
{^/if^}
<form action="./" method="post">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<div class="ui-body ui-body-a ui-corner-all">
  <h3>用户登录</h3>
  <input type="text" name="custom_account" value="{^$custom_account^}" placeholder="登录名/手机号码/电子邮箱" />
{^if isset($user_err_list["custom_account"])^}
  <p class="fc_red">{^$user_err_list["custom_account"]^}</p>
{^/if^}
  <input type="password" name="custom_password" placeholder="登录密码" autocomplete="off" />
{^if isset($user_err_list["custom_password"])^}
  <p class="fc_red">{^$user_err_list["custom_password"]^}</p>
{^/if^}
  <fieldset data-role="controlgroup">
    <input type="checkbox" name="remember_login" id="remember_login" value="1" checked />
    <label for="remember_login">保留登录信息</label>
  </fieldset>
  <button type="submit" name="do_login" class="ui-shadow ui-btn ui-corner-all ui-btn-b">登录</button>
  <a href="./?menu=user&act=register" class="ui-shadow ui-btn ui-corner-all ui-btn-a" data-ajax="false">注册</a>
  <a href="./?menu=user&act=getback_password" class="ui-shadow ui-btn ui-corner-all ui-btn-a" data-ajax="false">忘记密码</a>
</div>
</form>
{^include file=$mblfooter_file^}