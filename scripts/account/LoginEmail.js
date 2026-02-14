function LoginEmail(email) {
  $.ajax({
    url: "../backend/endpoints/ENDPOINT_LoginEmail.php",
    type: "POST",
    data: { email },
    dataType: "json",
    success: function (response) {
      if (response.status === "OK") {
        document.getElementById("loginEmailForm").style.display = "none";
        document.getElementById("loginCodeForm").style.display = "flex";

        if (response.devcode != null) {
          alert(response.devcode);
        }
      } else {
        alert(response.status + " " + response.error);
      }
    },
  });
}

document
  .getElementById("loginEmailForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();
    const email = document.getElementById("login_email").value;
    LoginEmail(email);
  });

document
  .getElementById("loginEmailButton")
  .addEventListener("click", function () {
    const email = document.getElementById("login_email").value;
    LoginEmail(email);
  });
