<?php

session_start();

require_once __DIR__ . '/../api/EditItem.php';
require_once __DIR__ . '/../api/VerifyGroupOwnership.php';

if (!isset($_SESSION['uid'])) { echo json_encode(["status" => "fail", "error" => "ERROR006"]); exit; }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "fail", "error" => "ERROR009"]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['itemId']) || !isset($data['name']) || !isset($data['link']) || !isset($data['price'])) {
    echo json_encode(["status" => "fail", "error" => "ERROR010"]);
    exit;
}

$uid = $_SESSION['uid'];
$itemId = intval($data['itemId']);
$name = $data['name'];
$link = $data['link'];
$price = floatval($data['price']);
$group_id = isset($data['groupId']) && $data['groupId'] !== '' ? intval($data['groupId']) : null;

if ($itemId <= 0 || empty($name)) {
    echo json_encode(["status" => "fail", "error" => "ERROR011"]);
    exit;
}

// Verify group ownership if group_id is provided
if ($group_id !== null && !VerifyGroupOwnership($uid, $group_id)) {
    echo json_encode(["status" => "fail", "error" => "ERROR011"]);
    exit;
}

$result = EditItem($uid, $itemId, $name, $link, $price, $group_id);

if ($result === false) {
    echo json_encode(["status" => "fail", "error" => "ERROR012"]);
    exit;
}

echo json_encode(["status" => "OK", "message" => "Item updated successfully"]);

