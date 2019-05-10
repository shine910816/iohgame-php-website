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
        if ($request->hasParameter("team_stats")) {
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
        //$team_stats = $request->getParameter("team_stats")
        //$team_chart_info = Utility::decodeCookieInfo($team_stats);
$team_chart_info = array("stats" => "120,80,90,70,80,90,70,80", "maximum" => "100,100,100,100,100,100,100,100", "color" => "f06000");
        $file_header = '<?xml version="1.0" standalone="no"?>' .
            '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">' .
            '<svg width="375" height="375" version="1.1" xmlns="http://www.w3.org/2000/svg">' .
            '<polygon points="187.5,57.5 95.576,95.576 57.5,187.5 95.576,279.424 187.5,317.5 279.424,279.424 317.5,187.5 279.424,95.576" style="fill:#DDD; stroke:#999; stroke-width:1;" />' .
            '<polygon points="187.5,83.5 113.961,113.961 83.5,187.5 113.961,261.039 187.5,291.5 261.039,261.039 291.5,187.5 261.039,113.961" style="fill:#CCC;" />' .
            '<polygon points="187.5,109.5 132.346,132.346 109.5,187.5 132.346,242.654 187.5,265.5 242.654,242.654 265.5,187.5 242.654,132.346" style="fill:#DDD;" />' .
            '<polygon points="187.5,135.5 150.73,150.73 135.5,187.5 150.73,224.27 187.5,239.5 224.27,224.27 239.5,187.5 224.27,150.73" style="fill:#CCC;" />' .
            '<polygon points="187.5,161.5 169.115,169.115 161.5,187.5 169.115,205.885 187.5,213.5 205.885,205.885 213.5,187.5 205.885,169.115" style="fill:#DDD;" />' .
            '<line x1="187.5" y1="187.5" x2="187.5" y2="57.5" style="stroke:#999; stroke-width:1;"/>' .
            '<line x1="187.5" y1="187.5" x2="95.576" y2="95.576" style="stroke:#999; stroke-width:1;"/>' .
            '<line x1="187.5" y1="187.5" x2="57.5" y2="187.5" style="stroke:#999; stroke-width:1;"/>' .
            '<line x1="187.5" y1="187.5" x2="95.576" y2="279.424" style="stroke:#999; stroke-width:1;"/>' .
            '<line x1="187.5" y1="187.5" x2="187.5" y2="317.5" style="stroke:#999; stroke-width:1;"/>' .
            '<line x1="187.5" y1="187.5" x2="279.424" y2="279.424" style="stroke:#999; stroke-width:1;"/>' .
            '<line x1="187.5" y1="187.5" x2="317.5" y2="187.5" style="stroke:#999; stroke-width:1;"/>' .
            '<line x1="187.5" y1="187.5" x2="279.424" y2="95.576" style="stroke:#999; stroke-width:1;"/>' .
            '<text x="187.5" y="46.5" style="fill:#999; font-size:24px; text-anchor:middle;">得分</text>' .
            '<text x="77.191" y="82.191" style="fill:#999; font-size:24px; text-anchor:middle;">篮板</text>' .
            '<text x="31.5" y="192.5" style="fill:#999; font-size:24px; text-anchor:middle;">助攻</text>' .
            '<text x="77.191" y="307.809" style="fill:#999; font-size:24px; text-anchor:middle;">抢断</text>' .
            '<text x="187.5" y="348.5" style="fill:#999; font-size:24px; text-anchor:middle;">盖帽</text>' .
            '<text x="297.809" y="307.809" style="fill:#999; font-size:24px; text-anchor:middle;">投篮</text>' .
            '<text x="343.5" y="192.5" style="fill:#999; font-size:24px; text-anchor:middle;">三分</text>' .
            '<text x="297.809" y="82.191" style="fill:#999; font-size:24px; text-anchor:middle;">罚球</text>' .
            '<!--Detail content START-->';
        $file_footer = '<!--Detail content END--></svg>';
        $stats_list = array();
        $max_list = array();
        if (isset($team_chart_info["stats"]) && isset($team_chart_info["maximum"]) && isset($team_chart_info["color"])) {
            $stats_list = explode(",", $team_chart_info["stats"]);
            $max_list = explode(",", $team_chart_info["maximum"]);
        }
        $graph_list = array();
        if (count($stats_list) == 8 && count($max_list) == 8) {
            $width_number = 375;
            for ($idx = 0; $idx < 8; $idx++) {
                $deg_number = 90 + $idx * 45;
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