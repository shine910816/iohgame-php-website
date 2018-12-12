{^include file=$comheader_file^}
{^include file=$comnaviga_file^}
{^include file=$usererror_file^}
<link rel="stylesheet" href="css/onmyouji/draw_card.css?201712182" type="text/css" />
<script type="text/javascript" src="js/onmyouji/draw_card.js?20171218"></script>
<form class="button_area" action="./" method="post">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<div class="button_box">
  <label>
    <span class="draw_card_btn btn_blu">单抽</span>
    <input type="submit" value="1" name="draw_card" class="submit_button" />
  </label>
</div>
<div class="button_box">
  <label>
    <span class="draw_card_btn btn_org">五抽</span>
    <input type="submit" value="5" name="draw_card" class="submit_button" />
  </label>
</div>
<div class="button_box">
  <label>
    <span class="draw_card_btn btn_blu">十抽</span>
    <input type="submit" value="10" name="draw_card" class="submit_button" />
  </label>
</div>
</form>
{^if $draw_card_num eq 99^}
{^foreach from=$omj_disp_list item=omj_item^}
<div class="skgm_box" id="skgm_{^$omj_item['s_id']^}">
  <div class="skgm_name_img_box">
    <div class="skgm_name_skin_box">
      <div class="skgm_name_box {^if $omj_item['s_level'] eq 1^}r{^elseif $omj_item['s_level'] eq 2^}sr{^elseif $omj_item['s_level'] eq 3^}ssr{^else^}n{^/if^}">
        <span class="s_name_box">
          <span class="s_name">{^$omj_item['s_name']^}</span>
          <span class="s_level"></span>
        </span>
      </div>
      <ul class="skgm_skin_box">
        <li><span class="skin_btn skin_btn_slct" data-skgm-id="{^$omj_item['s_id']^}" data-awake-status="0" data-awake-path="b_{^$omj_item['s_id']^}" data-img-path="img_b_{^$omj_item['s_id']^}">默认</span></li>
{^if $omj_item['s_level']^}
        <li><span class="skin_btn" data-skgm-id="{^$omj_item['s_id']^}" data-awake-status="1" data-awake-path="a_{^$omj_item['s_id']^}" data-img-path="img_a_{^$omj_item['s_id']^}">觉醒</span></li>
{^/if^}
{^if !empty($omj_item['skin'])^}
{^foreach from=$omj_item['skin'] key=skin_key item=skin_item^}
        <li><span class="skin_btn" data-skgm-id="{^$omj_item['s_id']^}" data-awake-status="1" data-awake-path="a_{^$omj_item['s_id']^}" data-img-path="img_s_{^$omj_item['s_id']^}_{^$skin_key^}">{^$skin_item['skin_name']^}</span></li>
{^/foreach^}
{^/if^}
      </ul>
    </div>
    <div class="skgm_img_box">
      <img src="img/onmyouji/before/{^$omj_item['img_name']^}" class="skgm_img disp" id="img_b_{^$omj_item['s_id']^}" />
{^if $omj_item['s_level']^}
      <img src="img/onmyouji/after/{^$omj_item['img_name']^}" class="skgm_img" id="img_a_{^$omj_item['s_id']^}" />
{^/if^}
{^if !empty($omj_item['skin'])^}
{^foreach from=$omj_item['skin'] key=skin_key item=skin_item^}
      <img src="img/onmyouji/after/{^$skin_item['img_name']^}" class="skgm_img" id="img_s_{^$omj_item['s_id']^}_{^$skin_key^}" />
{^/foreach^}
{^/if^}
    </div>
  </div>
  <div class="skgm_info_box">
    <div class="skgm_prop_all_box">
      <div class="skgm_prop_box before_slct" id="prop_b_{^$omj_item['s_id']^}">
        <div class="skgm_prop_page">
          <div class="skgm_prop_box_cols skgm_prop_box_cols_line">
            <div class="prop_{^$omj_item['attack_level_before']^}"><span></span></div>
            <div class="skgm_prop_box_title_1">攻击</div>
            <div class="skgm_prop_box_value">{^$omj_item['attack_before']^}</div>
          </div>
          <div class="skgm_prop_box_cols skgm_prop_box_cols_line mt_05">
            <div class="prop_{^$omj_item['health_level_before']^}"><span></span></div>
            <div class="skgm_prop_box_title_1">生命</div>
            <div class="skgm_prop_box_value">{^$omj_item['health_before']^}</div>
          </div>
          <div class="skgm_prop_box_cols skgm_prop_box_cols_line mt_05">
            <div class="prop_{^$omj_item['defence_level_before']^}"><span></span></div>
            <div class="skgm_prop_box_title_1">防御</div>
            <div class="skgm_prop_box_value">{^$omj_item['defence_before']^}</div>
          </div>
          <div class="skgm_prop_box_cols skgm_prop_box_cols_line mt_05">
            <div class="prop_{^$omj_item['speed_level_before']^}"><span></span></div>
            <div class="skgm_prop_box_title_1">速度</div>
            <div class="skgm_prop_box_value">{^$omj_item['speed_before']^}</div>
          </div>
          <div class="skgm_prop_box_cols skgm_prop_box_cols_line mt_05">
            <div class="prop_{^$omj_item['critical_rate_level_before']^}"><span></span></div>
            <div class="skgm_prop_box_title_1">暴击</div>
            <div class="skgm_prop_box_value">{^$omj_item['critical_rate_before']^}%</div>
          </div>
          <div class="skgm_prop_box_cols_s skgm_prop_box_cols_line mt_05">
            <div class="skgm_prop_box_title_2">暴击伤害</div>
            <div class="skgm_prop_box_value_s">{^$omj_item['critical_damage_before']^}%</div>
          </div>
          <div class="skgm_prop_box_cols_s skgm_prop_box_cols_line mt_05">
            <div class="skgm_prop_box_title_2">效果命中</div>
            <div class="skgm_prop_box_value_s">{^$omj_item['hit_rate_before']^}%</div>
          </div>
          <div class="skgm_prop_box_cols_s skgm_prop_box_cols_line mt_05">
            <div class="skgm_prop_box_title_2">效果抵抗</div>
            <div class="skgm_prop_box_value_s">{^$omj_item['oppose_rate_before']^}%</div>
          </div>
        </div>
      </div>
{^if $omj_item['s_level']^}
      <div class="skgm_prop_box" id="prop_a_{^$omj_item['s_id']^}">
        <div class="skgm_prop_page">
          <div class="skgm_prop_box_cols skgm_prop_box_cols_line">
            <div class="prop_{^$omj_item['attack_level_after']^}"><span></span></div>
            <div class="skgm_prop_box_title_1">攻击</div>
            <div class="skgm_prop_box_value">{^$omj_item['attack_after']^}</div>
          </div>
          <div class="skgm_prop_box_cols skgm_prop_box_cols_line mt_05">
            <div class="prop_{^$omj_item['health_level_after']^}"><span></span></div>
            <div class="skgm_prop_box_title_1">生命</div>
            <div class="skgm_prop_box_value">{^$omj_item['health_after']^}</div>
          </div>
          <div class="skgm_prop_box_cols skgm_prop_box_cols_line mt_05">
            <div class="prop_{^$omj_item['defence_level_after']^}"><span></span></div>
            <div class="skgm_prop_box_title_1">防御</div>
            <div class="skgm_prop_box_value">{^$omj_item['defence_after']^}</div>
          </div>
          <div class="skgm_prop_box_cols skgm_prop_box_cols_line mt_05">
            <div class="prop_{^$omj_item['speed_level_after']^}"><span></span></div>
            <div class="skgm_prop_box_title_1">速度</div>
            <div class="skgm_prop_box_value">{^$omj_item['speed_after']^}</div>
          </div>
          <div class="skgm_prop_box_cols skgm_prop_box_cols_line mt_05">
            <div class="prop_{^$omj_item['critical_rate_level_after']^}"><span></span></div>
            <div class="skgm_prop_box_title_1">暴击</div>
            <div class="skgm_prop_box_value">{^$omj_item['critical_rate_after']^}%</div>
          </div>
          <div class="skgm_prop_box_cols_s skgm_prop_box_cols_line mt_05">
            <div class="skgm_prop_box_title_2">暴击伤害</div>
            <div class="skgm_prop_box_value_s">{^$omj_item['critical_damage_after']^}%</div>
          </div>
          <div class="skgm_prop_box_cols_s skgm_prop_box_cols_line mt_05">
            <div class="skgm_prop_box_title_2">效果命中</div>
            <div class="skgm_prop_box_value_s">{^$omj_item['hit_rate_after']^}%</div>
          </div>
          <div class="skgm_prop_box_cols_s skgm_prop_box_cols_line mt_05">
            <div class="skgm_prop_box_title_2">效果抵抗</div>
            <div class="skgm_prop_box_value_s">{^$omj_item['oppose_rate_after']^}%</div>
          </div>
        </div>
      </div>
{^/if^}
    </div>
    <div class="skgm_skill_all_box disp" id="skill_b_{^$omj_item['s_id']^}">
{^foreach from=$omj_item['skill'] key=skill_key item=skill_item^}
{^if $skill_item['awake_flg'] eq "0"^}
      <div class="skgm_skill_box before_slct">
        <div class="skgm_skill_img_name_box">
          <div class="skgm_skill_img_box"><img src="img/onmyouji/skill/{^$skill_item['img_name']^}" /></div>
          <div class="skgm_skill_name_box">
            <div class="skgm_skill_name">{^$skill_item['skill_name']^}</div>
            <div class="skgm_skill_title">{^$skill_item['skill_title']^}</div>
          </div>
        </div>
        <div class="skgm_skill_disc_box">
          {^$skill_item['skill_disc']^}<br/>
          {^if $skill_item['skill_disc_lvl2']^}<br/>Lv.2&nbsp;{^$skill_item['skill_disc_lvl2']^}{^/if^}
          {^if $skill_item['skill_disc_lvl3']^}<br/>Lv.3&nbsp;{^$skill_item['skill_disc_lvl3']^}{^/if^}
          {^if $skill_item['skill_disc_lvl4']^}<br/>Lv.4&nbsp;{^$skill_item['skill_disc_lvl4']^}{^/if^}
          {^if $skill_item['skill_disc_lvl5']^}<br/>Lv.5&nbsp;{^$skill_item['skill_disc_lvl5']^}{^/if^}
          {^if $skill_item['skill_disc_lvl6']^}<br/>Lv.6&nbsp;{^$skill_item['skill_disc_lvl6']^}{^/if^}
        </div>
      </div>
{^/if^}
{^/foreach^}
    </div>
{^if  $omj_item['s_level']^}
    <div class="skgm_skill_all_box" id="skill_a_{^$omj_item['s_id']^}">
{^foreach from=$omj_item['skill'] key=skill_key item=skill_item^}
      <div class="skgm_skill_box after_slct">
        <div class="skgm_skill_img_name_box">
          <div class="skgm_skill_img_box"><img src="img/onmyouji/skill/{^$skill_item['img_name']^}" /></div>
          <div class="skgm_skill_name_box">
            <div class="skgm_skill_name">{^$skill_item['skill_name']^}</div>
            <div class="skgm_skill_title">{^$skill_item['skill_title']^}</div>
          </div>
        </div>
        <div class="skgm_skill_disc_box">
          {^$skill_item['skill_disc_awake']^}<br/>
          {^if $skill_item['skill_disc_lvl2']^}<br/>Lv.2&nbsp;{^$skill_item['skill_disc_lvl2']^}{^/if^}
          {^if $skill_item['skill_disc_lvl3']^}<br/>Lv.3&nbsp;{^$skill_item['skill_disc_lvl3']^}{^/if^}
          {^if $skill_item['skill_disc_lvl4']^}<br/>Lv.4&nbsp;{^$skill_item['skill_disc_lvl4']^}{^/if^}
          {^if $skill_item['skill_disc_lvl5']^}<br/>Lv.5&nbsp;{^$skill_item['skill_disc_lvl5']^}{^/if^}
          {^if $skill_item['skill_disc_lvl6']^}<br/>Lv.6&nbsp;{^$skill_item['skill_disc_lvl6']^}{^/if^}
        </div>
      </div>
{^/foreach^}
    </div>
{^/if^}
  </div>
</div>
{^/foreach^}
{^elseif $draw_card_num eq 0^}
<div class="result_box_1"></div>
{^else^}
<div class="result_box_{^$draw_card_num^}">
{^foreach from=$omj_disp_list item=omj_item^}
<div class="s_box {^if $omj_item['s_level'] eq 1^}r{^elseif $omj_item['s_level'] eq 2^}sr{^elseif $omj_item['s_level'] eq 3^}ssr{^else^}n{^/if^}">
  <span class="s_name_box">
    <span class="s_name">{^$omj_item['s_name']^}</span>
    <span class="s_level"></span>
  </span>
  <a href="./?menu=onmyouji&act=draw_card&view_card=1&s_id={^$omj_item['s_id']^}">
    <img src="img/onmyouji/head/{^$omj_item['img_name']^}" />
  </a>
</div>
{^/foreach^}
</div>
{^/if^}
{^include file=$comfooter_file^}