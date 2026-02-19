<?php

session_start();

require_once dirname(__DIR__, 2) . '/backend/functions/AddItem.php';

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

$weight = 1;
if (isset($data['weight'])) {
    $weight = intval($data['weight']);
}
$weight = max(1, min(100, $weight));

$group_id = null;
if (isset($data['group_id']) && $data['group_id'] !== '') {
    $group_id = intval($data['group_id']);
}

if (empty($name)) {
    echo json_encode(["status" => "fail", "error" => "ERROR011"]);
    exit;
}

$result = AddItem($uid, $name, $link, $price, $weight, $group_id);

if ($result === false) {
    echo json_encode(["status" => "fail", "error" => "ERROR013"]);
    exit;
}

echo json_encode(["status" => "OK", "message" => "Item added successfully"]);