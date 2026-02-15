<?php

function IsEmailReal(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
