{^include file=$mblheader_file^}
<div class="ui-body ui-body-a ui-corner-all">
  <h3>优惠券详细</h3>
  <table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
    <tbody>
      <tr>
        <th colspan="2">{^$coupon_info["coupon_name"]^}</th>
      </tr>
      <tr>
        <td colspan="2" class="ta_r">{^$coupon_info["coupon_number"]^}</td>
      </tr>
      <tr>
        <td colspan="2">{^$coupon_info["coupon_descript"]^}</td>
      </tr>
      <tr>
        <th>领取日期</th>
        <td>{^$coupon_info["coupon_publish_date"]|date_format:"%Y-%m-%d"^}</td>
      </tr>
      <tr>
        <th>有效期</th>
        <td>{^$coupon_info["coupon_vaildity_expiry"]|date_format:"%Y-%m-%d"^}</td>
      </tr>
      <tr>
        <th>使用状态</th>
        <td>{^if $coupon_info["coupon_apply_flg"]^}于{^$coupon_info["coupon_apply_date"]|date_format:"%Y-%m-%d"^}使用{^else^}尚未使用{^/if^}</td>
      </tr>
    </tbody>
  </table>
</div>
<a href="./{^$back_url^}" class="ui-btn ui-corner-all ui-btn-a" data-ajax="false">返回</a>
{^include file=$mblfooter_file^}