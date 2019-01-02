{^if $max_page gt 1^}
{^if $max_page gt 5^}
<div class="ui-grid-a">
  <div class="ui-block-a"><a href="{^$url_page^}page={^if $current_page gt 1^}{^$current_page-1^}{^else^}1{^/if^}" class="ui-btn ui-corner-all ui-btn-a ui-btn-icon-left ui-icon-carat-l" data-ajax="false">上一页</a></div>
  <div class="ui-block-b"><a href="{^$url_page^}page={^if $current_page lt $max_page^}{^$current_page+1^}{^else^}{^$max_page^}{^/if^}" class="ui-btn ui-corner-all ui-btn-a ui-btn-icon-right ui-icon-carat-r" data-ajax="false">下一页</a></div>
</div>
{^/if^}
{^if $max_page lt 6^}
<div class="{^$mbl_grid_class_list[$max_page]^}">
{^assign var="page_number_index" value=0^}
{^for $page_number=1 to $max_page^}
  <div class="{^$mbl_grid_block_class_list[$page_number_index]^}"><a href="{^$url_page^}page={^$page_number^}" class="ui-btn ui-corner-all ui-btn-{^if $page_number eq $current_page^}b{^else^}a{^/if^}" data-ajax="false">{^if $max_page lt 4^}第{^/if^}{^$page_number^}{^if $max_page lt 4^}页{^/if^}</a></div>
{^assign var="page_number_index" value=$page_number_index+1^}
{^/for^}
</div>
{^else^}
{^if $current_page lt 4^}
{^assign var="page_number_start" value=1^}
{^assign var="page_number_expiry" value=5^}
{^elseif $current_page gt $max_page-3^}
{^assign var="page_number_start" value=$max_page-4^}
{^assign var="page_number_expiry" value=$max_page^}
{^else^}
{^assign var="page_number_start" value=$current_page-2^}
{^assign var="page_number_expiry" value=$current_page+2^}
{^/if^}
<div class="ui-grid-d">
{^assign var="page_number_index" value=0^}
{^for $page_number=$page_number_start to $page_number_expiry^}
  <div class="{^$mbl_grid_block_class_list[$page_number_index]^}"><a href="{^$url_page^}page={^$page_number^}" class="ui-btn ui-corner-all ui-btn-{^if $page_number eq $current_page^}b{^else^}a{^/if^}" data-ajax="false">{^$page_number^}</a></div>
{^assign var="page_number_index" value=$page_number_index+1^}
{^/for^}
</div>
{^/if^}
{^if $max_page gt 5^}
<div class="ui-grid-a">
  <div class="ui-block-a"><a href="{^$url_page^}page=1" class="ui-btn ui-corner-all ui-btn-a ui-btn-icon-left ui-icon-arrow-l" data-ajax="false">首页</a></div>
  <div class="ui-block-b"><a href="{^$url_page^}page={^$max_page^}" class="ui-btn ui-corner-all ui-btn-a ui-btn-icon-right ui-icon-arrow-r" data-ajax="false">尾页</a></div>
</div>
{^/if^}
{^/if^}