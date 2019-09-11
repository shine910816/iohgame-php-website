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
</style>
<div class="ui-body ui-body-a ui-corner-all">
  <h3>{^$item_info["item_name"]^}</h3>
  <p>{^$class_position_type_list[$item_info["item_class"]][$item_info["item_position"]][$item_info["item_type"]]^}</p>
{^if $item_info["item_class"]^}
{^if $item_info["item_armor"] gt 0^}
  <p class="word_white">{^$item_info["item_armor"]|number_format^} 护甲</p>
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
{^/if^}
  <p>&nbsp;</p>
  <p>掉落: {^$map_info_list[$map_id]^}-{^$boss_info_list[$boss_id]["boss_name"]^}</p>
  <a href="{^$back_url^}" class="ui-btn ui-corner-all ui-shadow ui-btn-a" data-ajax="false">返回</a>
</div>
{^include file=$mblfooter_file^}