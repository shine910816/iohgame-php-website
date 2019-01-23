<?php

/**
 * 数据库操作类-g_sgsgz_card_*
 * @author Kinsama
 * @version 2019-01-22
 */
class IohSgsgzCardDBI
{
    public static function selectCommonCard()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT c.c_id, c.c_suit, c.c_number," .
               " c.card_id_1 AS card_id, t.card_type, t.c_equit_type," .
               " t.card_name, t.c_equit_disp, t.c_magic_delay_flg," .
               " t.c_reset_flg, c.c_horiz_flg_1 AS c_horiz_flg, t.card_descript" .
               " FROM g_sgsgz_card c LEFT OUTER JOIN g_sgsgz_card_type t ON c.card_id_1 = t.card_id" .
               " WHERE c.del_flg = 0 AND t.del_flg = 0 AND c_id < 109";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["c_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectExtendCard()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT c.c_id, c.c_suit, c.c_number," .
               " c.card_id_1 AS card_id, t.card_type, t.c_equit_type," .
               " t.card_name, t.c_equit_disp, t.c_magic_delay_flg," .
               " t.c_reset_flg, c.c_horiz_flg_1 AS c_horiz_flg, t.card_descript" .
               " FROM g_sgsgz_card c LEFT OUTER JOIN g_sgsgz_card_type t ON c.card_id_1 = t.card_id" .
               " WHERE c.del_flg = 0 AND t.del_flg = 0";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["c_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectEmperorCard()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT c.c_id, c.c_suit, c.c_number," .
               " c.card_id_2 AS card_id, t.card_type, t.c_equit_type," .
               " t.card_name, t.c_equit_disp, t.c_magic_delay_flg," .
               " t.c_reset_flg, c.c_horiz_flg_2 AS c_horiz_flg, t.card_descript" .
               " FROM g_sgsgz_card c LEFT OUTER JOIN g_sgsgz_card_type t ON c.card_id_2 = t.card_id" .
               " WHERE c.del_flg = 0 AND t.del_flg = 0";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["c_id"]] = $row;
        }
        $result->free();
        return $data;
    }
}
?>