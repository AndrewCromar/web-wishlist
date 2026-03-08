<?php
require_once dirname(__DIR__, 2) . '/backend/config/global.php';
require_once dirname(__DIR__, 2) . '/backend/functions/AuthCheck.php';

$uid = GetAuthenticatedUid();
if ($uid) {
    header("Location: dashboard.php");
    exit;
}

$protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$dashboard = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/dashboard.php';

global $live;
if ($live) {
    $authBase = 'https://auth.andrewcromar.org';
} else {
    $authBase = $protocol . $_SERVER['HTTP_HOST'] . '/web_auth/public';
}

$loginUrl = $authBase . '/pages/login.html?redirect=' . urlencode($dashboard);
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet" />

<link rel="stylesheet" href="../styles/a.css" />
<link rel="stylesheet" href="../styles/center-center.css" />
<link rel="stylesheet" href="../styles/content.css" />
<link rel="stylesheet" href="../styles/form.css" />
<link rel="stylesheet" href="../styles/main.css" />
<link rel="stylesheet" href="../styles/root.css" />
<link rel="stylesheet" href="../styles/wishlist.css" />

<div class="center-center">
    <div class="login-form">
        <center>
            <h1>Logged Out</h1>
        </center>
        <hr><br>
        <p>You are not currently logged in.</p>
        <br>
        <a href="<?php echo htmlspecialchars($loginUrl); ?>" style="text-decoration: none;">
            <button type="button" style="
                background-color: rgba(42, 42, 42);
                color: white;
                font-family: 'Roboto', monospace;
                height: 40px;
                padding: 10px;
                text-align: center;
                border: solid rgba(59, 59, 59) 2px;
                border-radius: 10px;
                transition-duration: 200ms;
                cursor: pointer;
            " onmouseover="this.style.backgroundColor='rgb(17,138,36)'; this.style.translate='0 -2px';"
               onmouseout="this.style.backgroundColor='rgba(42,42,42)'; this.style.translate='0 0';">
                Login with auth.andrewcromar.org
            </button>
        </a>
    </div>
</div>
