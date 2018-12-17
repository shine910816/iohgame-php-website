{^include file=$mblheader_file^}
<style type="text/css">
.custom-corners .ui-bar {
  -webkit-border-top-left-radius: inherit;
  border-top-left-radius: inherit;
  -webkit-border-top-right-radius: inherit;
  border-top-right-radius: inherit;
}
.custom-corners .ui-body {
  border-top-width: 0;
  -webkit-border-bottom-left-radius: inherit;
  border-bottom-left-radius: inherit;
  -webkit-border-bottom-right-radius: inherit;
  border-bottom-right-radius: inherit;
}
</style>
<a href="#rightpanel" class="ui-btn ui-icon-bullets ui-btn-icon-left ui-corner-all ui-shadow-icon ui-btn-b">积分卡券</a>
<div class="ui-corner-all custom-corners">
  <div class="ui-bar ui-bar-a">
    <h3>积分</h3>
  </div>
  <div class="ui-body ui-body-a">
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
</div>
{^if !empty($coupon_info)^}
<p></p>
<div class="ui-corner-all custom-corners">
  <div class="ui-bar ui-bar-a">
    <h3>优惠券</h3>
  </div>
  <div class="ui-body ui-body-a">
    <table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
      <tbody>
{^foreach from=$coupon_info item=coupon_info_item^}
        <tr>
          <td>
            <h4>{^$coupon_info_item["coupon_name"]^}</h4>
            <p>{^$coupon_info_item["coupon_descript"]^}</p>
            <p>使用范围: {^$coupon_apply_range_list[$coupon_info_item["coupon_apply_range"]]^}</p>
            <p>有效期至{^$coupon_info_item["coupon_vaildity_expiry"]|date_format:"%Y-%m-%d"^}</p>
            <a href="./?menu=coupon&act=detail&n={^$coupon_info_item["coupon_number"]^}" class="ui-btn ui-corner-all ui-btn-a ui-mini">详细</a>
          </td>
        </tr>
{^/foreach^}
      </tbody>
    </table>
  </div>
</div>
{^/if^}
{^include file=$mblfooter_file^}