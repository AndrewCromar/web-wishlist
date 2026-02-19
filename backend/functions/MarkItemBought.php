<?php

require_once __DIR__ . '/../db/CreateDBConnection.php';
require_once __DIR__ . '/AddFunding.php';
require_once __DIR__ . '/GetNetFundsByUID.php';

function MarkItemBought($uid, $item_id, $amount = null)
{
    $conn = CreateDBConnection();

    $stmt = $conn->prepare("SELECT price, bought, name FROM items WHERE id = ? AND uid = ?");
    if ($stmt === false) {
        $conn->close();
        return false;
    }
    $stmt->bind_param("ii", $item_id, $uid);
    if (! $stmt->execute()) {
        $stmt->close();
        $conn->close();
        return false;
    }
    $stmt->bind_result($price, $bought, $name);
    if (! $stmt->fetch()) {
        $stmt->close();
        $conn->close();
        return false;
    }
    $stmt->close();

    if ($bought) {
        $conn->close();
        return false;
    }

    $deduct = ($amount !== null ? floatval($amount) : floatval($price));
    if ($deduct < 0) {
        $deduct = abs($deduct);
    }

    $currentFunds = GetNetFundsByUID($uid);
    if ($currentFunds < $deduct) {
        $conn->close();
        return false;
    }

    AddToLedger($uid, -$deduct, "Purchased item " . $name);

    $stmt2 = $conn->prepare("UPDATE items SET bought = 1 WHERE id = ? AND uid = ?");
    if ($stmt2 === false) {
        $conn->close();
        return false;
    }
    $stmt2->bind_param("ii", $item_id, $uid);
    $result = $stmt2->execute();
    $stmt2->close();
    $conn->close();

    return $result;
}
