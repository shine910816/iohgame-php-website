<?php

/**
 * 数据库操作类-g_nba_boxscore
 * @author Kinsama
 * @version 2019-04-01
 */
class IohNbaStatsDBI
{

    public static function selectLatestGameDate()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT game_season, game_season_stage, game_date, COUNT(*) AS player_count" .
               " FROM g_nba_boxscore WHERE del_flg = 0 GROUP BY game_date ORDER BY game_date DESC";
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
        if (empty($data)) {
            return array(
                "game_season" => "2018",
                "game_season_stage" => "1",
                "game_date" => "20180928",
                "player_count" => "0"
            );
        }
        return $data[0];
    }

    public static function selectDailyPlayerLeader($game_date, $option)
    {
        $dbi = Database::getInstance();
        $option_list = array(
            "pts" => "g_points",
            "reb" => "g_rebounds",
            "ast" => "g_assists",
            "stl" => "g_steals",
            "blk" => "g_blocks"
        );
        $sql = "SELECT p_id, t_id, " . $option_list[$option] . " AS value FROM g_nba_boxscore" .
               " WHERE game_date = " . $game_date . " AND del_flg = 0" .
               " ORDER BY " . $option_list[$option] . " DESC, g_sort DESC";
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

    public static function selectSeasonStats($game_season, $game_season_stage)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT p_id, t_id," .
               " COUNT(*) AS game_played," .
               " SUM(g_points) AS pts," .
               " SUM(g_rebounds) AS reb," .
               " SUM(g_assists) AS ast," .
               " SUM(g_steals) AS stl," .
               " SUM(g_blocks) AS blk," .
               " SUM(g_sort) AS sort" .
               " FROM g_nba_boxscore WHERE del_flg = 0" .
               " AND game_season = " . $game_season . " AND game_season_stage = " . $game_season_stage .
               " GROUP BY p_id";
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
}
?>