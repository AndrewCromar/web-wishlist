document.getElementById("edit_group_id").addEventListener("input", function () {
  const groupId = this.value;

  if (!groupId || groupId === "") {
    document.getElementById("edit_group_name").value = "";
    return;
  }

  $.ajax({
    url: "../backend/endpoints/ENDPOINT_GetGroupById.php",
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify({
      groupId: parseInt(groupId),
    }),
    dataType: "json",
    success: function (response) {
      if (response.status === "OK") {
        const group = response.data;
        document.getElementById("edit_group_name").value = group.name;
      } else {
        document.getElementById("edit_group_name").value = "";
      }
    },
    error: function (xhr, status, error) {
      document.getElementById("edit_group_name").value = "";
    }
  });
});

document.getElementById("editGroupForm").addEventListener("submit", function (e) {
  e.preventDefault();
  const groupId = document.getElementById("edit_group_id").value;
  const name = document.getElementById("edit_group_name").value;
  EditGroup(groupId, name);
});

document.getElementById("editGroupButton").addEventListener("click", function () {
  const groupId = document.getElementById("edit_group_id").value;
  const name = document.getElementById("edit_group_name").value;
  EditGroup(groupId, name);
});

function EditGroup(groupId, name) {
  $.ajax({
    url: "../backend/endpoints/ENDPOINT_EditGroup.php",
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify({
      groupId: parseInt(groupId),
      name,
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
