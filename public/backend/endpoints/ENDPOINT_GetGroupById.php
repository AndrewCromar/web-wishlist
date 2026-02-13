<?php

session_start();

require_once __DIR__ . '/../api/GetGroupById.php';

if (!isset($_SESSION['uid'])) { echo json_encode(["status" => "fail", "error" => "ERROR006"]); exit; }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "fail", "error" => "ERROR009"]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['groupId'])) {
    echo json_encode(["status" => "fail", "error" => "ERROR010"]);
    exit;
}

$uid = $_SESSION['uid'];
$group_id = intval($data['groupId']);

if ($group_id <= 0) {
    echo json_encode(["status" => "fail", "error" => "ERROR011"]);
    exit;
}

$group = GetGroupById($uid, $group_id);

if (!$group) {
    echo json_encode(["status" => "fail", "error" => "ERROR014"]);
    exit;
}

echo json_encode(["status" => "OK", "data" => $group]);
