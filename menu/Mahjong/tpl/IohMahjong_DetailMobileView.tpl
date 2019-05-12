{^include file=$mblheader_file page_title="天津麻将记分器"^}
<script type="text/javascript">
$(document).ready(function(){
    $("input.top_selection").change(function(){
        $("button[name='round']").val($(this).val());
    });
    $("input.four_selection").change(function(){
        $("button[name='four[" + $(this).data("target-player") + "]']").val($(this).val());
    });
    $("input.tianhu_selection").change(function(){
        var target = $("input[name='win_times[" + $(this).data("target-player") + "][tianhu]']");
        if ($(this).prop("checked")) {
            target.val("1");
        } else {
            target.val("0");
        }
    });
    $("input.win_selection").change(function(){
        $("button[name='win[" + $(this).data("target-player") + "]']").val($(this).val());
        $("input.hidden_win_times").val("0");
        $("input.win_option").attr("checked", false).checkboxradio("refresh");
    });
});
</script>
<form action="./" method="post" data-ajax="false">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<input type="hidden" name="m_id" value="{^$m_id^}" />
<div data-role="collapsible" data-collapsed-icon="carat-d" data-expanded-icon="carat-u" data-iconpos="right" data-theme="b">
  <h4>{^$game_info["m_name"]^}({^$game_info["m_round"]^}/{^$game_info["m_part"]^})</h4>
  <fieldset data-role="controlgroup">
    <input name="top_selection" id="top_selection_1" value="1" type="radio" class="top_selection" />
    <label for="top_selection_1">铲庄</label>
    <input name="top_selection" id="top_selection_2" value="2" type="radio" class="top_selection" />
    <label for="top_selection_2">流局</label>
    <input name="top_selection" id="top_selection_3" value="3" type="radio" class="top_selection" />
    <label for="top_selection_3">结束</label>
  </fieldset>
  <button type="submit" name="round" value="0" class="ui-btn ui-corner-all ui-btn-b">确定</button>
