<?php

// Basic check to see if its an email address.
// Check if the email is in the db.
// Generate login code for user.
// Send login code to user.
// Return email success.

session_start();

$email = trim($_POST['email'] ?? '');

require_once __DIR__ . '/../../global.php';
require_once __DIR__ . '/../api/IsEmailReal.php';
require_once __DIR__ . '/../api/DoesEmailExist.php';
require_once __DIR__ . '/../api/GetUidByEmail.php';
require_once __DIR__ . '/../api/GenerateLoginCodeForUser.php';
require_once __DIR__ . '/../api/SendEmailCode.php';
require_once __DIR__ . '/../api/CheckCodeRequestRateLimitForUser.php';

if (!IsEmailReal($email)) { echo json_encode(["status" => "fail", "error" => "ERROR001"]); exit; }
if (!DoesEmailExist($email)) { echo json_encode(["status" => "fail", "error" => "ERROR002"]); exit; }

$uid = GetUidByEmail($email);
if (!$uid) { echo json_encode(["status" => "fail", "error" => "ERROR005"]); exit; }

if (CheckCodeRequestRateLimitForuser($uid)) { echo json_encode(["status" => "fail", "error" => "ERROR004"]); exit; }

$code = GenerateLoginCodeForUser($uid);

global $live;

if ($live)
{
    if (!SendEmailCode($email, $code)) { echo json_encode(["status" => "fail", "error" => "ERROR003"]); exit; }
}
else { echo json_encode(["status" => "OK", "devcode" => "$code"]); exit; }
        
echo json_encode(["status" => "OK"]);