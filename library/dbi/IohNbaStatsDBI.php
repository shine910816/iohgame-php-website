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
        $sql = "SELECT b.game_season, b.game_season_stage, b.game_date, s.game_date_cn, COUNT(*) AS player_count" .
               " FROM g_nba_boxscore b LEFT OUTER JOIN g_nba_schedule s ON s.game_id = b.game_id" .
               " WHERE b.del_flg = 0 AND s.del_flg = 0 GROUP BY s.game_date_cn ORDER BY s.game_date_cn DESC";
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
                "game_date_cn" => "20180929",
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
        $sql = "SELECT b.p_id, b.t_id, b." . $option_list[$option] . " AS `value`" .
               " FROM g_nba_boxscore b LEFT OUTER JOIN g_nba_schedule s ON s.game_id = b.game_id" .
               " WHERE s.game_date_cn = " . $game_date . " AND b.del_flg = 0 AND s.del_flg = 0 AND b." . $option_list[$option] . " > 0" .
               " ORDER BY b." . $option_list[$option] . " DESC, b.g_sort DESC";
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
               " SUM(g_points) AS ppg," .
               " SUM(g_rebounds) AS rpg," .
               " SUM(g_assists) AS apg," .
               " SUM(g_steals) AS spg," .
               " SUM(g_blocks) AS bpg," .
               " SUM(g_field_goals_made) AS fgm," .
               " SUM(g_field_goals_attempted) AS fga," .
               " SUM(g_three_points_made) AS tpm," .
               " SUM(g_three_points_attempted) AS tpa," .
               " SUM(g_free_throw_made) AS ftm," .
               " SUM(g_free_throw_attempted) AS fta," .
               " SUM(g_sort) AS sort" .
               " FROM g_nba_boxscore WHERE del_flg = 0" .
               " AND t_id >= 1610612737 AND t_id <= 1610612766" .
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

    public static function selectTeamGamePlayed($game_season, $game_season_stage)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT t_id, game_id, COUNT(*) AS player_count FROM g_nba_boxscore WHERE game_season = " . $game_season .
               " AND game_season_stage = " . $game_season_stage . " AND del_flg = 0 GROUP BY t_id, game_id ORDER BY t_id";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $tmp_data = array();
        while ($row = $result->fetch_assoc()) {
            $tmp_data[$row["t_id"]][$row["game_id"]] = $row["player_count"];
        }
        $result->free();
        $data = array();
        foreach ($tmp_data as $t_id => $game_id_list) {
            $data[$t_id] = count($game_id_list);
        }
        return $data;
    }

    public static function selectTeamSeasonStats($game_season, $game_season_stage)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT t_id," .
               " SUM(g_points) AS pts," .
               " SUM(g_field_goals_made) AS fgm," .
               " SUM(g_field_goals_attempted) AS fga," .
               " SUM(g_three_points_made) AS tpm," .
               " SUM(g_three_points_attempted) AS tpa," .
               " SUM(g_free_throw_made) AS ftm," .
               " SUM(g_free_throw_attempted) AS fta," .
               " SUM(g_rebounds) AS reb," .
               " SUM(g_offensive_rebounds) AS off," .
               " SUM(g_defensive_rebounds) AS def," .
               " SUM(g_assists) AS ast," .
               " SUM(g_steals) AS stl," .
               " SUM(g_blocks) AS blk," .
               " SUM(g_turnovers) AS `to`," .
               " SUM(g_personal_fouls) AS pf" .
               " FROM g_nba_boxscore" .
               " WHERE game_season = " . $game_season . " AND game_season_stage = " . $game_season_stage .
               " GROUP BY t_id";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["t_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectPlayerSeasonStats($p_id, $game_season, $game_season_stage)
    {
        $dbi = Database::getInstance();
        if (!is_array($p_id)) {
            $p_id = array($p_id);
        }
        $sql = "SELECT p_id," .
               " COUNT(*) AS gp," .
               " SUM(g_minutes) AS min," .
               " SUM(g_minutes_sec) AS sec," .
               " SUM(g_points) AS pts," .
               " SUM(g_field_goals_made) AS fgm," .
               " SUM(g_field_goals_attempted) AS fga," .
               " SUM(g_three_points_made) AS tpm," .
               " SUM(g_three_points_attempted) AS tpa," .
               " SUM(g_free_throw_made) AS ftm," .
               " SUM(g_free_throw_attempted) AS fta," .
               " SUM(g_rebounds) AS reb," .
               " SUM(g_offensive_rebounds) AS off," .
               " SUM(g_defensive_rebounds) AS def," .
               " SUM(g_assists) AS ast," .
               " SUM(g_steals) AS stl," .
               " SUM(g_blocks) AS blk," .
               " SUM(g_turnovers) AS `to`," .
               " SUM(g_personal_fouls) AS pf," .
               " SUM(g_plus_minus) AS pm" .
               " FROM g_nba_boxscore" .
               " WHERE game_season = " . $game_season . " AND game_season_stage = " . $game_season_stage .
               " AND p_id IN (" . implode(", ", $p_id) .
               ") AND del_flg = 0" .
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

    public static function selectPlayerGameStart($p_id, $game_season, $game_season_stage)
    {
        $dbi = Database::getInstance();
        if (!is_array($p_id)) {
            $p_id = array($p_id);
        }
        $sql = "SELECT p_id, COUNT(*) FROM g_nba_boxscore WHERE game_season = " . $game_season .
               " AND game_season_stage = " . $game_season_stage . " AND del_flg = 0" .
               " AND p_id IN (" . implode(", ", $p_id) . ") AND g_position > 0" .
               " GROUP BY p_id";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["p_id"]] = $row["COUNT(*)"];
        }
        $result->free();
        return $data;
    }

    public static function selectPlayerDoubleDouble($p_id, $game_season, $game_season_stage)
    {
        $dbi = Database::getInstance();
        if (!is_array($p_id)) {
            $p_id = array($p_id);
        }
        $sql = "SELECT p_id, COUNT(*) FROM g_nba_boxscore WHERE game_season = " . $game_season .
               " AND game_season_stage = " . $game_season_stage . " AND del_flg = 0" .
               " AND p_id IN (" . implode(", ", $p_id) . ") AND g_double_double = 1" .
               " GROUP BY p_id";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["p_id"]] = $row["COUNT(*)"];
        }
        $result->free();
        return $data;
    }

    public static function selectPlayerTribleDouble($p_id, $game_season, $game_season_stage)
    {
        $dbi = Database::getInstance();
        if (!is_array($p_id)) {
            $p_id = array($p_id);
        }
        $sql = "SELECT p_id, COUNT(*) FROM g_nba_boxscore WHERE game_season = " . $game_season .
               " AND game_season_stage = " . $game_season_stage . " AND del_flg = 0" .
               " AND p_id IN (" . implode(", ", $p_id) . ") AND g_triple_double = 1" .
               " GROUP BY p_id";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["p_id"]] = $row["COUNT(*)"];
        }
        $result->free();
        return $data;
    }

    // TODO Remove this function
    public static function selectSeasonTeamPlayerStats($p_id, $t_id, $game_season, $game_season_stage)
    {
        $dbi = Database::getInstance();
        $column_list = implode(", ", array(
            "p_id",
            "COUNT(*) AS gp",
            "SUM(g_minutes) AS min",
            "SUM(g_minutes_sec) AS min_s",
            "SUM(g_points) AS pts",
            "SUM(g_field_goals_made) AS fgm",
            "SUM(g_field_goals_attempted) AS fga",
            "SUM(g_three_points_made) AS tpm",
            "SUM(g_three_points_attempted) AS tpa",
            "SUM(g_free_throw_made) AS ftm",
            "SUM(g_free_throw_attempted) AS fta",
            "SUM(g_rebounds) AS reb",
            "SUM(g_offensive_rebounds) AS off",
            "SUM(g_defensive_rebounds) AS def",
            "SUM(g_assists) AS ast",
            "SUM(g_steals) AS stl",
            "SUM(g_blocks) AS blk",
            "SUM(g_turnovers) AS `to`",
            "SUM(g_personal_fouls) AS pf"
        ));
        if (!is_array($p_id)) {
            $p_id = array($p_id);
        }
        $where = "del_flg = 0 AND p_id IN (" . implode(", ", $p_id) . ") AND t_id = " . $t_id;
        $where .= " AND game_season = " . $game_season;
        $where .= " AND game_season_stage = " . $game_season_stage;
        $sql = "SELECT " . $column_list . " FROM g_nba_boxscore WHERE " . $where . " GROUP BY p_id";
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

    public static function selectLeaderStats($game_season, $game_season_stage, $is_team_flg = false)
    {
        $dbi = Database::getInstance();
        $select_column = array("g_ppg", "g_rpg", "g_apg", "g_spg", "g_bpg");
        $where = "del_flg = 0 AND game_stats_type = ";
        if ($is_team_flg) {
            $where .= "2";
        } else {
            $where .= "1";
        }
        $column_list = implode(", ", $select_column);
        $where .= " AND game_season = " . $game_season . " AND game_season_stage = " . $game_season_stage;
        $sql = "SELECT " . $column_list . " FROM g_nba_stats WHERE " . $where;
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
        if (count($data) == 1) {
            return $data[0];
        } else {
            $emp_data = array();
            foreach ($select_column as $column_text) {
                $emp_data[$column_text] = 10;
            }
            return $emp_data;
        }
    }

    public static function selectGameDetailBoxscore($game_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM g_nba_boxscore WHERE game_id = " . $game_id .
               " AND del_flg = 0 ORDER BY t_id ASC, g_position DESC, g_minutes DESC, g_minutes_sec DESC, g_sort DESC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["t_id"]][$row["p_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectTeamPastPlayed($t_id, $last_year)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT game_season_stage, game_season, COUNT(*) AS game_played FROM g_nba_schedule" .
               " WHERE game_season > " . ($last_year - 4) . " AND game_season < " . $last_year . " AND game_season_stage != 3" .
               " AND (game_home_team = " . $t_id . " OR game_away_team = " . $t_id .
               ") AND game_status = 3 AND del_flg = 0 GROUP BY game_season_stage, game_season";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["game_season_stage"]][$row["game_season"]] = $row["game_played"];
        }
        $result->free();
        return $data;
    }

    public static function selectTeamPastStats($t_id, $last_year)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT game_season, game_season_stage," .
               " SUM(g_points) AS pts," .
               " SUM(g_field_goals_made) AS fgm," .
               " SUM(g_field_goals_attempted) AS fga," .
               " SUM(g_three_points_made) AS tpm," .
               " SUM(g_three_points_attempted) AS tpa," .
               " SUM(g_free_throw_made) AS ftm," .
               " SUM(g_free_throw_attempted) AS fta," .
               " SUM(g_rebounds) AS reb," .
               " SUM(g_offensive_rebounds) AS `off`," .
               " SUM(g_defensive_rebounds) AS def," .
               " SUM(g_assists) AS ast," .
               " SUM(g_steals) AS stl," .
               " SUM(g_blocks) AS blk," .
               " SUM(g_personal_fouls) AS pf," .
               " SUM(g_turnovers) AS `to`" .
               " FROM g_nba_boxscore WHERE game_season > " . ($last_year - 4) . " AND game_season < " . $last_year .
               " AND game_season_stage != 3 AND t_id = " . $t_id . " AND del_flg = 0" .
               " GROUP BY game_season, game_season_stage" .
               " ORDER BY game_season_stage ASC, game_season DESC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["game_season_stage"]][$row["game_season"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectTeamLeader($t_id, $game_season, $game_season_stage)
    {
        $dbi = Database::getInstance();
        if (!is_array($t_id)) {
            $t_id = array($t_id);
        }
        $sql = "SELECT t_id, p_id, COUNT(*) AS pg, SUM(g_points) AS pts," .
               " SUM(g_rebounds) AS reb, SUM(g_assists) AS ast" .
               " FROM g_nba_boxscore WHERE t_id IN (" . implode(", ", $t_id) .
               ") AND game_season = " . $game_season .
               " AND game_season_stage = " . $game_season_stage .
               " AND del_flg = 0" .
               " GROUP BY p_id ORDER BY t_id ASC, p_id ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["t_id"]][$row["p_id"]] = $row;
        }
        $result->free();
        return $data;
    }
}
?>