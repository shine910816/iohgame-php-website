{^include file=$mblheader_file^}
<fieldset class="ui-grid-b">
  <div class="ui-block-a"><a href="./?menu=sgsgz&act=card&mode=1" class="ui-btn ui-corner-all ui-btn-{^if $mode eq "1"^}b{^else^}a{^/if^}">标准</a></div>
  <div class="ui-block-b"><a href="./?menu=sgsgz&act=card&mode=2" class="ui-btn ui-corner-all ui-btn-{^if $mode eq "2"^}b{^else^}a{^/if^}">扩展</a></div>
  <div class="ui-block-c"><a href="./?menu=sgsgz&act=card&mode=3" class="ui-btn ui-corner-all ui-btn-{^if $mode eq "3"^}b{^else^}a{^/if^}">君主</a></div>
</fieldset>
<p>三国杀国战{^if $mode eq "2"^}扩展{^elseif $mode eq "3"^}君主{^else^}标准{^/if^}模式共有游戏牌{^$card_count^}张</p>
{^if !empty($card_info)^}
{^foreach from=$card_info key=c_id item=card_item^}
<ul data-role="listview" data-inset="true">
  <li><a href="#"><span style="color:#{^if $card_item["c_suit"] eq "1" or $card_item["c_suit"] eq "3"^}000{^else^}F00{^/if^};">{^$card_item["suit_number"]^}</span>&nbsp;{^$card_item["card_name"]^}{^if $card_item["c_horiz_flg"] eq "1"^}(连){^/if^}</a></li>
</ul>
{^/foreach^}
{^/if^}
{^include file=$mblfooter_file^}