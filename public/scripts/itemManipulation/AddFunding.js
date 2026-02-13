function AddFunding(amount) {
  $.ajax({
    url: "../backend/endpoints/ENDPOINT_AddFunding.php",
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify({
      amount,
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

document
  .getElementById("addFundingForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();
    const amount = document.getElementById("add_funding_amount").value;
    AddFunding(amount);
  });

document
  .getElementById("addFundingButton")
  .addEventListener("click", function () {
    const amount = document.getElementById("add_funding_amount").value;
    AddFunding(amount);
  });
