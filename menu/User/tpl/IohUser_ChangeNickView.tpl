{^include file=$comheader_file^}
{^include file=$comnaviga_file^}
<link rel="stylesheet" href="css/user/user_disp.css" type="text/css" />
<table class="content bl_c mt_30">
<tr>
<td class="content-left" valign="top">{^include file=$leftmenu_file^}</td>
<td class="content-right" valign="top">
<!-- Main content START -->
  {^include file=$usererror_file^}
  <div class="main-content pb_10">
    <div class="main-content-title">修改昵称</div>
    <ul class="main-content-case bl_c mt_10">
      <li class="no-content-hint tx_c">请注意，修改昵称需要支付{^$change_nick_point^}积分</li>
    </ul>
    <form action="./" method="post">
    <input type="hidden" name="menu" value="{^$current_menu^}" />
    <input type="hidden" name="act" value="{^$current_act^}" />
    <ul class="main-content-case bl_c mt_10">
      <li class="main-content-case-list">昵称</li>
      <li class="main-content-case-list"><input type="text" name="do_change_nick" value="{^$do_change_nick^}" /></li>
      <li class="main-content-case-list"><input type="submit" name="do_change" value="确认修改" /></li>
    </ul>
    </form>
  </div>
<!-- Main content END -->
</td>
</tr>
</table>
{^include file=$comfooter_file^}