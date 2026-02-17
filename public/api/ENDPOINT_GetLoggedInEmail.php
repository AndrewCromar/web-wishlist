<?php

session_start();

require_once dirname(__DIR__, 2) . '/backend/functions/GetLoggedInEmail.php';

if (!isset($_SESSION['uid'])) { echo json_encode(["status" => "fail", "error" => "ERROR006"]); exit; }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "fail", "error" => "ERROR009"]);
    exit;
}

$email = GetLoggedInEmail();
if ($email === false || $email === null) {
    echo json_encode(["status" => "fail", "error" => "ERROR013"]);
    exit;
}

echo json_encode(["status" => "OK", "data" => $email]);
