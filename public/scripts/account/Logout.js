function Logout() {
  $.ajax({
    url: "../api/ENDPOINT_Logout.php",
    type: "POST",
    dataType: "json",
    success: function (response) {
      if (response.status === "OK") {
        document.location.href = "./login.php";
      } else {
        alert(response.status + " " + response.error);
      }
    },
  });
}
