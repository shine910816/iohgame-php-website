{^include file=$mblheader_file^}
<div class="ui-grid-solo">
  <div class="ui-block-a"><a class="ui-shadow ui-btn ui-corner-all ui-icon-back ui-btn-icon-left" data-ajax="false" href="./?menu=novel&act=list&novel_id={^$n_id^}#article_id_{^$n_article_id^}">章节选择</a></div>
</div>
<div class="ui-grid-a">
  <div class="ui-block-a">{^if $prev_flg^}<a class="ui-shadow ui-btn ui-corner-all ui-icon-carat-l ui-btn-icon-left" href="./?menu=novel&act=content&novel_id={^$n_id^}&article_id={^$n_article_id-1^}">上一章</a>{^/if^}</div>
  <div class="ui-block-b">{^if $next_flg^}<a class="ui-shadow ui-btn ui-corner-all ui-icon-carat-r ui-btn-icon-right" href="./?menu=novel&act=content&novel_id={^$n_id^}&article_id={^$n_article_id+1^}">下一章</a>{^/if^}</div>
</div>
<div>
  <h1 align="center">{^$n_name^}</h1>
  <h3 align="center">{^$n_author^}</h3>
  <h3 align="center">{^$n_article^}</h3>
{^section name=nc loop=$novel_content^}
  <p>{^$novel_content[nc]^}</p>
{^/section^}
</div>
<div class="ui-grid-a">
  <div class="ui-block-a">{^if $prev_flg^}<a class="ui-shadow ui-btn ui-corner-all ui-icon-carat-l ui-btn-icon-left" href="./?menu=novel&act=content&novel_id={^$n_id^}&article_id={^$n_article_id-1^}">上一章</a>{^/if^}</div>
  <div class="ui-block-b">{^if $next_flg^}<a class="ui-shadow ui-btn ui-corner-all ui-icon-carat-r ui-btn-icon-right" href="./?menu=novel&act=content&novel_id={^$n_id^}&article_id={^$n_article_id+1^}">下一章</a>{^/if^}</div>
</div>
<div class="ui-grid-solo">
  <div class="ui-block-a"><a class="ui-shadow ui-btn ui-corner-all ui-icon-back ui-btn-icon-left" data-ajax="false" href="./?menu=novel&act=list&novel_id={^$n_id^}#article_id_{^$n_article_id^}">章节选择</a></div>
</div>
{^include file=$mblfooter_file^}