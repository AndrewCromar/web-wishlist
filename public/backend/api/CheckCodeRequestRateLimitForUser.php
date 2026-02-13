<?php

function CheckCodeRequestRateLimitForUser(int $uid, int $seconds = 30): bool
{
    $_SESSION['last_code_request'] ??= [];

    $now = time();
    $lastRequest = $_SESSION['last_code_request'][$uid] ?? 0;

    if ($now - $lastRequest < $seconds) {
        return true;
    }

    $_SESSION['last_code_request'][$uid] = $now;
    return false;
}
