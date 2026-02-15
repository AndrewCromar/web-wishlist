<?php

// Basic check to see if its an email address.
// Check if the email is in the db.
// Generate login code for user.
// Send login code to user.
// Return email success.

session_start();

$email = trim($_POST['email'] ?? '');

require_once dirname(__DIR__, 2) . '/backend/config/global.php';
require_once dirname(__DIR__, 2) . '/backend/functions/IsEmailReal.php';
require_once dirname(__DIR__, 2) . '/backend/functions/DoesEmailExist.php';
require_once dirname(__DIR__, 2) . '/backend/functions/GetUidByEmail.php';
require_once dirname(__DIR__, 2) . '/backend/functions/GenerateLoginCodeForUser.php';
require_once dirname(__DIR__, 2) . '/backend/functions/SendEmailCode.php';
require_once dirname(__DIR__, 2) . '/backend/functions/CheckCodeRequestRateLimitForUser.php';

if (!IsEmailReal($email)) { echo json_encode(["status" => "fail", "error" => "ERROR001"]); exit; }
if (!DoesEmailExist($email)) { echo json_encode(["status" => "fail", "error" => "ERROR002"]); exit; }

$uid = GetUidByEmail($email);
if (!$uid) { echo json_encode(["status" => "fail", "error" => "ERROR005"]); exit; }

if (CheckCodeRequestRateLimitForUser($uid)) { echo json_encode(["status" => "fail", "error" => "ERROR004"]); exit; }

$code = GenerateLoginCodeForUser($uid);

global $live;

if ($live)
{
    if (!SendEmailCode($email, $code)) { echo json_encode(["status" => "fail", "error" => "ERROR003"]); exit; }
}
else { echo json_encode(["status" => "OK", "devcode" => "$code"]); exit; }
        
echo json_encode(["status" => "OK"]);