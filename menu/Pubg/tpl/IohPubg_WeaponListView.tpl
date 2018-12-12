{^include file=$comheader_file^}
{^include file=$comnaviga_file^}
<link rel="stylesheet" href="css/pubg/disp.css" type="text/css" />
<!--script type="text/javascript" src="js/pubg/disp.js"></script-->
<table class="table_box tb tb_org tb_p_05">
  <tr>
    <td class="table_name_box"><a href="./?menu=pubg&act=weapon_input">添加武器</a></td>
    <th>武器类型</th>
    <th>伤害</th>
    <th>可装配件</th>
    <th>弹夹容量</th>
  </tr>
{^foreach from=$weapon_type_list key=w_type_key item=w_type_name^}
{^foreach from=$weapon_list[$w_type_key] key=w_id item=weapon_info^}
  <tr>
    <td><a href="./?menu=pubg&act=weapon_input&w_id={^$w_id^}">{^$weapon_info["w_name"]^}</a></td>
    <td>{^$w_type_name^}</td>
    <td>
      <table class="tb tb_brn tb_p_03">
        <tr>
          <th class="weapon_box_th">无护甲</th>
          <td class="weapon_box_td">{^$weapon_info["w_damage_vest_0"]^}</td>
          <th class="weapon_box_th">无头盔</th>
          <td class="weapon_box_td">{^$weapon_info["w_damage_helmet_0"]^}</td>
        </tr>
        <tr>
          <th>1级护甲</th>
          <td>{^$weapon_info["w_damage_vest_1"]^}</td>
          <th>1级头盔</th>
          <td>{^$weapon_info["w_damage_helmet_1"]^}</td>
        </tr>
        <tr>
          <th>2级护甲</th>
          <td>{^$weapon_info["w_damage_vest_2"]^}</td>
          <th>2级头盔</th>
          <td>{^$weapon_info["w_damage_helmet_2"]^}</td>
        </tr>
        <tr>
          <th>3级护甲</th>
          <td>{^$weapon_info["w_damage_vest_3"]^}</td>
          <th>3级头盔</th>
          <td>{^$weapon_info["w_damage_helmet_3"]^}</td>
        </tr>
      </table>
    </td>
    <td>
      <table class="tb tb_brn tb_p_03">
        <tr>
          <th class="weapon_box_th">上轨道</th>
          <td class="weapon_box_td">{^if $weapon_info["w_part_able_1"]^}√{^/if^}</td>
        </tr>
        <tr>
          <th>枪口</th>
          <td>{^if $weapon_info["w_part_able_2"]^}√{^/if^}</td>
        </tr>
        <tr>
          <th>下轨道</th>
          <td>{^if $weapon_info["w_part_able_3"]^}√{^/if^}</td>
        </tr>
        <tr>
          <th>弹夹</th>
          <td>{^if $weapon_info["w_part_able_4"]^}√{^/if^}</td>
        </tr>
        <tr>
          <th>枪托</th>
          <td>{^if $weapon_info["w_part_able_5"]^}√{^/if^}</td>
        </tr>
      </table>
    </td>
    <td>{^$weapon_info["w_magazine_default"]^}{^if $weapon_info["w_magazine_default"] neq $weapon_info["w_magazine_extender"]^}({^$weapon_info["w_magazine_extender"]^}){^/if^}</td>
  </tr>
{^/foreach^}
{^/foreach^}
</table>
{^include file=$comfooter_file^}