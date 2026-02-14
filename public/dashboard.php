<?php
session_start();

if (!isset($_SESSION['uid'])) {
  header("Location: login.php");
  exit;
}
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet" />

<link rel="stylesheet" href="../styles/root.css" />
<link rel="stylesheet" href="../styles/main.css" />
<link rel="stylesheet" href="../styles/dropdown.css" />
<link rel="stylesheet" href="../styles/neatForm.css" />
<link rel="stylesheet" href="../styles/wishlist.css" />

<center>
  <h1>Dashboard</h1>
</center>
<hr>

<div class="dropdown">
  <div onclick="ToggleDropdown(this.parentElement)">
    <i class="fa-solid fa-caret-down"></i>
    <p>Account Information</p>
  </div>
  <div>
    <ul style="padding-left: 20px;">
      <li>
        Email: "
        <?php
        include_once __DIR__ . '/../backend/api/GetLoggedInEmail.php';
        echo GetLoggedInEmail();
        ?>
        ".
      </li>
      <li>
        UID: "
        <?php
        echo $_SESSION['uid'];
        ?>
        ".
      </li>
    </ul>
    <button onclick="Logout();">Logout</button>
  </div>
</div>

<div class="left-right-div">
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
  <div>

<div class="dropdown open">
  <div onclick="ToggleDropdown(this.parentElement)">
    <i class="fa-solid fa-caret-down"></i>
    <p>Add Funding</p>
  </div>
  <div>
    <form id="addFundingForm" class="neatForm">
      <input type="number" id="add_funding_amount" name="add_funding_amount" placeholder="Amount to Add (USD)" required />
      <button type="button" id="addFundingButton">Add Funding</button>
    </form>
  </div>
</div>

<div class="dropdown open">
  <div onclick="ToggleDropdown(this.parentElement)">
    <i class="fa-solid fa-caret-down"></i>
    <p>Item Manipulation</p>
  </div>
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
          <input type="number" id="add_price" name="add_price" placeholder="Price (USD)" required />
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
          <input type="number" id="edit_id" name="edit_id" placeholder="Item ID to Edit" required />
          <input type="text" id="edit_name" name="edit_name" placeholder="Name" required />
          <input type="text" id="edit_link" name="edit_link" placeholder="Link" required />
          <input type="number" id="edit_price" name="edit_price" placeholder="Price (USD)" required />
          <input type="number" id="edit_group" name="edit_group" placeholder="Group ID" required />
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
          <input type="number" id="remove_id" name="remove_id" placeholder="Item ID to Remove" required />
          <button type="button" id="removeItemButton">Remove Item</button>
        </form>
        <form id="removeBoughtForm" class="neatForm">
          <button type="button" id="removeBoughtButton">Remove Bought Items</button>
        </form>
      </div>
    </div>

  </div>
</div>

<div class="dropdown open">
  <div onclick="ToggleDropdown(this.parentElement)">
    <i class="fa-solid fa-caret-down"></i>
    <p>Group Manipulation</p>
  </div>
  <div>
    <div class="dropdown open">
      <div onclick="ToggleDropdown(this.parentElement)">
        <i class="fa-solid fa-caret-down"></i>
        <p>Add Group</p>
      </div>
      <div>
        <form id="addGroupForm" class="neatForm">
          <input type="text" id="add_group_name" name="add_group_name" placeholder="Group Name" required />
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
          <input type="number" id="edit_group_id" name="edit_group_id" placeholder="Group ID to Edit" required />
          <input type="text" id="edit_group_name" name="edit_group_name" placeholder="Group Name" required />
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
          <input type="number" id="remove_group_id" name="remove_group_id" placeholder="Group ID to Remove" required />
          <button type="button" id="removeGroupButton">Remove Group</button>
        </form>
        <form class="neatForm">
          <button id="removeUnusedGroupsButton">Remove Unused Groups</button>
        </form>
      </div>
    </div>
  </div>
</div>

  </div>
</div>

<script src="../scripts/Dropdown.js"></script>
<script src="../scripts/account/Logout.js"></script>
<script src="../scripts/RenderWishlist.js"></script>
<script src="../scripts/itemManipulation/AddItem.js"></script>
<script src="../scripts/itemManipulation/RemoveItem.js"></script>
<script src="../scripts/itemManipulation/RemoveBoughtItems.js"></script>
<script src="../scripts/itemManipulation/AddFunding.js"></script>
<script src="../scripts/itemManipulation/EditItem.js"></script>
<script src="../scripts/groupManipulation/AddGroup.js"></script>
<script src="../scripts/groupManipulation/EditGroup.js"></script>
<script src="../scripts/groupManipulation/DeleteGroup.js"></script>
<script src="../scripts/groupManipulation/DeleteUnusedGroups.js"></script>