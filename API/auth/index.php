<?php
// remove comments for dev mode
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once dirname(__FILE__)."/../../K_Utilities/_requireAll.php";
use K_Utilities\KCurlTool;


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$googleClientId = $_ENV["GOOGLE_CLIENT_ID"];
// Get action from URL path via .htaccess
$action = $_GET['action'] ?? '';
$provider = $_GET['provider'] ?? '';
$gtv = new GoogleTokenVerifier($googleClientId);
$input = json_decode(file_get_contents('php://input'), true);


$res= $gtv->verify($input["id_token"]);
//echo "$provider/$action";
$res["input"] = $input;
//echo json_encode($res);

$port = $_ENV["USER_SERVICE_PORT"];
$data = $res["payload"];
$data["providerUserId"] = $data["sub"];
$data["provider"]="google"; //TODO : this should not be hardcoded

$curlTool = new KCurlTool();
 $data = $curlTool->executePost("http://localhost:$port/api/findOrCreateUser",$data);
 $res["output"] =$data;     
 echo json_encode($res);