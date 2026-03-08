<?php
// Temporary endpoint for cache-change notifications. Delete after use.

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$passphrase = $_POST['passphrase'] ?? '';
if ($passphrase !== 'f69947d199658ac1ac49cd39b1b07c4b') {
    http_response_code(403);
    echo json_encode(['error' => 'Forbidden']);
    exit;
}

$message = $_POST['message'] ?? 'No message provided';
$to = 'andrewmcromar@gmail.com';
$subject = 'Wishlist Notify';
$headers = 'From: noreply@andrewcromar.org';

$sent = mail($to, $subject, $message, $headers);

echo json_encode(['success' => $sent, 'message' => $sent ? 'Email sent' : 'mail() failed']);
