{^include file=$mblheader_file^}
<a href="#rightpanel" class="ui-btn ui-icon-bullets ui-btn-icon-left ui-corner-all ui-shadow-icon ui-btn-b">积分卡券</a>
<h3 class="ui-bar ui-bar-a ui-corner-all">积分</h3>
<div class="ui-body ui-body-a ui-corner-all">
  <table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
    <tbody>
      <tr>
        <th>当前积分</th>
        <td>{^$custom_point^}</td>
      </tr>
    </tbody>
  </table>
  <a href="./?menu=user&act=point_history" class="ui-btn  ui-corner-all ui-btn-a">积分明细</a>
</div>
<h3 class="ui-bar ui-bar-a ui-corner-all">优惠券</h3>
<div class="ui-body ui-body-a ui-corner-all">
</div>
{^include file=$mblfooter_file^}