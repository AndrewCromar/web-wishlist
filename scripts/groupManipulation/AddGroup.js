document.getElementById("addGroupForm").addEventListener("submit", function (e) {
  e.preventDefault();
  const name = document.getElementById("add_group_name").value;
  AddGroup(name);
});

document.getElementById("addGroupButton").addEventListener("click", function () {
  const name = document.getElementById("add_group_name").value;
  AddGroup(name);
});

function AddGroup(name) {
  $.ajax({
    url: "../backend/endpoints/ENDPOINT_CreateGroup.php",
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify({
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
