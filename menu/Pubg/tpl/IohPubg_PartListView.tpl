{^include file=$comheader_file^}
{^include file=$comnaviga_file^}
<link rel="stylesheet" href="css/pubg/disp.css" type="text/css" />
<!--script type="text/javascript" src="js/pubg/disp.js"></script-->
<table class="table_box tb tb_org tb_p_05">
  <tr>
    <td class="table_name_box"><a href="./?menu=pubg&act=part_input">添加配件</a></td>
    <th>配件类型</th>
    <th>备注</th>
  </tr>
{^foreach from=$part_type_list key=p_type_key item=p_type_name^}
{^foreach from=$part_list[$p_type_key] key=p_id item=part_info^}
  <tr>
    <td><a href="./?menu=pubg&act=part_input&p_id={^$p_id^}">{^$part_info["p_name"]^}</a></td>
    <td>{^$p_type_name^}</td>
    <td>{^$part_info["p_note"]^}</td>
  </tr>
{^/foreach^}
{^/foreach^}
</table>
{^include file=$comfooter_file^}