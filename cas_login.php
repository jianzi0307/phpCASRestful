<?php
/**
 * @see https://wiki.jasig.org/display/casum/restful+api
 */
require_once 'inc/httpclient/httpclient.inc.php';
use hightman\http\Client;
use hightman\http\Request;
use hightman\http\Response;

$http = new Client();
$http->setHeader('Content-type', 'application/x-www-form-urlencoded');
$http->setHeader('Accept', 'text/plain');


$service = 'http://baidu.com';

$host = 'http://127.0.0.1:8080';
$data = array(
    'username' => 'jianzi',
    'password' => '111111'
);
$response = $http->post($host . '/cas/v1/tickets', $data);
if (!$response->hasError()) {
   //var_dump($response->body);
   //var_dump($response->status); 
   //var_dump($response->getHeader());
   if ($response->status == 201) {
       $header = $response->getHeader();
       $location = $header['location'];
       $data = array(
           'service' => $service
           //'service' => urlencode('http://a.com')
       );
       $path = parse_url($location, PHP_URL_PATH);
       echo $path.PHP_EOL;
       $response2 = $http->post($host . $path, $data);
       $status = $response2->status;
       if ($status == 400) {
           echo "400 Application Not Authorized to Use CAS";
       } else if ($status == 415) {
           echo "415 Unsupported Media Type";
       } else if ($status == 200) {
          $st = trim($response2->body);
           echo 'ST: ' . $st . PHP_EOL;

          //check service ticket
          //------------------------
          $data = array(
              'service' => $service, //Service
              'ticket' => $st //ST-Ticket
          );
          $queryStr = http_build_query($data);
          $response = $http->get($host . '/cas/serviceValidate?' . $queryStr);
          if (!$response->hasError()) {
             if ($response->status == 200) {
              $validateXML = simplexml_load_string($response->body, null, 0, 'cas', true);
              //var_dump(property_exists($validateXML, 'authenticationSuccess'));
              //var_dump(property_exists($validateXML, 'authenticationFailure'));die;
              if (property_exists($validateXML, 'authenticationSuccess')) {
                $user = $validateXML->authenticationSuccess[0]->user;
                echo '> user: ' . trim($user);
              } else {
                echo '>' . trim($validateXML->authenticationFailure[0]);
              }
             } else {
              //var_dump($response->body);
              //var_dump($response->status); 
              //var_dump($response->getHeader());
                echo "error.";
             }
          }
          //------------------------
       }
   } else if ($response->status == 400) {
       echo "400 Bad Request error";
   } else if ($response->status == 415) {
       echo "415 Unsupported Media Type";
   } 
}
