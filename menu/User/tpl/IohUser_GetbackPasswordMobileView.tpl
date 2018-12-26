{^include file=$mblheader_file^}
<form action="./" method="get" data-ajax="false">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<div class="ui-body ui-body-a ui-corner-all">
  <h3>找回用户登录密码</h3>
{^if $progress_step eq 1^}
<!-- STEP1 START -->
  <p>1.确认用户登录名</p>
  <input type="text" name="custom_account" value="{^$session_data["custom_account"]^}" placeholder="登录名" />
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
    <label for="security_type_1">安全问题认证</label>
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
  <label for="tele_send_code">已绑定手机号码{^$saved_tele_number^}</label>
  <input type="button" id="tele_send_code" value="发送验证码" class="ui-btn ui-corner-all ui-btn-a" />
  <label for="custom_verify_code">请输入验证码</label>
  <input name="custom_verify_code" id="custom_verify_code" type="text" />
{^if isset($user_err_list["custom_verify_code"])^}
  <p class="fc_red">{^$user_err_list["custom_verify_code"]^}</p>
{^/if^}
{^elseif $session_data["custom_security_type"] eq "3"^}
  <label for="mail_send_code">已绑定邮箱地址{^$saved_mail_address^}</label>
  <input type="button" id="mail_send_code" value="发送验证码" class="ui-btn ui-corner-all ui-btn-a" />
  <label for="custom_verify_code">请输入验证码</label>
  <input name="custom_verify_code" id="custom_verify_code" type="text" />
{^if isset($user_err_list["custom_verify_code"])^}
  <p class="fc_red">{^$user_err_list["custom_verify_code"]^}</p>
{^/if^}
{^else^}
  <label for="select_safety_question" class="select">请选择安全问题</label>
  <select name="select_safety_question" id="select_safety_question" data-native-menu="false">
    <option value="0">未选择</option>
{^foreach from=$custom_question item=question_id^}
    <option value="{^$question_id^}">{^$question_list[$question_id]^}</option>
{^/foreach^}
  </select>
{^if isset($user_err_list["select_safety_question"])^}
  <p class="fc_red">{^$user_err_list["select_safety_question"]^}</p>
{^/if^}
  <label for="select_safety_answer">请输入问题答案</label>
  <input name="select_safety_answer" id="select_safety_answer" type="text" />
{^if isset($user_err_list["select_safety_answer"])^}
  <p class="fc_red">{^$user_err_list["select_safety_answer"]^}</p>
{^/if^}
{^/if^}
</div>
<button type="submit" name="do_verify" value="next" class="ui-btn ui-corner-all ui-btn-b">下一步</button>
<button type="submit" name="do_confirm" value="back" class="ui-btn ui-corner-all ui-btn-a">重新选择安全认证方式</button>
<!-- STEP3 END -->
{^elseif $progress_step eq "4"^}
<!-- STEP4 START -->
  <p>4.新密码</p>
</div>
<button type="submit" name="do_complete" value="next" class="ui-btn ui-corner-all ui-btn-b">下一步</button>
<!-- STEP4 END -->
{^else^}
<!-- STEP5 START -->
  <p>5.完成</p>
  <p>登录密码已经完成找回，请您妥善保管新密码</p>
</div>
<a href="./?menu=user&act=login" class="ui-btn ui-corner-all ui-btn-a">前往登录</a>
<!-- STEP5 END -->
{^/if^}
</form>
{^include file=$mblfooter_file^}