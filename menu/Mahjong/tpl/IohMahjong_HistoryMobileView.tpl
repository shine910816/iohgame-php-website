{^include file=$mblheader_file page_title="天津麻将记分器"^}
<h3 class="ui-bar ui-bar-a ui-corner-all">{^$game_info["m_name"]^}</h3>
{^if !empty($game_history)^}
<div class="ui-body">
  <table data-role="table" data-mode="columntoggle:none" class="ui-responsive table-stroke">
    <tbody>
{^foreach from=$game_history item=history_item^}
      <tr>
        <td>{^$history_item["m_round"]^}/{^$history_item["m_part"]^}</td>
        <td>{^if $history_item["winner_player"]^}{^$game_detail[$history_item["winner_player"]]["m_player_name"]^}{^/if^}</td>
        <td>{^$history_item["win_type_name"]^}</td>
      </tr>
{^/foreach^}
    <tbody>
  </table>
</div>
<div class="ui-body">
  <p>玩家持有积分&开杠收益</p>
  <div style="width:311px; height:270px;" id="graph_1"></div>
  <p>玩家积分走势</p>
  <div style="width:311px; height:270px;" id="graph_2"></div>
</div>
<script type="text/javascript" src="https://www.echartsjs.com/dist/echarts.min.js"></script>
{^$javascript_text^}
<script type="text/javascript">
var graph_option_1 = {
    //title: {
    //    text: "玩家持有积分&开杠收益",
    //    x: 'center'
    //},
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
    //title: {
    //    text: "玩家积分走势",
    //    x: 'center'
    //},
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
var graph_1 = echarts.init(document.getElementById("graph_1"));
var graph_2 = echarts.init(document.getElementById("graph_2"));
graph_1.setOption(graph_option_1);
graph_2.setOption(graph_option_2);
</script>
<h4>ECharts: A Declarative Framework for Rapid Construction of Web-based Visualization</h4>
<p>Deqing Li, Honghui Mei, Yi Shen, Shuang Su, Wenli Zhang, Junting Wang, Ming Zu, Wei Chen.</p>
<p>Visual Informatics, 2018 <a href="http://www.cad.zju.edu.cn/home/vagblog/VAG_Work/echarts.pdf">[PDF]</a></p>
{^/if^}
<fieldset class="ui-grid-a">
  <div class="ui-block-a"><a class="ui-btn ui-corner-all ui-btn-a" href="./?menu=mahjong&act=start{^if $game_info["final_flg"]^}&history=1{^/if^}">返回大厅</a></div>
  <div class="ui-block-b">{^if !$game_info["final_flg"]^}<a class="ui-btn ui-corner-all ui-btn-b" href="./?menu=mahjong&act=detail&m_id={^$m_id^}" data-ajax="false">返回牌桌</a>{^elseif $restart_flg^}<a class="ui-btn ui-corner-all ui-btn-b" href="./?menu=mahjong&act=restart&m_id={^$m_id^}">再开一局</a>{^/if^}</div>
</fieldset>
{^include file=$mblfooter_file^}