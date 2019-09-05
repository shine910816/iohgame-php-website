{^include file=$mblheader_file^}
<div class="ui-corner-all custom-corners">
  <div class="ui-bar ui-bar-a">
    <h3>{^$custom_info["custom_nick"]^}</h3>
  </div>
  <div class="ui-body ui-body-a">
    <table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
      <tbody>
{^if $open_flg^}
        <tr>
          <th>性别</th>
          <td>{^if $custom_info["custom_gender"] eq "1"^}男&#9794;{^else^}女&#9792;{^/if^}</td>
        </tr>
{^if $custom_info["confirm_flg"]^}
        <tr>
          <th>星座</th>
          <td>{^$custom_birth_info["con"]^}</td>
        </tr>
        <tr>
          <th>年龄</th>
          <td>{^$custom_birth_info["age"]^}</td>
        </tr>
{^/if^}
{^/if^}
      </tbody>
    </table>
{^if !$self_flg^}
{^if $followed_flg^}
    <a href="./?menu=user&act=change_info" class="ui-btn ui-corner-all ui-btn-b" data-ajax="false">关注</a>
{^else^}
    <a href="./?menu=user&act=change_info" class="ui-btn ui-corner-all ui-btn-a" data-ajax="false">取消关注</a>
{^/if^}
{^/if^}
  </div>
</div>

{^include file=$mblfooter_file^}