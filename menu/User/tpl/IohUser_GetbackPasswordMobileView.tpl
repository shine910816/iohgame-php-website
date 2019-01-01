{^include file=$mblheader_file^}
{^if $progress_step eq 3 and ($session_data["custom_security_type"] eq "2" or $session_data["custom_security_type"] eq "3")^}
<script type="text/javascript">
var count_down_start = {^$count_down_start^};
var api_url = "./api/security/verifycode/?k=";
var count_down = function(){
    if (count_down_start > 0) {
        $("#send_code").attr("disabled", "disabled");
        $("#send_code").empty().html(count_down_start + "秒后才可再次发送验证码");
        count_down_start--;
        setTimeout("count_down()", 1000);
    } else {
        $("#send_code").removeAttr("disabled");
        $("#send_code").empty().html("发送验证码");
        count_down_start = 60;
    }
};
$(document).ready(function(){
    if (count_down_start < 60) {
        count_down();
    }
    $("#send_code").click(function(){
        var url = api_url;
        if ($(this).data("code-type") == "tele") {
            url += "5";
        } else {
            url += "6";
        }
        $.get(url, function(data){
            var json = eval("(" + data + ")");
            if (json.error != 0) {
                $("#err_msg").removeClass("ui-screen-hidden");
                $("#err_msg").empty().html(json.err_msg);
            } else {
                $("#err_msg").addClass("ui-screen-hidden");
                $("#err_msg").empty();
                count_down();
            }
        });
    });
});
</script>
{^/if^}
<form action="./" method="post" data-ajax="false">
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
  <label for="send_code">已绑定手机号码{^$saved_tele_number^}</label>
  <button type="button" id="send_code" class="ui-btn ui-corner-all ui-btn-a" data-code-type="tele">发送验证码</button>
  <label for="custom_verify_code">请输入验证码</label>
  <input name="verify_code" id="custom_verify_code" type="text" />
  <p class="fc_red{^if !isset($user_err_list["verify_code"])^} ui-screen-hidden{^/if^}" id="err_msg">{^if isset($user_err_list["verify_code"])^}{^$user_err_list["verify_code"]^}{^/if^}</p>
{^elseif $session_data["custom_security_type"] eq "3"^}
  <label for="send_code">已绑定邮箱地址{^$saved_mail_address^}</label>
  <button type="button" id="send_code" class="ui-btn ui-corner-all ui-btn-a" data-code-type="mail">发送验证码</button>
  <label for="custom_verify_code">请输入验证码</label>
  <input name="verify_code" id="custom_verify_code" type="text" />
  <p class="fc_red{^if !isset($user_err_list["verify_code"])^} ui-screen-hidden{^/if^}" id="err_msg">{^if isset($user_err_list["verify_code"])^}{^$user_err_list["verify_code"]^}{^/if^}</p>
{^else^}
  <label for="select_safety_question" class="select">请选择安全问题</label>
  <select name="select_safety_question" id="select_safety_question" data-native-menu="false">
    <option value="0">未选择</option>
{^foreach from=$custom_question item=question_id^}
    <option value="{^$question_id^}"{^if $selected_question_id eq $question_id^} selected{^/if^}>{^$question_list[$question_id]^}</option>
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
  <label for="custom_password">请输入新密码</label>
  <input name="custom_password" id="custom_password" type="password" />
  <label for="custom_password_2">请确认新密码</label>
  <input name="custom_password_2" id="custom_password_2" type="password" />
{^if isset($user_err_list["custom_password"])^}
  <p class="fc_red">{^$user_err_list["custom_password"]^}</p>
{^/if^}
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