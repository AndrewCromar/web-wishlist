function RemoveItem(id) {
  $.ajax({
    url: "../backend/endpoints/ENDPOINT_RemoveItem.php",
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify({
      itemId: id,
    }),
    dataType: "json",
    success: function (response) {
      if (response.status === "OK") {
        document.location.reload();
      } else {
        alert("Error: " + (response.error || response.message));
      }
    },
  });
}

document
  .getElementById("removeItemForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();
    const id = document.getElementById("remove_id").value;
    RemoveItem(id);
  });

document
  .getElementById("removeItemButton")
  .addEventListener("click", function () {
    const id = document.getElementById("remove_id").value;
    RemoveItem(id);
  });
