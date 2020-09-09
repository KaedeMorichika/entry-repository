<?php

$response = [
    'title' => 'Hello, Ajax',
    'from' => 'PHP Code',
    'type' => 'json'
];

header('Content-type:application/json; charset=utf8');
echo json_encode($response);