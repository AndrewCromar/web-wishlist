function FetchAndRenderLedger() {
	$.ajax({
		url: "../api/ENDPOINT_GetLedger.php",
		type: "POST",
		contentType: "application/json",
		data: JSON.stringify({}),
		dataType: "json",
		success: function (response) {
			if (response.status === "OK") {
				const rows = (response.data || []).slice(0, 100);
				const tables = document.getElementsByClassName("ledger-table");
				for (let t = 0; t < tables.length; t++) {
					const table = tables[t];
					let html = "";
					rows.forEach(function (r) {
						const amt = parseFloat(r.amount) || 0;
						const abs = Math.abs(amt).toFixed(2);
						let sign = "";
						let varName = "--warning";
						if (amt > 0) {
							sign = "+";
							varName = "--success";
						} else if (amt < 0) {
							sign = "-";
							varName = "--danger";
						} else {
							sign = "";
							varName = "--warning";
						}

						html += '<tr><td style="border-left: solid var(' + varName + ') 2px;">' + sign + "$" + abs + '</td></tr>';
					});
					table.innerHTML = html;
				}
			} else {
				console.error("Failed to get ledger:", response.error || response.message);
			}
		},
		error: function (xhr, status, error) {
			console.error("Request failed:", error);
		}
	});
}

document.addEventListener("DOMContentLoaded", function () {
	FetchAndRenderLedger();
});
