{^include file=$mblheader_file^}
<div data-role="collapsible" data-collapsed-icon="carat-d" data-expanded-icon="carat-u" data-iconpos="right" data-collapsed="false">
  <h4>{^$novel_info["n_name"]^}</h4>
  <table>
    <tbody>
      <tr>
        <td colspan="2">{^$novel_info["n_info"]^}</td>
      </tr>
      <tr>
        <th width="18%" align="left">作者</th>
        <td>{^$novel_info["n_author"]^}</td>
      </tr>
      <tr>
        <th align="left" valign="top">简介</th>
        <td>{^$novel_info["n_evaluate"]^}</td>
      </tr>
{^if $novel_info["final_flg"]^}
      <tr>
        <th align="left" valign="top">已完结</th>
        <td>{^$novel_info["update_date"]|date_format:"%Y-%m-%d"^}</td>
      </tr>
{^else^}
      <tr>
        <th rowspan="2" align="left" valign="top">新章节</th>
        <td>{^$novel_info["update_date"]|date_format:"%Y-%m-%d"^}</td>
      </tr>
      <tr>
        <td><a href="./?menu=novel&act=content&novel_id={^$n_id^}&article_id={^$last_article["article_id"]^}" class="ui-btn ui-corner-all">{^$last_article["title"]^}</a></td>
      </tr>
{^/if^}
    </tbody>
  </table>
</div>
<h1></h1>
<ul data-role="listview">
{^foreach from=$article_list key=article_id item=article_name^}
  <li><a href="./?menu=novel&act=content&novel_id={^$n_id^}&article_id={^$article_id^}" id="article_id_{^$article_id^}">{^$article_name^}</a></li>
{^/foreach^}
</ul>
{^include file=$mblfooter_file^}