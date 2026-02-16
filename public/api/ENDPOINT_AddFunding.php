<?php

session_start();

require_once dirname(__DIR__, 2) . '/backend/functions/AddFunding.php';

if (!isset($_SESSION['uid'])) { echo json_encode(["status" => "fail", "error" => "ERROR006"]); exit; }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "fail", "error" => "ERROR009"]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['amount'])) {
    echo json_encode(["status" => "fail", "error" => "ERROR010"]);
    exit;
}

$uid = $_SESSION['uid'];
$amount = floatval($data['amount']);

$result = AddToLedger($uid, $amount, $amount > 0 ? "Add funds." : "Remove funds.");

if ($result === false) {
    echo json_encode(["status" => "fail", "error" => "ERROR013"]);
    exit;
}

echo json_encode(["status" => "OK", "message" => "Funding added/removed successfully."]);