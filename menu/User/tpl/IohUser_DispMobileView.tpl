{^include file=$mblheader_file^}
<a href="#rightpanel" class="ui-btn ui-icon-bullets ui-btn-icon-left ui-corner-all ui-shadow-icon ui-btn-b">个人设定</a>
<div class="ui-body ui-body-a ui-corner-all">
  <h3 class="ui-bar ui-bar-a ui-corner-all">{^$custom_info["custom_nick"]^}</h3>
  <table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
    <tbody>
      <tr>
        <th>性别</th>
        <td>{^if $custom_info["custom_gender"] eq "1"^}男&#9794;{^else^}女&#9792;{^/if^}</td>
      </tr>
{^if !$custom_info["confirm_flg"]^}
      <tr>
        <th>生日</th>
        <td>{^$custom_info["custom_birth"]^}</td>
      </tr>
{^else^}
      <tr>
        <th>星座</th>
        <td>{^$custom_birth_info["con"]^}</td>
      </tr>
      <tr>
        <th>年龄</th>
        <td>{^$custom_birth_info["age"]^}</td>
      </tr>
{^/if^}
{^if $custom_info["confirm_flg"] neq "1"^}
      <tr>
        <th>确认状态</th>
        <td><span style="color:#F60000;">未确认</span></td>
      </tr>
{^/if^}
      <tr>
        <th>公开状态</th>
        <td>{^$open_level_list[$custom_info["open_level"]]^}</td>
      </tr>
    </tbody>
  </table>
</div>
<a href="./?menu=user&act=change_nick" class="ui-btn ui-corner-all">修改昵称</a>
<a href="./?menu=user&act=change_info" class="ui-btn ui-corner-all">修改个人信息</a>
{^include file=$mblfooter_file^}