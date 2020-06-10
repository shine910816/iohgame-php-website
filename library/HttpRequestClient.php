<?php
require_once SRC_PATH . "/driver/guzzle-6.5/src/Client.php";

/**
 * HTTP请求
 */
class HttpRequestClient
{
    private $_client;

    public function __construct()
    {
        $this->_client = new \GuzzleHttp\Client(array(
            "base_uri" => "https://api.pubg.com/shards/steam/",
            "headers" => array(
                "Authorization" => "Bearer " . PUBG_ACCESS_KEY,
                "Accept" => "application/vnd.api+json"
            )
        ));
    }

    public function request()
    {
        return $this->client->get("players?filter[playerNames]=Kinsama");
    }

    public static function getInstance()
    {
        return new HttpRequestClient();
    }
}
?>