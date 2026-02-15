<?php

session_start();

require_once __DIR__ . '/../api/EditGroup.php';

if (!isset($_SESSION['uid'])) { echo json_encode(["status" => "fail", "error" => "ERROR006"]); exit; }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "fail", "error" => "ERROR009"]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['groupId']) || !isset($data['name'])) {
    echo json_encode(["status" => "fail", "error" => "ERROR010"]);
    exit;
}

$uid = $_SESSION['uid'];
$group_id = intval($data['groupId']);
$name = $data['name'];

if ($group_id <= 0 || empty($name)) {
    echo json_encode(["status" => "fail", "error" => "ERROR011"]);
    exit;
}

$result = EditGroup($uid, $group_id, $name);

if ($result === false) {
    echo json_encode(["status" => "fail", "error" => "ERROR014"]);
    exit;
}

echo json_encode(["status" => "OK", "message" => "Group updated successfully"]);
