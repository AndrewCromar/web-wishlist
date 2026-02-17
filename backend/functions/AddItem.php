<?php

require_once __DIR__ . '/../db/CreateDBConnection.php';

function AddItem($uid, $name, $link, $price, $weight, $group_id = null)
{
    $conn = CreateDBConnection();
    if ($group_id === null) {
        $stmt = $conn->prepare("INSERT INTO items (uid, name, link, price, weight) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issdi", $uid, $name, $link, $price, $weight);
    } else {
        $stmt = $conn->prepare("INSERT INTO items (uid, name, link, price, weight, group_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issdii", $uid, $name, $link, $price, $weight, $group_id);
    }

    $stmt->execute();
    $stmt->close();
    $conn->close();

    return true;
}