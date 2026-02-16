<?php

require_once __DIR__ . '/../db/CreateDBConnection.php';

function GetNetFundsByUID($uid)
{
    $conn = CreateDBConnection();

    $stmt = $conn->prepare("SELECT COALESCE(SUM(amount), 0) AS total FROM ledger WHERE uid = ?");
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

    $stmt->bind_result($total);
    $stmt->fetch();

    $stmt->close();
    $conn->close();

    return $total !== null ? floatval($total) : 0.0;
}
