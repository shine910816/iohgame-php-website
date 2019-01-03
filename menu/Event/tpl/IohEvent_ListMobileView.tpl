{^include file=$mblheader_file^}
<h3 class="ui-bar ui-bar-a ui-corner-all">站内活动</h3>
{^if !empty($event_list)^}
{^foreach from=$event_list key=event_list_key item=event_list_item^}
<div class="ui-body ui-body-a ui-corner-all mt_08">
  <h3>
    <span>{^$event_list_item["event_name"]^}</span>
    <a href="./?menu=event&act=detail&k={^$event_list_item["detail_param"]^}" class="ui-btn ui-icon-arrow-r ui-btn-icon-notext ui-corner-all ui-btn-inline" data-ajax="false">活动详情</a>
  </h3>
  <p>{^$event_list_item["event_descript"]^}</p>
{^if $event_list_item["event_expiry_date"] neq "9999-12-31 23:59:59"^}
  <p>活动截止日期为{^$event_list_item["event_expiry_date"]|date_format:"%Y-%m-%d"^}</p>
{^/if^}
</div>
{^/foreach^}
{^/if^}
{^include file=$mblpagina_file^}
<a href="./" class="ui-btn ui-corner-all ui-btn-a" data-ajax="false">返回</a>
{^include file=$mblfooter_file^}