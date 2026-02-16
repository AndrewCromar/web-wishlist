
function FetchAndRenderNetFunds() {
	$.ajax({
		url: "../api/ENDPOINT_GetTotalFunds.php",
		type: "POST",
		contentType: "application/json",
		data: JSON.stringify({}),
		dataType: "json",
		success: function (response) {
			if (response.status === "OK") {
				const total = parseFloat(response.data) || 0;
				const abs = Math.abs(total).toFixed(2);
				let display = "$" + abs;
				if (total > 0) display = "+" + display;
				else if (total < 0) display = "-" + display;

				const els = document.getElementsByClassName("net-funds");
				for (let i = 0; i < els.length; i++) {
					els[i].textContent = display;
				}
			} else {
				console.error("Failed to get net funds:", response.error || response.message);
			}
		},
		error: function (xhr, status, error) {
			console.error("Request failed:", error);
		}
	});
}

document.addEventListener("DOMContentLoaded", function () {
	FetchAndRenderNetFunds();
});
