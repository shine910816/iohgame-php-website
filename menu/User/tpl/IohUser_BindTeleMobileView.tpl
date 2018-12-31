{^include file=$mblheader_file^}
<script type="text/javascript">
var count_down_start = {^$count_down_start^};
{^if $bound_flg^}
var api_url = "./api/security/verifycode/?k=7";
var count_down = function(){
    if (count_down_start > 0) {
        $("#send_remove_verify").attr("disabled", "disabled");
        $("#send_remove_verify").empty().html(count_down_start + "秒后才可再次发送验证码");
        count_down_start--;
        setTimeout("count_down()", 1000);
    } else {
        $("#send_remove_verify").removeAttr("disabled");
        $("#send_remove_verify").empty().html("发送验证码");
        count_down_start = 60;
    }
};
{^else^}
var mode = "{^$mode^}";
var api_url = "./api/security/verifycode/?k=1&mode=";
var count_down = function(){
    if (count_down_start > 0) {
        $("#send_bind_verify").attr("disabled", "disabled");
        $("#send_bind_verify").empty().html(count_down_start + "秒后才可再次发送验证码");
        count_down_start--;
        setTimeout("count_down()", 1000);
    } else {
        $("#send_bind_verify").removeAttr("disabled");
        $("#send_bind_verify").empty().html("发送验证码");
        count_down_start = 60;
    }
};
{^/if^}
$(document).ready(function(){
{^if !$bound_flg^}
    if (mode == "1") {
        $("#phone_number").attr("disabled", "disabled");
    }
{^/if^}
    if (count_down_start < 60) {
        count_down();
    }
{^if $bound_flg^}
    $("#send_remove_verify").click(function(){
        $.get(api_url, function(data){
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
{^else^}
    $("input[name='selected_mode']").change(function(){
        var phone_number = $("#phone_number");
        if ($(this).val() == "2") {
            phone_number.removeAttr("disabled");
            mode = "2";
        } else {
            phone_number.attr("disabled", "disabled");
            mode = "1";
        }
    });
    $("#send_bind_verify").click(function(){
        var url = "";
        if (mode == "1") {
            url = api_url + "1";
        } else {
            url = api_url + "2&number=" + $("#phone_number").val();
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
{^/if^}
});
</script>
<form action="./" method="post" data-ajax="false">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<div class="ui-body ui-body-a ui-corner-all">
  <h3>{^if $bound_flg^}解除{^/if^}绑定手机号码</h3>
{^if $bound_flg^}
  <input type="hidden" name="selected_mode" value="1" />
  <p>已绑定手机号码{^$custom_login_info["saved_tele_number"]^}</p>
  <p class="fc_orange">若此号码无法正常接收短信，或不是您本人在使用，请点击下方填写申请表单，向客服提出解除手机号码绑定申请。</p>
  <button type="button" id="send_remove_verify" class="ui-btn ui-corner-all ui-btn-a" />发送验证码</button>
{^else^}
{^if $custom_login_info["saved_tele_number"] neq ""^}
  <fieldset data-role="controlgroup">
    <input type="radio" name="selected_mode" id="selected_mode_1" value="1"{^if $mode eq "1"^} checked{^/if^} />
    <label for="selected_mode_1">预存手机号码{^$custom_login_info["saved_tele_number"]^}</label>
    <input type="radio" name="selected_mode" id="selected_mode_2" value="2"{^if $mode eq "2"^} checked{^/if^} />
    <label for="selected_mode_2">新的手机号码</label>
  </fieldset>
{^else^}
  <input type="hidden" name="selected_mode" value="2" />
{^/if^}
  <input type="text" name="phone_number" id="phone_number" value="{^$send_code_tele_number^}" placeholder="请输入手机号码" />
  <p class="fc_red{^if !isset($user_err_list["send_code_tele_number"])^} ui-screen-hidden{^/if^}" id="err_msg">{^if isset($user_err_list["send_code_tele_number"])^}{^$user_err_list["send_code_tele_number"]^}{^/if^}</p>
  <button type="button" id="send_bind_verify" class="ui-btn ui-corner-all ui-btn-a" />发送验证码</button>
{^/if^}
  <p/>
  <input type="text" name="verify_code" placeholder="请输入验证码" autocomplete="off" />
{^if isset($user_err_list["verify_code"])^}
  <p class="fc_red">{^$user_err_list["verify_code"]^}</p>
{^/if^}
{^if $bound_flg^}
  <input type="password" name="custom_password" placeholder="请输入登录密码" autocomplete="off" />
{^if isset($user_err_list["custom_password"])^}
  <p class="fc_red">{^$user_err_list["custom_password"]^}</p>
{^/if^}
{^/if^}
</div>
<button type="submit" name="do_change" class="ui-btn ui-corner-all ui-btn-b" />确认</button>
<a href="./?menu=user&act=safety" class="ui-btn ui-corner-all ui-btn-a" data-ajax="false">返回</a>
{^if $bound_flg^}
<a href="#" class="ui-btn ui-corner-all ui-btn-a" data-ajax="false">填写申请表单</a>
{^/if^}
</form>
{^include file=$mblfooter_file^}