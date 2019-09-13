{^include file=$mblheader_file^}
<style type="text/css">
.word_white {
  color:#FFF;
  text-shadow:1px 1px 1px #000;
}
.word_green {
  color:#1EFF00;
  text-shadow:1px 1px 1px #000;
}
.word_yellow {
  color:#FFD100;
  text-shadow:1px 1px 1px #000;
}
.double_word {
  height:1.25em;
}
.double_word span {
  width:50%;
  height:1.25em;
  line-height:1.25em;
  display:block;
  float:left;
}
.left_word {
  text-align:left;
}
.right_word {
  text-align:right;
}
</style>
<div class="ui-body ui-body-a ui-corner-all" style="background-color:#2B1507;">
  <h3 style="color:#C600FF; text-shadow:1px 1px 1px #000;">{^$item_info["item_name"]^}</h3>
  <p class="word_white">史诗</p>
  <p class="word_green">史诗</p>
  <p class="word_yellow">物品等级400{^if !$special_flg^}+{^/if^}</p>
  <p class="word_white">拾取后绑定</p>
  <p class="word_white double_word">
    <span class="left_word">{^$type_info["left"]^}</span>
    <span class="right_word">{^$type_info["right"]^}</span>
  </p>
{^if $item_info["item_class"]^}
{^if $weapon_display_flg and !empty($weapon_info)^}
  <p class="word_white double_word">
    <span class="left_word">{^if $weapon_info["min"] eq $weapon_info["max"]^}{^$weapon_info["max"]|number_format^} {^else^}{^$weapon_info["min"]|number_format^} - {^$weapon_info["max"]|number_format^}点{^/if^}伤害</span>
    <span class="right_word">速度 {^$weapon_info["spd"]^}</span>
  </p>
  <p class="word_white">（每秒伤害{^$weapon_info["dps"]^}）</p>
{^/if^}
{^if $item_info["item_armor"] gt 0^}
  <p class="word_white">{^$item_info["item_armor"]|number_format^} 护甲</p>
{^/if^}
{^if $item_info["item_block"] gt 0^}
  <p class="word_white">{^$item_info["item_block"]|number_format^} 格挡</p>
{^/if^}
{^if $item_info["item_strength"] gt 0^}
  <p class="word_white">+{^$item_info["item_strength"]|number_format^} 力量</p>
{^/if^}
{^if $item_info["item_agility"] gt 0^}
  <p class="word_white">+{^$item_info["item_agility"]|number_format^} 敏捷</p>
{^/if^}
{^if $item_info["item_intellect"] gt 0^}
  <p class="word_white">+{^$item_info["item_intellect"]|number_format^} 智力</p>
{^/if^}
{^if $item_info["item_stamina"] gt 0^}
  <p class="word_white">+{^$item_info["item_stamina"]|number_format^} 耐力</p>
{^/if^}
{^if $item_info["item_critical"] gt 0^}
  <p class="word_green">+{^$item_info["item_critical"]|number_format^} 爆击</p>
{^/if^}
{^if $item_info["item_haste"] gt 0^}
  <p class="word_green">+{^$item_info["item_haste"]|number_format^} 急速</p>
{^/if^}
{^if $item_info["item_versatility"] gt 0^}
  <p class="word_green">+{^$item_info["item_versatility"]|number_format^} 全能</p>
{^/if^}
{^if $item_info["item_mastery"] gt 0^}
  <p class="word_green">+{^$item_info["item_mastery"]|number_format^} 精通</p>
{^/if^}
{^if $item_equit_effect^}
  <p class="word_green">装备: {^$item_equit_effect^}</p>
{^/if^}
{^if $item_use_effect^}
  <p class="word_green">使用: {^$item_use_effect^}</p>
{^/if^}
{^if !empty($suit_info)^}
  <p class="word_yellow">{^$suit_info["suit_name"]^} (0/{^$suit_info["suit_item_amount"]^})</p>
{^foreach from=$suit_info["suit_item"] item=suit_item_name^}
  <p class="word_white">&nbsp;&nbsp;{^$suit_item_name^}</p>
{^/foreach^}
{^foreach from=$suit_info["suit_equit_effect"] key=suit_amount_num item=suit_effect_text^}
  <p class="word_green">({^$suit_amount_num^}) 套装: {^$suit_effect_text^}</p>
{^/foreach^}
{^/if^}
{^if $special_flg^}
  <p class="word_yellow">艾泽里特之力(0/5):</p>
{^foreach from=$special_info[$item_info["item_position"]] item=unlock_level^}
  <p class="word_white">- 在艾泽拉斯之心达到{^$unlock_level^}级时解锁</p>
{^/foreach^}
{^/if^}
{^/if^}
</div>
<p>掉落: {^$map_info_list[$map_id]^}-{^$boss_info_list[$boss_id]["boss_name"]^}</p>
<a href="{^$back_url^}" class="ui-btn ui-corner-all ui-shadow ui-btn-a" data-ajax="false">返回</a>
{^include file=$mblfooter_file^}