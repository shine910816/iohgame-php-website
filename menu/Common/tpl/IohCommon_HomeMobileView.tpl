{^include file=$mblheader_file^}
<div data-role="collapsible" data-content-theme="false" data-collapsed="false" data-collapsed-icon="carat-d" data-expanded-icon="carat-u" data-iconpos="right" data-theme="b">
  <h4>站内活动</h4>
  <table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
    <tbody>
{^foreach from=$event_list key=event_list_key item=event_list_item^}
      <tr>
        <td>
          <h3>
            <span>{^$event_list_item["event_name"]^}</span>
            <a href="./?menu=event&act=detail&k={^$event_list_item["detail_param"]^}" class="ui-btn ui-icon-arrow-r ui-btn-icon-notext ui-corner-all ui-btn-inline" data-ajax="false">活动详情</a>
          </h3>
          <p>{^$event_list_item["event_descript"]^}</p>
{^if $event_list_item["event_expiry_date"] neq "9999-12-31 23:59:59"^}
          <p>活动截止日期为{^$event_list_item["event_expiry_date"]|date_format:"%Y-%m-%d"^}</p>
{^/if^}
        </td>
      </tr>
{^/foreach^}
    </tbody>
  </table>
  <a href="./?menu=event&act=list" class="ui-btn ui-mini ui-corner-all">更多内容</a>
</div>
{^include file=$mblfooter_file^}