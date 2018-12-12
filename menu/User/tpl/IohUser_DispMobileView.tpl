{^include file=$mblheader_file^}
<a href="#rightpanel" class="ui-btn ui-icon-bullets ui-btn-icon-left ui-corner-all ui-shadow-icon ui-btn-b">个人设定</a>
<h3 class="ui-bar ui-bar-a ui-corner-all">{^$custom_info["custom_nick"]^}</h3>
<div class="ui-body ui-body-a ui-corner-all">
  <a href="./?menu=user&act=change_nick" class="ui-btn ui-corner-all">修改昵称</a>
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
      <tr>
        <th>公开状态</th>
        <td>{^if $custom_info["open_level"] eq "2"^}全部可见{^elseif $custom_info["open_level"] eq "1"^}仅好友可见{^else^}仅自己可见{^/if^}</td>
      </tr>
    </tbody>
  </table>
  <a href="#" class="ui-btn ui-corner-all">修改个人信息</a>
</div>
{^include file=$mblfooter_file^}