<?php

require_once dirname(__DIR__, 2) . '/backend/config/global.php';
require_once dirname(__DIR__, 2) . '/backend/functions/AuthCheck.php';
$uid = GetAuthenticatedUid();

require_once dirname(__DIR__, 2) . '/backend/functions/RemoveItem.php';


if (!$uid) { echo json_encode(["status" => "fail", "error" => "ERROR006"]); exit; }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "fail", "error" => "ERROR009"]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['itemId'])) {
    echo json_encode(["status" => "fail", "error" => "ERROR010"]);
    exit;
}


$itemId = intval($data['itemId']);

if ($itemId <= 0) {
    echo json_encode(["status" => "fail", "error" => "ERROR011"]);
    exit;
}

$result = RemoveItem($uid, $itemId);

if ($result === false) {
    echo json_encode(["status" => "fail", "error" => "ERROR013"]);
    exit;
}

echo json_encode(["status" => "OK", "message" => "Item removed successfully"]);