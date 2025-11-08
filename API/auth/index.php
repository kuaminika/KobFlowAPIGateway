<?php
// remove comments for dev mode
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once dirname(__FILE__)."/../../K_Utilities/_requireAll.php";

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
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
$googleClientId = "192547503034-j23mcmi5bvae13g1dl04ssav6c5tpau4.apps.googleusercontent.com";
// Get action from URL path via .htaccess
$action = $_GET['action'] ?? '';
$provider = $_GET['provider'] ?? '';
$gtv = new GoogleTokenVerifier($googleClientId);
$input = json_decode(file_get_contents('php://input'), true);


echo input;

//$res= $gtv->verify("eyJhbGciOiJSUzI1NiIsImtpZCI6IjRmZWI0NGYwZjdhN2UyN2M3YzQwMzM3OWFmZjIwYWY1YzhjZjUyZGMiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJodHRwczovL2FjY291bnRzLmdvb2dsZS5jb20iLCJhenAiOiIxOTI1NDc1MDMwMzQtajIzbWNtaTVidmFlMTNnMWRsMDRzc2F2NmM1dHBhdTQuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJhdWQiOiIxOTI1NDc1MDMwMzQtajIzbWNtaTVidmFlMTNnMWRsMDRzc2F2NmM1dHBhdTQuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJzdWIiOiIxMDA4NzI1MzI0ODM5OTQyMjg0MjQiLCJlbWFpbCI6Imt1YW1pbmlrYUBnbWFpbC5jb20iLCJlbWFpbF92ZXJpZmllZCI6dHJ1ZSwibmJmIjoxNzYyNTc4NzcwLCJuYW1lIjoiSGVybWFuIEQiLCJwaWN0dXJlIjoiaHR0cHM6Ly9saDMuZ29vZ2xldXNlcmNvbnRlbnQuY29tL2EvQUNnOG9jS3loaExGdWVhaFNRYmhMcFc1azNMMndpcmhOQkE0UXBmNUVaVzhwNklteW5JOUx4Zz1zOTYtYyIsImdpdmVuX25hbWUiOiJIZXJtYW4iLCJmYW1pbHlfbmFtZSI6IkQiLCJpYXQiOjE3NjI1NzkwNzAsImV4cCI6MTc2MjU4MjY3MCwianRpIjoiYzE1NGUyNWUzMGUxYmMxM2M4YzA0MThjYTI2N2VlYzU0MmU5Y2RmYSJ9.r6lTUH5z9Ht6YrtI-8lFKT79NQaBZFthz5Mc8apoY6XyexcEPe6q6QY247e1iXFlH9xtjb-CPtZKHI8LCaJc7_YTqIJAo4Rhw5sEEDEqzoG6rBmSaC5z-ueu7ksfZUmdU41b0Z1tOrJreZT2i_KEAMZrlefyTlj_C_vckhvnfHZcUatXqasMq-9q70X8jLWUAD7K9EUb59hhu2PS-inaPRNa6qLgvNqPmV10mCWe2vrsuYVA0cOa8kYKY4PvrRyQAAvo_9q3gaYIxwwxLVVQHZ_zw8yIOWNOmNzsyTt8LeRHnbloXTuyirJ1JNsW1u1eLHUUB81wP8Fb90p1G8mT7w");
//echo "$provider/$action";
//echo json_encode($res);