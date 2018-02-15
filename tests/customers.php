<?php

require_once '../vendor/autoload.php';

if(empty(session_id())) session_start();

$lib = new \Library\Lib(array(
  'apiKey' => 'XXXX',
  'secretKey' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
  'redirectUri' => 'http://example.com',
));

$randNo = rand('10', '99');
$attributes = [
    "name" => "TestDemo ".$randNo,
    "email" => "test_demo".$randNo."@example.com",
    "address_type" => 1,
    "address" => "address",
    "postal_code" => "456584",
    "city" => "city",
    "country" => "42",
];

$result = $lib->customers()->all();

echo "<pre>"; print_r($result); die;
