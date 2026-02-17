<?php

require_once __DIR__ . '/../db/CreateDBConnection.php';

function AddItem($uid, $name, $link, $price, $group_id = null)
{
    $conn = CreateDBConnection();
    if ($group_id === null) {
        $stmt = $conn->prepare("INSERT INTO items (uid, name, link, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issd", $uid, $name, $link, $price);
    } else {
        $stmt = $conn->prepare("INSERT INTO items (uid, name, link, price, group_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issdi", $uid, $name, $link, $price, $group_id);
    }

    $stmt->execute();
    $stmt->close();
    $conn->close();

    return true;
}