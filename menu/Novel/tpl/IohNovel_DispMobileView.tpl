{^include file=$mblheader_file^}
<link rel="stylesheet" href="css/novel/disp_sp.css" type="text/css" />
<ul data-role="listview" data-inset="true">
{^foreach from=$novel_info item=itm_info^}
  <li>
    <a href="./?menu=novel&act=list&novel_id={^$itm_info["n_id"]^}">
      <img alt="NO IMAGE" />
      <h2>{^$itm_info["n_name"]^}</h2>
      <p>{^$itm_info["n_author"]^}</p>
    </a>
  </li>
{^/foreach^}
</ul>
{^include file=$mblfooter_file^}