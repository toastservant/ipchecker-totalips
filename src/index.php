<?php
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");
require('functions.inc.php');

$response = array(
  "error" => false,
  "message" => "Total IPs calculated.",
  "data" => array(
    "items" => array(),
    "total_ips" => 0
  )
);

$statusCode = 200;
$itemsRaw = $_REQUEST['items'] ?? null;

if ($itemsRaw === null) {
  $response['error'] = true;
  $response['message'] = "Missing required 'items' parameter.";
  $response['data'] = null;
  $statusCode = 400;
} elseif (!is_string($itemsRaw)) {
  $response['error'] = true;
  $response['message'] = "The 'items' parameter must be provided as a string.";
  $response['data'] = null;
  $statusCode = 400;
} elseif (trim($itemsRaw) === "") {
  $response['error'] = true;
  $response['message'] = "The 'items' parameter cannot be empty.";
  $response['data'] = null;
  $statusCode = 400;
} else {
  $items = parseItems($itemsRaw);
  $total_ips = getTotalIPs($items);
  $response['data']['items'] = $items;
  $response['data']['total_ips'] = $total_ips;
}

$json = json_encode($response);

if ($json === false || json_last_error() !== JSON_ERROR_NONE) {
  http_response_code(500);
  echo '{"error":true,"message":"Failed to encode response.","data":null}';
  exit();
}

http_response_code($statusCode);
echo $json;
exit();
