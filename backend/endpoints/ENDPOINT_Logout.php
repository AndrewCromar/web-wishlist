<?php

require_once __DIR__ . '/../api/Logout.php';

Logout();

echo json_encode(["status" => "OK"]);
