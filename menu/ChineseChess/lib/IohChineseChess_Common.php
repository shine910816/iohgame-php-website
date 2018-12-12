<?php

/**
 * 进行中国象棋比赛
 * @author Kinsama
 * @version 2017-05-17
 */
class IohChineseChess_Common
{

    /**
     * 游戏ID
     * @access private
     */
    private $_game_id;

    /**
     * 棋子信息
     * @access private
     */
    private $_chess_book_info;

    /**
     * 棋盘信息
     * @access private
     */
    public $chess_table_info;

    /**
     * 获取棋盘棋子信息
     * @param int $game_id 游戏ID
     * @return boolean or object
     */
    public function getChineseChessInfo($game_id)
    {
        $chess_book_info = IohChineseChessBookDBI::selectChessGame($game_id);
        if (Error::isError($chess_book_info)) {
            $chess_book_info->setPos(__FILE__, __LINE__);
            return $chess_book_info;
        }
        $chess_table_info = array();
        foreach ($chess_book_info as $chess_book_item) {
            $chess_table_info[$chess_book_item['cols_num']][$chess_book_item['rows_num']] = $chess_book_item;
        }
        $this->_game_id = $game_id;
        $this->_chess_book_info = $chess_book_info;
        $this->chess_table_info = $chess_table_info;
        return true;
    }

