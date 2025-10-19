<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Accept: application/json");

$congregations = [
    ['code' => 'GRA', 'name' => 'GRA CONGREGATION'],
    ['code' => 'STADIUM', 'name' => 'STADIUM CONGREGATION'],
    ['code' => 'COLLEGE', 'name' => 'COLLEGE CONGREGATION'],
    ['code' => 'NEW', 'name' => 'NEW LAYOUT CONGREGATION'],
    ['code' => 'BANK', 'name' => 'BANK AVENUE CONGREGATION'],
];
