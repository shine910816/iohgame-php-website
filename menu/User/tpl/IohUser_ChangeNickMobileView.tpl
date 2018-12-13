{^include file=$mblheader_file^}
<style type="text/css">
.display_point_box {
  text-align:right!important;
}
.added_item_box {
  margin-top: 8px!important;
}
.error_hint {
  color:#F60000!important;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
    $("#custom_nick").change(function(){
        var url = "./?menu={^$current_menu^}&act={^$current_act^}&n=" + encodeURI($(this).val());
        $.get(url);
    });
});
</script>
<form action="./" method="post">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<input type="hidden" name="selected_coupon" value="{^$selected_coupon^}" />
<div class="ui-body ui-body-a ui-corner-all">
  <h3>修改昵称</h3>
  <input name="custom_nick" value="{^$default_custom_nick^}" type="text" id="custom_nick">
{^if isset($user_err_list["custom_nick"])^}
  <h4 style="color:#F60000;">{^$user_err_list["custom_nick"]^}</h4>
{^/if^}
  <table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
    <tbody>
      <tr>
        <th>所需积分</th>
        <td class="display_point_box">{^$cost_point^}</td>
      </tr>
      <tr>
        <th>抵价减免</th>
        <td class="display_point_box">{^if $deduct_point gt 0^}-{^$deduct_point^}{^else^}无{^/if^}</td>
      </tr>
      <tr>
        <th>总计</th>
        <td class="display_point_box{^if $error_hint_flg^} error_hint{^/if^}">{^$total_point^}</td>
      </tr>
    </tbody>
  </table>
  <div class="ui-body ui-body-a ui-corner-all added_item_box">
    <table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
      <tbody>
        <tr>
          <th>当前积分</th>
          <td class="display_point_box">{^$custom_point^}</td>
        </tr>
      </tbody>
    </table>
{^if isset($user_err_list["custom_point"])^}
    <h4 style="color:#F60000;">{^$user_err_list["custom_point"]^}</h4>
{^/if^}
{^if !empty($coupon_info)^}
    <div data-role="collapsible" data-content-theme="false" data-iconpos="right" data-theme="{^if $selected_coupon eq ""^}a{^else^}b{^/if^}">
      <h4>{^if $selected_coupon eq ""^}未选择优惠券{^else^}{^$coupon_info[$selected_coupon]["coupon_name"]^}{^/if^}</h4>
      <table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
        <tbody>
{^foreach from=$coupon_info key=coupon_info_key item=coupon_info_item^}
          <tr>
            <td>
              <h4>{^$coupon_info_item["coupon_name"]^}</h4>
              <p>{^$coupon_info_item["coupon_descript"]^}</p>
              <p>有效期至{^$coupon_info_item["coupon_vaildity_expiry"]|date_format:"%Y-%m-%d"^}</p>
{^if $coupon_info_key eq $selected_coupon^}
              <a href="./?menu={^$current_menu^}&act={^$current_act^}" class="ui-btn ui-btn-b ui-corner-all">取消使用</a>
{^else^}
              <a href="./?menu={^$current_menu^}&act={^$current_act^}&selected_coupon={^$coupon_info_key^}" class="ui-btn ui-btn-a ui-corner-all">使用</a>
{^/if^}
            </td>
          </tr>
{^/foreach^}
        </tbody>
      </table>
    </div>
{^/if^}
  </div>
  <button type="submit" name="do_change" class="ui-btn ui-corner-all ui-btn-{^if $error_hint_flg eq ""^}b{^else^}a{^/if^}" />确认修改</button>
  <a href="./?menu=user&act=disp" class="ui-btn ui-corner-all" data-ajax="false">返回</a>
</div>
</form>
{^include file=$mblfooter_file^}