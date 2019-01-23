{^include file=$comheader_file^}
<link rel="stylesheet" href="css/common/common_form.css" type="text/css" />
<form class="ui-formbox" action="./" method="post">
<input type="hidden" name="menu" value="{^$current_menu^}"/>
<input type="hidden" name="act" value="{^$current_act^}"/>
<table class="tb tb_p_03 tb_org">
{^assign var="page_card_index" value=0^}
  <tr>
{^foreach from=$card_info key=c_id item=card_item^}
    <th style="width:40px;">{^$card_item["suit_number"]^}</th>
    <td><select name="card_info[{^$c_id^}]" class="ui-textbox" style="width:152px;">{^$card_item["content"]^}</select></td>
{^assign var="page_card_index" value=$page_card_index+1^}
{^if $page_card_index eq 5^}
  </tr>
  <tr>
{^assign var="page_card_index" value=0^}
{^/if^}
{^/foreach^}
  </tr>
  <tr>
    <td colspan="10"><input type="submit" name="do_submit" value="确定" class="ui-button ui-box-orange mt_05" /></td>
  </tr>
</table>
</form>
{^include file=$comfooter_file^}