<?php
header('Content-type: application/json');
$array = [
    'status'  => 200,
    'message' => 'OK'
];
echo json_encode($array);