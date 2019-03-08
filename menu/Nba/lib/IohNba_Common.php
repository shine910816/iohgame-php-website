<?php
class IohNba_Common
{
    public function getStandings()
    {
        $url = "http://data.nba.net/10s/prod/v1/current/standings_all.json";
        $json_array = Utility::transJson($url);
        if (Error::isError($json_array)) {
            $json_array->setPos(__FILE__, __LINE__);
            return $json_array;
        }
        $json_teams = $json_array["league"]["standard"]["teams"];
        $result = array();
        foreach ($json_teams as $json_info) {
            $result[$json_info["teamId"]] = $json_info;
        }
        return $result;
    }

    public function getPlayers($team_group_flg = false)
    {
        $url = "http://data.nba.net/10s/prod/v1/2018/players.json";
        $json_array = Utility::transJson($url);
        if (Error::isError($json_array)) {
            $json_array->setPos(__FILE__, __LINE__);
            return $json_array;
        }
        $json_teams = $json_array["league"]["standard"];
        $result = array();
        foreach ($json_teams as $json_info) {
            if ($team_group_flg) {
                if (!isset($result[$json_info["teamId"]])) {
                    $result[$json_info["teamId"]] = array();
                }
                $result[$json_info["teamId"]][$json_info["personId"]] = $json_info;
            } else {
                $result[$json_info["personId"]] = $json_info;
            }
        }
        return $result;
    }
}
?>