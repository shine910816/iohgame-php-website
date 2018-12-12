{^include file=$comheader_file^}
{^include file=$comnaviga_file^}
<link rel="stylesheet" href="css/novel/list.css" type="text/css" />
<div class="novel_info_area bl_c mt_10 brr bx_sh">
  <div class="novel_info_line">{^$novel_info["n_name"]^}</div>
  <div class="novel_info_line">{^$novel_info["n_info"]^}</div>
  <div class="novel_info_line">作者 {^$novel_info["n_author"]^}</div>
  <div class="novel_info_line">简介 {^$novel_info["n_evaluate"]^}</div>
  <div class="novel_info_line">{^if $novel_info["final_flg"]^}已完结{^else^}最后更新 <a href="./?menu=novel&act=content&novel_id={^$n_id^}&article_id={^$last_article["article_id"]^}">{^$last_article["title"]^}</a>{^/if^} ({^$novel_info["update_date"]|date_format:"%Y-%m-%d"^})</div>
</div>
<ul class="novel_list_area bl_c mt_10 brr bx_sh">
{^foreach from=$article_list key=article_id item=article_name^}
  <li><a href="./?menu=novel&act=content&novel_id={^$n_id^}&article_id={^$article_id^}" id="article_id_{^$article_id^}">{^$article_name^}</a></li>
{^/foreach^}
</ul>
{^include file=$comfooter_file^}