{^include file=$comheader_file^}
{^include file=$comnaviga_file^}
<link rel="stylesheet" href="css/user/user_disp.css" type="text/css" />
<table class="content bl_c mt_30">
<tr>
<td class="content-left" valign="top">{^include file=$leftmenu_file^}</td>
<td class="content-right" valign="top">
<!-- Main content START -->
  <div class="main-content pb_10">
    <div class="main-content-title">个人信息</div>
    <ul class="main-content-case bl_c mt_10">
      <li class="main-content-case-title">昵称</li>
      <li class="main-content-case-display">{^$custom_info["custom_nick"]^}<a href="./?menu=user&act=change_nick" class="change_nick_link">修改</a></li>
    </ul>
    <ul class="main-content-case bl_c mt_10">
      <li class="main-content-case-title">性别</li>
      {^if $custom_info["custom_gender"] eq "1"^}
      <li class="main-content-case-display fc_deep_sky_blue"><i class="fa fa-mars"></i></li>
      {^else^}
      <li class="main-content-case-display fc_hot_pink"><i class="fa fa-venus"></i></li>
      {^/if^}
    </ul>
    <ul class="main-content-case bl_c mt_10">
      <li class="main-content-case-title">生日</li>
      <li class="main-content-case-display">{^$custom_info["custom_birth"]^}</li>
    </ul>
  </div>
<!-- Main content END -->
</td>
</tr>
</table>
{^include file=$comfooter_file^}