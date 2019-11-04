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
<script type="text/javascript">
$(document).ready(function(){
    var synchFlag = function () {
        var flag_cols = $("input.confirm_checkbox");
        var flag_cols_max = flag_cols.length;
        var flag_count = 0;
        flag_cols.each(function(){
            if ($(this).prop("checked")) {
                flag_count += 1;
            }
        });
        var t_checkbox = $("input#select_total");
        if (flag_count == flag_cols_max) {
            t_checkbox.prop("indeterminate", false);
            t_checkbox.prop("checked", true);
        } else if (flag_count == 0) {
            t_checkbox.prop("indeterminate", false);
            t_checkbox.prop("checked", false);
        } else {
            t_checkbox.prop("indeterminate", true);
        }
    };
    synchFlag();
    $("input.confirm_checkbox").change(function(){
        synchFlag();
    });
    $("input#select_total").change(function(){
        if ($(this).prop("checked")) {
            $("input.confirm_checkbox").prop("checked", true);
        } else {
            $("input.confirm_checkbox").prop("checked", false);
        }
    });
    $(".player_name_en").focus(function(){
        $(this).select();
    });
});
</script>
<div class="disp-box bl_c mt_30">
<form action="./" method="get">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<input type="hidden" name="t_id" value="{^$t_id^}" />
  <table class="tb tb_p_05 tb_brn" style="width:1000px;">
    <tr>
      <th rowspan="2">球队选择</th>
      <td style="text-align:left!important;" colspan="8">
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
      <td style="text-align:left!important;" colspan="8">
{^foreach from=$western_team_list item=team_item^}
{^if $team_item["t_id"] eq $t_id^}
        <span>{^$team_item["t_name_cn"]^}</span>
{^else^}
        <a href="./?menu={^$current_menu^}&act={^$current_act^}&t_id={^$team_item["t_id"]^}">{^$team_item["t_name_cn"]^}</a>
{^/if^}
{^/foreach^}
      </td>
    </tr>
{^if !empty($player_info_list)^}
    <tr>
      <th rowspan="{^$player_info_list|@count + 1^}">球员信息</th>
      <th><label><input type="checkbox" id="select_total" />全选</label></th>
      <th>英文名</th>
      <th>中文名</th>
      <th>索引</th>
      <th>球衣号码</th>
      <th>国籍</th>
      <th>生日</th>
      <th>操作</th>
    </tr>
{^foreach from=$player_info_list item=player_info_item^}
    <tr>
      <td><input type="checkbox" name="p_name_cnf_flg[{^$player_info_item["p_id"]^}]" value="1" class="confirm_checkbox"{^if $player_info_item["p_name_cnf_flg"] eq "1"^} checked{^/if^}/></td>
      <td><input type="text" class="text-box player_name_en" value="{^$player_info_item["p_first_name"]^} {^$player_info_item["p_last_name"]^}" readonly /></td>
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
      <td><label><span class="operate_button">确认</span><input type="submit" name="syncho" value="{^$player_info_item["p_id"]^}" style="display:none;" /></label></td>
    </tr>
{^/foreach^}
{^/if^}
    <tr>
      <td colspan="9"><label><span class="operate_button" style="width:400px; margin:0 auto;">提交</span><input type="submit" name="submit" value="1" style="display:none;" /></label></td>
    </tr>
  </table>
</form>
</div>
{^include file=$comfooter_file^}