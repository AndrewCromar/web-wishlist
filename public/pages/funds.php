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
<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap"
    rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Knewave&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Caveat+Brush&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Funnel+Sans:ital,wght@0,300..800;1,300..800&display=swap"
    rel="stylesheet">

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
<link rel="stylesheet" href="../styles/scroll-section.css" />

<div class="content">
    <!-- TITLE -->
    <div>
        <div class="center-center">
            <h1>FUND MANAGEMENT</h1>
        </div>
    </div>
    <div>
        <br>
        <!-- NAVIGATION -->
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
        <!-- LEDGER -->
        <div class="left-right">
            <div style="flex: none; width: 250px;">
                <div class="dropdown open">
                    <div onclick="ToggleDropdown(this.parentElement)">
                        <i class="fa-solid fa-caret-down"></i>
                        <p>Ledger</p>
                    </div>
                    <div>
                        <p>
                            <span style="font-weight: bold;">Net Total:</span>
                            <span class="net-funds"></span>
                        </p>
                        <hr>
                        <p style="font-size: smaller;">new to old</p>
                        <div class="scroll-section">
                            <table class="ledger-table">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FORMS -->
            <div>
                <div class="dropdown open">
                    <div onclick="ToggleDropdown(this.parentElement)">
                        <i class="fa-solid fa-caret-down"></i>
                        <p>Add Funds</p>
                    </div>
                    <div>
                        <form id="addFundingForm" class="neatForm">
                            <input type="number" id="add_funding_amount" name="add_funding_amount"
                                placeholder="Amount to Add (USD)" required />
                            <button type="button" id="addFundingButton">Add Funding</button>
                        </form>
                    </div>
                </div>
                <div class="dropdown open">
                    <div onclick="ToggleDropdown(this.parentElement)">
                        <i class="fa-solid fa-caret-down"></i>
                        <p>Remove Funds</p>
                    </div>
                    <div>
                        <form id="removeFundingForm" class="neatForm">
                            <input type="number" id="remove_funding_amount" name="remove_funding_amount"
                                placeholder="Amount to Remove (USD)" required />
                            <button type="button" id="removeFundingButton">Remove Funding</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../scripts/Dropdown.js"></script>
<script src="../scripts/account/Logout.js"></script>
<script src="../scripts/funds/AddFunding.js"></script>
<script src="../scripts/funds/RemoveFunding.js"></script>
<script src="../scripts/funds/RenderNetFunds.js"></script>
<script src="../scripts/funds/RenderLedger.js"></script>