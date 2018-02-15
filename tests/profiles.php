<?php

require_once '../vendor/autoload.php';

if(empty(session_id())) session_start();

$lib = new \Library\Lib(array(
    'apiKey' => '45645s65df4s65d4s54',
    'secretKey' => '45645s65df4s65d4s54sdfssfd',
    'redirectUri' => '/',
));

$attributes = [
    'first_name' => 'super',
    'last_name' => 'admin',
    'email' => 'superadmin@gmail.com',
    'address' => 'st logan',
    'city' => 'chd',
    'postal_code' => '1456561',
    'telephone_number' => '1564654211',
];

$result = $lib->profiles()->create($attributes);

echo "<pre>"; print_r($result); die;
