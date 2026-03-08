<?php

require_once dirname(__DIR__, 2) . '/backend/config/global.php';
require_once dirname(__DIR__, 2) . '/backend/functions/AuthCheck.php';
$uid = GetAuthenticatedUid();

require_once dirname(__DIR__, 2) . '/backend/functions/GetLedgerByUID.php';


if (!$uid) { echo json_encode(["status" => "fail", "error" => "ERROR006"]); exit; }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "fail", "error" => "ERROR009"]);
    exit;
}



$result = GetLedgerByUID($uid);
if ($result === false) {
    echo json_encode(["status" => "fail", "error" => "ERROR013"]);
    exit;
}

echo json_encode(["status" => "OK", "data" => $result]);
