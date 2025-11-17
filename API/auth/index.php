<?php
// remove comments for dev mode
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once dirname(__FILE__)."/../../K_Utilities/_requireAll.php";
use K_Utilities\KCurlTool;
// api/auth/index.php
// header('Content-Type: application/json');
// header("Access-Control-Allow-Origin: *");
// header('Access-Control-Allow-Methods: POST, OPTIONS, GET');
// header('Access-Control-Allow-Headers: Content-Type');


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle preflight (OPTIONS)
// if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
//     http_response_code(200);
//     exit;
// }
$googleClientId = "192547503034-j23mcmi5bvae13g1dl04ssav6c5tpau4.apps.googleusercontent.com";
// Get action from URL path via .htaccess
$action = $_GET['action'] ?? '';
$provider = $_GET['provider'] ?? '';
$gtv = new GoogleTokenVerifier($googleClientId);
$input = json_decode(file_get_contents('php://input'), true);

//echo $googleClientId;
//echo json_encode($input);

$res= $gtv->verify($input["id_token"]);
//echo "$provider/$action";
$res["input"] = $input;
//echo json_encode($res);

$port = 5038;
$data = $res["payload"];

$curlTool = new KCurlTool();
 $data = $curlTool->executePost("http://localhost:$port/api/findOrCreateUser",$data);
       
 echo json_encode($data);