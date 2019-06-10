<?php

/**
 * 数据库操作类-g_nba_*
 * @author Kinsama
 * @version 2019-01-30
 */
class IohNbaDBI
{

    public static function getTeamInfo($t_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM g_nba_team WHERE del_flg = 0 AND t_id = " . $t_id;
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['t_id']] = $row;
        }
        $result->free();
        return $data;
    }

    public static function getTeamList()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM g_nba_team WHERE del_flg = 0";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['t_id']] = $row;
        }
        $result->free();
        return $data;
    }

    public static function getFranchiseTeamList($group_flg = false)
    {
        $dbi = Database::getInstance();
        $order_by_text = " ORDER BY";
        if ($group_flg) {
            $order_by_text .= " t_conference ASC, t_name_short ASC";
        } else {
            $order_by_text .= " t_name_short ASC";
        }
        $sql = "SELECT * FROM g_nba_team WHERE t_franchise_flg = 1 AND t_all_star_flg = 0 AND del_flg = 0" . $order_by_text;
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            if ($group_flg) {
                $data[$row['t_conference']][$row['t_id']] = $row;
            } else {
                $data[$row['t_id']] = $row;
            }
        }
        $result->free();
        return $data;
    }

    public static function selectPlayer($p_id)
    {
        $dbi = Database::getInstance();
        if (!is_array($p_id)) {
            $p_id = array($p_id);
        }
        $where = "del_flg = 0 AND p_id IN (" . implode(", ", $p_id) . ")";
        $sql = "SELECT * FROM g_nba_player WHERE " . $where;
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

    public static function selectStandardPlayerGroupByTeam()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM g_nba_player WHERE t_id >= 1610612737 AND t_id <= 1610612766 AND p_league = 0 AND view_flg = 1 AND del_flg = 0 ORDER BY t_id ASC, p_jersey ASC";
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

    public static function selectScheduleGamePlayed($game_date)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM g_nba_schedule" .
               " WHERE del_flg = 0 AND game_date_cn = " . $game_date .
               " ORDER BY game_start_date ASC, game_id ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["game_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function updatePlayer($p_id, $update_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->update("g_nba_player", $update_data, "p_id = " . $p_id);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function selectStandings($div_group_flg = "1")
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM g_nba_standings WHERE del_flg = 0 ORDER BY ";
        if ($div_group_flg == "1") {
            $sql .= "t_conference ASC, t_conf_rank ASC";
        } elseif ($div_group_flg == "2") {
            $sql .= "t_division ASC, t_div_rank ASC";
        } else {
            $sql .= "t_id ASC";
        }
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            if ($div_group_flg == "1") {
                $data[$row["t_conference"]][$row["t_conf_rank"]] = $row;
            } elseif ($div_group_flg == "2") {
                $data[$row["t_division"]][$row["t_div_rank"]] = $row;
            } else {
                $data[$row["t_id"]] = $row;
            }
        }
        $result->free();
        return $data;
    }

    public static function selectTeamSchedule($game_season, $t_id, $game_season_stage = 0)
    {
        $dbi = Database::getInstance();
        $where = "del_flg = 0 AND (game_home_team = " . $t_id . " OR game_away_team = " . $t_id . ") AND game_season = " . $game_season;
        if ($game_season_stage) {
            $where .= " AND game_season_stage = " . $game_season_stage . " AND game_status = 3";
        }
        $sql = "SELECT * FROM g_nba_schedule WHERE " . $where . " ORDER BY game_date ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["game_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectStandardPlayerGameStarted($p_id, $t_id, $game_season, $game_season_stage)
    {
        $dbi = Database::getInstance();
        if (!is_array($p_id)) {
            $p_id = array($p_id);
        }
        $where = "del_flg = 0 AND p_id IN (" . implode(", ", $p_id) . ") AND t_id = " . $t_id;
        $where .= " AND game_season = " . $game_season;
        $where .= " AND game_season_stage = " . $game_season_stage;
        $where .= " AND g_position > 0";
        $sql = "SELECT p_id, COUNT(*) AS game_started FROM g_nba_boxscore WHERE " . $where . " GROUP BY p_id";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["p_id"]] = $row["game_started"];
        }
        $result->free();
        return $data;
    }
}
?>