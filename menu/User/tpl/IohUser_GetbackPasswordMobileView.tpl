{^include file=$mblheader_file^}
<form action="./" method="get" data-ajax="false">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<div class="ui-body ui-body-a ui-corner-all">
  <h3>找回用户登录密码</h3>
{^if $progress_step eq 1^}
<!-- STEP1 START -->
  <p>1.确认用户登录名</p>
  <input type="text" name="custom_account" value="{^$session_data["custom_account"]^}" placeholder="登录名/手机号码/电子邮箱" />
{^if isset($user_err_list["custom_account"])^}
  <p class="fc_red">{^$user_err_list["custom_account"]^}</p>
{^/if^}
</div>
<input type="submit" name="do_verify" value="下一步" />
<!-- STEP1 END -->
{^elseif $progress_step eq 2^}
<!-- STEP2 START -->
</div>
<!-- STEP2 END -->
{^elseif $progress_step eq 3^}
<!-- STEP3 START -->
</div>
<!-- STEP3 END -->
{^else^}
<!-- STEP4 START -->
</div>
<!-- STEP4 END -->
{^/if^}
</form>
{^include file=$mblfooter_file^}