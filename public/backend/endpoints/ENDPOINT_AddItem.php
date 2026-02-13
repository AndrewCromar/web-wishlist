<?php

session_start();

require_once __DIR__ . '/../api/AddItem.php';

if (!isset($_SESSION['uid'])) { echo json_encode(["status" => "fail", "error" => "ERROR006"]); exit; }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "fail", "error" => "ERROR009"]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['name']) || !isset($data['link']) || !isset($data['price'])) {
    echo json_encode(["status" => "fail", "error" => "ERROR010"]);
    exit;
}

$uid = $_SESSION['uid'];
$name = $data['name'];
$link = $data['link'];
$price = floatval($data['price']);

if (empty($name)) {
    echo json_encode(["status" => "fail", "error" => "ERROR011"]);
    exit;
}

$result = AddItem($uid, $name, $link, $price);

if ($result === false) {
    echo json_encode(["status" => "fail", "error" => "ERROR013"]);
    exit;
}

echo json_encode(["status" => "OK", "message" => "Item added successfully"]);