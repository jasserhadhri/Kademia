<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class kademia_paiement{


 $httpClient = new Client();

function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
function getToken($login,$password,$service_id,$session_id) { 
    
    $data =array(
    'login' => $login,
    'password' =>$password);
$response = $httpClient->post(
    'https://billing.virgopass.com/api_v1.5.php?getToken=1&service_id='.$service_id.'&session_id='.$session_id,
    [
        'form_params' =>$data ,
        RequestOptions::HEADERS => [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ],
    ]
);

 
     $result = str_replace(' ', '', $response->getBody()->getContents())  ;
if (strpos($result, 'token')  == true) {
    $token =get_string_between($result,"token:","expiration_date");
}
 return $token;
     
}
function subscribe($token,$email,$msisdn) {    
    
     $data =array(
    'token' => $token ,
    'email' => $email,
	'msisdn' => $msisdn,
	'mccmnc' => '60501'
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
function getEnrichement($login,$password,$service_id) {    
   if ( !empty($_SERVER['HTTP_CLIENT_IP']) ) {
  // Check IP from internet.
  $ip_adress = $_SERVER['HTTP_CLIENT_IP'];
 } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
  // Check IP is passed from proxy.
  $ip_adress = $_SERVER['HTTP_X_FORWARDED_FOR'];
 } else {
  // Get IP address from remote address.
  $ip_adress = $_SERVER['REMOTE_ADDR'];
 }
   if($ip_adress=='::1'){$ip_adress='127.0.0.1';}
  $httpClient = new Client();
 
$response = $httpClient->get(
    'https://billing.virgopass.com/enrichment.php?service=enrichment&login='.$login.'&password='.$password.'&service_id='.$service_id.'&redirect_url=https%3A%2F%2Fwww.kademia.tn%2Fconfirmation-inscription%2F&ip='.$ip_adress,
    [
        'form_params' =>$data ,
        RequestOptions::HEADERS => [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ],
    ]
);

 
     $result = str_replace(' ', '', $response->getBody()->getContents())  ;
if (strpos($result, 'rid')  == true) {
  $enrichment_id=get_string_between($result,"rid=","&mno");
}
 return $enrichment_id;  
     
}
function unsubscribe($login,$password,$subscription_id) {    
       $data =array(
     'login' => $login,
	'password' =>$password,
	'subscription_id' => $subscription_id
	);
$response = $httpClient->post(
    'https://billing.virgopass.com/api_v1.5.php?unsubscribe=1
',
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
}