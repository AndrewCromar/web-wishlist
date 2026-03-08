<?php

require_once dirname(__DIR__, 2) . '/backend/config/global.php';
require_once dirname(__DIR__, 2) . '/backend/functions/AuthCheck.php';
$uid = GetAuthenticatedUid();

require_once dirname(__DIR__, 2) . '/backend/functions/EditItem.php';
require_once dirname(__DIR__, 2) . '/backend/functions/VerifyGroupOwnership.php';


if (!$uid) { echo json_encode(["status" => "fail", "error" => "ERROR006"]); exit; }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "fail", "error" => "ERROR009"]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['itemId']) || !isset($data['name']) || !isset($data['link']) || !isset($data['price'])) {
    echo json_encode(["status" => "fail", "error" => "ERROR010"]);
    exit;
}


$itemId = intval($data['itemId']);
$name = $data['name'];
$link = $data['link'];
$price = floatval($data['price']);
$weight = isset($data['weight']) ? max(1, min(100, intval($data['weight']))) : 1;
$group_id = isset($data['groupId']) && $data['groupId'] !== '' ? intval($data['groupId']) : null;
$archived = isset($data['archived']) ? (bool)$data['archived'] : false;

if ($itemId <= 0 || empty($name)) {
    echo json_encode(["status" => "fail", "error" => "ERROR011"]);
    exit;
}

if ($group_id !== null && !VerifyGroupOwnership($uid, $group_id)) {
    echo json_encode(["status" => "fail", "error" => "ERROR011"]);
    exit;
}

$result = EditItem($uid, $itemId, $name, $link, $price, $weight, $group_id, $archived);

if ($result === false) {
    echo json_encode(["status" => "fail", "error" => "ERROR012"]);
    exit;
}

echo json_encode(["status" => "OK", "message" => "Item updated successfully"]);

