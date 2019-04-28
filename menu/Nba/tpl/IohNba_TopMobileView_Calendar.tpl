<style type="text/css">
.calendar_table th,
.calendar_table td {
  text-align:center;
}
</style>
<div data-role="panel" id="calendar" data-display="reveal" data-position="right">
{^foreach from=$calendar_info key=m_year item=year_item^}
{^foreach from=$year_item key=m_month item=month_item^}
<h3 class="ui-bar ui-bar-a ui-corner-all">{^$m_year^}年{^$m_month^}月</h3>
<table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke calendar_table">
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
{^/foreach^}
{^/foreach^}
</div>