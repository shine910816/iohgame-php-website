<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>天津麻将记分器</title>
<link rel="shortcut icon" type="image/x-icon" href="img/ico/favicon.ico"/>
<link rel="stylesheet" href="css/sp/common.css?{^$ts^}" type="text/css" />
<link rel="stylesheet" href="css/common/common_font.css" type="text/css" />
<link rel="stylesheet" href="css/font-awesome.css" type="text/css" />
<link rel="stylesheet" href="css/mahjong/detail.css?{^$ts^}" type="text/css" />
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="js/mahjong/detail.js?{^$ts^}"></script>
</head>
<body>
<form action="./" method="post">
<input type="hidden" name="menu" value="{^$current_menu^}" />
<input type="hidden" name="act" value="{^$current_act^}" />
<input type="hidden" name="m_id" value="{^$m_id^}" />
<div class="top_box">
  <div class="top_title">{^$game_info["m_name"]^}({^$game_info["m_round"]^}/{^$game_info["m_part"]^})</div>
  <ul class="top_box_cols">
    <li><span class="top_selection selection" data-target-value="1">铲庄</span></li>
    <li><span class="top_selection selection" data-target-value="2">流局</span></li>
    <li><span class="top_selection selection" data-target-value="3">结束</span></li>
  </ul>
  <label>
    <span class="confirm_button">确定</span>
    <input type="submit" name="round" value="0" class="undisp" />
  </label>
</div>

{^foreach from=$game_detail key=m_player item=item_detail^}
<div class="{^if $m_player eq "1"^}east{^elseif $m_player eq "2"^}south{^elseif $m_player eq "3"^}west{^else^}north{^/if^}_box detail_box">
  <ul class="detail_title">
    <li class="detail_title_content_1{^if $item_detail["m_banker_flg"]^} banker_disp{^/if^}">{^if $m_player eq "1"^}东{^elseif $m_player eq "2"^}南{^elseif $m_player eq "3"^}西{^else^}北{^/if^}</li>
    <li class="detail_title_content_2">{^$item_detail["m_player_name"]^}</li>
    <li class="detail_title_content_1">{^$item_detail["m_point"]^}</li>
  </ul>
{^if !$item_detail["m_banker_flg"]^}
  <ul class="detail_box_cols">
{^if $pull_banker[$m_player]^}
    <li class="two_selection"><span class="pull_selection selection selected">{^if $pull_banker[$m_player] eq "1"^}拉一庄{^else^}拉两庄{^/if^}</span></li>
    <li class="two_selection"><a class="pull_selection selection" href="./?menu=mahjong&act=detail&m_id={^$m_id^}&pull={^$pull_banker_list[$m_player][0]^}">取消</a></li>
{^else^}
    <li class="two_selection"><a class="pull_selection selection" href="./?menu=mahjong&act=detail&m_id={^$m_id^}&pull={^$pull_banker_list[$m_player][1]^}">拉一庄</a></li>
    <li class="two_selection"><a class="pull_selection selection" href="./?menu=mahjong&act=detail&m_id={^$m_id^}&pull={^$pull_banker_list[$m_player][2]^}">拉两庄</a></li>
{^/if^}
  </ul>
{^/if^}
  <ul class="detail_box_cols{^if !$item_detail["m_banker_flg"]^} important_cols{^/if^}">
    <li class="three_selection"><span class="four_selection selection" data-target-value="1" data-target-id="four_{^$m_player^}">明杠</span></li>
    <li class="three_selection"><span class="four_selection selection" data-target-value="2" data-target-id="four_{^$m_player^}">暗杠</span></li>
    <li class="three_selection"><span class="four_selection selection" data-target-value="4" data-target-id="four_{^$m_player^}">金杠</span></li>
  </ul>
  <label>
    <span class="confirm_button">开杠</span>
    <input type="submit" name="four[{^$m_player^}]" value="0" class="undisp" id="four_{^$m_player^}" />
  </label>
{^if $item_detail["m_banker_flg"]^}
  <ul class="detail_box_cols important_cols">
    <li class="one_selection"><span class="tianhu_selection selection" data-target-id="tianhu-{^$m_player^}">天和</span></li>
  </ul>
{^/if^}
  <ul class="detail_box_cols important_cols">
    <li class="two_selection"><span class="gangkai_selection selection" data-target-value="1" data-target-id="gangkai-{^$m_player^}">杠开</span></li>
    <li class="two_selection"><span class="gangkai_selection selection" data-target-value="2" data-target-id="gangkai-{^$m_player^}">杠开x2</span></li>
  </ul>
  <ul class="detail_box_cols">
    <li class="two_selection"><span class="gangkai_selection selection" data-target-value="3" data-target-id="gangkai-{^$m_player^}">杠开x3</span></li>
    <li class="two_selection"><span class="gangkai_selection selection" data-target-value="4" data-target-id="gangkai-{^$m_player^}">杠开x4</span></li>
  </ul>
  <ul class="detail_box_cols important_cols">
    <li class="one_selection"><span class="important_selection" data-target-value="1" data-target-id="win_{^$m_player^}">提溜</span></li>
  </ul>
  <ul class="detail_box_cols">
    <li class="one_selection"><span class="diliu_selection selection times_selection" data-target-id="diliu_su-{^$m_player^}">素</span></li>
  </ul>
  <ul class="detail_box_cols important_cols">
    <li class="one_selection"><span class="important_selection" data-target-value="2" data-target-id="win_{^$m_player^}">混吊</span></li>
  </ul>
  <ul class="detail_box_cols important_cols">
    <li class="one_selection"><span class="important_selection" data-target-value="3" data-target-id="win_{^$m_player^}">捉伍</span></li>
  </ul>
  <ul class="detail_box_cols">
    <li class="two_selection"><span class="zhuowu_selection selection times_selection" data-target-id="zhuowu_su-{^$m_player^}">素</span></li>
    <li class="two_selection"><span class="zhuowu_selection selection times_selection" data-target-id="zhuowu_shuang-{^$m_player^}">双混</span></li>
  </ul>
  <ul class="detail_box_cols important_cols">
    <li class="one_selection"><span class="important_selection" data-target-value="4" data-target-id="win_{^$m_player^}">龙</span></li>
  </ul>
  <ul class="detail_box_cols">
    <li class="three_selection"><span class="long_selection selection times_selection" data-target-id="long_su-{^$m_player^}">素</span></li>
    <li class="three_selection"><span class="long_selection selection times_selection" data-target-id="long_diao-{^$m_player^}">混吊</span></li>
    <li class="three_selection"><span class="long_selection selection times_selection" data-target-id="long_ben-{^$m_player^}">本混</span></li>
  </ul>
  <ul class="detail_box_cols important_cols">
    <li class="one_selection"><span class="important_selection" data-target-value="7" data-target-id="win_{^$m_player^}">捉伍龙</span></li>
  </ul>
  <ul class="detail_box_cols">
    <li class="three_selection"><span class="zwl_selection selection times_selection" data-target-id="zwl_su-{^$m_player^}">素</span></li>
    <li class="three_selection"><span class="zwl_selection selection times_selection" data-target-id="zwl_shaung-{^$m_player^}">双混</span></li>
    <li class="three_selection"><span class="zwl_selection selection times_selection" data-target-id="zwl_ben-{^$m_player^}">本混</span></li>
  </ul>
  <label>
    <span class="confirm_button important_cols">和牌</span>
    <input type="submit" name="win[{^$m_player^}]" value="0" class="undisp" id="win_{^$m_player^}" />
  </label>
