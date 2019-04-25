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

    public static function selectPlayerByTeamId($t_id, $league_flg = false)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM g_nba_player WHERE del_flg = 0 AND t_id = " . $t_id;
        if ($league_flg) {
            $sql .= " AND p_league = 0";
        }
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

    public static function selectScheduleGamePlayed($game_season)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT game_date, COUNT(*) AS game_number FROM g_nba_schedule WHERE del_flg = 0 AND game_season = " . $game_season . " GROUP BY game_date";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data_tmp = array();
        while ($row = $result->fetch_assoc()) {
            $game_date = $row["game_date"];
            $data_tmp[] = array(
                "game_date" => date("Ymd", mktime(0, 0, 0, substr($game_date, 4, 2), substr($game_date, 6, 2), substr($game_date, 0, 4))),
                "game_number" => $row["game_number"],
                "game_date_prev" => "",
                "game_date_next" => ""
            );
        }
        $result->free();
        $data = array();
        foreach ($data_tmp as $data_idx => $data_item) {
            $data[$data_item["game_date"]] = array(
                "game_date" => $data_item["game_date"],
                "game_number" => $data_item["game_number"],
                "game_date_prev" => $data_item["game_date_prev"],
                "game_date_next" => $data_item["game_date_next"],
            );
            if (isset($data_tmp[$data_idx - 1])) {
                $data[$data_item["game_date"]]["game_date_prev"] = $data_tmp[$data_idx - 1]["game_date"];
            }
            if (isset($data_tmp[$data_idx + 1])) {
                $data[$data_item["game_date"]]["game_date_next"] = $data_tmp[$data_idx + 1]["game_date"];
            }
        }
        return $data;
    }

    public static function selectLatestScheduleGameDate($game_date)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT game_date FROM g_nba_schedule WHERE del_flg = 0 AND game_date <= " . $game_date . " ORDER BY game_date DESC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = "";
        while ($row = $result->fetch_assoc()) {
            return $data = $row["game_date"];
            //$game_date_res = $row["game_date"];
            //$data = date("Ymd", mktime(0, 0, 0, substr($game_date_res, 4, 2), substr($game_date_res, 6, 2) + 1, substr($game_date_res, 0, 4)));
            break;
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
                $data[$row["p_id"]] = $row;
            }
        }
        $result->free();
        return $data;
    }
}
?>