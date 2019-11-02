{^include file=$empheader_file^}
<link rel="stylesheet" href="css/hearth_stone/admin_list.css" type="text/css">
<link rel="stylesheet" href="css/hearth_stone/input.css" type="text/css">
<style type="text/css">
.operate_button {
  width:70px;
  height:32px;
  border:1px solid #000;
  display:block;
  text-align:center;
  line-height:32px;
  background-color:#F60;
  color:#FFF;
  border-radius:5px;
}
</style>
<div class="disp-box bl_c mt_30">
<form action="./" method="get">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<input type="hidden" name="t_id" value="{^$t_id^}" />
  <table class="tb tb_p_05 tb_brn">
    <tr>
      <th rowspan="2">球队选择</th>
      <td style="text-align:left!important;">
{^foreach from=$eastern_team_list item=team_item^}
{^if $team_item["t_id"] eq $t_id^}
        <span>{^$team_item["t_name_cn"]^}</span>
{^else^}
        <a href="./?menu={^$current_menu^}&act={^$current_act^}&t_id={^$team_item["t_id"]^}">{^$team_item["t_name_cn"]^}</a>
{^/if^}
{^/foreach^}
      </td>
    </tr>
    <tr>
      <td style="text-align:left!important;">
{^foreach from=$western_team_list item=team_item^}
{^if $team_item["t_id"] eq $t_id^}
        <span>{^$team_item["t_name_cn"]^}</span>
{^else^}
        <a href="./?menu={^$current_menu^}&act={^$current_act^}&t_id={^$team_item["t_id"]^}">{^$team_item["t_name_cn"]^}</a>
{^/if^}
{^/foreach^}
      </td>
    </tr>
    <tr>
      <th>球员信息</th>
      <td>
{^if !empty($player_info_list)^}
        <table class="tb tb_p_05 tb_grn">
          <tr>
            <td></td>
            <th>中文名</th>
            <th>索引</th>
            <th>球衣号码</th>
            <th>国籍</th>
            <th>生日</th>
            <th colspan="2">操作</th>
          </tr>
{^foreach from=$player_info_list item=player_info_item^}
          <tr>
            <th>{^$player_info_item["p_first_name"]^} {^$player_info_item["p_last_name"]^}</th>
            <td><input type="text" name="p_name[{^$player_info_item["p_id"]^}]" value="{^$player_info_item["p_name"]^}" class="text-box" /></td>
            <td>
              <select name="p_alpha[{^$player_info_item["p_id"]^}]" class="text-box" style="width:70px!important;">
{^foreach from=$alpha_list key= alpha_key item=alpha_item^}
                <option value="{^$alpha_key^}"{^if $alpha_key eq $player_info_item["p_name_alphabet"]^} selected{^/if^}>{^$alpha_item^}</option>
{^/foreach^}
              </select>
            </td>
            <td>{^$player_info_item["p_jersey"]^}</td>
            <td>{^if isset($country_list[$player_info_item["p_country"]])^}{^$country_list[$player_info_item["p_country"]]^}{^/if^}</td>
            <td>{^$player_info_item["p_birth_date"]^}</td>
            <td><label><input type="checkbox" name="p_name_cnf_flg[{^$player_info_item["p_id"]^}]" value="1" {^if $player_info_item["p_name_cnf_flg"] eq "1"^} checked{^/if^}/>同步</label></td>
            <td><label><span class="operate_button">确认</span><input type="submit" name="syncho" value="{^$player_info_item["p_id"]^}" style="display:none;" /></label></td>
          </tr>
{^/foreach^}
        </table>
{^/if^}
      </td>
    </tr>
    <tr>
      <td colspan="2"><label><span class="operate_button">提交</span><input type="submit" name="submit" value="1" style="display:none;" /></label></td>
    </tr>
  </table>
</form>
</div>
{^include file=$comfooter_file^}