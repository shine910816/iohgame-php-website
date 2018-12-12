{^include file=$comheader_file^}
{^include file=$comnaviga_file^}
<link rel="stylesheet" href="css/hearth_stone/input.css" type="text/css" />
<script type="text/javascript" src="js/hearth_stone/input.js"></script>
<form action="./" method="post" class="input-box bl_c mt_30">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<input type="hidden" name="edit_mode" value="{^$edit_mode^}" />
<table class="tb tb_p_05 tb_org" id="start_table">
  <tr>
    <th>卡牌ID</th>
    <td class="link-box">
      {^$c_id^}<input type="hidden" name="c_id" value="{^$c_id^}" />
{^if $edit_mode eq "1"^}
      <a href="./?menu=hearth_stone&act=input&edit_mode=1&c_id={^$c_id-1^}">上一张</a>
      <a href="./?menu=hearth_stone&act=input&edit_mode=1&c_id={^$c_id+1^}">下一张</a>
{^/if^}
    </td>
    <th>模式</th>
    <td><label><input type="checkbox" name="c_mode" value="1"{^if $card_info['c_mode'] eq "1"^} checked{^/if^} /> 狂野模式限定</label></td>
  </tr>
  <tr>
    <th>来源</th>
    <td>
      <select name="c_from" class="select-box">
{^foreach from=$c_from_list key=c_from_key item=c_from_item^}
        <option value="{^$c_from_key^}"{^if $card_info['c_from'] eq $c_from_key^} selected{^/if^}>{^$c_from_item^}</option>
{^/foreach^}
      </select>
    </td>
    <th>帮派</th>
    <td>
      <select name="c_group" class="select-box">
        <option value="0">无</option>
{^foreach from=$c_group_list key=c_group_key item=c_group_item^}
        <option value="{^$c_group_key^}"{^if $card_info['c_group'] eq $c_group_key^} selected{^/if^}>{^$c_group_item^}</option>
{^/foreach^}
      </select>
    </td>
  </tr>
  <tr>
    <th>职业</th>
    <td>
      <select name="c_class" class="select-box">
{^foreach from=$c_class_list key=c_class_key item=c_class_item^}
        <option value="{^$c_class_key^}"{^if $card_info['c_class'] eq $c_class_key^} selected{^/if^}>{^$c_class_item^}</option>
{^/foreach^}
      </select>
    </td>
    <th>类型</th>
    <td>
      <select name="c_type" class="select-box">
{^foreach from=$c_type_list key=c_type_key item=c_type_item^}
        <option value="{^$c_type_key^}"{^if $card_info['c_type'] eq $c_type_key^} selected{^/if^}>{^$c_type_item^}</option>
{^/foreach^}
      </select>
    </td>
  </tr>
  <tr>
    <th>消耗</th>
    <td>
      <input type="button" value="-" class="tune-button" id="c_cost_minus" />
      <input type="text" name="c_cost" value="{^$card_info['c_cost']^}" class="number-box ml_03" id="c_cost" />
      <input type="button" value="+" class="tune-button ml_03" id="c_cost_plus" />
    </td>
    <th>名称</th>
    <td><input type="text" name="c_name" value="{^$card_info['c_name']^}" class="text-box" /></td>
  </tr>
  <tr>
    <th>攻击</th>
    <td>
      <input type="button" value="-" class="tune-button" id="c_attack_minus" />
      <input type="text" name="c_attack" value="{^$card_info['c_attack']^}" class="number-box ml_03" id="c_attack" />
      <input type="button" value="+" class="tune-button ml_03" id="c_attack_plus" />
    </td>
    <th>生命(耐久)</th>
    <td>
      <input type="button" value="-" class="tune-button" id="c_health_minus" />
      <input type="text" name="c_health" value="{^$card_info['c_health']^}" class="number-box ml_03" id="c_health" />
      <input type="button" value="+" class="tune-button ml_03" id="c_health_plus" />
    </td>
  </tr>
  <tr>
    <th>品质</th>
    <td>
      <select name="c_quality" class="select-box">
        <option value="0">基本</option>
{^foreach from=$c_quality_list key=c_quality_key item=c_quality_item^}
        <option value="{^$c_quality_key^}"{^if $card_info['c_quality'] eq $c_quality_key^} selected{^/if^}>{^$c_quality_item^}</option>
{^/foreach^}
      </select>
    </td>
    <th>随从类型</th>
    <td>
      <select name="c_minion" class="select-box">
        <option value="0">无</option>
{^foreach from=$c_minion_list key=c_minion_key item=c_minion_item^}
        <option value="{^$c_minion_key^}"{^if $card_info['c_minion'] eq $c_minion_key^} selected{^/if^}>{^$c_minion_item^}</option>
{^/foreach^}
      </select>
    </td>
  </tr>
  <tr>
    <th>描述</th>
    <td><textarea name="c_descript" class="textarea-box">{^$card_info['c_descript']^}</textarea></td>
    <th>趣文</th>
    <td><textarea name="c_funny" class="textarea-box">{^$card_info['c_funny']^}</textarea></td>
  </tr>
  <tr>
    <th>关键字</th>
    <td class="keyword-td" colspan="3">
{^assign var="keyword_index" value="0"^}
{^foreach from=$c_keyword_list item=c_keyword_item^}
{^assign var="keyword_index" value=$keyword_index+1^}
      <label><input type="checkbox" name="{^$c_keyword_item^}" value="1"{^if $card_info[$c_keyword_item] eq "1"^} checked{^/if^} /> {^$volumn_name_list[$c_keyword_item]^}</label>
{^if $keyword_index eq 16^}
      <br/>
{^assign var="keyword_index" value="0"^}
{^/if^}
{^/foreach^}
    </td>
  </tr>
</table>
<input type="submit" name="execute" value="提交" class="execute-button mt_10 bl_c" />
</form>
{^include file=$comfooter_file^}