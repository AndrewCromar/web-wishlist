<?php
require_once __DIR__ . '/../db/CreateDBConnection.php';

function GetLoggedInEmail() {
    if (!isset($_SESSION['uid'])) {
        return "Not logged in";
    }

    $uid = $_SESSION['uid'];

    $conn = CreateDBConnection();
    $stmt = $conn->prepare("SELECT email FROM accounts WHERE uid = ?");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->fetch();
    $stmt->close();
    $conn->close();

    return $email;
}
