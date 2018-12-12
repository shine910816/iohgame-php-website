<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>天津麻将记分器</title>
<link rel="shortcut icon" type="image/x-icon" href="img/ico/favicon.ico"/>
<link rel="stylesheet" href="css/sp/common.css?{^$ts^}" type="text/css" />
<link rel="stylesheet" href="css/common/common_font.css" type="text/css" />
<link rel="stylesheet" href="css/font-awesome.css" type="text/css" />
<link rel="stylesheet" href="css/mahjong/history.css?{^$ts^}" type="text/css" />
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="js/echarts.min.js"></script>
<script type="text/javascript" src="js/mahjong/history.js?{^$ts^}"></script>
{^$javascript_text^}
</head>
<body>
<div class="top_box">
  <div class="top_title">{^$game_info["m_name"]^}</div>
</div>
{^foreach from=$game_history item=history_item^}
<ul class="detail_title">
  <li class="detail_title_content_1">{^$history_item["m_round"]^}/{^$history_item["m_part"]^}</li>
  <li class="detail_title_content_2">{^$history_item["win_type_name"]^}</li>
  <li class="detail_title_content_2">{^if $history_item["winner_player"]^}{^$game_detail[$history_item["winner_player"]]["m_player_name"]^}{^/if^}</li>
</ul>
{^/foreach^}
<div class="graph_box">
  <div class="graph" id="graph_1"></div>
</div>
<div class="graph_box">
  <div class="graph" id="graph_2"></div>
</div>
<ul class="buttom_box_button_cols">
  <li><a class="buttom_button" href="./?menu=mahjong&act=start{^if $game_info["final_flg"]^}&history=1{^/if^}">返回大厅</a></li>
  <li>{^if !$game_info["final_flg"]^}<a class="buttom_button button_selected" href="./?menu=mahjong&act=detail&m_id={^$m_id^}">返回牌桌</a>{^elseif $restart_flg^}<a class="buttom_button button_selected" href="./?menu=mahjong&act=restart&m_id={^$m_id^}">再开一局</a>{^/if^}</li>
</ul>
<div class="footer"></div>
<script type="text/javascript">
var graph_option_1 = {
    title: {
        text: "玩家持有积分&开杠收益",
        x: 'center'
    },
    color: [
        "#BF4B35",
        "#A5C3CD"
    ],
    tooltip: {
        trigger: "axis",
        axisPointer: {
            type: 'shadow'
        }
    },
    legend: {
        top: '5%'
    },
    xAxis: {
        data: player_name
    },
    yAxis: {
        show: false,
        type: 'value',
        splitLine: {show: false}
    },
    series: [{
        name: "持有积分",
        type: "bar",
        data: player_point,
        markArea: {
            silent: true,
            data: [[{
                yAxis: 0
            }, {
                yAxis: m_point
            }]]
        },
    }, {
        name: "开杠收益",
        type: "bar",
        data: player_point_gang,
        barGap: 0
    }]
};
var graph_option_2 = {
    title: {
        text: "玩家积分走势",
        x: 'center'
    },
    color: [
        "#1E90FF",
        "#F08080",
        "#32CD32",
        "#CDCD00",
        "#FF6C00",
        "#73635C"
    ],
    tooltip: {
        trigger: "axis",
        axisPointer: {
            type: 'shadow'
        }
    },
    legend: {
        top: "5%"
    },
    xAxis: {
        data: round_number
    },
    yAxis: {
        show: false
    },
    series: [{
        name: player_name_1,
        type: 'line',
        symbol: 'circle',
        data: player_1_point
    }, {
        name: player_name_2,
        type: 'line',
        symbol: 'rect',
        data: player_2_point
    }, {
        name: player_name_3,
        type: 'line',
        symbol: 'triangle',
        data: player_3_point
    }, {
        name: player_name_4,
        type: 'line',
        symbol: 'diamond',
        data: player_4_point
    }, {
        name: "赢家收益",
        type: "bar",
        data: winner_point,
        barGap: 0
    }, {
        name: "庄家收支",
        type: "bar",
        data: banker_point
    }]
};
echarts.init(document.getElementById('graph_1')).setOption(graph_option_1);
echarts.init(document.getElementById('graph_2')).setOption(graph_option_2);
</script>
</body>
</html>