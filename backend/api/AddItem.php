<?php

require_once __DIR__ . '/../db/CreateDBConnection.php';

function AddItem($uid, $name, $link, $price)
{
    $conn = CreateDBConnection();
    $stmt = $conn->prepare("INSERT INTO items (uid, name, link, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issd", $uid, $name, $link, $price);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    return true;
}