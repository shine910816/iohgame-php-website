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
        $("input.times_selection").val("0");
        $("button.win_submit").val("0");
        var target_player = $(this).data("target-player");
        var win_base = $(this).val();
        var win_times = eval("[" + $(this).data("win-times") + "]");
        if (win_base != "2") {
            for (var j = 0; j < win_times.length; j++) {
                $("input[name='win_times["+target_player+"]["+win_base+"]["+j+"]']").val(win_times[j]);
            }
        }
        $("button[name='win["+target_player+"]']").val(win_base);
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
      <legend>提溜</legend>
      <input name="win_selection" id="win_selection_{^$m_player^}_1" value="1" type="radio" class="win_selection" data-target-player="{^$m_player^}" data-win-times="0" />
      <label for="win_selection_{^$m_player^}_1">提溜</label>
      <input name="win_selection" id="win_selection_{^$m_player^}_2" value="1" type="radio" class="win_selection" data-target-player="{^$m_player^}" data-win-times="1" />
      <label for="win_selection_{^$m_player^}_2">素提溜</label>
    </fieldset>
    <fieldset data-role="controlgroup">
      <legend>提溜</legend>
      <input name="win_selection" id="win_selection_{^$m_player^}_3" value="2" type="radio" class="win_selection" data-target-player="{^$m_player^}" />
      <label for="win_selection_{^$m_player^}_3">混吊</label>
    </fieldset>
    <fieldset data-role="controlgroup">
      <legend>捉伍</legend>
      <input name="win_selection" id="win_selection_{^$m_player^}_4" value="3" type="radio" class="win_selection" data-target-player="{^$m_player^}" data-win-times="0,0" />
      <label for="win_selection_{^$m_player^}_4">捉伍</label>
      <input name="win_selection" id="win_selection_{^$m_player^}_5" value="3" type="radio" class="win_selection" data-target-player="{^$m_player^}" data-win-times="1,0" />
      <label for="win_selection_{^$m_player^}_5">素捉伍</label>
      <input name="win_selection" id="win_selection_{^$m_player^}_6" value="3" type="radio" class="win_selection" data-target-player="{^$m_player^}" data-win-times="0,1" />
      <label for="win_selection_{^$m_player^}_6">双混伍</label>
    </fieldset>
    <fieldset data-role="controlgroup">
      <legend>龙</legend>
      <input name="win_selection" id="win_selection_{^$m_player^}_7" value="4" type="radio" class="win_selection" data-target-player="{^$m_player^}" data-win-times="0,0,0" />
      <label for="win_selection_{^$m_player^}_7">龙</label>
      <input name="win_selection" id="win_selection_{^$m_player^}_8" value="4" type="radio" class="win_selection" data-target-player="{^$m_player^}" data-win-times="1,0,0" />
      <label for="win_selection_{^$m_player^}_8">素龙</label>
      <input name="win_selection" id="win_selection_{^$m_player^}_9" value="4" type="radio" class="win_selection" data-target-player="{^$m_player^}" data-win-times="0,1,0" />
      <label for="win_selection_{^$m_player^}_9">混吊龙</label>
      <input name="win_selection" id="win_selection_{^$m_player^}_10" value="4" type="radio" class="win_selection" data-target-player="{^$m_player^}" data-win-times="0,0,1" />
      <label for="win_selection_{^$m_player^}_10">本混龙</label>
      <input name="win_selection" id="win_selection_{^$m_player^}_11" value="4" type="radio" class="win_selection" data-target-player="{^$m_player^}" data-win-times="1,0,1" />
      <label for="win_selection_{^$m_player^}_11">素本龙</label>
      <input name="win_selection" id="win_selection_{^$m_player^}_12" value="4" type="radio" class="win_selection" data-target-player="{^$m_player^}" data-win-times="0,1,1" />
      <label for="win_selection_{^$m_player^}_12">混吊本混龙</label>
    </fieldset>
    <fieldset data-role="controlgroup">
      <legend>捉伍龙</legend>
      <input name="win_selection" id="win_selection_{^$m_player^}_13" value="7" type="radio" class="win_selection" data-target-player="{^$m_player^}" data-win-times="0,0,0" />
      <label for="win_selection_{^$m_player^}_13">捉伍龙</label>
      <input name="win_selection" id="win_selection_{^$m_player^}_14" value="7" type="radio" class="win_selection" data-target-player="{^$m_player^}" data-win-times="1,0,0" />
      <label for="win_selection_{^$m_player^}_14">素伍龙</label>
      <input name="win_selection" id="win_selection_{^$m_player^}_15" value="7" type="radio" class="win_selection" data-target-player="{^$m_player^}" data-win-times="0,1,0" />
      <label for="win_selection_{^$m_player^}_15">双混伍龙</label>
      <input name="win_selection" id="win_selection_{^$m_player^}_16" value="7" type="radio" class="win_selection" data-target-player="{^$m_player^}" data-win-times="0,0,1" />
      <label for="win_selection_{^$m_player^}_16">本混捉伍龙</label>
      <input name="win_selection" id="win_selection_{^$m_player^}_17" value="7" type="radio" class="win_selection" data-target-player="{^$m_player^}" data-win-times="1,0,1" />
      <label for="win_selection_{^$m_player^}_17">素本捉伍龙</label>
      <input name="win_selection" id="win_selection_{^$m_player^}_18" value="7" type="radio" class="win_selection" data-target-player="{^$m_player^}" data-win-times="0,1,1" />
      <label for="win_selection_{^$m_player^}_18">本混双伍龙</label>
    </fieldset>
    <input type="hidden" name="win_times[{^$m_player^}][1][0]" value="0" class="times_selection" />
    <input type="hidden" name="win_times[{^$m_player^}][3][0]" value="0" class="times_selection" />
    <input type="hidden" name="win_times[{^$m_player^}][3][1]" value="0" class="times_selection" />
    <input type="hidden" name="win_times[{^$m_player^}][4][0]" value="0" class="times_selection" />
    <input type="hidden" name="win_times[{^$m_player^}][4][1]" value="0" class="times_selection" />
    <input type="hidden" name="win_times[{^$m_player^}][4][2]" value="0" class="times_selection" />
    <input type="hidden" name="win_times[{^$m_player^}][7][0]" value="0" class="times_selection" />
    <input type="hidden" name="win_times[{^$m_player^}][7][1]" value="0" class="times_selection" />
    <input type="hidden" name="win_times[{^$m_player^}][7][2]" value="0" class="times_selection" />
    <button type="submit" name="win[{^$m_player^}]" value="0" class="ui-btn ui-corner-all ui-btn-b win_submit">和牌</button>
  </div>
{^/foreach^}
</div>
</form>
<fieldset class="ui-grid-a">
  <div class="ui-block-a"><a class="ui-btn ui-corner-all ui-btn-a" href="./?menu=mahjong&act=start">返回</a></div>
  <div class="ui-block-b"><a class="ui-btn ui-corner-all ui-btn-b" href="./?menu=mahjong&act=history&m_id={^$m_id^}" data-ajax="false">统计</a></div>
</fieldset>
{^include file=$mblfooter_file^}