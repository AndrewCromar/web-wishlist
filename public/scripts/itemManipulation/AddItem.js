function AddItem(name, link, price, weight, group_id) {
  const payload = { name, link, price, weight };
  if (typeof group_id !== 'undefined' && group_id !== null && group_id !== '') payload.group_id = group_id;

  $.ajax({
    url: "../api/ENDPOINT_AddItem.php",
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify(payload),
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

document.getElementById("addItemForm").addEventListener("submit", function (e) {
  e.preventDefault();
  const name = document.getElementById("add_name").value;
  const link = document.getElementById("add_link").value;
  const price = document.getElementById("add_price").value;
  const weight = document.getElementById("add_weight").value;
  const group = document.getElementById("add_group").value;
  AddItem(name, link, price, weight, group);
});

document.getElementById("addItemButton").addEventListener("click", function () {
  const name = document.getElementById("add_name").value;
  const link = document.getElementById("add_link").value;
  const price = document.getElementById("add_price").value;
  const weight = document.getElementById("add_weight").value;
  const group = document.getElementById("add_group").value;
  AddItem(name, link, price, weight, group);
});
