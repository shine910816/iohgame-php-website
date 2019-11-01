<?php

/**
 * Object NBA图表
 * @author Kinsama
 * @version 2019-05-10
 */
class IohNba_ChartAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("t")) {
            $ret = $this->_doOctagonExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } else {
            $ret = $this->_doDefaultExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        }
        return $ret;
    }

    /**
     * 执行参数检测
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainValidate(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_NONE;
    }

    private function _doOctagonExecute(Controller $controller, User $user, Request $request)
    {
        $team_stats = $request->getParameter("t");
        $team_chart_info = Utility::decodeCookieInfo($team_stats);
        $file_header = '<?xml version="1.0" standalone="no"?>' .
                '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">' .
                '<svg width="375" height="375" version="1.1" xmlns="http://www.w3.org/2000/svg">' .
                '<polygon points="187.5,57.5 63.863,147.328 111.088,292.672 263.912,292.672 311.137,147.328" style="fill:#DDD; stroke:#999; stroke-width:1;" />' .
                '<polygon points="187.5,83.5 88.59,155.362 126.37,271.638 248.63,271.638 286.41,155.362" style="fill:#CCC;" />' .
                '<polygon points="187.5,109.5 113.318,163.397 141.653,250.603 233.347,250.603 261.682,163.397" style="fill:#DDD;" />' .
                '<polygon points="187.5,135.5 138.045,171.431 156.935,229.569 218.065,229.569 236.955,171.431" style="fill:#CCC;" />' .
                '<polygon points="187.5,161.5 162.773,179.466 172.218,208.534 202.782,208.534 212.227,179.466" style="fill:#DDD;" />' .
                '<line x1="187.5" y1="187.5" x2="187.5" y2="57.5" style="stroke:#999; stroke-width:1;"/>' .
                '<line x1="187.5" y1="187.5" x2="63.863" y2="147.328" style="stroke:#999; stroke-width:1;"/>' .
                '<line x1="187.5" y1="187.5" x2="111.088" y2="292.672" style="stroke:#999; stroke-width:1;"/>' .
                '<line x1="187.5" y1="187.5" x2="263.912" y2="292.672" style="stroke:#999; stroke-width:1;"/>' .
                '<line x1="187.5" y1="187.5" x2="311.137" y2="147.328" style="stroke:#999; stroke-width:1;"/>' .
                '<text x="187.5" y="44.5" style="fill:#999; font-size:20px; text-anchor:middle;">得分</text>' .
                '<text x="33.723" y="150.585" style="fill:#999; font-size:20px; text-anchor:middle;">篮板</text>' .
                '<text x="93.752" y="320.415" style="fill:#999; font-size:20px; text-anchor:middle;">助攻</text>' .
                '<text x="281.248" y="320.415" style="fill:#999; font-size:20px; text-anchor:middle;">抢断</text>' .
                '<text x="344.277" y="150.585" style="fill:#999; font-size:20px; text-anchor:middle;">盖帽</text>' .
                '<!--Detail content START-->';
        $file_footer = '<!--Detail content END--></svg>';
        $stats_list = array();
        $max_list = array();
        if (isset($team_chart_info["stats"]) && isset($team_chart_info["maximum"]) && isset($team_chart_info["color"])) {
            $stats_list = explode(",", $team_chart_info["stats"]);
            $max_list = explode(",", $team_chart_info["maximum"]);
        }
        $graph_list = array();
        if (count($stats_list) == 5 && count($max_list) == 5) {
            $width_number = 375;
            for ($idx = 0; $idx < 5; $idx++) {
                $deg_number = 90 + $idx * 72;
                $item_array = array();
                $item_array["x"] = sprintf("%.3f", cos(deg2rad($deg_number)) * (130 * $stats_list[$idx] / $max_list[$idx]) + $width_number / 2);
                $item_array["y"] = sprintf("%.3f", $width_number / 2 - sin(deg2rad($deg_number)) * (130 * $stats_list[$idx] / $max_list[$idx]));
                $item_array["xy"] = $item_array["x"] . "," . $item_array["y"];
                $graph_list[$idx] = $item_array;
            }
        }
        header("Content-type:image/svg+xml");
        echo $file_header;
        if (!empty($graph_list)) {
            $polygon_text = "";
            foreach ($graph_list as $stats_graph_info) {
                $polygon_text .= $stats_graph_info["xy"] . " ";
            }
            $polygon_text = rtrim($polygon_text);
            echo '<polygon points="' . $polygon_text . '" style="fill:#' . $team_chart_info["color"] . '; opacity:0.7; stroke:#000; stroke-width:1;" />';
            foreach ($graph_list as $stats_graph_info) {
                $polygon_text .= $stats_graph_info["xy"] . " ";
                echo '<circle cx="' . $stats_graph_info["x"] . '" cy="' . $stats_graph_info["y"] . '" r="3.5" style="fill:#FFF; opacity:0.7; stroke:#000; stroke-width:1;" />';
            }
        }
        echo $file_footer;
        return VIEW_NONE;
    }
}
?>