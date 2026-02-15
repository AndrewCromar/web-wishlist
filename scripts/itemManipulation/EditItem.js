document.getElementById("edit_id").addEventListener("input", function () {
  const itemId = this.value;

  if (!itemId || itemId === "") {
    document.getElementById("edit_name").value = "";
    document.getElementById("edit_link").value = "";
    document.getElementById("edit_price").value = "";
    document.getElementById("edit_group").value = "";
    return;
  }

  $.ajax({
    url: "../backend/endpoints/ENDPOINT_GetItemById.php",
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify({
      itemId: parseInt(itemId),
    }),
    dataType: "json",
    success: function (response) {
      if (response.status === "OK") {
        const item = response.data;
        document.getElementById("edit_name").value = item.name;
        document.getElementById("edit_link").value = item.link;
        document.getElementById("edit_price").value = item.price;
        document.getElementById("edit_group").value = item.group_id || "";
      } else {
        document.getElementById("edit_name").value = "";
        document.getElementById("edit_link").value = "";
        document.getElementById("edit_price").value = "";
        document.getElementById("edit_group").value = "";
      }
    },
    error: function (xhr, status, error) {
      document.getElementById("edit_name").value = "";
      document.getElementById("edit_link").value = "";
      document.getElementById("edit_price").value = "";
      document.getElementById("edit_group").value = "";
    }
  });
});

document.getElementById("editItemForm").addEventListener("submit", function (e) {
  e.preventDefault();
  const id = document.getElementById("edit_id").value;
  const name = document.getElementById("edit_name").value;
  const link = document.getElementById("edit_link").value;
  const price = document.getElementById("edit_price").value;
  const groupId = document.getElementById("edit_group").value;
  EditItem(id, name, link, price, groupId);
});

document.getElementById("editItemButton").addEventListener("click", function () {
  const id = document.getElementById("edit_id").value;
  const name = document.getElementById("edit_name").value;
  const link = document.getElementById("edit_link").value;
  const price = document.getElementById("edit_price").value;
  const groupId = document.getElementById("edit_group").value;
  EditItem(id, name, link, price, groupId);
});

function EditItem(id, name, link, price, groupId) {
  $.ajax({
    url: "../backend/endpoints/ENDPOINT_EditItem.php",
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify({
      itemId: parseInt(id),
      name,
      link,
      price,
      groupId: groupId !== '' ? parseInt(groupId) : null,
    }),
    dataType: "json",
    success: function (response) {
      if (response.status === "OK") {
        document.location.reload();
      } else {
        alert("Error: " + (response.error || response.message));
      }
    },
    error: function (xhr, status, error) {
      alert("Request failed: " + error);
    }
  });
}
