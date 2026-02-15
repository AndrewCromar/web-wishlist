function RemoveBoughtItems() {
  $.ajax({
    url: "../backend/endpoints/ENDPOINT_RemoveBoughtItems.php",
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify({}),
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

document
  .getElementById("removeBoughtButton")
  .addEventListener("click", function () {
    if (confirm("Are you sure you want to remove all bought items?")) {
      RemoveBoughtItems();
    }
  });
