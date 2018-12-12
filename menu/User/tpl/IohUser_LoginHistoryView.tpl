{^include file=$comheader_file^}
{^include file=$comnaviga_file^}
<link rel="stylesheet" href="css/user/user_disp.css" type="text/css" />
<link rel="stylesheet" href="css/user/user_login_history.css" type="text/css" />
<table class="content bl_c mt_30">
<tr>
<td class="content-left" valign="top">{^include file=$leftmenu_file^}</td>
<td class="content-right" valign="top">
<!-- Main content START -->
  <div class="main-content pb_10">
    <div class="main-content-title">登录记录</div>
    {^if empty($login_his_info)^}
    <ul class="main-content-case bl_c mt_10">
      <li class="no-content-hint">您没有任何登录记录。</li>
    </ul>
    {^else^}
    <ul class="main-content-case bl_c mt_10">
      <li class="main-content-case-list">登录IP</li>
      <li class="main-content-case-list">登录时间</li>
    </ul>
    {^foreach from=$login_his_info item=his_info^}
    <ul class="main-content-case bl_c mt_10">
      <li class="main-content-case-list{^if $his_info['cus_ip_address'] neq $remote_addr^} local-difference{^/if^}">{^$his_info['cus_ip_address']^}</li>
      <li class="main-content-case-list">{^$his_info['insert_date']^}</li>
    </ul>
    {^/foreach^}
    {^/if^}
    {^include file=$compagina_file^}
  </div>
<!-- Main content END -->
</td>
</tr>
</table>
{^include file=$comfooter_file^}