<?php

require_once dirname(__DIR__, 2) . '/backend/api/Logout.php';

Logout();

echo json_encode(["status" => "OK"]);
