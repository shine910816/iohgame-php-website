<?php

class IohTool_Common
{

    public static function getDaysData($start_date)
    {
        $month_max_day = date("t", strtotime($start_date . "01"));
        $gender_code_list = array(
            "1",
            "2"
        );
        $generation_e_code_list = array(
            "15",
            "30",
            "40",
            "50",
            "60"
        );
        $exist_code_list = array(
            "1",
            "2"
        );
        $result = array();
        for ($day = 1; $day <= $month_max_day; $day++) {
            $days = $start_date . sprintf("%02d", $day);
            foreach ($exist_code_list as $exist_code) {
                foreach ($gender_code_list as $gender_code) {
                    foreach ($generation_e_code_list as $generation_e_code) {
                        $result[$days][$exist_code][$gender_code][$generation_e_code] = self::_getItem();
                    }
                }
                $normal_data = $result[$days][$exist_code];
                $other_data = self::_getAverageItem($normal_data, 5, 15);
                $none_data = self::_getAverageItem($normal_data, 40, 60);
                $result[$days][$exist_code]["10"]["100"] = $other_data;
                $result[$days][$exist_code]["99"]["999"] = $none_data;
            }
        }
        return $result;
    }

    private static function _getItem()
    {
        $result = array(
            "invest_uu_num" => 0,
            "invest_card_num" => 0,
            "purchase_amount" => 0,
            "invest_num" => 0,
            "invest_point" => 0,
            "use_uu_num" => 0,
            "use_num" => 0,
            "use_point" => 0,
            "use_term_point" => 0
        );
        $result["purchase_amount"] = rand(1500, 150000);
        $result["invest_point"] = self::getPercent($result["purchase_amount"], 5, 10);
        $result["use_point"] = self::getPercent($result["purchase_amount"], 10, 15);
        $result["use_term_point"] = self::getPercent($result["use_point"], 40, 60);
        $result["invest_uu_num"] = self::getPercent($result["purchase_amount"] / rand(700, 1300));
        $result["invest_card_num"] = self::getPercent($result["invest_uu_num"], 40, 60);
        $result["invest_num"] = self::getPercent($result["invest_uu_num"], 40, 60);
        $result["use_uu_num"] = self::getPercent($result["purchase_amount"] / rand(300, 700));
        $result["use_num"] = self::getPercent($result["use_uu_num"], 40, 60);
        return $result;
    }

    private static function _getAverageItem($data_list, $from_percent, $to_percent)
    {
        $result = array(
            "invest_uu_num" => 0,
            "invest_card_num" => 0,
            "purchase_amount" => 0,
            "invest_num" => 0,
            "invest_point" => 0,
            "use_uu_num" => 0,
            "use_num" => 0,
            "use_point" => 0,
            "use_term_point" => 0
        );
        foreach ($data_list as $gender_code => $data_sublist) {
            foreach ($data_sublist as $generation_e_code => $item) {
                $result["invest_uu_num"] += $item["invest_uu_num"];
                $result["invest_card_num"] += $item["invest_card_num"];
                $result["purchase_amount"] += $item["purchase_amount"];
                $result["invest_num"] += $item["invest_num"];
                $result["invest_point"] += $item["invest_point"];
                $result["use_uu_num"] += $item["use_uu_num"];
                $result["use_num"] += $item["use_num"];
                $result["use_point"] += $item["use_point"];
                $result["use_term_point"] += $item["use_term_point"];
            }
        }
        foreach ($result as $res_key => $res_val) {
            $result[$res_key] = self::getPercent($res_val, $from_percent, $to_percent);
        }
        return $result;
    }

    public static function getPercent($number, $from_percent = 70, $to_percent = 130)
    {
        return ceil($number * rand($from_percent, $to_percent) / 100);
    }
}
?>