{^include file=$comheader_file^}
{^include file=$comnaviga_file^}
<link rel="stylesheet" href="css/novel/content.css" type="text/css" />
<div class="novel_disp_area bl_c mt_10 brr bx_sh">
  <div class="novel_title mt_10">{^$n_name^}</div>
  <div class="novel_author mt_10">{^$n_author^}</div>
  <div class="article_page mt_30 bl_c">
    <div class="article_page_one">{^if $prev_flg^}<a href="./?menu=novel&act=content&novel_id={^$n_id^}&article_id={^$n_article_id-1^}"><i class="fa fa-chevron-left"></i>&nbsp;上一章</a>{^/if^}</div>
    <div class="article_page_one"><a href="./?menu=novel&act=list&novel_id={^$n_id^}#article_id_{^$n_article_id^}">章节选择</a></div>
    <div class="article_page_one">{^if $next_flg^}<a href="./?menu=novel&act=content&novel_id={^$n_id^}&article_id={^$n_article_id+1^}">下一章&nbsp;<i class="fa fa-chevron-right"></i></a>{^/if^}</div>
  </div>
  <div class="cut_line mt_20"></div>
  <div class="article_title mt_20">{^$n_article^}</div>
  <div class="article_content">
  {^section name=nc loop=$novel_content^}
  <p>{^$novel_content[nc]^}</p>
  {^/section^}
  </div>
  <div class="cut_line mt_20"></div>
  <div class="article_page mt_20 bl_c">
    <div class="article_page_one">{^if $prev_flg^}<a href="./?menu=novel&act=content&novel_id={^$n_id^}&article_id={^$n_article_id-1^}"><i class="fa fa-chevron-left"></i>&nbsp;上一章</a>{^/if^}</div>
    <div class="article_page_one"><a href="./?menu=novel&act=list&novel_id={^$n_id^}#article_id_{^$n_article_id^}">章节选择</a></div>
    <div class="article_page_one">{^if $next_flg^}<a href="./?menu=novel&act=content&novel_id={^$n_id^}&article_id={^$n_article_id+1^}">下一章&nbsp;<i class="fa fa-chevron-right"></i></a>{^/if^}</div>
  </div>
</div>
{^include file=$comfooter_file^}