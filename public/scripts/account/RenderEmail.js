function FetchAndRenderEmail() {
	$.ajax({
		url: "../api/ENDPOINT_GetLoggedInEmail.php",
		type: "POST",
		contentType: "application/json",
		data: JSON.stringify({}),
		dataType: "json",
		success: function (response) {
			if (response.status === "OK") {
				const email = response.data || "";
				const els = document.getElementsByClassName("email-display");
				for (let i = 0; i < els.length; i++) {
					els[i].textContent = email;
				}
			} else {
				console.error("Failed to get email:", response.error || response.message);
			}
		},
		error: function (xhr, status, error) {
			console.error("Request failed:", error);
		}
	});
}

document.addEventListener("DOMContentLoaded", function () {
	FetchAndRenderEmail();
});
