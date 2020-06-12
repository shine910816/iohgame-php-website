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

$curl_command = 'curl -X GET "https://api.pubg.com/shards/steam/players?filter[playerNames]=Kinsama" -H "accept: application/vnd.api+json" -H "Authorization: Bearer ' . PUBG_ACCESS_KEY . '"';
$output_array = array();
exec($curl_command, $output_array);
$res = json_decode(implode("", $output_array), true);
Utility::testVariable($res);
?>