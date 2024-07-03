$(document).ready(function () {
  $("#loginBtn").click(function () {
    let username = $("#username").val();
    let password = $("#password").val();

    $.ajax({
      url: "/guvi_in/php/login.php",
      method: "POST",
      data: {
        username: username,
        password: password,
      },
      dataType: "json",
      success: function (response) {
        console.log(response); // Log the response to check its structure
        alert(response.message);
        if (response.success) {
          console.log(response.sessionID);
          localStorage.setItem("sessionID", response.sessionID);
          window.location.href = "/guvi_in/templates/profile.html";
        }
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
        alert("An error occurred. Please try again.");
      },
    });
  });
});
