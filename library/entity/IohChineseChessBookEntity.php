<?php

/**
 * 数据库应用类-chinese_chess_book
 * @author Kinsama
 * @version 2017-05-10
 */
class IohChineseChessBookEntity
{
    // 存在
    const DISP_FLG_ON = 1;
    const DISP_FLG_OFF = 0;
    // 边界
    const COLS_NUM_MIN = 0;
    const COLS_NUM_MAX = 9;
    const ROWS_NUM_MIN = 0;
    const ROWS_NUM_MAX = 8;
    // 棋子
    const CHESS_VALUE_SHUAI = 0;
    const CHESS_VALUE_SHI = 1;
    const CHESS_VALUE_XIANG = 2;
    const CHESS_VALUE_MA = 3;
    const CHESS_VALUE_CHE = 4;
    const CHESS_VALUE_PAO = 5;
    const CHESS_VALUE_BING = 6;
    // 阵营
    const CHESS_GROUP_WHITE = 0;
    const CHESS_GROUP_BLACK = 1;

    public static function getEntityName()
    {
        return 'chinese_chess_book';
    }

    public static function getVolumnName()
    {
        return array(
            'game_id',
            'chess_id',
            'cols_num',
            'rows_num',
            'group',
            'value',
            'disp_flg'
        );
    }

    public static function getChessInfoList()
    {
        return array(
            array(
                "帥",
                "仕",
                "相",
                "馬",
                "車",
                "炮",
                "兵"
            ),
            array(
                "将",
                "士",
                "象",
                "馬",
                "車",
                "砲",
                "卒"
            )
        );
    }
}
?>