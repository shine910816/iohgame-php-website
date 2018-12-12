{^include file=$comheader_file^}
{^include file=$comnaviga_file^}
<link rel="stylesheet" href="css/user/user_disp.css" type="text/css" />
<link rel="stylesheet" href="css/user/user_friend_disp.css" type="text/css" />
<table class="content bl_c mt_30">
<tr>
<td class="content-left" valign="top">{^include file=$leftmenu_file^}</td>
<td class="content-right" valign="top">
<!-- Main content START -->
  <ul class="main-content-switch-box bl_c">
    {^foreach from=$disp_switch_list key=switch_key item=switch_value name=disp_switch^}
    {^if $switch_key neq $disp_mode^}<a href="./?menu=user&act=friend_disp&disp_mode={^$switch_key^}">{^/if^}<li class="main-content-switch-list{^if $switch_key eq $disp_mode^}-selected{^/if^}{^if $smarty.foreach.disp_switch.first^} no-border{^/if^} tx_c">{^$switch_value^}</li>{^if $switch_key neq $disp_mode^}</a>{^/if^}
    {^/foreach^}
  </ul>
  {^if $disp_mode eq 2^}
  <div class="main-content pb_10 mt_10">
    {^if empty($disp_cus_id_list)^}
    <ul class="main-content-case bl_c mt_10">
      <li class="no-content-hint tx_c">尚未添加</li>
    </ul>
    {^else^}
    {^foreach from=$disp_cus_id_list key=friend_id item=cus_id_item^}
    <ul class="main-content-case bl_c mt_10">
      <li class="main-content-case-list tx_c">{^$custom_info[$cus_id_item]['nick']^}</li>
      <li class="main-content-case-list"></li>
      <li class="main-content-case-list tx_c">
        <a href="{^$a_href_url^}&friend_id={^$friend_id^}&black_remove=1" title="移除" class="fc_peru"><i class="fa fa-trash-o fa-lg"></i></a>
      </li>
    </ul>
    {^/foreach^}
    {^/if^}
  </div>
  {^else^}
  {^if empty($wait_friend_list) and empty($disp_friend_list)^}
  <div class="main-content pb_10 mt_10">
    <ul class="main-content-case bl_c mt_10">
      <li class="no-content-hint tx_c">好友列表空空如也，前往<a href="./?menu=user&act=friend_search" class="fc_black">查找朋友</a>页面就可以添加好友了</li>
    </ul>
  </div>
  {^else^}
  {^if !empty($wait_friend_list)^}
  <div class="main-content pb_10 mt_10">
    <div class="main-content-title">您有{^$wait_friend_num^}条未处理的好友申请</div>
    {^foreach from=$wait_friend_list key=friend_id item=wait_friend_list_item^}
    <ul class="main-content-case bl_c mt_10">
      <li class="main-content-case-list">{^$custom_info[$wait_friend_list_item['cus_id']]['nick']^}</li>
      <li class="main-content-case-list">{^$wait_friend_list_item['notes']^}</li>
      <li class="main-content-case-list">
        <a href="{^$a_href_url^}&friend_id={^$friend_id^}&friend_confirm=1" title="接受" class="fc_lime_green"><i class="fa fa-check fa-lg"></i></a>
        <a href="{^$a_href_url^}&friend_id={^$friend_id^}&friend_refuse=1" title="拒绝" class="fc_red"><i class="fa fa-close fa-lg"></i></a>
      </li>
    </ul>
    {^/foreach^}
  </div>
  {^/if^}
  {^if !empty($disp_friend_list)^}
  <div class="main-content pb_10 mt_10">
    <div class="main-content-title">好友列表</div>
    {^foreach from=$disp_friend_list key=friend_id item=disp_friend_list_item^}
    <ul class="main-content-case bl_c mt_10">
      <li class="main-content-case-list">{^$custom_info[$disp_friend_list_item['oppo_cus_id']]['nick']^}</li>
      <li class="main-content-case-list">{^if $disp_friend_list_item['friend_status'] eq 1^}亲密好友{^elseif $disp_friend_list_item['friend_status'] eq 2^}好友{^else^}等待对方确认{^/if^}</li>
      <li class="main-content-case-list">
        {^if $disp_friend_list_item['friend_status'] eq 1^}
        <a href="{^$a_href_url^}&friend_id={^$friend_id^}&close_remove=1" title="取消亲密好友" class="fc_light_coral"><i class="fa fa-heart fa-lg"></i></a>
        {^elseif $disp_friend_list_item['friend_status'] eq 2^}
        <a href="{^$a_href_url^}&friend_id={^$friend_id^}&close_add=1" title="设置亲密好友" class="fc_light_coral"><i class="fa fa-heart-o fa-lg"></i></a>
        <a href="{^$a_href_url^}&friend_id={^$friend_id^}&black_add=1" title="拉黑" class="fc_slate_gray"><i class="fa fa-user-times fa-lg"></i></a>
        <a href="{^$a_href_url^}&friend_id={^$friend_id^}&friend_remove=1" title="移除好友" class="fc_peru"><i class="fa fa-trash-o fa-lg"></i></a>
        {^/if^}
      </li>
    </ul>
    {^/foreach^}
  </div>
  {^/if^}
  {^/if^}
  {^/if^}
<!-- Main content END -->
</td>
</tr>
</table>
{^include file=$comfooter_file^}