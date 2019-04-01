<?php

/**
 * 数据库操作类-g_nba_boxscore
 * @author Kinsama
 * @version 2019-04-01
 */
class IohNbaStatsDBI
{

    public static function selectLatestGameDate($play_season)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT game_date, COUNT(*) AS number FROM g_nba_boxscore WHERE game_season = " .
               $play_season . " AND del_flg = 0 GROUP BY game_date ORDER BY game_date DESC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectDailyStatsByGameData($game_date)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM g_nba_boxscore WHERE game_date = \"" . $game_date . "\" AND del_flg = 0";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["p_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectSeasonStats($game_season)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT p_id, t_id," .
               " COUNT(*) AS game_played," .
               " SUM(g_points) AS pts," .
               " SUM(g_offensive_rebounds) AS off," .
               " SUM(g_defensive_rebounds) AS def," .
               " SUM(g_assists) AS ast" .
               " FROM g_nba_boxscore WHERE del_flg = 0" .
               " AND game_season = " . $game_season . " GROUP BY p_id, t_id";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["p_id"]][$row["t_id"]] = $row;
        }
        $result->free();
        return $data;
    }
}
?>