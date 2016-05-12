<?php
/**
 * @see https://wiki.jasig.org/display/casum/restful+api
 */
require_once 'inc/httpclient/httpclient.inc.php';
use hightman\http\Client;
use hightman\http\Request;
use hightman\http\Response;

$http = new Client();
//$http->setHeader('Content-type', 'application/x-www-form-urlencoded');
//$http->setHeader('Accept', 'text/plain');

$host = 'http://127.0.0.1:8080';
$data = array(
    'service' => 'http://baidu.com', //Service
    'ticket' => 'ST-25-a7P09XWcwfJhsDZcx4U7-cas.t.com' //ST-Ticket
);
$response = $http->post($host . '/cas/serviceValidate', $data);

var_dump($response->body);
var_dump($response->status); 
var_dump($response->getHeader());


/**
<cas:serviceResponse xmlns:cas='http://www.yale.edu/tp/cas'>
	<cas:authenticationFailure code='INVALID_TICKET'>
		未能够识别出目标 &#039;ST-29-nWmW6JTpq2u2PeY5o73i-cas.t.com&#039;票根
	</cas:authenticationFailure>
</cas:serviceResponse>

<cas:serviceResponse xmlns:cas='http://www.yale.edu/tp/cas'>
	<cas:authenticationSuccess>
		<cas:user>jianzi</cas:user>
	</cas:authenticationSuccess>
</cas:serviceResponse>
*/
if (!$response->hasError()) {
   if ($response->status == 200) {
      echo $response->body;
   } else {
		//var_dump($response->body);
		//var_dump($response->status); 
		//var_dump($response->getHeader());
   }
}
