<?php

/**
 * 绝地求生API数据获取
 */
class IohPubgClient
{
    private $_base_url = "https://api.pubg.com/shards/";

    private function __construct($shard)
    {
        $this->_base_url .= $shard;
    }

    private function getRequest($param)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->_base_url . $param);
        //curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
        //curl_setopt($curl, CURLOPT_SSLVERSION, 3);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Accept: application/vnd.api+json",
            "Authorization: Bearer " . PUBG_ACCESS_KEY
        ));
        $request_context = curl_exec($curl);
        curl_close($curl);
        return $request_context;
    }
}
?>