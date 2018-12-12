<?php

/**
 * 数字转换类
 * @author Kinsama
 * @version 2017-09-21
 */
class Number
{

    public function doTransNumber($number, $chinese_upper_flg = false)
    {
        $number_arr = $this->_chunkNumber($number);
        if (empty($number_arr)) {
            return;
        }
        $result_str = "";
        $result_list = array();
        foreach ($number_arr as $unit_key => $unit_number) {
            $item_value = $this->_transUnitNumber($unit_number);
            $result_list[$unit_key] = $item_value;
            if ($item_value != "零") {
                $result_str .= "1";
            } else {
                $result_str .= "0";
            }
        }
        $result = "";
        switch ($result_str) {
            case "000":
                $result = "零";
                break;
            case "001":
                $result = $result_list[2];
                break;
            case "010":
                $result = sprintf("%s万", $result_list[1]);
                break;
            case "011":
                $result = sprintf("%s万%s", $result_list[1], $result_list[2]);
                break;
            case "100":
                $result = sprintf("%s亿", $result_list[0]);
                break;
            case "101":
                $result = sprintf("%s亿零%s", $result_list[0], $result_list[2]);
                break;
            case "110":
                $result = sprintf("%s亿%s万", $result_list[0], $result_list[1]);
                break;
            case "111":
                $result = sprintf("%s亿%s万%s", $result_list[0], $result_list[1], $result_list[2]);
                break;
        }
        if ($chinese_upper_flg) {
            $number_list = array(
                array(
                    "一",
                    "壹"
                ),
                array(
                    "二",
                    "贰"
                ),
                array(
                    "三",
                    "叁"
                ),
                array(
                    "四",
                    "肆"
                ),
                array(
                    "五",
                    "伍"
                ),
                array(
                    "六",
                    "陆"
                ),
                array(
                    "七",
                    "柒"
                ),
                array(
                    "八",
                    "捌"
                ),
                array(
                    "九",
                    "玖"
                ),
                array(
                    "十",
                    "拾"
                ),
                array(
                    "百",
                    "佰"
                ),
                array(
                    "千",
                    "仟"
                ),
                array(
                    "万",
                    "萬"
                ),
                array(
                    "亿",
                    "億"
                )
            );
            foreach ($number_list as $item) {
                $result = str_replace($item[0], $item[1], $result);
            }
            return $result;
        }
        return $result;
    }

    private function _chunkNumber($number)
    {
        $chunk_num = 4;
        $result_arr = array();
        if (strlen($number) > 12) {
            return $result_arr;
        }
        $zero_number = 12 - strlen($number);
        if ($zero_number > 0) {
            $number = str_repeat("0", $zero_number) . $number;
        }
        $last_count = str_split($number, $chunk_num);
        foreach ($last_count as $one_item) {
            $result_arr[] = $one_item;
        }
        return $result_arr;
    }

    private function _transUnitNumber($number)
    {
        $number_list = array(
            "零",
            "一",
            "二",
            "三",
            "四",
            "五",
            "六",
            "七",
            "八",
            "九"
        );
        $number_arr = str_split($number, 1);
        $result = "";
        $judge_str = "";
        foreach ($number_arr as $item) {
            if ($item != "0") {
                $judge_str .= "1";
            } else {
                $judge_str .= "0";
            }
        }
        switch ($judge_str) {
            case "0000":
                $result = "零";
                break;
            case "0001":
                $result = $number_list[$number_arr[3]];
                break;
            case "0010":
                $result = sprintf("%s十", $number_list[$number_arr[2]]);
                break;
            case "0011":
                $result = sprintf("%s十%s", $number_list[$number_arr[2]], $number_list[$number_arr[3]]);
                break;
            case "0100":
                $result = sprintf("%s百", $number_list[$number_arr[1]]);
                break;
            case "0101":
                $result = sprintf("%s百零%s", $number_list[$number_arr[1]], $number_list[$number_arr[3]]);
                break;
            case "0110":
                $result = sprintf("%s百%s十", $number_list[$number_arr[1]], $number_list[$number_arr[2]]);
                break;
            case "0111":
                $result = sprintf("%s百%s十%s", $number_list[$number_arr[1]], $number_list[$number_arr[2]], $number_list[$number_arr[3]]);
                break;
            case "1000":
                $result = sprintf("%s千", $number_list[$number_arr[0]]);
                break;
            case "1001":
                $result = sprintf("%s千零%s", $number_list[$number_arr[0]], $number_list[$number_arr[3]]);
                break;
            case "1010":
                $result = sprintf("%s千零%s十", $number_list[$number_arr[0]], $number_list[$number_arr[2]]);
                break;
            case "1011":
                $result = sprintf("%s千零%s十%s", $number_list[$number_arr[0]], $number_list[$number_arr[2]], $number_list[$number_arr[3]]);
                break;
            case "1100":
                $result = sprintf("%s千%s百", $number_list[$number_arr[0]], $number_list[$number_arr[1]]);
                break;
            case "1101":
                $result = sprintf("%s千%s百零%s", $number_list[$number_arr[0]], $number_list[$number_arr[1]], $number_list[$number_arr[3]]);
                break;
            case "1110":
                $result = sprintf("%s千%s百%s十", $number_list[$number_arr[0]], $number_list[$number_arr[1]], $number_list[$number_arr[2]]);
                break;
            case "1111":
                $result = sprintf("%s千%s百%s十%s", $number_list[$number_arr[0]], $number_list[$number_arr[1]], $number_list[$number_arr[2]], $number_list[$number_arr[3]]);
                break;
        }
        return $result;
    }
}
?>