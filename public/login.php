<?php
session_start();

if (isset($_SESSION['uid'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap"
    rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Knewave&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Caveat+Brush&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Funnel+Sans:ital,wght@0,300..800;1,300..800&display=swap"
    rel="stylesheet">

<?php require_once '../scripts/LoadStyles.php'; ?>

<div class="center-center">
    <div class="login-form">
        <center>
            <h1>Login</h1>
        </center>
        <hr><br>
        <form id="loginEmailForm">
            <label for="login_email">EMAIL:</label>
            <input type="text" id="login_email" name="login_email" required />
            <br><br>
            <button type="button" id="loginEmailButton">Login</button>
        </form>
        <form id="loginCodeForm" style="display: none;">
            <label for="login_code">LOGIN CODE (sent via email)</label>
            <input type="text" id="login_code" name="login_code" required />
            <br><br>
            <button type="button" id="loginCodeButton">Login</button>
        </form>
    </div>
</div>

<script src="../scripts/account/LoginEmail.js"></script>
<script src="../scripts/account/LoginCode.js"></script>