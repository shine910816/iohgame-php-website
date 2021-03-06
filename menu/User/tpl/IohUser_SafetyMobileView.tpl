{^include file=$mblheader_file^}
<a href="#rightpanel" class="ui-btn ui-icon-bullets ui-btn-icon-left ui-corner-all ui-shadow-icon ui-btn-b">安全设定</a>
<div class="ui-corner-all custom-corners">
  <div class="ui-bar ui-bar-a">
    <h3>密码服务</h3>
  </div>
  <div class="ui-body ui-body-a">
{^if $disp_no_change_password_hint gt 0^}
    <p class="fc_orange">您已经{^$disp_no_change_password_hint^}天没有更换密码了<br/>强烈建议您修改登录密码</p>
{^/if^}
    <a href="./?menu=user&act=change_password" class="ui-btn ui-corner-all ui-btn-a" data-ajax="false">修改登录密码</a>
  </div>
</div>
<p/>
<div class="ui-corner-all custom-corners">
  <div class="ui-bar ui-bar-a">
    <h3>安全问题</h3>
  </div>
  <div class="ui-body ui-body-a">
    <table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
      <tbody>
        <tr>
          <th>状态</th>
          <td class="ta_r">已设定</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<p/>
<div class="ui-corner-all custom-corners">
  <div class="ui-bar ui-bar-a">
    <h3>手机绑定</h3>
  </div>
  <div class="ui-body ui-body-a">
    <table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
      <tbody>
        <tr>
          <th>手机号码</th>
          <td class="ta_r{^if $custom_login_info["disp_tele_number"] eq ""^} fc_red{^/if^}">{^if $custom_login_info["disp_tele_number"] neq ""^}{^$custom_login_info["disp_tele_number"]^}{^else^}未设定{^/if^}</td>
        </tr>
        <tr>
          <th>状态</th>
          <td class="ta_r{^if $custom_login_info["custom_tele_flg"] eq "0"^} fc_red{^/if^}">{^if $custom_login_info["custom_tele_flg"] eq "1"^}已{^else^}未{^/if^}绑定</td>
        </tr>
      </tbody>
    </table>
    <a href="./?menu=user&act=bind_tele" class="ui-btn ui-corner-all ui-btn-a" data-ajax="false">{^if $custom_login_info["custom_tele_flg"] eq "1"^}解除{^/if^}绑定手机号码</a>
  </div>
</div>
<p/>
<div class="ui-corner-all custom-corners">
  <div class="ui-bar ui-bar-a">
    <h3>邮箱绑定</h3>
  </div>
  <div class="ui-body ui-body-a">
    <table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
      <tbody>
        <tr>
          <th>电子邮箱</th>
          <td class="ta_r{^if $custom_login_info["disp_mail_number"] eq ""^} fc_red{^/if^}">{^if $custom_login_info["disp_mail_number"] neq ""^}{^$custom_login_info["disp_mail_number"]^}{^else^}未设定{^/if^}</td>
        </tr>
        <tr>
          <th>状态</th>
          <td class="ta_r{^if $custom_login_info["custom_mail_flg"] eq "0"^} fc_red{^/if^}">{^if $custom_login_info["custom_mail_flg"] eq "1"^}已{^else^}未{^/if^}绑定</td>
        </tr>
      </tbody>
    </table>
    <a href="./?menu=user&act=bind_mail" class="ui-btn ui-corner-all ui-btn-a" data-ajax="false">{^if $custom_login_info["custom_mail_flg"] eq "1"^}解除{^/if^}绑定电子邮箱</a>
  </div>
</div>
{^include file=$mblfooter_file^}