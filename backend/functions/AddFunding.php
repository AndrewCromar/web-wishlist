<?php

require_once __DIR__ . '/../db/CreateDBConnection.php';

function AddToLedger($uid, $amount, $description)
{
    $conn = CreateDBConnection();
    $stmt = $conn->prepare("INSERT INTO ledger (uid, amount, description) VALUES (?, ?, ?)");
    $stmt->bind_param("ids", $uid, $amount, $description);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    return true;
}