<?php

/**
 * 数据库操作类-chinese_chess_book
 * @author Kinsama
 * @version 2017-05-10
 */
class IohChineseChessBookDBI
{

    /**
     * 根据条件获取当前比赛棋子位置
     *
     * @param int $game_id 游戏ID
     * @param int $group 阵营
     * @param int $value 棋子
     * @return int or object
     */
    public static function selectChessGame($game_id, $group = null, $value = null)
    {
        $dbi = Database::getInstance();
        $where = "WHERE `game_id` = " . $dbi->quote($game_id);
        $where .= " AND `del_flg` = 0";
        $where .= " AND `disp_flg` = 1";
        if (!is_null($group)) {
            $where .= " AND `group` = " . $dbi->quote($group);
        }
        if (!is_null($value)) {
            $where .= " AND `value` = " . $dbi->quote($value);
        }
        $where .= " ORDER BY `cols_num` ASC, `rows_num` ASC";
        $volumn = implode(", ", $dbi->quote(IohChineseChessBookEntity::getVolumnName(), true));
        $sql = sprintf("SELECT %s FROM `%s` %s", $volumn, IohChineseChessBookEntity::getEntityName(), $where);
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['chess_id']] = $row;
        }
        $result->free();
        return $data;
    }

    /**
     * 棋子变更
     *
     * @param int $game_id 游戏ID
     * @param int $chess_id 棋子ID
     * @param array $update_data 变更内容
     * @return boolean
     */
    public static function update($game_id, $chess_id, $update_data)
    {
        $dbi = Database::getInstance();
        $where = sprintf("`game_id` = %s AND `chess_id` = %s", $dbi->quote($game_id), $dbi->quote($chess_id));
        $result = $dbi->update(IohChineseChessBookEntity::getEntityName(), $update_data, $where);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    /**
     * 发起一局游戏
     *
     * @param int $game_id 游戏ID
     * @return boolean
     */
    public static function insert($game_id)
    {
        $dbi = Database::getInstance();
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 1,
            'cols_num' => 9,
            'rows_num' => 4,
            'group' => 0,
            'value' => 0,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 2,
            'cols_num' => 0,
            'rows_num' => 4,
            'group' => 1,
            'value' => 0,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 3,
            'cols_num' => 9,
            'rows_num' => 3,
            'group' => 0,
            'value' => 1,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 4,
            'cols_num' => 0,
            'rows_num' => 3,
            'group' => 1,
            'value' => 1,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 5,
            'cols_num' => 9,
            'rows_num' => 5,
            'group' => 0,
            'value' => 1,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 6,
            'cols_num' => 0,
            'rows_num' => 5,
            'group' => 1,
            'value' => 1,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 7,
            'cols_num' => 9,
            'rows_num' => 2,
            'group' => 0,
            'value' => 2,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 8,
            'cols_num' => 0,
            'rows_num' => 2,
            'group' => 1,
            'value' => 2,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 9,
            'cols_num' => 9,
            'rows_num' => 6,
            'group' => 0,
            'value' => 2,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 10,
            'cols_num' => 0,
            'rows_num' => 6,
            'group' => 1,
            'value' => 2,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 11,
            'cols_num' => 9,
            'rows_num' => 1,
            'group' => 0,
            'value' => 3,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 12,
            'cols_num' => 0,
            'rows_num' => 1,
            'group' => 1,
            'value' => 3,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 13,
            'cols_num' => 9,
            'rows_num' => 7,
            'group' => 0,
            'value' => 3,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 14,
            'cols_num' => 0,
            'rows_num' => 7,
            'group' => 1,
            'value' => 3,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 15,
            'cols_num' => 9,
            'rows_num' => 0,
            'group' => 0,
            'value' => 4,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 16,
            'cols_num' => 0,
            'rows_num' => 0,
            'group' => 1,
            'value' => 4,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 17,
            'cols_num' => 9,
            'rows_num' => 8,
            'group' => 0,
            'value' => 4,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 18,
            'cols_num' => 0,
            'rows_num' => 8,
            'group' => 1,
            'value' => 4,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 19,
            'cols_num' => 7,
            'rows_num' => 1,
            'group' => 0,
            'value' => 5,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 20,
            'cols_num' => 2,
            'rows_num' => 1,
            'group' => 1,
            'value' => 5,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 21,
            'cols_num' => 7,
            'rows_num' => 7,
            'group' => 0,
            'value' => 5,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 22,
            'cols_num' => 2,
            'rows_num' => 7,
            'group' => 1,
            'value' => 5,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 23,
            'cols_num' => 6,
            'rows_num' => 0,
            'group' => 0,
            'value' => 6,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 24,
            'cols_num' => 3,
            'rows_num' => 0,
            'group' => 1,
            'value' => 6,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 25,
            'cols_num' => 6,
            'rows_num' => 2,
            'group' => 0,
            'value' => 6,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 26,
            'cols_num' => 3,
            'rows_num' => 2,
            'group' => 1,
            'value' => 6,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 27,
            'cols_num' => 6,
            'rows_num' => 4,
            'group' => 0,
            'value' => 6,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 28,
            'cols_num' => 3,
            'rows_num' => 4,
            'group' => 1,
            'value' => 6,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 29,
            'cols_num' => 6,
            'rows_num' => 6,
            'group' => 0,
            'value' => 6,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 30,
            'cols_num' => 3,
            'rows_num' => 6,
            'group' => 1,
            'value' => 6,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 31,
            'cols_num' => 6,
            'rows_num' => 8,
            'group' => 0,
            'value' => 6,
            'disp_flg' => 1
        );
        $insert_data[] = array(
            'game_id' => $game_id,
            'chess_id' => 32,
            'cols_num' => 3,
            'rows_num' => 8,
            'group' => 1,
            'value' => 6,
            'disp_flg' => 1
        );
        foreach ($insert_data as $data_one) {
            $result = $dbi->insert(IohChineseChessBookEntity::getEntityName(), $data_one);
            if ($dbi->isError($result)) {
                $result->setPos(__FILE__, __LINE__);
                return $result;
            }
        }
        return true;
    }
}
?>