</div>
<div data-role="collapsibleset">
{^foreach from=$game_detail key=m_player item=item_detail^}
  <div data-role="collapsible" data-collapsed-icon="carat-r" data-expanded-icon="carat-d" data-theme="{^if $item_detail["m_banker_flg"]^}b{^else^}a{^/if^}">
    <h3>{^if $m_player eq "1"^}东{^elseif $m_player eq "2"^}南{^elseif $m_player eq "3"^}西{^else^}北{^/if^}&nbsp;{^$item_detail["m_player_name"]^}<span class="ui-li-count ui-body-inherit">{^$item_detail["m_point"]^}</span></h3>
{^if !$item_detail["m_banker_flg"]^}
{^if $pull_banker[$m_player]^}
    <a class="ui-btn ui-corner-all ui-btn-b" href="./?menu=mahjong&act=detail&m_id={^$m_id^}&pull={^$pull_banker_list[$m_player][0]^}" data-ajax="false">{^if $pull_banker[$m_player] eq "1"^}拉一庄{^else^}拉两庄{^/if^}</a>
{^else^}
    <fieldset class="ui-grid-a">
      <div class="ui-block-a"><a class="ui-btn ui-corner-all ui-btn-a" href="./?menu=mahjong&act=detail&m_id={^$m_id^}&pull={^$pull_banker_list[$m_player][1]^}" data-ajax="false">拉一庄</a></div>
      <div class="ui-block-b"><a class="ui-btn ui-corner-all ui-btn-a" href="./?menu=mahjong&act=detail&m_id={^$m_id^}&pull={^$pull_banker_list[$m_player][2]^}" data-ajax="false">拉两庄</a></div>
    </fieldset>
{^/if^}
{^/if^}
    <fieldset data-role="controlgroup">
      <input name="four_selection_{^$m_player^}" id="four_selection_{^$m_player^}_1" value="1" type="radio" data-target-player="{^$m_player^}" class="four_selection" />
      <label for="four_selection_{^$m_player^}_1">明杠</label>
      <input name="four_selection_{^$m_player^}" id="four_selection_{^$m_player^}_2" value="2" type="radio" data-target-player="{^$m_player^}" class="four_selection" />
      <label for="four_selection_{^$m_player^}_2">暗杠</label>
      <input name="four_selection_{^$m_player^}" id="four_selection_{^$m_player^}_4" value="4" type="radio" data-target-player="{^$m_player^}" class="four_selection" />
      <label for="four_selection_{^$m_player^}_4">金杠</label>
    </fieldset>
    <button type="submit" name="four[{^$m_player^}]" value="0" class="ui-btn ui-corner-all ui-btn-b">开杠</button>
{^if $item_detail["m_banker_flg"]^}
    <fieldset data-role="controlgroup">
      <input id="tianhu_selection_{^$m_player^}_1" value="1" type="checkbox" data-target-player="{^$m_player^}" class="tianhu_selection" />
      <label for="tianhu_selection_{^$m_player^}_1">天和</label>
    </fieldset>
{^/if^}
    <input type="hidden" name="win_times[{^$m_player^}][tianhu]" value="0" />
    <label for="gangkai_{^$m_player^}">杠开</label>
    <input name="win_times[{^$m_player^}][gangkai]" id="gangkai_{^$m_player^}" value="0" min="0" max="4" type="range" data-highlight="true">
    <fieldset data-role="controlgroup">
      <input name="win_selection_{^$m_player^}" id="win_selection_{^$m_player^}_1" value="1" type="radio" data-target-player="{^$m_player^}" class="win_selection" />
      <label for="win_selection_{^$m_player^}_1">提溜</label>
    </fieldset>

    <fieldset data-role="controlgroup" data-type="horizontal" >
      <input name="diliu_selection_{^$m_player^}" id="diliu_su_{^$m_player^}" value="1" type="checkbox" data-target-player="{^$m_player^}" class="diliu_su_selection win_option" />
      <label for="diliu_su_{^$m_player^}">素</label>
    </fieldset>

    <input type="hidden" name="win_times[{^$m_player^}][1][0]" value="0" class="hidden_win_times" />
    <fieldset data-role="controlgroup">
      <input name="win_selection_{^$m_player^}" id="win_selection_{^$m_player^}_2" value="2" type="radio" data-target-player="{^$m_player^}" class="win_selection" />
      <label for="win_selection_{^$m_player^}_2">混吊</label>
    </fieldset>
    <fieldset data-role="controlgroup">
      <input name="win_selection_{^$m_player^}" id="win_selection_{^$m_player^}_3" value="3" type="radio" data-target-player="{^$m_player^}" class="win_selection" />
      <label for="win_selection_{^$m_player^}_3">捉伍</label>
    </fieldset>
    <fieldset data-role="controlgroup" data-type="horizontal" >
      <input name="zhuowu_selection_{^$m_player^}" id="zhuowu_su_{^$m_player^}" value="1" type="checkbox" data-target-player="{^$m_player^}" class="zhuowu_su_selection win_option" />
      <label for="zhuowu_su_{^$m_player^}">素</label>
      <input name="zhuowu_selection_{^$m_player^}" id="zhuowu_shuang_{^$m_player^}" value="1" type="checkbox" data-target-player="{^$m_player^}" class="zhuowu_shuang_selection win_option" />
      <label for="zhuowu_shuang_{^$m_player^}">双混</label>
    </fieldset>
    <input type="hidden" name="win_times[{^$m_player^}][3][0]" value="0" id="zhuowu_su-{^$m_player^}" class="hidden_times_selection" />
    <input type="hidden" name="win_times[{^$m_player^}][3][1]" value="0" id="zhuowu_shuang-{^$m_player^}" class="hidden_times_selection" />


    <fieldset data-role="controlgroup">
      <input name="win_selection_{^$m_player^}" id="win_selection_{^$m_player^}_4" value="4" type="radio" data-target-player="{^$m_player^}" class="win_selection" />
      <label for="win_selection_{^$m_player^}_4">龙</label>
    </fieldset>
    <input type="hidden" name="win_times[{^$m_player^}][4][0]" value="0" id="long_su-{^$m_player^}" class="hidden_times_selection" />
    <input type="hidden" name="win_times[{^$m_player^}][4][1]" value="0" id="long_diao-{^$m_player^}" class="hidden_times_selection" />
    <input type="hidden" name="win_times[{^$m_player^}][4][2]" value="0" id="long_ben-{^$m_player^}" class="hidden_times_selection" />


    <fieldset data-role="controlgroup">
      <input name="win_selection_{^$m_player^}" id="win_selection_{^$m_player^}_7" value="7" type="radio" data-target-player="{^$m_player^}" class="win_selection" />
      <label for="win_selection_{^$m_player^}_7">捉伍龙</label>
    </fieldset>
    <input type="hidden" name="win_times[{^$m_player^}][7][0]" value="0" id="zwl_su-{^$m_player^}" class="hidden_times_selection" />
    <input type="hidden" name="win_times[{^$m_player^}][7][1]" value="0" id="zwl_shaung-{^$m_player^}" class="hidden_times_selection" />
    <input type="hidden" name="win_times[{^$m_player^}][7][2]" value="0" id="zwl_ben-{^$m_player^}" class="hidden_times_selection" />




    <button type="submit" name="win[{^$m_player^}]" value="0" class="ui-btn ui-corner-all ui-btn-b">和牌</button>
  </div>
{^/foreach^}
</div>
</form>
<fieldset class="ui-grid-a">
  <div class="ui-block-a"><a class="ui-btn ui-corner-all ui-btn-a" href="./?menu=mahjong&act=start">返回</a></div>
  <div class="ui-block-b"><a class="ui-btn ui-corner-all ui-btn-b" href="./?menu=mahjong&act=history&m_id={^$m_id^}" data-ajax="false">统计</a></div>
</fieldset>
{^include file=$mblfooter_file^}