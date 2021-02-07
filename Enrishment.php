<?php 
require 'vendor/autoload.php';
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
$redirect_url = $_GET["redirect_url"];
$ip = $_GET["ip"];

 
 $httpClient = new Client();
$data =array(
    'login' => 'kademia',
    'password' => 'kfGBXFcc5MtZaKg2');
$response = $httpClient->get(
    'https://billing.virgopass.com/enrichment.php?service=enrichment&login=kademia&password=kfGBXFcc5MtZaKg2&service_id='.$service_id.'&redirect_url='.$redirect_url.'&ip='.$ip,
    [
        'form_params' =>$data ,
        RequestOptions::HEADERS => [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ],
    ]
);

     $result = str_replace(' ', '', $response->getBody()->getContents())  ;
if (strpos($result, 'rid')  == true) {
    echo(get_string_between($result,"rid=","&mno"));
 $result=get_string_between($result,"rid=","&mno");
}
return $result;
?>