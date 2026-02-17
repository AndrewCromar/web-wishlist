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
            <h1>GROUP MANAGEMENT</h1>
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
                        <p>Add Group</p>
                    </div>
                    <div>
                        <form id="addGroupForm" class="neatForm">
                            <input type="text" id="add_group_name" name="add_group_name"
                                placeholder="Group Name" required />
                            <button type="button" id="addGroupButton">Add Group</button>
                        </form>
                    </div>
                </div>
                <div class="dropdown open">
                    <div onclick="ToggleDropdown(this.parentElement)">
                        <i class="fa-solid fa-caret-down"></i>
                        <p>Edit Group</p>
                    </div>
                    <div>
                        <form id="editGroupForm" class="neatForm">
                            <input type="number" id="edit_group_id" name="edit_group_id"
                                placeholder="Group ID to Edit" required />
                            <input type="text" id="edit_group_name" name="edit_group_name"
                                placeholder="Group Name" required />
                            <button type="button" id="editGroupButton">Edit Group</button>
                        </form>
                    </div>
                </div>
                <div class="dropdown open">
                    <div onclick="ToggleDropdown(this.parentElement)">
                        <i class="fa-solid fa-caret-down"></i>
                        <p>Remove Group</p>
                    </div>
                    <div>
                        <form id="removeGroupForm" class="neatForm">
                            <input type="number" id="remove_group_id" name="remove_group_id"
                                placeholder="Group ID to Remove" required />
                            <button type="button" id="removeGroupButton">Remove Group</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../scripts/Dropdown.js"></script>
<script src="../scripts/account/Logout.js"></script>
<script src="../scripts/groupManipulation/AddGroup.js"></script>
<script src="../scripts/groupManipulation/EditGroup.js"></script>
<script src="../scripts/groupManipulation/DeleteGroup.js"></script>
<script src="../scripts/groupManipulation/RenderGroupsTable.js"></script>