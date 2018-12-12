{^include file=$comheader_file^}
{^include file=$comnaviga_file^}
{^include file=$usererror_file^}
<link rel="stylesheet" href="css/user/user_login.css" type="text/css" />
<form action="./" method="post" class="form-box bl_c mt_30">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<div class="form-title">用户登录</div>
<ul>
  <li class="case-title">用户名</li>
  <li id="cus_name_box"><input type="text" name="custom_account" class="input-box" value="{^$custom_account^}" /></li>
</ul>
<ul>
  <li class="case-title">密码</li>
  <li><input type="password" name="custom_password" class="input-box" /> &nbsp;<a href="./?menu=user&act=getback_password" class="link-black">忘记密码</a></li>
</ul>
<ul>
  <li class="button-box"><input type="button" name="do_reg" value="注册" class="button btn_grey bl_c" id="do_reg" /></li>
  <li class="button-box"><input type="submit" name="do_login" value="登录" class="button btn_orange bl_c" /></li>
</ul>
</form>
{^include file=$comfooter_file^}