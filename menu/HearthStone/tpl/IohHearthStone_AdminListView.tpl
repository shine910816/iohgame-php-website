{^include file=$comheader_file^}
{^include file=$comnaviga_file^}
<link rel="stylesheet" href="css/hearth_stone/admin_list.css" type="text/css" />
<div class="disp-box bl_c mt_30">
<table class="tb tb_p_05 {^if $disp_mode^}tb_grn{^else^}tb_brn{^/if^}">
  <tr>
    <td rowspan="2">
{^if $disp_mode^}
      <a href="./?menu=hearth_stone&act=admin_list&c_class={^$c_class^}">管理员模式</a>
{^else^}
      <a href="./?menu=hearth_stone&act=input">卡牌录入</a><br/>
      <a href="./?menu=hearth_stone&act=admin_list&c_class={^$c_class^}&disp_mode=1">用户模式</a>
{^/if^}
    </td>
    <th colspan="5">职业</th>
  </tr>
  <tr>
    <td colspan="{^if $disp_mode^}4{^else^}5{^/if^}" class="ts_01">
{^foreach from=$c_class_list key=c_class_key item=c_class_item^}
{^if $c_class_key eq $c_class^}
      <span style="cursor:default; color:#{^$c_class_color_list[$c_class_key]^};">{^$c_class_item^}</span>
{^else^}
      <a href="./?menu=hearth_stone&act=admin_list&c_class={^$c_class_key^}&disp_mode={^$disp_mode^}" style="color:#{^$c_class_color_list[$c_class_key]^};">{^$c_class_item^}</a>
{^/if^}
{^/foreach^}
    </td>
  </tr>
  <tr>
    <th width="120px">名称</th>
    <th width="50px">基本属性</th>
    <th width="70px">类型</th>
{^if $disp_mode^}
    <th width="592px">描述</th>
    <th width="120px">扩展包</th>
{^else^}
    <th width="530px">描述</th>
    <th width="120px">扩展包</th>
    <th width="60px">操作</th>
{^/if^}
  </tr>
{^foreach from=$card_info item=card_item^}
  <tr>
    <td style="color:#{^if $card_item['c_quality'] neq "0"^}{^$c_quality_color_list[$card_item['c_quality']]^}{^else^}1EFF00{^/if^};" class="ts_01">{^$card_item['c_name']^}</td>
    <td>
      <span style="color:#03E;" class="ts_01">{^$card_item['c_cost']^}</span>
{^if $card_item['c_type'] neq "3"^}
      <span style="color:#F50;" class="ts_01">{^$card_item['c_attack']^}</span>
      <span style="color:#C11;" class="ts_01">{^$card_item['c_health']^}</span>
{^/if^}
    </td>
    <td>{^if $card_item['c_type'] eq "1" and $card_item['c_minion'] neq "0"^}{^$c_minion_list[$card_item['c_minion']]^}{^/if^}{^$c_type_list[$card_item['c_type']]^}</td>
    <td class="tx_l">{^$card_item['c_descript']^}</td>
    <td>{^$c_from_list[$card_item['c_from']]^}</td>
{^if !$disp_mode^}
    <td>
      <a href="./?menu=hearth_stone&act=input&edit_mode=1&c_id={^$card_item['c_id']^}">编辑</a>
    </td>
{^/if^}
  </tr>
{^/foreach^}
</table>
</div>
{^include file=$comfooter_file^}