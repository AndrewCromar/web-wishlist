<?php

require_once __DIR__ . '/../db/CreateDBConnection.php';

function GetLedgerByUID($uid)
{
    $conn = CreateDBConnection();

    $stmt = $conn->prepare("SELECT id, amount, description, created_at FROM ledger WHERE uid = ? ORDER BY created_at DESC");
    if ($stmt === false) {
        $conn->close();
        return false;
    }

    $stmt->bind_param("i", $uid);
    if (! $stmt->execute()) {
        $stmt->close();
        $conn->close();
        return false;
    }

    $stmt->bind_result($id, $amount, $description, $created_at);
    $rows = [];
    while ($stmt->fetch()) {
        $rows[] = [
            'id' => $id,
            'amount' => floatval($amount),
            'description' => $description,
            'created_at' => $created_at,
        ];
    }

    $stmt->close();
    $conn->close();

    return $rows;
}
