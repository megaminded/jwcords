<?php
include('config.php');
include('db.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['congregation']) || empty($_POST['name']) || empty($_POST['publishers'])) {
        echo json_encode([
            'success' => false,
            'message' => "Please enter Congregation, name and publishers record"
        ]);
    } else {
        $db = new DBConnection();
        $data['congregation'] = $_POST['congregation'];
        $data['name'] = $_POST['name'];
        $data['phone'] = $_POST['phone'];
        $data['publishers'] = $_POST['publishers'];
        $data['longitude'] = $_POST['longitude'];
        $data['latitude'] = $_POST['latitude'];
        $save = $db->save($data);
        if ($save) {
            echo json_encode([
                'success' => true,
                'message' => "Thanks, your record has been received"
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "There was an error saving your record"
            ]);
        }
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => "No access"
    ]);
}
