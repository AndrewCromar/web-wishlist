function RenderItemsTable() {
  $.ajax({
    url: "../api/ENDPOINT_GetUserItems.php",
    type: "POST",
    dataType: "json",
    success: function (response) {
      if (response.status === "OK") {
        const table = document.querySelector(".items-table");
        
        while (table.rows.length > 1) {
          table.deleteRow(1);
        }

        const { items } = response.data;
        const { groups } = response.data;

        items.forEach((item) => {
          table.appendChild(
            GenerateItemRow(
              item.id,
              item.name,
              item.link,
              item.price,
              item.weight,
              item.bought,
              groups.find((g) => g.id === item.group_id)?.name || "N/A"
            )
          );
        });
      } else {
        console.error("Error fetching items:", response.error);
        alert(response.status + " " + response.error);
      }
    },
  });
}

function GenerateItemRow(id, name, url, price, weight, bought, groupId) {
  const row = document.createElement("tr");

  const formattedPrice = price ? `$${price}` : "$0";
  const displayGroup = groupId || "N/A";

  row.innerHTML = `
    <td>${id}</td>
    <td>${name}</td>
    <td><a href="${url}" target="_blank">link</a></td>
    <td>${formattedPrice}</td>
    <td>${weight}</td>
    <td>${bought ? "&check;" : "&#10007;"}</td>
    <td>${displayGroup}</td>
  `;

  return row;
}

RenderItemsTable();