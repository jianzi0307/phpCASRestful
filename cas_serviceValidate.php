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
    'ticket' => 'ST-31-eygQrqfyRdOQJ1MYTzSf-cas.t.com' //ST-Ticket
);
$queryStr = http_build_query($data);
$response = $http->get($host . '/cas/serviceValidate?' . $queryStr);

//var_dump($response->body);
//var_dump($response->status); 
//var_dump($response->getHeader());


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
		$validateXML = simplexml_load_string($response->body, null, 0, 'cas', true);
		//var_dump(property_exists($validateXML, 'authenticationSuccess'));
		//var_dump(property_exists($validateXML, 'authenticationFailure'));die;
		if (property_exists($validateXML, 'authenticationSuccess')) {
			$user = $validateXML->authenticationSuccess[0];
			echo $user;
		} else {
			echo trim($validateXML->authenticationFailure[0]);
		}
   } else {
		//var_dump($response->body);
		//var_dump($response->status); 
		//var_dump($response->getHeader());
   		echo "error.";
   }
}
