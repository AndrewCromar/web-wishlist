document.getElementById("removeGroupForm").addEventListener("submit", function (e) {
  e.preventDefault();
  const groupId = document.getElementById("remove_group_id").value;
  DeleteGroup(groupId);
});

document.getElementById("removeGroupButton").addEventListener("click", function () {
  const groupId = document.getElementById("remove_group_id").value;
  DeleteGroup(groupId);
});

function DeleteGroup(groupId) {
  if (!confirm("Are you sure you want to delete this group?")) {
    return;
  }

  $.ajax({
    url: "../backend/endpoints/ENDPOINT_DeleteGroup.php",
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify({
      groupId: parseInt(groupId),
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