    /**
     * 执行获取棋子可能移动位置
     * @param object $request Request对象类
     * @param int $chess_id 棋子ID
     * @param boolean $ajax_flg 格式flg(true:ajax格式/false:action格式)
     * @return array
     */
    public function getChessMove($chess_id, $ajax_flg = false)
    {
        // 棋盘信息获取
        $chess_book_info = $this->_chess_book_info;
        if (!isset($chess_book_info[$chess_id])) {
            $err = Error::getInstance();
            $err->raiseError(ERROR_CODE_USER_FALSIFY, "参数chess_id值被窜改");
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $chess_move_info = $chess_book_info[$chess_id];
        $chess_table_info = $this->chess_table_info;
        // 主处理
        $pos_arr = array();
        if ($chess_move_info['value'] == IohChineseChessBookEntity::CHESS_VALUE_SHI) {
            if ($chess_move_info['rows_num'] != 4) {
                if ($chess_move_info['cols_num'] < 5) {
                    $pos_arr[] = array(
                        'c' => 1,
                        'r' => 4
                    );
                } else {
                    $pos_arr[] = array(
                        'c' => 8,
                        'r' => 4
                    );
                }
            } else {
                $pos_arr[] = array(
                    'c' => $chess_move_info['cols_num'] + 1,
                    'r' => $chess_move_info['rows_num'] + 1
                );
                $pos_arr[] = array(
                    'c' => $chess_move_info['cols_num'] - 1,
                    'r' => $chess_move_info['rows_num'] + 1
                );
                $pos_arr[] = array(
                    'c' => $chess_move_info['cols_num'] + 1,
                    'r' => $chess_move_info['rows_num'] - 1
                );
                $pos_arr[] = array(
                    'c' => $chess_move_info['cols_num'] - 1,
                    'r' => $chess_move_info['rows_num'] - 1
                );
            }
        } elseif ($chess_move_info['value'] == IohChineseChessBookEntity::CHESS_VALUE_XIANG) {
            if ($chess_move_info['cols_num'] == 0 || $chess_move_info['cols_num'] == 5) {
                if (!isset($chess_table_info[$chess_move_info['cols_num'] + 1][$chess_move_info['rows_num'] - 1])) {
                    $pos_arr[] = array(
                        'c' => $chess_move_info['cols_num'] + 2,
                        'r' => $chess_move_info['rows_num'] - 2
                    );
                }
                if (!isset($chess_table_info[$chess_move_info['cols_num'] + 1][$chess_move_info['rows_num'] + 1])) {
                    $pos_arr[] = array(
                        'c' => $chess_move_info['cols_num'] + 2,
                        'r' => $chess_move_info['rows_num'] + 2
                    );
                }
            } elseif ($chess_move_info['cols_num'] == 4 || $chess_move_info['cols_num'] == 9) {
                if (!isset($chess_table_info[$chess_move_info['cols_num'] - 1][$chess_move_info['rows_num'] - 1])) {
                    $pos_arr[] = array(
                        'c' => $chess_move_info['cols_num'] - 2,
                        'r' => $chess_move_info['rows_num'] - 2
                    );
                }
                if (!isset($chess_table_info[$chess_move_info['cols_num'] - 1][$chess_move_info['rows_num'] + 1])) {
                    $pos_arr[] = array(
                        'c' => $chess_move_info['cols_num'] - 2,
                        'r' => $chess_move_info['rows_num'] + 2
                    );
                }
            } else {
                if (!isset($chess_table_info[$chess_move_info['cols_num'] + 1][$chess_move_info['rows_num'] - 1])) {
                    $pos_arr[] = array(
                        'c' => $chess_move_info['cols_num'] + 2,
                        'r' => $chess_move_info['rows_num'] - 2
                    );
                }
                if (!isset($chess_table_info[$chess_move_info['cols_num'] + 1][$chess_move_info['rows_num'] + 1])) {
                    $pos_arr[] = array(
                        'c' => $chess_move_info['cols_num'] + 2,
                        'r' => $chess_move_info['rows_num'] + 2
                    );
                }
                if (!isset($chess_table_info[$chess_move_info['cols_num'] - 1][$chess_move_info['rows_num'] - 1])) {
                    $pos_arr[] = array(
                        'c' => $chess_move_info['cols_num'] - 2,
                        'r' => $chess_move_info['rows_num'] - 2
                    );
                }
                if (!isset($chess_table_info[$chess_move_info['cols_num'] - 1][$chess_move_info['rows_num'] + 1])) {
                    $pos_arr[] = array(
                        'c' => $chess_move_info['cols_num'] - 2,
                        'r' => $chess_move_info['rows_num'] + 2
                    );
                }
            }
        } elseif ($chess_move_info['value'] == IohChineseChessBookEntity::CHESS_VALUE_MA) {
            if (!isset($chess_table_info[$chess_move_info['cols_num'] + 1][$chess_move_info['rows_num']])) {
                $pos_arr[] = array(
                    'c' => $chess_move_info['cols_num'] + 2,
                    'r' => $chess_move_info['rows_num'] - 1
                );
                $pos_arr[] = array(
                    'c' => $chess_move_info['cols_num'] + 2,
                    'r' => $chess_move_info['rows_num'] + 1
                );
            }
            if (!isset($chess_table_info[$chess_move_info['cols_num'] - 1][$chess_move_info['rows_num']])) {
                $pos_arr[] = array(
                    'c' => $chess_move_info['cols_num'] - 2,
                    'r' => $chess_move_info['rows_num'] - 1
                );
                $pos_arr[] = array(
                    'c' => $chess_move_info['cols_num'] - 2,
                    'r' => $chess_move_info['rows_num'] + 1
                );
            }
            if (!isset($chess_table_info[$chess_move_info['cols_num']][$chess_move_info['rows_num'] + 1])) {
                $pos_arr[] = array(
                    'c' => $chess_move_info['cols_num'] - 1,
                    'r' => $chess_move_info['rows_num'] + 2
                );
                $pos_arr[] = array(
                    'c' => $chess_move_info['cols_num'] + 1,
                    'r' => $chess_move_info['rows_num'] + 2
                );
            }
            if (!isset($chess_table_info[$chess_move_info['cols_num']][$chess_move_info['rows_num'] - 1])) {
                $pos_arr[] = array(
                    'c' => $chess_move_info['cols_num'] - 1,
                    'r' => $chess_move_info['rows_num'] - 2
                );
                $pos_arr[] = array(
                    'c' => $chess_move_info['cols_num'] + 1,
                    'r' => $chess_move_info['rows_num'] - 2
                );
            }
        } elseif ($chess_move_info['value'] == IohChineseChessBookEntity::CHESS_VALUE_CHE) {
            for ($idx = $chess_move_info['cols_num'] - 1; $idx >= IohChineseChessBookEntity::COLS_NUM_MIN; $idx--) {
                if (isset($chess_table_info[$idx][$chess_move_info['rows_num']])) {
                    $pos_arr[] = array(
                        'c' => $idx,
                        'r' => $chess_move_info['rows_num']
                    );
                    break;
                } else {
                    $pos_arr[] = array(
                        'c' => $idx,
                        'r' => $chess_move_info['rows_num']
                    );
                }
            }
            for ($idx = $chess_move_info['cols_num'] + 1; $idx <= IohChineseChessBookEntity::COLS_NUM_MAX; $idx++) {
                if (isset($chess_table_info[$idx][$chess_move_info['rows_num']])) {
                    $pos_arr[] = array(
                        'c' => $idx,
                        'r' => $chess_move_info['rows_num']
                    );
                    break;
                } else {
                    $pos_arr[] = array(
                        'c' => $idx,
                        'r' => $chess_move_info['rows_num']
                    );
                }
            }
            for ($idx = $chess_move_info['rows_num'] - 1; $idx >= IohChineseChessBookEntity::ROWS_NUM_MIN; $idx--) {
                if (isset($chess_table_info[$chess_move_info['cols_num']][$idx])) {
                    $pos_arr[] = array(
                        'c' => $chess_move_info['cols_num'],
                        'r' => $idx
                    );
                    break;
                } else {
                    $pos_arr[] = array(
                        'c' => $chess_move_info['cols_num'],
                        'r' => $idx
                    );
                }
            }
            for ($idx = $chess_move_info['rows_num'] + 1; $idx <= IohChineseChessBookEntity::ROWS_NUM_MAX; $idx++) {
                if (isset($chess_table_info[$chess_move_info['cols_num']][$idx])) {
                    $pos_arr[] = array(
                        'c' => $chess_move_info['cols_num'],
                        'r' => $idx
                    );
                    break;
                } else {
                    $pos_arr[] = array(
                        'c' => $chess_move_info['cols_num'],
                        'r' => $idx
                    );
                }
            }
        } elseif ($chess_move_info['value'] == IohChineseChessBookEntity::CHESS_VALUE_PAO) {
            $top_chess_arr = array();
            $bottom_chess_arr = array();
            $left_chess_arr = array();
            $right_chess_arr = array();
            for ($idx = $chess_move_info['cols_num'] - 1; $idx >= IohChineseChessBookEntity::COLS_NUM_MIN; $idx--) {
                if (isset($chess_table_info[$idx][$chess_move_info['rows_num']])) {
                    $top_chess_arr = array(
                        'c' => $idx,
                        'r' => $chess_move_info['rows_num']
                    );
                    break;
                } else {
                    $pos_arr[] = array(
                        'c' => $idx,
                        'r' => $chess_move_info['rows_num']
                    );
                }
            }
            for ($idx = $chess_move_info['cols_num'] + 1; $idx <= IohChineseChessBookEntity::COLS_NUM_MAX; $idx++) {
                if (isset($chess_table_info[$idx][$chess_move_info['rows_num']])) {
                    $bottom_chess_arr = array(
                        'c' => $idx,
                        'r' => $chess_move_info['rows_num']
                    );
                    break;
                } else {
                    $pos_arr[] = array(
                        'c' => $idx,
                        'r' => $chess_move_info['rows_num']
                    );
                }
            }
            for ($idx = $chess_move_info['rows_num'] - 1; $idx >= IohChineseChessBookEntity::ROWS_NUM_MIN; $idx--) {
                if (isset($chess_table_info[$chess_move_info['cols_num']][$idx])) {
                    $left_chess_arr = array(
                        'c' => $chess_move_info['cols_num'],
                        'r' => $idx
                    );
                    break;
                } else {
                    $pos_arr[] = array(
                        'c' => $chess_move_info['cols_num'],
                        'r' => $idx
                    );
                }
            }
            for ($idx = $chess_move_info['rows_num'] + 1; $idx <= IohChineseChessBookEntity::ROWS_NUM_MAX; $idx++) {
                if (isset($chess_table_info[$chess_move_info['cols_num']][$idx])) {
                    $right_chess_arr = array(
                        'c' => $chess_move_info['cols_num'],
                        'r' => $idx
                    );
                    break;
                } else {
                    $pos_arr[] = array(
                        'c' => $chess_move_info['cols_num'],
                        'r' => $idx
                    );
                }
            }
            if (!empty($top_chess_arr)) {
                for ($idx = $top_chess_arr['c'] - 1; $idx >= IohChineseChessBookEntity::COLS_NUM_MIN; $idx--) {
                    if (isset($chess_table_info[$idx][$top_chess_arr['r']])) {
                        $pos_arr[] = array(
                            'c' => $idx,
                            'r' => $top_chess_arr['r']
                        );
                        break;
                    }
                }
            }
            if (!empty($bottom_chess_arr)) {
                for ($idx = $bottom_chess_arr['c'] + 1; $idx <= IohChineseChessBookEntity::COLS_NUM_MAX; $idx++) {
                    if (isset($chess_table_info[$idx][$bottom_chess_arr['r']])) {
                        $pos_arr[] = array(
                            'c' => $idx,
                            'r' => $bottom_chess_arr['r']
                        );
                        break;
                    }
                }
            }
            if (!empty($left_chess_arr)) {
                for ($idx = $left_chess_arr['r'] - 1; $idx >= IohChineseChessBookEntity::ROWS_NUM_MIN; $idx--) {
                    if (isset($chess_table_info[$left_chess_arr['c']][$idx])) {
                        $pos_arr[] = array(
                            'c' => $left_chess_arr['c'],
                            'r' => $idx
                        );
                        break;
                    }
                }
            }
            if (!empty($right_chess_arr)) {
                for ($idx = $right_chess_arr['r'] + 1; $idx <= IohChineseChessBookEntity::ROWS_NUM_MAX; $idx++) {
                    if (isset($chess_table_info[$right_chess_arr['c']][$idx])) {
                        $pos_arr[] = array(
                            'c' => $right_chess_arr['c'],
                            'r' => $idx
                        );
                        break;
                    }
                }
            }
        } elseif ($chess_move_info['value'] == IohChineseChessBookEntity::CHESS_VALUE_BING) {
            if ($chess_move_info['group'] == IohChineseChessBookEntity::CHESS_GROUP_WHITE) {
                $pos_arr[] = array(
                    'c' => $chess_move_info['cols_num'] - 1,
                    'r' => $chess_move_info['rows_num']
                );
                if ($chess_move_info['cols_num'] <= 4) {
                    $pos_arr[] = array(
                        'c' => $chess_move_info['cols_num'],
                        'r' => $chess_move_info['rows_num'] - 1
                    );
                    $pos_arr[] = array(
                        'c' => $chess_move_info['cols_num'],
                        'r' => $chess_move_info['rows_num'] + 1
                    );
                }
            } else {
                $pos_arr[] = array(
                    'c' => $chess_move_info['cols_num'] + 1,
                    'r' => $chess_move_info['rows_num']
                );
                if ($chess_move_info['cols_num'] >= 5) {
                    $pos_arr[] = array(
                        'c' => $chess_move_info['cols_num'],
                        'r' => $chess_move_info['rows_num'] - 1
                    );
                    $pos_arr[] = array(
                        'c' => $chess_move_info['cols_num'],
                        'r' => $chess_move_info['rows_num'] + 1
                    );
                }
            }
        } else {
            $pos_arr[] = array(
                'c' => $chess_move_info['cols_num'] - 1,
                'r' => $chess_move_info['rows_num']
            );
            $pos_arr[] = array(
                'c' => $chess_move_info['cols_num'] + 1,
                'r' => $chess_move_info['rows_num']
            );
            $pos_arr[] = array(
                'c' => $chess_move_info['cols_num'],
                'r' => $chess_move_info['rows_num'] - 1
            );
            $pos_arr[] = array(
                'c' => $chess_move_info['cols_num'],
                'r' => $chess_move_info['rows_num'] + 1
            );
        }
        // 排除规则以外的位置
        foreach ($pos_arr as $pos_idx => $pos_itm) {
            // 出界
            if (!$this->_isChessOutBorder($pos_itm['c'], $pos_itm['r'])) {
                unset($pos_arr[$pos_idx]);
                continue;
            }
            if (!$chess_move_info['value']) {
                // 出九宫
                if (!$this->_isChessShuaiOutJiugongBorder($pos_itm['c'], $pos_itm['r'], $chess_move_info['group'])) {
                    unset($pos_arr[$pos_idx]);
                    continue;
                }
                // 移动将导致明将
                $oppo_shuai_info = array();
                if ($chess_move_info['chess_id'] == 1) {
                    $oppo_shuai_info = $chess_book_info[2];
                } else {
                    $oppo_shuai_info = $chess_book_info[1];
                }
                if ($pos_itm['r'] == $oppo_shuai_info['rows_num']) {
                    $chess_gap_flg = false;
                    $from_cols_num = 0;
                    $to_cols_num = 0;
                    if ($pos_itm['c'] > $oppo_shuai_info['cols_num']) {
                        $from_cols_num = $oppo_shuai_info['cols_num'] + 1;
                        $to_cols_num = $pos_itm['c'] - 1;
                    } else {
                        $from_cols_num = $pos_itm['c'] + 1;
                        $to_cols_num = $oppo_shuai_info['cols_num'] - 1;
                    }
                    for ($idx = $from_cols_num; $idx <= $to_cols_num; $idx++) {
                        if (isset($chess_table_info[$idx][$pos_itm['r']])) {
                            $chess_gap_flg = true;
                            break;
                        }
                    }
                    if (!$chess_gap_flg) {
                        unset($pos_arr[$pos_idx]);
                        continue;
                    }
                }
            } else {
                // 移动非将棋子导致明将
                if ($chess_book_info[1]['rows_num'] == $chess_book_info[2]['rows_num'] && $chess_book_info[2]['rows_num'] == $chess_move_info['rows_num']) {
                    $chess_gap_num = 0;
                    for ($idx = $chess_book_info[2]['cols_num'] + 1; $idx <= $chess_book_info[1]['cols_num'] - 1; $idx++) {
                        if (isset($chess_table_info[$idx][$chess_move_info['rows_num']])) {
                            $chess_gap_num++;
                        }
                    }
                    if ($chess_gap_num <= 1) {
                        if ($pos_itm['r'] != $chess_move_info['rows_num']) {
                            unset($pos_arr[$pos_idx]);
                            continue;
                        }
                    }
                }
            }
            // 己方棋子位置
            if (isset($chess_table_info[$pos_itm['c']][$pos_itm['r']]) && $chess_table_info[$pos_itm['c']][$pos_itm['r']]['group'] == $chess_move_info['group']) {
                unset($pos_arr[$pos_idx]);
                continue;
            }
        }
        // 结果整合
        if ($ajax_flg) {
            $result = array();
            if (empty($pos_arr)) {
                $result['result'] = 0;
            } else {
                $result['result'] = 1;
            }
            $result['content'] = $pos_arr;
            return $result;
        } else {
            $result = array();
            foreach ($pos_arr as $pos_one) {
                $result[$pos_one['c']][$pos_one['r']] = 1;
            }
            return $result;
        }
    }

    public function isChessJiangjun($group)
    {
        $chess_shuai_info = array();
        $chess_oppo_id_list = array();
        $chess_list = array(
            array(
                11,
                13,
                15,
                17,
                19,
                21,
                23,
                25,
                27,
                29,
                31
            ),
            array(
                12,
                14,
                16,
                18,
                20,
                22,
                24,
                26,
                28,
                30,
                32
            )
        );
        if ($group) {
            $chess_shuai_info = $this->_chess_book_info[2];
            $chess_oppo_id_list = $chess_list[0];
        } else {
            $chess_shuai_info = $this->_chess_book_info[1];
            $chess_oppo_id_list = $chess_list[1];
        }
        foreach ($chess_oppo_id_list as $chess_id) {
            if (isset($this->_chess_book_info[$chess_id])) {
                $chess_info = $this->getChessMove($chess_id);
                if (!empty($chess_info)) {
                    foreach ($chess_id as $cols_num => $chess_item) {
                        foreach ($chess_item as $rows_num => $val) {
                            if ($cols_num == $chess_shuai_info['cols_num'] && $rows_num == $chess_shuai_info['rows_num']) {
                                return true;
                            }
                        }
                    }
                }
            }
        }
        return false;
    }

    /**
     * 检查帅是否跨出九宫边界
     * @param int $cols_num 棋子cols_num
     * @param int $rows_num 棋子rows_num
     * @param int $group 阵营
     * @access private
     * @return boolean
     */
    private function _isChessShuaiOutJiugongBorder($cols_num, $rows_num, $group)
    {
        if ($rows_num > 5 || $rows_num < 3) {
            return false;
        }
        if ($group) {
            if ($cols_num > 2 || $cols_num < 0) {
                return false;
            }
        } else {
            if ($cols_num > 9 || $cols_num < 7) {
                return false;
            }
        }
        return true;
    }

    /**
     * 检查棋子是否跨出边界
     * @param int $cols_num 棋子cols_num
     * @param int $rows_num 棋子rows_num
     * @access private
     * @return boolean
     */
    private function _isChessOutBorder($cols_num, $rows_num)
    {
        if ($cols_num > IohChineseChessBookEntity::COLS_NUM_MAX || $cols_num < IohChineseChessBookEntity::COLS_NUM_MIN) {
            return false;
        }
        if ($rows_num > IohChineseChessBookEntity::ROWS_NUM_MAX || $rows_num < IohChineseChessBookEntity::ROWS_NUM_MIN) {
            return false;
        }
        return true;
    }
}
?>