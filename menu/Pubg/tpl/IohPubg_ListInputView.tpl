{^include file=$comheader_file^}
{^include file=$comnaviga_file^}
<link rel="stylesheet" href="css/pubg/input.css" type="text/css" />
<link rel="stylesheet" href="css/pubg/disp.css" type="text/css" />
<!--script type="text/javascript" src="js/pubg/disp.js"></script-->
<form class="form_box" action="./" method="post">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<table class="table_box tb tb_org tb_p_05">
  <tr>
    <td class="table_name_box">
      <a href="./?menu=pubg&act=weapon_list">武器列表</a><br/>
      <a href="./?menu=pubg&act=part_list">配件列表</a>
    </td>
{^foreach from=$part_type_list key=p_type item=p_type_name^}
    <th>{^$p_type_name^}</th>
{^/foreach^}
  </tr>
{^foreach from=$weapon_list key=w_id item=weapon_info^}
  <tr>
    <th>{^$weapon_info["w_name"]^}</th>
{^foreach from=$part_type_list key=p_type item=p_type_name^}
    <td valign="top">
{^if $p_type neq "6"^}
{^assign var="part_able_key" value="w_part_able_"|cat:$p_type^}
{^if $weapon_info[$part_able_key]^}
      <table class="tb tb_brn tb_p_03">
{^foreach from=$part_list[$p_type] key=p_id item=part_info^}
        <tr>
          <td>
            <label><input type="checkbox" name="weapon_part[{^$w_id^}][{^$p_id^}]" value="1"{^if isset($weapon_part_list[$w_id][$p_id])^} checked{^/if^} /> {^$part_info["p_name"]^}{^if $part_info["p_note"]^}({^$part_info["p_note"]^}){^/if^}</label>
          </td>
        </tr>
{^/foreach^}
      </table>
{^/if^}
{^else^}
      <table class="tb tb_brn tb_p_03">
{^foreach from=$part_list[$p_type] key=p_id item=part_info^}
        <tr>
          <td>
            <label><input type="radio" name="ammo[{^$w_id^}]" value="{^$p_id^}"{^if isset($weapon_part_list[$w_id][$p_id])^} checked{^/if^} /> {^$part_info["p_name"]^}</label>
          </td>
        </tr>
{^/foreach^}
      </table>
{^/if^}
    </td>
{^/foreach^}
  </tr>
{^/foreach^}
</table>
<label class="clickable_button button_orange">
  <span>提交</span>
  <input class="no_disp" type="submit" name="confirm" value="1" />
</label>
<label class="clickable_button button_white">
  <span>返回</span>
  <input class="no_disp" type="submit" name="back" value="1" />
</label>
</form>
{^include file=$comfooter_file^}