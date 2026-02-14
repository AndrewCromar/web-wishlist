document.getElementById("removeUnusedGroupsButton").addEventListener("click", function () {
  DeleteUnusedGroups();
});

function DeleteUnusedGroups() {
  if (!confirm("Are you sure you want to remove all unused groups?")) {
    return;
  }

  $.ajax({
    url: "../backend/endpoints/ENDPOINT_DeleteUnusedGroups.php",
    type: "POST",
    contentType: "application/json",
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
