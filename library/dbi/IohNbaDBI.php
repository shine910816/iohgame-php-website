<?php

class IohNbaDBI
{

    public static function getTeamList($conference = "0", $division = "0")
    {
        $dbi = Database::getInstance();
        $where = "del_flg = 0";
        if ($conference != "0") {
            $where .= " AND t_conference = " . $conference;
        }
        if ($division != "0") {
            $where .= " AND t_division = " . $division;
        }
        $sql = "SELECT * FROM g_nba_team WHERE " . $where . " ORDER BY t_name_short ASC";
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
}
?>