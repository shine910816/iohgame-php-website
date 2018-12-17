{^include file=$mblheader_file^}
<div class="ui-body ui-body-a ui-corner-all">
  <h3>积分明细</h3>
  <table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
    <thead>
      <tr>
        <th>日期</th>
        <th>理由</th>
        <th>额度</th>
      </tr>
    </thead>
{^if !empty($point_history_list)^}
    <tbody>
{^foreach from=$point_history_list item=point_history_item^}
      <tr>
        <td>{^$point_history_item["insert_date"]|date_format:"%Y-%m-%d"^}</td>
        <td>{^$point_reason_code_list[$point_history_item["point_type"]]^}{^if $point_history_item["point_note"] neq ""^}({^$point_history_item["point_note"]^}){^/if^}</td>
        <td class="ta_r{^if $point_history_item["point_value"] lt 0^} fc_red{^/if^}">{^$point_history_item["point_value"]^}</td>
      </tr>
{^/foreach^}
    </tbody>
{^/if^}
  </table>
  <a href="./?menu=user&act=pocket" class="ui-btn ui-corner-all ui-btn-a" data-ajax="false">返回</a>
</div>
{^include file=$mblfooter_file^}