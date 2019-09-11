{^include file=$mblheader_file^}
<div class="ui-body ui-body-a ui-corner-all">
  <h3>{^$item_info["item_name"]^}</h3>
  <p>{^$class_position_type_list[$item_info["item_class"]][$item_info["item_position"]][$item_info["item_type"]]^}</p>
{^if $item_info["item_class"]^}
{^if $item_info["item_armor"] gt 0^}
  <p>{^$item_info["item_armor"]|number_format^} 护甲</p>
{^/if^}
{^if $item_info["item_strength"] gt 0^}
  <p>+{^$item_info["item_strength"]|number_format^} 力量</p>
{^/if^}
{^if $item_info["item_agility"] gt 0^}
  <p>+{^$item_info["item_agility"]|number_format^} 敏捷</p>
{^/if^}
{^if $item_info["item_intellect"] gt 0^}
  <p>+{^$item_info["item_intellect"]|number_format^} 智力</p>
{^/if^}
{^if $item_info["item_stamina"] gt 0^}
  <p>+{^$item_info["item_stamina"]|number_format^} 耐力</p>
{^/if^}
{^if $item_info["item_critical"] gt 0^}
  <p>+{^$item_info["item_critical"]|number_format^} 爆击</p>
{^/if^}
{^if $item_info["item_haste"] gt 0^}
  <p>+{^$item_info["item_haste"]|number_format^} 急速</p>
{^/if^}
{^if $item_info["item_versatility"] gt 0^}
  <p>+{^$item_info["item_versatility"]|number_format^} 全能</p>
{^/if^}
{^if $item_info["item_mastery"] gt 0^}
  <p>+{^$item_info["item_mastery"]|number_format^} 精通</p>
{^/if^}
{^if $item_equit_effect^}
  <p>装备: {^$item_equit_effect^}</p>
{^/if^}
{^if $item_use_effect^}
  <p>使用: {^$item_use_effect^}</p>
{^/if^}
{^/if^}
</div>
{^include file=$mblfooter_file^}