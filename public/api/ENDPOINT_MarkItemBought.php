<?php

session_start();

require_once dirname(__DIR__, 2) . '/backend/functions/MarkItemBought.php';

if (!isset($_SESSION['uid'])) { echo json_encode(["status" => "fail", "error" => "ERROR006"]); exit; }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "fail", "error" => "ERROR009"]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['item_id'])) {
    echo json_encode(["status" => "fail", "error" => "ERROR010"]);
    exit;
}

$uid = $_SESSION['uid'];
$item_id = intval($data['item_id']);
if ($item_id <= 0) {
    echo json_encode(["status" => "fail", "error" => "ERROR011"]);
    exit;
}

$amount = null;
if (isset($data['amount'])) {
    $amount = floatval($data['amount']);
}

$result = MarkItemBought($uid, $item_id, $amount);

if ($result === false) {
    echo json_encode(["status" => "fail", "error" => "ERROR014"]);
    exit;
}

echo json_encode(["status" => "OK", "message" => "Item marked bought"]);
