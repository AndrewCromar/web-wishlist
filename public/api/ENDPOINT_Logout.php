<?php

require_once dirname(__DIR__, 2) . '/backend/functions/Logout.php';

Logout();

echo json_encode(["status" => "OK"]);
