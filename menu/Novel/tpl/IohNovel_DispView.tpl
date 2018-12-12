{^include file=$comheader_file^}
{^include file=$comnaviga_file^}
<link rel="stylesheet" href="css/novel/disp.css" type="text/css" />
{^foreach from=$novel_info item=itm_info^}
<ul class="novel_disp_area bl_c mt_10 brr bx_sh">
  <li class="novel_disp_line"><a href="./?menu=novel&act=list&novel_id={^$itm_info["n_id"]^}">{^$itm_info["n_name"]^}</a></li>
</ul>
{^/foreach^}
{^include file=$comfooter_file^}