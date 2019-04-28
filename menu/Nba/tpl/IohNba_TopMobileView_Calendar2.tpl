<style type="text/css">
.calendar_table th,
.calendar_table td {
  text-align:center;
}
.collapsible_box {
  padding-left:0;
  padding-right:0;
}
</style>
<div data-role="panel" id="calendar" data-display="reveal" data-position="right">
<div data-role="collapsibleset" data-theme="a" data-content-theme="a" data-collapsed-icon="calendar" data-expanded-icon="delete" data-inset="false">
{^foreach from=$calendar_info key=m_year item=year_item^}
{^foreach from=$year_item key=m_month item=month_item^}
<div data-role="collapsible" class="collapsible_box" data-inset="false" data-collapsed="{^if $month_item["key"] eq $calendar_year_month^}false{^else^}true{^/if^}">
<h3>{^$m_year^}年{^$m_month^}月</h3>
<table data-role="table" data-mode="columntoggle:none" class="ui-responsive calendar_table">
  <thead>
    <tr>
      <th>日</th>
      <th>一</th>
      <th>二</th>
      <th>三</th>
      <th>四</th>
      <th>五</th>
      <th>六</th>
    </tr>
  </thead>
  <tbody>
{^foreach from=$month_item["data"] item=week_info^}
    <tr>
{^foreach from=$week_info item=day_info^}
      <td>{^if $day_info["date"]^}<a href="./?menu=nba&act=top&date={^$day_info["date"]^}">{^$day_info["day"]^}</a>{^else^}&nbsp;{^/if^}</td>
{^/foreach^}
    </tr>
{^/foreach^}
  </tbody>
</table>
</div>
{^/foreach^}
{^/foreach^}
</div>
</div>