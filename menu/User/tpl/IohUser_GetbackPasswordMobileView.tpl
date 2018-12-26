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
<button type="submit" name="do_confirm" value="next" class="ui-btn ui-corner-all ui-btn-b">下一步</button>
<!-- STEP1 END -->
{^elseif $progress_step eq 2^}
<!-- STEP2 START -->
  <p>2.选择安全认证方式</p>
  <fieldset data-role="controlgroup">
    <input name="security_type" id="security_type_1" value="1" type="radio"{^if $session_data["custom_security_type"] eq "1"^} checked{^/if^} />
    <label for="security_type_1">安全问题</label>
{^if $security_able_tele^}
    <input name="security_type" id="security_type_2" value="2" type="radio"{^if $session_data["custom_security_type"] eq "2"^} checked{^/if^} />
    <label for="security_type_2">手机验证</label>
{^/if^}
{^if $security_able_mail^}
    <input name="security_type" id="security_type_3" value="3" type="radio"{^if $session_data["custom_security_type"] eq "3"^} checked{^/if^} />
    <label for="security_type_3">邮箱验证</label>
{^/if^}
  </fieldset>
</div>
<button type="submit" name="do_select" value="next" class="ui-btn ui-corner-all ui-btn-b">下一步</button>
<!-- STEP2 END -->
{^elseif $progress_step eq 3^}
<!-- STEP3 START -->
  <p>3.安全认证</p>
{^if $session_data["custom_security_type"] eq "2"^}
{^elseif $session_data["custom_security_type"] eq "3"^}
{^else^}
{^/if^}
</div>
<button type="submit" name="do_select" value="next" class="ui-btn ui-corner-all ui-btn-b">下一步</button>
<button type="submit" name="do_confirm" value="back" class="ui-btn ui-corner-all ui-btn-a">重新选择安全认证方式</button>
<!-- STEP3 END -->
{^else^}
<!-- STEP4 START -->
</div>
<!-- STEP4 END -->
{^/if^}
</form>
{^include file=$mblfooter_file^}