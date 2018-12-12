{^include file=$comheader_file^}
{^include file=$comnaviga_file^}
<link rel="stylesheet" href="css/user/user_disp.css" type="text/css" />
<link rel="stylesheet" href="css/user/user_friend_search.css" type="text/css" />
<table class="content bl_c mt_30">
<tr>
<td class="content-left" valign="top">{^include file=$leftmenu_file^}</td>
<td class="content-right" valign="top">
<!-- Main content START -->
  <div class="main-content pb_10">
    <form action="./" method="post">
      <input type="hidden" name="menu" value="{^$current_menu^}" />
      <input type="hidden" name="act" value="{^$current_act^}" />
    </form>
    {^*include file=$compagina_file*^}
  </div>
<!-- Main content END -->
</td>
</tr>
</table>
{^include file=$comfooter_file^}