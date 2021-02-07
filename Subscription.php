<?php 
require 'vendor/autoload.php';
header("Access-Control-Allow-Origin: *");
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
 

$httpClient = new Client();
$token = $_POST["token"];
$email = $_POST["email"];
$msisdn = $_POST["msisdn"];

$data =array(
    'token' => $token,
    'email' => $email,
	'msisdn' => $msisdn
	);
$response = $httpClient->post(
    'https://billing.virgopass.com/api_v1.5.php?subscription=1',
    [
        'form_params' =>$data ,
        RequestOptions::HEADERS => [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ],
    ]
);


     $result =  $response->getBody() ;
	 echo($result);

?>