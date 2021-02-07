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
 $service_id = $_GET["service_id"] ;
 $session_id = $_GET["session_id"] ;
 $email=$_GET["email"];
 $msisdn=$_GET["msisdn"];
$str = str_replace($msisdn, "+".$msisdn, $msisdn);
$stri = str_replace("+ ", "+", $str);
 $httpClient = new Client();
$data =array(
    'login' => 'kademia',
    'password' => 'kfGBXFcc5MtZaKg2');
$response = $httpClient->post(
    'https://billing.virgopass.com/api_v1.5.php?getToken=1&service_id='.$service_id.'&session_id='.$session_id,
    [
        'form_params' =>$data ,
        RequestOptions::HEADERS => [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ],
    ]
);

 
     $string = str_replace(' ', '', $response->getBody()->getContents())  ;
if (strpos($string, 'token')  == true) {
    $data =array(
        'token' => get_string_between($string,"token:","expiration_date"),
        'email' => $email,
        'msisdn' => $stri
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
}

?>
