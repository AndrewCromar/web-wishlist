<?php

session_start();

require_once __DIR__ . '/../api/DistributeFunds.php';
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

if ($amount <= 0) {
    echo json_encode(["status" => "fail", "error" => "ERROR011"]);
    exit;
}

$result = DistributeFunds($uid, $amount);

if ($result === false) {
    echo json_encode(["status" => "fail", "error" => "ERROR013"]);
    exit;
}

echo json_encode(["status" => "OK", "message" => "Funding distributed successfully"]);