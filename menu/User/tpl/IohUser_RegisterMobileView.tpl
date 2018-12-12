{^include file=$mblheader_file^}
<form action="./" method="post">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<div class="ui-body ui-body-a ui-corner-all">
  <h3>用户注册</h3>
  <label for="custom_login_name">登录名*</label>
  <input name="custom_login_name" id="custom_login_name" value="{^$custom_login_name^}" type="text">
{^if isset($user_err_list["custom_login_name"])^}
  <h4 style="color:#F60000;">{^$user_err_list["custom_login_name"]^}</h4>
{^/if^}
  <label for="custom_password">登录密码*</label>
  <input name="custom_password" id="custom_password" type="password" autocomplete="off">
  <label for="custom_password_confirm">确认密码*</label>
  <input name="custom_password_confirm" id="custom_password_confirm" type="password" autocomplete="off">
{^if isset($user_err_list["custom_password"])^}
  <h4 style="color:#F60000;">{^$user_err_list["custom_password"]^}</h4>
{^/if^}
  <label for="custom_tele_number">手机号码</label>
  <input name="custom_tele_number" id="custom_tele_number" value="{^$custom_tele_number^}" type="text">
{^if isset($user_err_list["custom_tele_number"])^}
  <h4 style="color:#F60000;">{^$user_err_list["custom_tele_number"]^}</h4>
{^/if^}
  <label for="custom_mail_address">邮箱地址</label>
  <input name="custom_mail_address" id="custom_mail_address" value="{^$custom_mail_address^}" type="text">
{^if isset($user_err_list["custom_mail_address"])^}
  <h4 style="color:#F60000;">{^$user_err_list["custom_mail_address"]^}</h4>
{^/if^}
</div>
<div data-role="collapsible" data-inset="true" data-iconpos="right">
  <h3>注意事项</h3>
  <p>1. 带有*的为必须填写项目。</p>
  <p>2. 登录名中可含有字母(不区分大小写)、数字与下划线(_)，最小长度不小于4半角字符且最大长度不大于50半角字符。</p>
  <p>3. 登录密码中可含有字母(区分大小写)、数字与符号，最小长度不小于6半角字符且最大长度不大于100半角字符。</p>
  <p>4. 手机号码与邮箱地址为选择填写项目，注册完成后可前往个人设置以完成认证绑定。</p>
</div>
<input type="submit" class="ui-btn" name="go_to_next" value="下一步" />
</form>
{^include file=$mblfooter_file^}