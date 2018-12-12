{^include file=$mblheader_file^}
<style type="text/css">
.percent_bar_background {
  width:100%;
  height:1em;
  background-color:#EDEDED;
}
.percent_bar {
  height:1em;
  background-color:#A5A5A5;
}
</style>
{^foreach from=$weapon_type_list key=w_type item=w_type_name^}
{^foreach from=$weapon_list[$w_type] key=w_id item=weapon_info^}
{^assign var=wp value=$weapon_part_list[$w_type][$w_id]^}
<div data-role="collapsible" data-collapsed-icon="carat-d" data-expanded-icon="carat-u">
  <h4>{^$weapon_info["w_name"]^}</h4>
  <table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
    <tbody>
      <tr>
        <th>类型</th>
        <td>{^$w_type_name^}</td>
      </tr>
      <tr>
        <th>弹药</th>
        <td>{^$part_list["6"][$wp["6"]]["p_name"]^}</td>
      </tr>
      <tr>
        <th>弹夹容量</th>
        <td>{^$weapon_info["w_magazine_default"]^}{^if $weapon_info["w_magazine_default"] neq $weapon_info["w_magazine_extender"]^}({^$weapon_info["w_magazine_extender"]^}){^/if^}</td>
      </tr>
      <tr>
        <th rowspan="2">伤害</th>
        <td>
          <table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
            <thead>
              <tr>
                <td></td>
                <th>护甲</th>
                <th>头盔</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>无</th>
                <td>{^$weapon_info["w_damage_vest_0"]|string_format:"%d"^}</td>
                <td>{^$weapon_info["w_damage_helmet_0"]|string_format:"%d"^}</td>
              </tr>
              <tr>
                <th>1级</th>
                <td>{^$weapon_info["w_damage_vest_1"]|string_format:"%d"^}</td>
                <td>{^$weapon_info["w_damage_helmet_1"]|string_format:"%d"^}</td>
              </tr>
              <tr>
                <th>2级</th>
                <td>{^$weapon_info["w_damage_vest_2"]|string_format:"%d"^}</td>
                <td>{^$weapon_info["w_damage_helmet_2"]|string_format:"%d"^}</td>
              </tr>
              <tr>
                <th>3级</th>
                <td>{^$weapon_info["w_damage_vest_3"]|string_format:"%d"^}</td>
                <td>{^$weapon_info["w_damage_helmet_3"]|string_format:"%d"^}</td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
      <tr>
        <td><div class="percent_bar_background"><div class="percent_bar" style="width:{^$weapon_info["w_damage_percent"]^}%;"></div></div></td>
      </tr>
      <tr>
        <th rowspan="2">归零距离</th>
        <td>{^$weapon_info["w_distance_min"]^}{^if $weapon_info["w_distance_min"] neq $weapon_info["w_distance_max"]^}~{^$weapon_info["w_distance_max"]^}{^/if^}m</td>
      </tr>
      <tr>
        <td><div class="percent_bar_background"><div class="percent_bar" style="width:{^$weapon_info["w_distance_percent"]^}%;"></div></div></td>
      </tr>
      <tr>
        <th rowspan="2">子弹初速</th>
        <td>{^$weapon_info["w_speed"]^}m/s</td>
      </tr>
      <tr>
        <td><div class="percent_bar_background"><div class="percent_bar" style="width:{^$weapon_info["w_speed_percent"]^}%;"></div></div></td>
      </tr>
      <tr>
        <th rowspan="2">射击间隔</th>
        <td>{^$weapon_info["w_interval_time"]^}s</td>
      </tr>
      <tr>
        <td><div class="percent_bar_background"><div class="percent_bar" style="width:{^$weapon_info["w_interval_percent"]^}%;"></div></div></td>
      </tr>
      <tr>
        <td colspan="2">
{^if isset($wp["1"]) and $weapon_info["w_part_able_1"]^}
          <div data-role="collapsible" data-mini="true">
            <h4>上轨道</h4>
            <ul data-role="listview" data-inset="false">
{^foreach from=$wp["1"] item=p_id^}
              <li>{^$part_list["1"][$p_id]["p_name"]^}</li>
{^/foreach^}
            </ul>
          </div>
{^/if^}
{^if isset($wp["2"]) and $weapon_info["w_part_able_2"]^}
          <div data-role="collapsible" data-mini="true">
            <h4>枪口</h4>
            <ul data-role="listview" data-inset="false">
{^foreach from=$wp["2"] item=p_id^}
              <li>{^$part_list["2"][$p_id]["p_name"]^}{^if $part_list["2"][$p_id]["p_note"]^}({^$part_list["2"][$p_id]["p_note"]^}){^/if^}</li>
{^/foreach^}
            </ul>
          </div>
{^/if^}
{^if isset($wp["3"]) and $weapon_info["w_part_able_3"]^}
          <div data-role="collapsible" data-mini="true">
            <h4>下轨道</h4>
            <ul data-role="listview" data-inset="false">
{^foreach from=$wp["3"] item=p_id^}
              <li>{^$part_list["3"][$p_id]["p_name"]^}</li>
{^/foreach^}
            </ul>
          </div>
{^/if^}
{^if isset($wp["4"]) and $weapon_info["w_part_able_4"]^}
          <div data-role="collapsible" data-mini="true">
            <h4>弹夹</h4>
            <ul data-role="listview" data-inset="false">
{^foreach from=$wp["4"] item=p_id^}
              <li>{^$part_list["4"][$p_id]["p_name"]^}{^if $part_list["4"][$p_id]["p_note"]^}({^$part_list["4"][$p_id]["p_note"]^}){^/if^}</li>
{^/foreach^}
            </ul>
          </div>
{^/if^}
{^if isset($wp["5"]) and $weapon_info["w_part_able_5"]^}
          <div data-role="collapsible" data-mini="true">
            <h4>枪托</h4>
            <ul data-role="listview" data-inset="false">
{^foreach from=$wp["5"] item=p_id^}
              <li>{^$part_list["5"][$p_id]["p_name"]^}{^if $part_list["5"][$p_id]["p_note"]^}({^$part_list["5"][$p_id]["p_note"]^}){^/if^}</li>
{^/foreach^}
            </ul>
          </div>
{^/if^}
        </td>
      </tr>
    </tbody>
  </table>
</div>
{^/foreach^}
{^/foreach^}
{^include file=$mblfooter_file^}