<?php

session_start();

require_once dirname(__DIR__, 2) . '/backend/functions/GetUserItems.php';
require_once dirname(__DIR__, 2) . '/backend/functions/GetUserGroups.php';

if (!isset($_SESSION['uid'])) { echo json_encode(["status" => "fail", "error" => "ERROR006"]); exit; }

$uid = $_SESSION['uid'];

$items = GetUserItems($uid);
$groups = GetUserGroups($uid);

if ($items === false) { echo json_encode(["status" => "fail", "error" => "ERROR007"]); exit; }

echo json_encode(["status" => "OK", "data" => ["items" => $items, "groups" => $groups]]);
