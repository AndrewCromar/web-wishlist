function RenderItemsTable() {
  $.ajax({
    url: "../api/ENDPOINT_GetUserItems.php",
    type: "POST",
    dataType: "json",
    success: function (response) {
      if (response.status === "OK") {
        // Target the table specifically
        const table = document.querySelector(".items-table");
        
        // Clear existing rows except for the header (first row)
        while (table.rows.length > 1) {
          table.deleteRow(1);
        }

        const { items } = response.data;

        // Iterate through items and append rows
        items.forEach((item) => {
          table.appendChild(
            GenerateItemRow(
              item.id,
              item.name,
              item.link,
              item.price,
              item.group_id
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

function GenerateItemRow(id, name, url, price, groupId) {
  const row = document.createElement("tr");

  // Format the price to ensure it looks like currency
  const formattedPrice = price ? `$${price}` : "$0";
  // Default to a placeholder if groupId is null/empty
  const displayGroup = groupId || "N/A";

  row.innerHTML = `
    <td>${id}</td>
    <td>${name}</td>
    <td><a href="${url}" target="_blank">link</a></td>
    <td>${formattedPrice}</td>
    <td>${displayGroup}</td>
  `;

  return row;
}

// Initialize the render
RenderItemsTable();