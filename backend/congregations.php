<?php
include('config.php');

echo json_encode([
    'success' => true,
    'congregations' => $congregations
]);
