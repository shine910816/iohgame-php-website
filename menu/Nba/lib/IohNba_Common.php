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

    public function getDailyActivePlayersInfo()
    {
        $base_url = "http://data.nba.net/10s";
        $today_url = $base_url . "/prod/v1/today.json";
        $today_json_array = Utility::transJson($today_url);
        if (Error::isError($today_json_array)) {
            $today_json_array->setPos(__FILE__, __LINE__);
            return $today_json_array;
        }
        $current_date = $today_json_array["links"]["currentDate"];
        $game_id_list = $this->_getLastGameIdByDate($current_date);
        if (Error::isError($game_id_list)) {
            $game_id_list->setPos(__FILE__, __LINE__);
            return $game_id_list;
        }
        $active_player_info = array();
        foreach ($game_id_list["result"] as $game_id) {
            $box_score_url = "http://data.nba.net/10s/prod/v1/" . $game_id_list["date"] . "/" . $game_id . "_boxscore.json";
            $box_score_json_array = Utility::transJson($box_score_url);
            if (Error::isError($box_score_json_array)) {
                $box_score_json_array->setPos(__FILE__, __LINE__);
                return $box_score_json_array;
            }
            if (isset($box_score_json_array["stats"]["activePlayers"])) {
                foreach ($box_score_json_array["stats"]["activePlayers"] as $player_info) {
                    $active_player_info[$player_info["personId"]] = $player_info;
                }
            }
        }
        return $active_player_info;
    }

    private function _getLastGameIdByDate($play_date)
    {
        $play_date_ts = mktime(0, 0, 0, substr($play_date, 4, 2), substr($play_date, 6, 2), substr($play_date, 0, 4));
        $game_id_list = array();
        while (empty($game_id_list)) {
            $score_board_url = "http://data.nba.net/10s/prod/v1/" . date("Ymd", $play_date_ts) . "/scoreboard.json";
            $score_board_array = Utility::transJson($score_board_url);
            if (Error::isError($score_board_array)) {
                $score_board_array->setPos(__FILE__, __LINE__);
                return $score_board_array;
            }
            if ($score_board_array["numGames"] == 0) {
                $play_date_ts = mktime(0, 0, 0, date("n", $play_date_ts), date("j", $play_date_ts) - 1, date("Y", $play_date_ts));
                continue;
            }
            foreach ($score_board_array["games"] as $game_info) {
                if ($game_info["statusNum"] != 1) {
                    $game_id_list[] = $game_info["gameId"];
                }
            }
            if (empty($game_id_list)) {
                $play_date_ts = mktime(0, 0, 0, date("n", $play_date_ts), date("j", $play_date_ts) - 1, date("Y", $play_date_ts));
                continue;
            }
        }
        return array(
            "date" => date("Ymd", $play_date_ts),
            "result" => $game_id_list
        );
    }
}
?>