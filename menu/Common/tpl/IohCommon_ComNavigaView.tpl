{^if $navigation_flg eq "1"^}
<div class="tree-nav mt_10 bl_c bx_sh brr">
  <a href="./">首页</a>
{^section loop=$disp_nav_list name=nav_index^}
{^if !empty($disp_nav_list[nav_index])^}
  <span>&gt;</span>
  {^$disp_nav_list[nav_index]^}
{^/if^}
{^/section^}
</div>
{^/if^}
