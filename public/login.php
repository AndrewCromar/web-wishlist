<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet" />

<link rel="stylesheet" href="../styles/root.css" />
<link rel="stylesheet" href="../styles/main.css" />
<link rel="stylesheet" href="../styles/login.css" />

<center>
    <h1>Login</h1>
</center>
<hr>

<form id="loginEmailForm">
    <label for="login_email">Email</label>
    <input type="text" id="login_email" name="login_email" required />
    <button type="button" id="loginEmailButton">Login</button>
</form>

<form id="loginCodeForm" style="display: none;">
    <label for="login_code">Login Code (sent via email)</label>
    <input type="text" id="login_code" name="login_code" required />
    <button type="button" id="loginCodeButton">Login</button>
</form>

<script src="../scripts/account/LoginEmail.js"></script>
<script src="../scripts/account/LoginCode.js"></script>