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
$TGT = 'TGT-24-pv7QL2nxgVmtjHp53bGFqqCGfl4IrjVFOJaxfNvhRpIAca-cas.t.com';
//$TGT = 'ST-17-QXp1ZN2lbCcLNbQpVJ5d-cas.t.com';
$response = $http->delete($host. '/cas/v1/tickets/'.$TGT);
//var_dump($response);
if ($response->status == 500) {
    echo "Invalid response code (" .$response->status. ") from CAS server!";
} else if ($response->status == 200) {
    echo 'ok';
}
