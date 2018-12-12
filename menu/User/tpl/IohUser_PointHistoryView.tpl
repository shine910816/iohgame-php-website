{^include file=$comheader_file^}
{^include file=$comnaviga_file^}
<link rel="stylesheet" href="css/user/user_disp.css" type="text/css" />
<link rel="stylesheet" href="css/user/user_point_history.css" type="text/css" />
<table class="content bl_c mt_30">
<tr>
<td class="content-left" valign="top">{^include file=$leftmenu_file^}</td>
<td class="content-right" valign="top">
<!-- Main content START -->
  <div class="main-content pb_10">
    <div class="main-content-title">积分记录</div>
    {^if empty($point_info)^}
    <ul class="main-content-case bl_c mt_10">
      <li class="no-content-hint">您没有任何积分记录。</li>
    </ul>
    {^else^}
    <ul class="main-content-case bl_c mt_10">
      <li class="main-content-case-list">积分额度</li>
      <li class="main-content-case-list">发生时间</li>
      <li class="main-content-case-list">备注</li>
    </ul>
    {^foreach from=$point_info item=tmp_info^}
    <ul class="main-content-case bl_c mt_10">
      <li class="main-content-case-list{^if $tmp_info['point'] lt 0^} local-difference{^/if^}">{^$tmp_info['point']^}</li>
      <li class="main-content-case-list">{^$tmp_info['insert_date']^}</li>
      <li class="main-content-case-list">{^$reason_cd_list[$tmp_info['reason_cd']]^}</li>
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