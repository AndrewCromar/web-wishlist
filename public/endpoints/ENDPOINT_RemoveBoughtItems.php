<?php

session_start();

require_once dirname(__DIR__, 2) . '/backend/api/RemoveBoughtItems.php';

if (!isset($_SESSION['uid'])) { echo json_encode(["status" => "fail", "error" => "ERROR006"]); exit; }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "fail", "error" => "ERROR009"]);
    exit;
}

$uid = $_SESSION['uid'];

$result = RemoveBoughtItems($uid);

if ($result === false) {
    echo json_encode(["status" => "fail", "error" => "ERROR013"]);
    exit;
}

echo json_encode(["status" => "OK", "message" => "Bought items removed successfully"]);
