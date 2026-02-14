function LoginCode(code) {
  $.ajax({
    url: "../backend/endpoints/ENDPOINT_LoginCode.php",
    type: "POST",
    data: { code },
    dataType: "json",
    success: function (response) {
      if (response.status === "OK") {
        document.location.href = "./dashboard.php";
      } else {
        alert(response.status + " " + response.error);
      }
    },
  });
}

document
  .getElementById("loginCodeForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();
    const code = document.getElementById("login_code").value;
    LoginCode(code);
  });

document
  .getElementById("loginCodeButton")
  .addEventListener("click", function () {
    const code = document.getElementById("login_code").value;
    LoginCode(code);
  });
