<?php

session_start();

require_once __DIR__ . '/../api/GetItemById.php';

if (!isset($_SESSION['uid'])) { echo json_encode(["status" => "fail", "error" => "ERROR006"]); exit; }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "fail", "error" => "ERROR009"]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['itemId'])) {
    echo json_encode(["status" => "fail", "error" => "ERROR010"]);
    exit;
}

$uid = $_SESSION['uid'];
$itemId = intval($data['itemId']);

if ($itemId <= 0) {
    echo json_encode(["status" => "fail", "error" => "ERROR011"]);
    exit;
}

$item = GetItemById($uid, $itemId);

if (!$item) {
    echo json_encode(["status" => "fail", "error" => "ERROR012"]);
    exit;
}

echo json_encode(["status" => "OK", "data" => $item]);