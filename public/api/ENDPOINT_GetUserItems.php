<?php

require_once dirname(__DIR__, 2) . '/backend/config/global.php';
require_once dirname(__DIR__, 2) . '/backend/functions/AuthCheck.php';
$uid = GetAuthenticatedUid();

require_once dirname(__DIR__, 2) . '/backend/functions/GetUserItems.php';
require_once dirname(__DIR__, 2) . '/backend/functions/GetUserGroups.php';


if (!$uid) { echo json_encode(["status" => "fail", "error" => "ERROR006"]); exit; }



$input = json_decode(file_get_contents('php://input'), true);
$includeArchived = isset($input['includeArchived']) && $input['includeArchived'] ? true : false;

$items = GetUserItems($uid, $includeArchived);
$groups = GetUserGroups($uid);

if ($items === false) { echo json_encode(["status" => "fail", "error" => "ERROR007"]); exit; }

echo json_encode(["status" => "OK", "data" => ["items" => $items, "groups" => $groups]]);
