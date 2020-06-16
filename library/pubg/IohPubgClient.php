<?php

/**
 * 绝地求生API数据获取
 */
class IohPubgClient
{
    private $_base_url = "https://api.pubg.com/shards/";
    private $_season_id = "division.bro.official.pc-2018-07";

    private function __construct($shard)
    {
        $this->_base_url .= $shard;
    }

    private function _getRequest($param, $auth_flg = false)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->_base_url . $param);
        //curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
        //curl_setopt($curl, CURLOPT_SSLVERSION, 3);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        $headers = array();
        $headers[] = "Accept: application/vnd.api+json";
        if ($auth_flg) {
            $headers[] = "Authorization: Bearer " . PUBG_ACCESS_KEY;
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $request_context = curl_exec($curl);
        $json_result = json_decode($request_context, true);
        if ($json_result == null) {
            $err_message = curl_errno($curl) . ": " . curl_error($curl);
            $err = Error::getInstance();
            $err->raiseError(ERROR_CODE_API_GET_FALSIFY, $err_message);
            return $err;
        }
        curl_close($curl);
        return $json_result;
    }

    public static function getInstance($shard = "steam")
    {
        return new IohPubgClient($shard);
    }

    /**
     * 获取角色信息(角色名)
     */
    public function getPlayersByNames($param)
    {
        if (!is_array($param)) {
            $param = array($param);
        }
        return $this->_getRequest("/players?filter[playerNames]=" . implode(",", $param), true);
    }

    /**
     * 获取赛季休闲统计
     */
    public function getPlayerSeasonStats($account_id)
    {
        return $this->_getRequest("/players/" . $account_id . "/seasons/" . $this->_season_id, true);
    }

    /**
     * 获取赛季天梯统计
     */
    public function getPlayerRankedStats($account_id)
    {
        return $this->_getRequest("/players/" . $account_id . "/seasons/" . $this->_season_id . "/ranked", true);
    }

    /**
     * 获取生涯统计
     */
    public function getPlayerLifetime($account_id)
    {
        return $this->_getRequest("/players/" . $account_id . "/seasons/lifetime", true);
    }
}
?>