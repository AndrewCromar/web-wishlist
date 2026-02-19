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
            <h1>ITEM MANAGEMENT</h1>
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
        <!-- LIST -->
        <div class="left-right">
            <div style="flex: none; width: 75%;">
                <div class="dropdown open">
                    <div onclick="ToggleDropdown(this.parentElement)">
                        <i class="fa-solid fa-caret-down"></i>
                        <p>Items</p>
                    </div>
                    <div>
                        <div class="scroll-section">
                            <table class="items-table" style="width: 100%; text-align: left;">
                                <tr>
                                    <th>id</th>
                                    <th>name</th>
                                    <th>link</th>
                                    <th>price</th>
                                    <th>weight</th>
                                    <th>bought</th>
                                    <th>group</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="dropdown open">
                    <div onclick="ToggleDropdown(this.parentElement)">
                        <i class="fa-solid fa-caret-down"></i>
                        <p>Groups</p>
                    </div>
                    <div>
                        <div class="scroll-section">
                            <table class="groups-table" style="width: 100%; text-align: left;">
                                <tr>
                                    <th>id</th>
                                    <th>name</th>
                                </tr>
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
                        <p>Add Item</p>
                    </div>
                    <div>
                        <form id="addItemForm" class="neatForm">
                            <input type="text" id="add_name" name="add_name" placeholder="Name" required />
                            <input type="text" id="add_link" name="add_link" placeholder="Link" required />
                            <input type="number" id="add_price" name="add_price" placeholder="Price (USD)"
                                required />
                            <input type="number" id="add_weight" name="add_weight" min="1" max="100" placeholder="Weight (1-100) (optional)" />
                            <input type="number" id="add_group" name="add_group" placeholder="Group ID (optional)" />
                            <button type="button" id="addItemButton">Add Item</button>
                        </form>
                    </div>
                </div>
                <div class="dropdown open">
                    <div onclick="ToggleDropdown(this.parentElement)">
                        <i class="fa-solid fa-caret-down"></i>
                        <p>Edit Item</p>
                    </div>
                    <div>
                        <form id="editItemForm" class="neatForm">
                            <input type="number" id="edit_id" name="edit_id" placeholder="Item ID to Edit"
                                required />
                            <input type="text" id="edit_name" name="edit_name" placeholder="Name" required />
                            <input type="text" id="edit_link" name="edit_link" placeholder="Link" required />
                            <input type="number" id="edit_price" name="edit_price" placeholder="Price (USD)"
                                required />
                            <input type="number" id="edit_weight" name="edit_weight" min="1" max="100" placeholder="Weight (1-100) (optional)" />
                            <input type="number" id="edit_group" name="edit_group" placeholder="Group ID"
                                required />
                            <button type="button" id="editItemButton">Edit Item</button>
                        </form>
                    </div>
                </div>
                <div class="dropdown open">
                    <div onclick="ToggleDropdown(this.parentElement)">
                        <i class="fa-solid fa-caret-down"></i>
                        <p>Remove Item</p>
                    </div>
                    <div>
                        <form id="removeItemForm" class="neatForm">
                            <input type="number" id="remove_id" name="remove_id" placeholder="Item ID to Remove"
                                required />
                            <button type="button" id="removeItemButton">Remove Item</button>
                        </form>
                        <form id="removeBoughtForm" class="neatForm">
                            <button type="button" id="removeBoughtButton">Remove Bought Items</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../scripts/Dropdown.js"></script>
<script src="../scripts/account/Logout.js"></script>
<script src="../scripts/itemManipulation/AddItem.js"></script>
<script src="../scripts/itemManipulation/RemoveItem.js"></script>
<script src="../scripts/itemManipulation/EditItem.js"></script>
<script src="../scripts/itemManipulation/RemoveBoughtItems.js"></script>
<script src="../scripts/itemManipulation/RenderItemsTable.js"></script>
<script src="../scripts/groupManipulation/RenderGroupsTable.js"></script>
