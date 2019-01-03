{^include file=$mblheader_file^}
<div class="ui-body ui-body-a ui-corner-all">
  <h3>{^$event_info["event_name"]^}</h3>
  <p>{^$event_info["event_descript"]^}</p>
{^if $event_info["event_expiry_date"] neq "9999-12-31 23:59:59"^}
  <p>活动截止日期为{^$event_info["event_expiry_date"]|date_format:"%Y-%m-%d"^}</p>
{^/if^}
</div>
{^if $event_info["event_active_url"] neq ""^}
<a href="{^$event_info["event_active_url"]^}" class="ui-btn ui-corner-all ui-btn-b" data-ajax="false">{^$event_info["event_active_name"]^}</a>
{^/if^}
<a href="{^$back_url^}" class="ui-btn ui-corner-all ui-btn-a" data-ajax="false">返回</a>
{^include file=$mblfooter_file^}