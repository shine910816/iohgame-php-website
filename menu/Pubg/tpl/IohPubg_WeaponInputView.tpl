{^include file=$comheader_file^}
{^include file=$comnaviga_file^}
<link rel="stylesheet" href="css/pubg/input.css" type="text/css" />
<!--script type="text/javascript" src="js/pubg/input.js"></script-->
<form class="form_box" action="./" method="post">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<table class="tb tb_org tb_p_05">
  <tr>
    <th class="table_th">名称</th>
    <td class="table_td">
      <input class="input_box" type="text" name="weapon_info[w_name]" value="{^$weapon_info["w_name"]^}" />
      <input type="hidden" name="w_id" value="{^$w_id^}" />
    </td>
    <th class="table_th">类型</th>
    <td class="table_td">
      <select class="input_box" name="weapon_info[w_type]">
        <option value="0">未选择</option>
{^foreach from=$weapon_type_list key=w_type_value item=w_type_name^}
        <option value="{^$w_type_value^}"{^if $w_type_value eq $weapon_info["w_type"]^} selected{^/if^}>{^$w_type_name^}</option>
{^/foreach^}
      </select>
    </td>
  </tr>
  <tr>
    <th>对身体伤害</th>
    <td>
      <table class="tb tb_brn tb_p_03">
        <tr>
          <th>无护甲</th>
          <td><input class="input_box" type="text" name="weapon_info[w_damage_vest_0]" value="{^$weapon_info["w_damage_vest_0"]^}" /></td>
        </tr>
        <tr>
          <th>1级护甲</th>
          <td><input class="input_box" type="text" name="weapon_info[w_damage_vest_1]" value="{^$weapon_info["w_damage_vest_1"]^}" /></td>
        </tr>
        <tr>
          <th>2级护甲</th>
          <td><input class="input_box" type="text" name="weapon_info[w_damage_vest_2]" value="{^$weapon_info["w_damage_vest_2"]^}" /></td>
        </tr>
        <tr>
          <th>3级护甲</th>
          <td><input class="input_box" type="text" name="weapon_info[w_damage_vest_3]" value="{^$weapon_info["w_damage_vest_3"]^}" /></td>
        </tr>
      </table>
    </td>
    <th>对头部伤害</th>
    <td>
      <table class="tb tb_brn tb_p_03">
        <tr>
          <th>无头盔</th>
          <td><input class="input_box" type="text" name="weapon_info[w_damage_helmet_0]" value="{^$weapon_info["w_damage_helmet_0"]^}" /></td>
        </tr>
        <tr>
          <th>1级头盔</th>
          <td><input class="input_box" type="text" name="weapon_info[w_damage_helmet_1]" value="{^$weapon_info["w_damage_helmet_1"]^}" /></td>
        </tr>
        <tr>
          <th>2级头盔</th>
          <td><input class="input_box" type="text" name="weapon_info[w_damage_helmet_2]" value="{^$weapon_info["w_damage_helmet_2"]^}" /></td>
        </tr>
        <tr>
          <th>3级头盔</th>
          <td><input class="input_box" type="text" name="weapon_info[w_damage_helmet_3]" value="{^$weapon_info["w_damage_helmet_3"]^}" /></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <th>可装配件</th>
    <td colspan="3">
{^for $part_able_index=1 to 5^}
{^assign var="part_able_key" value="w_part_able_"|cat:$part_able_index^}
      <label class="checkbox_label"><input type="checkbox" name="part_able[{^$part_able_key^}]" value="1"{^if $weapon_info["$part_able_key"] eq "1"^} checked{^/if^} />{^$part_type_list[$part_able_index]^}</label>
{^/for^}
    </td>
  </tr>
  <tr>
    <th>弹夹容量</th>
    <td>
      <input class="input_box" type="text" name="weapon_info[w_magazine_default]" value="{^$weapon_info["w_magazine_default"]^}" />
    </td>
    <th>弹夹容量（扩展后）</th>
    <td>
      <input class="input_box" type="text" name="weapon_info[w_magazine_extender]" value="{^$weapon_info["w_magazine_extender"]^}" />
    </td>
  </tr>
  <tr>
    <th>图片</th>
    <td>
      <input class="input_box" type="text" name="weapon_info[w_image]" value="{^$weapon_info["w_image"]^}" />
    </td>
    <th>描述</th>
    <td>
      <input class="input_box" type="text" name="weapon_info[w_descript]" value="{^$weapon_info["w_descript"]^}" />
    </td>
  </tr>
</table>
<label class="clickable_button button_orange">
  <span>{^if $w_id^}修改{^else^}创建{^/if^}</span>
  <input class="no_disp" type="submit" name="confirm" value="1" />
</label>
<label class="clickable_button button_white">
  <span>返回</span>
  <input class="no_disp" type="submit" name="back" value="1" />
</label>
</form>
{^include file=$comfooter_file^}