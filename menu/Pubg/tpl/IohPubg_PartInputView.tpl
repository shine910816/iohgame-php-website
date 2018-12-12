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
      <input class="input_box" type="text" name="part_info[p_name]" value="{^$part_info["p_name"]^}" />
      <input type="hidden" name="p_id" value="{^$p_id^}" />
    </td>
    <th class="table_th">类型</th>
    <td class="table_td">
      <select class="input_box" name="part_info[p_type]">
        <option value="0">未选择</option>
{^foreach from=$part_type_list key=p_type_value item=p_type_name^}
        <option value="{^$p_type_value^}"{^if $p_type_value eq $part_info["p_type"]^} selected{^/if^}>{^$p_type_name^}</option>
{^/foreach^}
      </select>
    </td>
  </tr>
  <tr>
  <tr>
    <th>注释</th>
    <td colspan="3">
      <input class="input_box" type="text" name="part_info[p_note]" value="{^$part_info["p_note"]^}" />
    </td>
  </tr>
    <th>图片</th>
    <td>
      <input class="input_box" type="text" name="part_info[p_image]" value="{^$part_info["p_image"]^}" />
    </td>
    <th>描述</th>
    <td>
      <input class="input_box" type="text" name="part_info[p_descript]" value="{^$part_info["p_descript"]^}" />
    </td>
  </tr>
</table>
<label class="clickable_button button_orange">
  <span>{^if $p_id^}修改{^else^}创建{^/if^}</span>
  <input class="no_disp" type="submit" name="confirm" value="1" />
</label>
<label class="clickable_button button_white">
  <span>返回</span>
  <input class="no_disp" type="submit" name="back" value="1" />
</label>
</form>
{^include file=$comfooter_file^}