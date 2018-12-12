{^include file=$comheader_file^}
{^include file=$comnaviga_file^}
<link rel="stylesheet" href="css/pubg/disp.css" type="text/css" />
<!--script type="text/javascript" src="js/pubg/disp.js"></script-->
<table class="table_box tb tb_org tb_p_05">
  <tr>
{^if $test_mode_info['auth_level'] >= 3^}
    <td rowspan="2"><a href="./?menu=pubg&act=list_input">列表编辑</a></td>
{^else^}
    <th rowspan="2">名称</th>
{^/if^}
    <th rowspan="2">类型</th>
    <th colspan="2">伤害</th>
    <th colspan="5">配件</th>
    <th rowspan="2">弹药</th>
    <th rowspan="2">弹夹容量</th>
  </tr>
  <tr>
    <th>对身体</th>
    <th>对头部</th>
    <th>上轨道</th>
    <th>枪口</th>
    <th>下轨道</th>
    <th>弹夹</th>
    <th>枪托</th>
  </tr>
{^foreach from=$weapon_type_list key=w_type item=w_type_name^}
{^foreach from=$weapon_list[$w_type] key=w_id item=weapon_info^}
  <tr valign="top">
    <td>
      <table class="tb tb_brn tb_p_03">
        <tr>
          <td>{^$weapon_info["w_name"]^}</td>
        </tr>
      </table>
    </td>
    <td>
      <table class="tb tb_brn tb_p_03">
        <tr>
          <td>{^$w_type_name^}</td>
        </tr>
      </table>
    </td>
    <td>
      <table class="tb tb_brn tb_p_03">
        <tr>
          <td>{^$weapon_info["w_damage_vest_0"]^}</td>
        </tr>
        <tr>
          <td>{^$weapon_info["w_damage_vest_1"]^}</td>
        </tr>
        <tr>
          <td>{^$weapon_info["w_damage_vest_2"]^}</td>
        </tr>
        <tr>
          <td>{^$weapon_info["w_damage_vest_3"]^}</td>
        </tr>
      </table>
    </td>
    <td>
      <table class="tb tb_brn tb_p_03">
        <tr>
          <td>{^$weapon_info["w_damage_helmet_0"]^}</td>
        </tr>
        <tr>
          <td>{^$weapon_info["w_damage_helmet_1"]^}</td>
        </tr>
        <tr>
          <td>{^$weapon_info["w_damage_helmet_2"]^}</td>
        </tr>
        <tr>
          <td>{^$weapon_info["w_damage_helmet_3"]^}</td>
        </tr>
      </table>
    </td>
    <!--weapon_part-->
{^assign var="wp" value=$weapon_part_list[$w_type][$w_id]^}
    <td>
{^if isset($wp["1"]) and $weapon_info["w_part_able_1"]^}
      <table class="tb tb_brn tb_p_03">
{^foreach from=$wp["1"] item=p_id^}
        <tr>
          <td>{^$part_list["1"][$p_id]["p_name"]^}</td>
        </tr>
{^/foreach^}
      </table>
{^/if^}
    </td>
    <td>
{^if isset($wp["2"]) and $weapon_info["w_part_able_2"]^}
      <table class="tb tb_brn tb_p_03">
{^foreach from=$wp["2"] item=p_id^}
        <tr>
          <td>{^$part_list["2"][$p_id]["p_name"]^}{^if $part_list["2"][$p_id]["p_note"]^}({^$part_list["2"][$p_id]["p_note"]^}){^/if^}</td>
        </tr>
{^/foreach^}
      </table>
{^/if^}
    </td>
    <td>
{^if isset($wp["3"]) and $weapon_info["w_part_able_3"]^}
      <table class="tb tb_brn tb_p_03">
{^foreach from=$wp["3"] item=p_id^}
        <tr>
          <td>{^$part_list["3"][$p_id]["p_name"]^}</td>
        </tr>
{^/foreach^}
      </table>
{^/if^}
    </td>
    <td>
{^if isset($wp["4"]) and $weapon_info["w_part_able_4"]^}
      <table class="tb tb_brn tb_p_03">
{^foreach from=$wp["4"] item=p_id^}
        <tr>
          <td>{^$part_list["4"][$p_id]["p_name"]^}{^if $part_list["4"][$p_id]["p_note"]^}({^$part_list["4"][$p_id]["p_note"]^}){^/if^}</td>
        </tr>
{^/foreach^}
      </table>
{^/if^}
    </td>
    <td>
{^if isset($wp["5"]) and $weapon_info["w_part_able_5"]^}
      <table class="tb tb_brn tb_p_03">
{^foreach from=$wp["5"] item=p_id^}
        <tr>
          <td>{^$part_list["5"][$p_id]["p_name"]^}{^if $part_list["5"][$p_id]["p_note"]^}({^$part_list["5"][$p_id]["p_note"]^}){^/if^}</td>
        </tr>
{^/foreach^}
      </table>
{^/if^}
    </td>
    <td>
      <table class="tb tb_brn tb_p_03">
        <tr>
          <td>{^$part_list["6"][$wp["6"]]["p_name"]^}</td>
        </tr>
      </table>
    </td>
    <td>
      <table class="tb tb_brn tb_p_03">
        <tr>
          <td>{^$weapon_info["w_magazine_default"]^}</td>
        </tr>
{^if $weapon_info["w_magazine_default"] neq $weapon_info["w_magazine_extender"]^}
        <tr>
          <td>{^$weapon_info["w_magazine_extender"]^}</td>
        </tr>
{^/if^}
      </table>
    </td>
  </tr>
{^/foreach^}
{^/foreach^}
</table>
{^include file=$comfooter_file^}