<?php

/**
 * 数据库操作类-g_sgsgz_card_*
 * @author Kinsama
 * @version 2019-01-22
 */
class IohSgsgzCardDBI
{
    public static function selectCardType()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM g_sgsgz_card_type WHERE del_flg = 0";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["card_type"]][$row["card_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectCard()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM g_sgsgz_card WHERE del_flg = 0";
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

    public static function updateCard($c_id, $update)
    {
        $dbi = Database::getInstance();
        $result = $dbi->update("g_sgsgz_card", $update, "c_id = " . $c_id);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>