</div>
<input type="hidden" name="win_times[{^$m_player^}][tianhu]" value="0" id="tianhu-{^$m_player^}" />
<input type="hidden" name="win_times[{^$m_player^}][gangkai]" value="0" id="gangkai-{^$m_player^}" />
<input type="hidden" name="win_times[{^$m_player^}][1][0]" value="0" id="diliu_su-{^$m_player^}" class="hidden_times_selection" />
<input type="hidden" name="win_times[{^$m_player^}][3][0]" value="0" id="zhuowu_su-{^$m_player^}" class="hidden_times_selection" />
<input type="hidden" name="win_times[{^$m_player^}][3][1]" value="0" id="zhuowu_shuang-{^$m_player^}" class="hidden_times_selection" />
<input type="hidden" name="win_times[{^$m_player^}][4][0]" value="0" id="long_su-{^$m_player^}" class="hidden_times_selection" />
<input type="hidden" name="win_times[{^$m_player^}][4][1]" value="0" id="long_diao-{^$m_player^}" class="hidden_times_selection" />
<input type="hidden" name="win_times[{^$m_player^}][4][2]" value="0" id="long_ben-{^$m_player^}" class="hidden_times_selection" />
<input type="hidden" name="win_times[{^$m_player^}][7][0]" value="0" id="zwl_su-{^$m_player^}" class="hidden_times_selection" />
<input type="hidden" name="win_times[{^$m_player^}][7][1]" value="0" id="zwl_shaung-{^$m_player^}" class="hidden_times_selection" />
<input type="hidden" name="win_times[{^$m_player^}][7][2]" value="0" id="zwl_ben-{^$m_player^}" class="hidden_times_selection" />
{^/foreach^}
</form>
<ul class="buttom_box_button_cols">
  <li><a class="buttom_button" href="./?menu=mahjong&act=start">返回</a></li>
  <li><a class="buttom_button button_selected" href="./?menu=mahjong&act=history&m_id={^$m_id^}">统计</a></li>
</ul>
<div class="footer"></div>
</body>
</html>