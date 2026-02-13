function AddItem(name, link, price) {
  $.ajax({
    url: "../backend/endpoints/ENDPOINT_AddItem.php",
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify({
      name,
      link,
      price,
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

document.getElementById("addItemForm").addEventListener("submit", function (e) {
  e.preventDefault();
  const name = document.getElementById("add_name").value;
  const link = document.getElementById("add_link").value;
  const price = document.getElementById("add_price").value;
  AddItem(name, link, price);
});

document.getElementById("addItemButton").addEventListener("click", function () {
  const name = document.getElementById("add_name").value;
  const link = document.getElementById("add_link").value;
  const price = document.getElementById("add_price").value;
  AddItem(name, link, price);
});
