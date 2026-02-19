<?php
session_start();

if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit;
}
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet" />

<link rel="stylesheet" href="../styles/a.css" />
<link rel="stylesheet" href="../styles/center-center.css" />
<link rel="stylesheet" href="../styles/content.css" />
<link rel="stylesheet" href="../styles/dropdown.css" />
<link rel="stylesheet" href="../styles/form.css" />
<link rel="stylesheet" href="../styles/hr.css" />
<link rel="stylesheet" href="../styles/icon-text.css" />
<link rel="stylesheet" href="../styles/left-right.css" />
<link rel="stylesheet" href="../styles/main.css" />
<link rel="stylesheet" href="../styles/nav-area.css" />
<link rel="stylesheet" href="../styles/neat-form.css" />
<link rel="stylesheet" href="../styles/root.css" />
<link rel="stylesheet" href="../styles/wishlist.css" />

<div class="content">
    <div>
        <div class="center-center">
            <h1>DASHBOARD</h1>
        </div>
    </div>
    <div>
        <br>
        <div class="dropdown open">
            <div onclick="ToggleDropdown(this.parentElement)">
                <i class="fa-solid fa-caret-down"></i>
                <p>Navigation</p>
            </div>
            <div>
                <p>
                    <span><a href="dashboard.php">Dashboard</a></span>
                    /
                    <span><a href="account.php">Account</a></span>
                    /
                    <span><a onclick="Logout();">Logout</a></span>
                </p>
                <p>
                    <span>Management</span>
                    :
                    <span><a href="funds.php">Funds</a></span>
                    /
                    <span><a href="items.php">Items</a></span>
                    /
                    <span><a href="groups.php">Groups</a></span>
                </p>
            </div>
        </div>
        <div>
            <div class="dropdown open">
                <div onclick="ToggleDropdown(this.parentElement)">
                    <i class="fa-solid fa-caret-down"></i>
                    <p>Wishlist</p>
                </div>
                <div class="wishlist-groups">
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../scripts/Dropdown.js"></script>
<script src="../scripts/account/Logout.js"></script>
<script src="../scripts/account/RenderEmail.js"></script>
<script src="../scripts/RenderWishlist.js"></script>