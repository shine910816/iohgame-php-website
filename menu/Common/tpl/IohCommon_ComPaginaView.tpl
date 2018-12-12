{^if $max_page gt 1^}
<style type="text/css" />
/* 分页条 */
div.pagination {
  width:100%;
  height:30px;
  text-align:center;
  line-height:30px;
}
div.pagination a {
  color:#999;
}
div.pagination a:hover,
div.pagination span {
  color:#000;
}
</style>
<div class="pagination bl_c mt_10">
  {^if $max_page gt 9^}<a href="{^$url_page^}page=1">首页</a>{^/if^}
  <a href="{^$url_page^}page={^if $current_page gt 1^}{^$current_page-1^}{^else^}1{^/if^}">上一页</a>
{^if $max_page lt 10^}
{^for $page=1 to $max_page^}
  {^if $page eq $current_page^}<span>{^$page^}</span>{^else^}<a href="{^$url_page^}page={^$page^}">{^$page^}</a>{^/if^}
{^/for^}
{^else^}
{^if $current_page lt 6^}
{^for $page=1 to 9^}
  {^if $page eq $current_page^}<span>{^$page^}</span>{^else^}<a href="{^$url_page^}page={^$page^}">{^$page^}</a>{^/if^}
{^/for^}
{^elseif $current_page gt $max_page-5^}
{^for $page=$max_page-8 to $max_page^}
  {^if $page eq $current_page^}<span>{^$page^}</span>{^else^}<a href="{^$url_page^}page={^$page^}">{^$page^}</a>{^/if^}
{^/for^}
{^else^}
{^for $page=$current_page-4 to $current_page+4^}
  {^if $page eq $current_page^}<span>{^$page^}</span>{^else^}<a href="{^$url_page^}page={^$page^}">{^$page^}</a>{^/if^}
{^/for^}
{^/if^}
{^/if^}
  <a href="{^$url_page^}page={^if $current_page lt $max_page^}{^$current_page+1^}{^else^}{^$max_page^}{^/if^}">下一页</a>
  {^if $max_page gt 9^}<a href="{^$url_page^}page={^$max_page^}">尾页</a>{^/if^}
</div>
{^/if^}
