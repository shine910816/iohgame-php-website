<?php
/**
 * 系统主目录
 */
define("SRC_PATH", str_replace("\\", "/", __DIR__));
require_once SRC_PATH . "/library/ActionBase.php";
require_once SRC_PATH . "/library/Config.php";
require_once SRC_PATH . "/library/Controller.php";
require_once SRC_PATH . "/library/Database.php";
require_once SRC_PATH . "/library/Error.php";
require_once SRC_PATH . "/library/Utility.php";
require_once SRC_PATH . "/library/Init.php";
require_once SRC_PATH . "/library/Launcher.php";
require_once SRC_PATH . "/library/Request.php";
require_once SRC_PATH . "/library/Rule.php";
require_once SRC_PATH . "/library/Translate.php";
require_once SRC_PATH . "/library/User.php";
require_once SRC_PATH . "/library/Validate.php";
require_once SRC_PATH . "/library/View.php";
date_default_timezone_set(DATE_DEFAULT_TIMEZONE);
mb_internal_encoding("UTF-8");
$controller = Controller::getInstance();
$user = User::getInstance();
$request = Request::getInstance();
$launcher = Launcher::getInstance();
//$launcher->start($controller, $user, $request, true);

function getPubgJson($service)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://api.pubg.com/shards/steam" . $service);
//    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
//    curl_setopt($curl, CURLOPT_SSLVERSION, 3);
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

$res = getPubgJson("/players?filter[playerNames]=Kinsama");
Utility::testVariable($res);
//Utility::testVariable(json_decode($res, true));
?>