<?php

// Get UID that goes with the code.
// If the UID does not exist error out.
// If the UID does exist mark the user as logged in.
// Delete the codes for the user.
// Return login success.

session_start();

require_once dirname(__DIR__, 2) . '/backend/functions/GetUidByCode.php';
require_once dirname(__DIR__, 2) . '/backend/functions/DeleteCodesForUser.php';

$code = trim($_POST['code'] ?? '');

$uid = GetUidByCode($code);

if (!$uid) { echo json_encode(["status" => "fail", "error" => "ERROR005"]); exit; }

session_regenerate_id(true);
$_SESSION['uid'] = $uid;

DeleteCodesForUser($uid);

echo json_encode(["status" => "OK"]);
