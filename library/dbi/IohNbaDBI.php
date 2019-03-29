<?php

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

    public static function getTeamGroupList($group = "0")
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM g_nba_team WHERE del_flg = 0 ORDER BY t_name_short ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            if ($group == "1") {
                $data[$row['t_conference']][$row['t_id']] = $row;
            } elseif ($group == "2") {
                $data[$row['t_division']][$row['t_id']] = $row;
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

    public static function insertSchedule($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("g_nba_schedule", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function selectGamePeriodGroupByDate($play_season)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT game_date, MIN(game_start_date) AS first_start_time, MAX(game_start_date) AS last_start_date" .
               " FROM g_nba_schedule WHERE del_flg = 0 AND game_season = " . $play_season ." GROUP BY game_date";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["game_date"]] = array(
                "from_time" => strtotime($row["first_start_time"]),
                "to_time" => strtotime($row["last_start_date"]) + 2.5 * 3600
            );
        }
        $result->free();
        return $data;
    }
}
?>