function RenderGroupsTable() {
  $.ajax({
    url: "../api/ENDPOINT_GetUserItems.php",
    type: "POST",
    dataType: "json",
    success: function (response) {
      if (response.status === "OK") {
        const table = document.querySelector(".groups-table");
        
        while (table.rows.length > 1) {
          table.deleteRow(1);
        }

        const { groups } = response.data;

        if (groups && groups.length > 0) {
          groups.forEach((group) => {
            table.appendChild(GenerateGroupRow(group.id, group.name));
          });
        } else {
          const emptyRow = document.createElement("tr");
          emptyRow.innerHTML = `<td colspan="2" style="text-align:center; padding:10px;">No groups found.</td>`;
          table.appendChild(emptyRow);
        }
      } else {
        console.error("API Error:", response.error);
        alert("Error: " + response.error);
      }
    },
    error: function (xhr, status, error) {
      console.error("AJAX Error:", error);
    }
  });
}

function GenerateGroupRow(id, name) {
  const row = document.createElement("tr");

  row.innerHTML = `
    <td>${id}</td>
    <td>${name}</td>
  `;

  return row;
}

$(document).ready(function() {
    RenderGroupsTable();
});