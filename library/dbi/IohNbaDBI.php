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
}
?>