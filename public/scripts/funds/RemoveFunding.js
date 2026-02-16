function RemoveFunding(amount) {
  console.log("sending");
  $.ajax({
    url: "../api/ENDPOINT_AddFunding.php",
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
  .getElementById("removeFundingForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();
    const amount = -1 * document.getElementById("remove_funding_amount").value;
    RemoveFunding(amount);
  });

document
  .getElementById("removeFundingButton")
  .addEventListener("click", function () {
    const amount = -1 * document.getElementById("remove_funding_amount").value;
    RemoveFunding(amount);
  });
