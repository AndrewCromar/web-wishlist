<?php

function SendEmailCode($email, $code)
{
    $to = $email;
    $subject = "Your Wishlist Login Code - {$code}";
    $from = 'no-reply@andrewcromar.org';

    $body = <<<EOD
    Hello,

    Your login code for Wishlist is:

        {$code}

    This code is valid for 10 minutes. Please do not share it with anyone.

    Thank you,
    Wishlist

    ---
    This is an automated message, please do not reply.
    EOD;

    $headers = "From: Wishlist <{$from}>\r\n";
    $headers .= "Reply-To: {$from}\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    return mail($to, $subject, $body, $headers);
}